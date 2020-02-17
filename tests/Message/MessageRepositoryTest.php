<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use App\Repository\MessageRepository;

class MessageRepositoryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /messages [GET]
     * 200
     */
    public function testShouldGetFilteredMessages()
    {
        $repository = new MessageRepository();

        $result = $repository->index();

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }

    /**
     * /messages [GET]
     * 200
     */
    public function testShouldGetMessages()
    {
        $repository = new MessageRepository();

        $result = $repository->index();

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }

    /**
     * /messages/id [GET]
     * 200
     */
    public function testShouldGetMessage()
    {
        $repository = new MessageRepository();

        $result = $repository->findOrFail(1);

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }

    /**
     * /messages [POST]
     * 201
     */
    public function testShouldPostMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
            'phone_number' => '+8898837970000',
            'type' => 'before',
        ];

        $repository = new MessageRepository();

        $result = $repository->create($parameters);

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }

    /**
     * /messages/id [PATCH/PUT]
     * 200
     */
    public function testShouldPutMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
            'type' => 'after',
            'phone_number' => '00000000',
            'restaurant_id' => 1,
        ];

        $repository = new MessageRepository();

        $result = $repository->update($parameters, 1);

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }

    /**
     * /messages/id [DELETE]
     * 200
     */
    public function testShouldDeleteMessage()
    {
        $repository = new MessageRepository();

        $result = $repository->delete(1);

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }
}
