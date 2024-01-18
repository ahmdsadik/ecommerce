<?php

namespace App\Http\Controllers;

class ChatController extends Controller
{
    public function __invoke()
    {
        return view('dashboard.Chat.index');
    }
}
