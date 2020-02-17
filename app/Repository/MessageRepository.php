<?php

namespace App\Repository;

use App\Traits\ApiResponser;
use App\Message;
use Carbon\Carbon;
use Illuminate\Http\Response;

class MessageRepository implements MessageRepositoryInterface
{
    use ApiResponser;

    protected $messageModel;

    /**
     * Create a new MessageRepository instance.
     *
     * @return void
     */
    public function __construct(Message $messageModel = null)
    {
        $this->messageModel = $messageModel === null ? new Message() : $messageModel;
    }

    /**
     * Get filtered messages by query
     *
     * @param Array $query
     * @return Illuminate\Http\Response
     */
    public function index($query = array())
    {
        $message = $this->messageModel;

        if (array_key_exists('status', $query)) {
            $message = $message->where('status', '=', $query['status']);
        }

        if (array_key_exists('body', $query)) {
            $message = $message->where('body', 'LIKE', '%' . $query['body'] . '%');
        }

        if (array_key_exists('from', $query)) {
            $message = $message->
                where("updated_at", ">", Carbon::now()->subMinutes($query['from']));
        }

        if (array_key_exists('take', $query)) {
            $message = $message->take($query['take'])->get();
        } else {
            $message = $message->get();
        }

        return $this->successResponse($message);
    }

    public function checkScheduledSms() {
        $message = $this->messageModel;

        return $message->
            join('restaurants', 'messages.restaurant_id', '=', 'restaurants.id')->

            whereRaw(
                'DATE_ADD(messages.updated_at, INTERVAL restaurants.delivery_time SECOND) > '.
                'DATE_SUB(CURRENT_TIME(), INTERVAL 91 MINUTE)'
            )->

            whereRaw(
                'DATE_ADD(messages.updated_at, INTERVAL restaurants.delivery_time SECOND) < '.
                'DATE_SUB(CURRENT_TIME(), INTERVAL 90 MINUTE)'
            )->
            where("type", "=", "before")->
            where("status", "=","delivered")->
            get();
    }

    /**
     * Obtains and show one message
     * @return Illuminate\Http\Response
     */
    public function findOrFail($message_id)
    {
        $messages = $this->messageModel;

        $messages = $messages->findOrFail($message_id);

        return $this->successResponse($messages);
    }

    /**
     * Create one new message
     * @return Illuminate\Http\Response
     */
    public function create($request)
    {
        $messages = $this->messageModel;

        $messages = $messages->create($request);

        return $this->successResponse($messages, Response::HTTP_CREATED);
    }

    /**
     * Update an existing message
     * @return Illuminate\Http\Response
     */
    public function update($request, $message_id)
    {
        $messages = $this->messageModel;

        $message = $messages->findOrFail($message_id);

        $message->fill($request);

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
    public function delete($message_id)
    {
        $messages = $this->messageModel;

        $messages = $messages->findOrFail($message_id);

        $messages->delete();

        return $this->successResponse($messages);
    }
}
