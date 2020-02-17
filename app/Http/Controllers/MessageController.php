<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Repository\MessageRepository;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use ApiResponser;

    protected $message;

    /**
     * Create a new MessageController instance.
     *
     * @return void
     */
    public function __construct($message = null)
    {
        $this->message = $message === null ? new MessageRepository() : $message;
    }

    /**
     * Return the list of messages
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rules = [
            'body' => 'max:255',
            'status' => 'min:4|max:10',
            'take' => 'numeric|min:1',
            'from' => 'numeric|min:1',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        return $this->message->index($data);
    }

    /**
     * Obtains and show one message
     * @return Illuminate\Http\Response
     */
    public function show($message)
    {
        return $this->message->findOrFail($message);
    }

    /**
     * Create one new message
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'body' => 'required|max:255',
            'status' => 'required|string',
            'restaurant_id' => 'required',
            'phone_number' => 'required',
            'type' => 'required',
        ];

        $this->validate($request, $rules);

        return $this->message->create($request->all());
    }

    /**
     * Update an existing message
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $message)
    {
        $rules = [
            'body' => 'max:255',
            'status' => 'min:4|max:10',
            'type' => 'min:4|max:10',
        ];

        $this->validate($request, $rules);

        return $this->message->update($request->all(), $message);
    }

    /**
     * Remove an existing message
     * @return Illuminate\Http\Response
     */
    public function destroy($message)
    {
        return $this->message->delete($message);
    }
}
