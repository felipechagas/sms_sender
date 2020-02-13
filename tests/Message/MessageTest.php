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

    /**
     * /messages/id [GET]
     * 200
     */
    public function testShouldReturnMessage()
    {
        $this->get("messages/1", []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            [
                'data' =>
                [
                    'id',
                    'body',
                    'status',
                    'restaurant_id',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
    }

    /**
     * /messages/id [GET]
     * 404
     */
    public function testShouldNotGetNotFoundMessage()
    {
        $this->get("messages/1000", []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages [POST]
     * 201
     */
    public function testShouldCreateMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'sent',
            'restaurant_id' => 1,
        ];

        $this->post("messages", $parameters, []);
        $this->seeStatusCode(Response::HTTP_CREATED);
        $this->seeJsonStructure(
            [
                'data' =>
                [
                    'id',
                    'body',
                    'status',
                    'restaurant_id',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
    }

    /**
     * /messages [POST]
     * 422
     */
    public function testShouldNotCreateInvalidMessage()
    {
        $parameters = [
            'name' => 'Test',
        ];

        $this->post("messages", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [PUT]
     * 200
     */
    public function testShouldPutUpdateMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'sent',
            'restaurant_id' => 1,
        ];

        $this->put("messages/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            [
                'data' =>
                [
                    'id',
                    'name',
                    'delivery_time',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
    }

    /**
     * /messages/id [PUT]
     * 404
     */
    public function testShouldNotPutNotFoundMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'sent',
            'restaurant_id' => 1,
        ];

        $this->put("messages/1000", $parameters, []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [PUT]
     * 422
     */
    public function testShouldNotPutEmptyChanges()
    {
        $parameters = [];

        $this->put("messages/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [PUT]
     * 422
     */
    public function testShouldNotPutUpdateInvalidMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 10,
            'restaurant_id' => 1,
        ];

        $this->put("messages/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [PATCH]
     */
    public function testShouldPatchUpdateMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 10,
            'restaurant_id' => 1,
        ];

        $this->patch("messages/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            [
                'data' =>
                [
                    'id',
                    'body',
                    'status',
                    'restaurant_id',
                    'created_at',
                    'updated_at'
                ]
            ]
        );
    }
}
