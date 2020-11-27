<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Message;
use Pusher\Pusher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->whereHas('message', function ($query) {
            $query->where('to', Auth::id())->orWhere('user_id', Auth::id());
        })->get();

        if (count($users) == 0) {
            return $this->SendResponse('failed', 'Message not found', NULL, 404);
        }

        return response([
            'status'    => 'success',
            'message'   => 'Data loaded',
            'data'      => $users
        ]);
    }

    public function getMessage($id)
    {
        $my_id = Auth::id();

        $user = User::select('id', 'username', 'avatar')->where('id', $id)->get();

        // when click to see message selected message will be read, update
        Message::where(['user_id' => $id, 'to' => $my_id])->update(['is_read' => 1]);

        $messages = Message::where(function ($query) use ($id, $my_id) {
            $query->where('user_id', $my_id)->Where('to', $id);
        })->orWhere(function ($query) use ($id, $my_id) {
            $query->where('user_id', $id)->Where('to', $my_id);
        })->get();

        if (count($user) == 0) {
            return $this->SendResponse('failed', 'User not found', NULL, 404);
        }

        return response([
            'status'    => 'success',
            'message'   => 'Chat loaded successfully',
            'user'      => $user,
            'data'      => $messages
        ]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->to;
        $message = $request->message;

        $data = new Message();
        $data->user_id = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();

        $options = [
            'cluster' => 'ap1',
            'useTLS' => true
        ];

        $pusher = new Pusher(
            '8d28dfe973d0377c124b',
            'a91a7e8d600915953718',
            '1111413',
            $options
        );

        $data = ["user_id" => $from, "to" => $to, "message" => $message];
        $pusher->trigger('my-channel', 'my-event', $data);

        return response([
            'status' => 'success',
            'message' => 'Message sent',
            'data' => $data
        ]);
    }
}
