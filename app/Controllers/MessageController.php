<?php


namespace App\Controllers;


use App\Models\Message;
use Flamingo\Kernel\Request;

class MessageController
{
    public function index()
    {
        $messages = Message::all();

        return view('messages', ['messages' => $messages]);
    }

    public function store()
    {
        $message = new Message;

        $request = new Request;
        $request->setParams($_POST);

        $message->author = $request->author;
        $message->body = $request->body;

        $message->save();

        redirect('messages');
    }
}