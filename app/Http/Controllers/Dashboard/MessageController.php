<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\NewMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('dashboard.Chat.index',
            [
                'messages' => Message::with(
                    [
                        'user:id,name' => ['media']
                    ]
                )
                    ->get()
            ]
        );
    }

    public function store(Request $request)
    {
        $msg = auth('admin')->user()->messages()->create($request->only('body'));

        $msg = $msg->load(
            [
                'user:id,name'
            ]
        );

        broadcast(new NewMessageEvent($msg))->toOthers();
    }
}
