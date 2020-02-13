<?php

namespace App\Http\Controllers;

use App\Message;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    use ApiResponser;

    /**
     * Create a new MessageController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of messages
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();

        return $this->successResponse($messages);
    }

    /**
     * Obtains and show one message
     * @return Illuminate\Http\Response
     */
    public function show($message)
    {
        $message = Message::findOrFail($message);

        return $this->successResponse($message);
    }
}
