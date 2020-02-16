<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class MessageControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /messages [GET]
     * 200
     */
    public function testShouldGetMessages()
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
    public function testShouldGetMessage()
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
    public function testGetShouldReturnNotFound()
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
    public function testShouldPostMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
            'phone_number' => '+8898837970000',
            'type' => 'before',
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
                    'type',
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
    public function testPostShouldReturnUnprocessableEntity()
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
    public function testShouldPutMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
        ];

        $this->put("messages/1", $parameters, []);
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
     * /messages/id [PUT]
     * 404
     */
    public function testPutShouldReturnNotFound()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
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
    public function testPutShouldReturnEmptyEntity()
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
    public function testPutShouldReturnUnprocessableEntity()
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
    public function testShouldPatchMessage()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
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

    /**
     * /messages/id [PATCH]
     * 404
     */
    public function testPatchShouldReturnNotFound()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 'delivered',
            'restaurant_id' => 1,
        ];

        $this->patch("messages/1000", $parameters, []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [PATCH]
     * 422
     */
    public function testPatchShouldReturnEmptyEntity()
    {
        $parameters = [];

        $this->patch("messages/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [PATCH]
     * 422
     */
    public function testPatchShouldReturnUnprocessableEntity()
    {
        $parameters = [
            'body' => 'Teste',
            'status' => 10,
            'restaurant_id' => 1,
        ];

        $this->patch("messages/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /messages/id [DELETE]
     * 200
     */
    public function testShouldDeleteMessage()
    {
        $this->delete("messages/1", [], []);
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
     * /messages/id [DELETE]
     * 404
     */
    public function testDeleteShouldReturnNotFound()
    {
        $this->delete("messages/1000", [], []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }
}
