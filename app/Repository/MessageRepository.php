<?php

namespace App\Repository;

use App\Traits\ApiResponser;
use App\Message;
use Carbon\Carbon;

class MessageRepository implements MessageRepositoryInterface
{
    use ApiResponser;

    /**
     * Create a new MessageRepository instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get filtered messages by query
     *
     * @param Array $query
     * @return Illuminate\Http\Response
     */
    public function index($query = array())
    {
        $messages = new Message();

        if (array_key_exists('status', $query)) {
            $messages = $messages->where('status', '=', $query['status']);
        }

        if (array_key_exists('body', $query)) {
            $messages = $messages->where('body', 'LIKE', '%' . $query['body'] . '%');
        }

        if (array_key_exists('from', $query)) {
            $messages = $messages->
                where("updated_at", ">", Carbon::now()->subMinutes($query['from']));
        }

        if (array_key_exists('take', $query)) {
            $messages = $messages->take($query['take'])->get();
        } else {
            $messages = $messages->get();
        }

        return $this->successResponse($messages);
    }
}
