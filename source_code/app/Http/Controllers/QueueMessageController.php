<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\QueueMessage;

class QueueMessageController extends Controller
{
    //messagesPage
    public function messagesPage() {

        $messages = QueueMessage::orderBy('created_at', 'desc')->paginate(24);

        return view('pages.messagesPage', [
            'messages' => $messages
        ]);
    }
}
