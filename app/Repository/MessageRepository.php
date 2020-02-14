<?php

namespace App\Repository;

use App\Traits\ApiResponser;
use App\Message;

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
     *
     *
     * @param
     * @return
     */
    public function index($query = array())
    {
        $messages = new Message();

        if(!is_null($query['status'])) {
            $messages->where('status', '=', $query['status']);
        }

        if(!is_null($query['body'])) {
            $messages->where('body', 'LIKE', '%' .$query['body'].'%' );
        }

        if(!is_null($query['take'])) {
            $messages->take($query['take'])->get();
        } else {
            $messages = $messages->get();
        }

        return $this->successResponse($messages);
    }
}
