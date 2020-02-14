<?php

namespace App\Http\Controllers;

use App\Message;
use App\Traits\ApiResponser;
use App\Repository\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    use ApiResponser;

    protected $message;

    /**
     * Create a new MessageController instance.
     *
     * @return void
     */
    public function __construct(MessageRepositoryInterface $message)
    {
        $this->message = $message;
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
        $message = Message::findOrFail($message);

        return $this->successResponse($message);
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
        ];

        $this->validate($request, $rules);

        $message = Message::create($request->all());

        return $this->successResponse($message, Response::HTTP_CREATED);
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
        ];

        $this->validate($request, $rules);

        $message = Message::findOrFail($message);

        $message->fill($request->all());

        if ($message->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $message->save();

        return $this->successResponse($message);
    }

    /**
     * Remove an existing message
     * @return Illuminate\Http\Response
     */
    public function destroy($message)
    {
        $message = Message::findOrFail($message);

        $message->delete();

        return $this->successResponse($message);
    }
}
