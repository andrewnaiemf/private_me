<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Validation\Rule;
use App\Models\Chat;
use App\Models\Captain;
use App\Models\User;
use App\Notifications\PushNotification;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    use GeneralTrait;

    const IMAGE = 1;
    const VIDEO = 2;
    const AUDIO = 3;
    const TEXT = 4;
    const FILE = 5;


    private function getTypesMapping()
    {
        return [
            'image' => self::IMAGE,
            'video' => self::VIDEO,
            'audio' => self::AUDIO,
            'text' => self::TEXT,
            'file' => self::FILE,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->header('per_page', 10);

        $user = auth()->user();

        $chat = $user->chats()->whereNull('deleted_at')->simplePaginate($perPage);
        $chat->load('sender');
        $chat->load('receiver');

        return $this->returnData(['chat' => $chat]);
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
        $user = auth()->user();
        $typeMapping = $this->getTypesMapping();

        $validator = Validator::make($request->all(), [
            'type' => 'required|in:' . implode(',', array_keys($typeMapping)),
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
            'firebase_id' => 'required|string',

        ]);

        if ($validator->fails()) {
            return $this->returnValidationError(401,$validator->errors()->all());
        }

        $receiver_id = $request->receiver_id;
        $receiver = User::find($receiver_id);
        $chat = Chat::where(['receiver_id'=> $receiver_id, 'sender_id' => $user->id])
            ->orWhere(['sender_id' => $receiver_id,'receiver_id' => $user->id ])
            ->whereNull('deleted_at')
            ->first();

        $message =  $request->message;

        $requestedtype = $typeMapping[$request->type];
        if (!$chat) {
            $chat = Chat::create([
                'sender_id' => $user->id,
                'receiver_id' => $receiver_id,
                'type' => $requestedtype,
                'message' => $message,
                'is_read' => 0,
                'firebase_id' => $request->firebase_id
            ]);
        }else{
            $chat->update([
                'type' => $requestedtype,
                'message' => $message,
                'is_read' => 0,
                'firebase_id' => $request->firebase_id,
                'sender_id' => $user->id,
                'receiver_id' => $receiver_id
            ]);
        }

        $this->sendFriendshipNotification($receiver, $chat);

        return $this->returnSuccessMessage(trans("api.Chat_opend_successfully"));
    }

    private function sendFriendshipNotification($reciever, $chat)
    {
        $friend = User::findOrFail($reciever->id);
        app()->setLocale($friend->lng);
        $user = User::find(auth()->user()->id);

        $msg = $user->name .' '. $chat->message;

        $screen = 'chat_screen';

        PushNotification::send($friend, $screen, $msg);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)//read message
    {
        $message = Chat::findOrFail($id);
        $message->update(['is_read' => 1]);
        return $this->returnSuccessMessage(trans("api.Message_Read_successfully"));
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($firebase_id)
    {
        $message = Chat::where(['firebase_id' => $firebase_id])->first();

        if ($message) {
            $message->delete();
        }

        return $this->returnSuccessMessage(trans("api.message_deleted_successfully"));
    }
}
