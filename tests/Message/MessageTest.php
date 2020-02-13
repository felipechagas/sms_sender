<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class MessageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /messages [GET]
     * 200
     */
    public function testShouldReturnAllMessages()
    {
        $this->get("messages", []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            'data' => [
                '*' =>
                [
                    'id',
                    'body',
                    'status',
                    'restaurant_id',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }
}
