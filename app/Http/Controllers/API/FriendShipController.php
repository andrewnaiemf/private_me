<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class FriendShipController extends Controller
{

    const STATUS_ACCEPT = 1;
    const STATUS_REJECT = -1;
    const STATUS_DELETE = -2;
    const STATUS_CANCEL = -3;


    private function getStatusMapping()
    {
        return [
            'Accept' => self::STATUS_ACCEPT,
            'Reject' => self::STATUS_REJECT,
            'Delete' => self::STATUS_DELETE,
            'Cancel' => self::STATUS_CANCEL,
        ];
    }

    public function notifications(Request $request)
    {
        $perPage = $request->header('per_page', 10);

        $user = auth()->user();
        $friendships = $user->friendships;

        $notifications = [];

        foreach ($friendships as $friendship) {
            $friend = $friendship->receiver_id === $user->id ? $friendship->sender : $friendship->receiver;
            $notification = [
                'friend_id' => $friend->id,
                'friend_name' => $friend->name,
                'friend_profile' => $friend->profile,
                'status' => $friendship->status,
                'message' => $friendship->friendship_message,
            ];
            $notifications[] = $notification;
        }
        // Convert the array to a Laravel Collection
        $notificationsCollection = collect($notifications);

        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Slice the collection to get the items to display for the current page
        $currentPageNotifications = $notificationsCollection->slice(($currentPage - 1) * $perPage, $perPage);

        // Reindex the keys of the data array
        $data = $currentPageNotifications->values();

        // Create a new LengthAwarePaginator instance
        $paginatedNotifications = new LengthAwarePaginator($data, count($notificationsCollection), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        return $this->returnData($paginatedNotifications);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        $users = User::where('name', 'LIKE', '%' . $name . '%')
        ->where('email', '!=', auth()->user()->email)
        ->with(['sentFriendships' => function ($query) {
            $query->whereIn('status', [null,0, 1]);
        }, 'receivedFriendships' => function ($query) {
            $query->whereIn('status', [null,0, 1]);
        }])
        ->get();
        $result = [];

        foreach ($users as $user) {
            // Initialize the sender_id as null
            $senderId = null;

            // Check if the user has sentFriendships and get the sender_id from the first relationship
            if ($user->sentFriendships->isNotEmpty()) {
                $senderId = $user->sentFriendships->first()->sender_id;
            }

            // If sender_id is still null, check if the user has receivedFriendships and get the sender_id from the first relationship
            if (!$senderId && $user->receivedFriendships->isNotEmpty()) {
                $senderId = $user->receivedFriendships->first()->sender_id;
            }

            $result[] = [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'name' => $user->name,
                'profile' => $user->profile ?? '',
                'avatar_location' => $user->avatar_location,
                'email' => $user->email,
                'sender_id' => $senderId,
                'is_friend' => $user->status, // Append the friendship status using the `status` attribute
            ];
        }

        return $this->returnData($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendFriendRequest($id)
    {

        $loggedInUserId = auth()->user()->id;

        // Check if a friendship record exists between the users
        $friendship = Friendship::where(function ($query) use ($loggedInUserId, $id) {
            $query->where('sender_id', $loggedInUserId)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($loggedInUserId, $id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $loggedInUserId);
        })->first();

        if ($friendship) {
            if ($friendship->status == 0) {
                // Friendship request already sent
                $msg = "Friendship request already sent";
            } elseif ($friendship->status == 1) {
                // Users are already friends
                $msg = "You are already friends";
            } elseif ($friendship->status == -1) {
                // Update the friendship status to 0 (pending request)
                $friendship->status = 0;
                $friendship->save();

                $msg = "Friendship request sent";
            }
        }else{
            Friendship::create([
                'sender_id' => $loggedInUserId,
                'receiver_id' => $id,
                'status' => 0
            ]);
            $msg = "Friendship request sent";
        }

        return $this->returnSuccessMessage($msg);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $statusMapping = $this->getStatusMapping();
        $loggedInUserId = auth()->user()->id;

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', array_keys($statusMapping)),
        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }

        // Handle cancel request
        if ($request->status === 'Cancel') {
            $cancelledFriendship = $this->cancelFriendship($loggedInUserId, $id);
            if ($cancelledFriendship) {
                return $this->returnSuccessMessage("Friendship canceled successfully");
            }
        }

        // Find the friendship record between the users
        $friendship = Friendship::where(function ($query) use ($loggedInUserId, $id) {
            $query->where('sender_id', $loggedInUserId)
                ->where('receiver_id', $id);
        })->orWhere(function ($query) use ($loggedInUserId, $id) {
            $query->where('sender_id', $id)
                ->where('receiver_id', $loggedInUserId);
        })->first();

        if ($friendship) {
            $requestedStatus = $statusMapping[$request->status];

            if ($friendship->status === 0 && in_array($requestedStatus, [self::STATUS_ACCEPT, self::STATUS_REJECT])) {
                // Update the friendship status
                $friendship->status = $requestedStatus;
                $friendship->save();

                if ($requestedStatus === self::STATUS_ACCEPT) {
                    return $this->returnSuccessMessage("Friendship request accepted");
                } elseif ($requestedStatus === self::STATUS_REJECT) {
                    return $this->returnSuccessMessage("Friendship request rejected");
                }
            } elseif ($requestedStatus === self::STATUS_DELETE) {
                $friendship->delete();
                return $this->returnSuccessMessage("Friendship request deleted");
            }
        }

        return $this->returnError("Friendship request not found");
    }

    private function cancelFriendship($loggedInUserId, $id)
    {
        return Friendship::where(['sender_id' => $loggedInUserId, 'receiver_id' => $id])->delete();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function myFriends(Request $request){

        $perPage = $request->header('per_page', 10);
        $user = User::find(auth()->user()->id);
        $friendships = $user->friendships->where('status', self::STATUS_ACCEPT);

        $friendsWithMessages = [];

        foreach ($friendships as $friendship) {
            $friend = $friendship->receiver_id === $user->id ? $friendship->sender : $friendship->receiver;
            $friendWithMessages = $friend->toArray();
            $friendWithMessages['message'] = $this->getFriendMessages($user, $friend);
            $friendsWithMessages[] = $friendWithMessages;
        }

        //Sort friends by the latest message timestamp
        usort($friendsWithMessages, function ($a, $b) {
            if (isset($a['message']) && isset($b['message'])) {
                return strcmp($b['message']['updated_at'], $a['message']['updated_at']);
            }
            return 0;
        });


        // Convert the array to a Laravel Collection
        $friendsCollection = collect($friendsWithMessages);

        // Get the current page from the request
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Define how many items to display per page
        $perPage = $perPage;

        // Slice the collection to get the items to display for the current page
        $currentPageFriends = $friendsCollection->slice(($currentPage - 1) * $perPage, $perPage);

        // Reindex the keys of the data array
        $data = $currentPageFriends->values();

        // Create a new LengthAwarePaginator instance
        $paginatedFriends = new LengthAwarePaginator($data, count($friendsCollection), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return $this->returnData($paginatedFriends);
    }

    public function getFriendMessages(User $user, User $friend)
    {
        // Fetch the latest message where the user is the sender and the friend is the receiver
        $sentMessage = Chat::where('sender_id', $user->id)
        ->where('receiver_id', $friend->id)
        ->orderBy('created_at', 'desc')
        ->first();

        // Fetch the latest message where the user is the receiver and the friend is the sender
        $receivedMessage = Chat::where('sender_id', $friend->id)
            ->where('receiver_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Compare the timestamps of the sent and received messages to get the latest one
        if ($sentMessage && $receivedMessage) {
            return $sentMessage->created_at > $receivedMessage->created_at ? $sentMessage : $receivedMessage;
        } elseif ($sentMessage) {
            return $sentMessage;
        } elseif ($receivedMessage) {
            return $receivedMessage;
        } else {
            return null; // No messages between the user and the friend
        }
    }
}
