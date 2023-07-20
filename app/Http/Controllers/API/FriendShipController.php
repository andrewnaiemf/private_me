<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            $result[] = [
                'id' => $user->id,
                'uuid' => $user->uuid,
                'name' => $user->name,
                'profile' => $user->profile ?? '',
                'avatar_location' => $user->avatar_location,
                'email' => $user->email,
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
}
