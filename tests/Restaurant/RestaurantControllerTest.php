<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class RestaurantControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /restaurants [GET]
     * 200
     */
    public function testShouldGetRestaurants()
    {
        $this->get("restaurants", []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            'data' => [
                '*' =>
                [
                    'id',
                    'name',
                    'delivery_time',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    /**
     * /restaurants/id [GET]
     * 200
     */
    public function testShouldGetRestaurant()
    {
        $this->get("restaurants/1", []);
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
     * /restaurants/id [GET]
     * 404
     */
    public function testGetShouldReturnNotFound()
    {
        $this->get("restaurants/51", []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants [POST]
     * 201
     */
    public function testShouldPostRestaurant()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000,
        ];

        $this->post("restaurants", $parameters, []);
        $this->seeStatusCode(Response::HTTP_CREATED);
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
     * /restaurants [POST]
     * 422
     */
    public function testPostShouldReturnUnprocessableEntity()
    {
        $parameters = [
            'delivery_time' => 1000,
        ];

        $this->post("restaurants", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [PUT]
     * 200
     */
    public function testShouldPutRestaurant()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000,
        ];

        $this->put("restaurants/1", $parameters, []);
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
     * /restaurants/id [PUT]
     * 404
     */
    public function testPtShouldReturnNotFound()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000,
        ];

        $this->put("restaurants/51", $parameters, []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [PUT]
     * 422
     */
    public function testPutShouldReturnEmptyEntity()
    {
        $parameters = [];

        $this->put("restaurants/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [PUT]
     * 422
     */
    public function testPutShouldReturnUnprocessableEntity()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000000,
        ];

        $this->put("restaurants/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [PATCH]
     */
    public function testShouldPatchRestaurant()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1500,
        ];

        $this->patch("restaurants/1", $parameters, []);
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
     * /restaurants/id [PATCH]
     * 404
     */
    public function testPatchShouldReturnNotFound()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000,
        ];

        $this->patch("restaurants/51", $parameters, []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [PATCH]
     * 422
     */
    public function testPatchShouldReturnEmptyEntity()
    {
        $parameters = [];

        $this->patch("restaurants/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [PATCH]
     * 422
     */
    public function testPatchShouldReturnUnprocessableEntity()
    {
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000000,
        ];

        $this->patch("restaurants/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }

    /**
     * /restaurants/id [DELETE]
     * 200
     */
    public function testShouldDeleteRestaurant()
    {
        $this->delete("restaurants/1", [], []);
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
     * /restaurants/id [DELETE]
     * 404
     */
    public function testDeleteShouldReturnNotFound()
    {
        $this->delete("restaurants/51", [], []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }
}
