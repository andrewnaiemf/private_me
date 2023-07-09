<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Validation\Rule;
use App\Models\Chat;
use App\Models\Captain;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    use GeneralTrait;
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

        $validator = $request->validate([
            'receiver_id' => [
                'required',
                Rule::exists('users', 'id')
            ]
        ]);

        $receiver_id = $request->receiver_id;

        $chat = $user->chats()
            ->where('receiver_id', $receiver_id)
            ->whereNull('deleted_at')
            ->first();

        if (!$chat) {
            $chat = Chat::create([
                'sender_id' => $user->id,
                'receiver_id' => $receiver_id,
            ]);
        }

        return $this->returnSuccessMessage(trans("api.Chat_opend_successfully"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        $chat = Chat::find($id);

        if ($chat) {
            $chat->delete();
        }

        return $this->returnSuccessMessage(trans("api.user_blocked_successfully"));
    }
}
