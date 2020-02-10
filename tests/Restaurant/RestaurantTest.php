<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class RestaurantTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /restaurants [GET]
     * 200
     */
    public function testShouldReturnAllRestaurants()
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
    public function testShouldReturnRestaurant()
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
    public function testShouldNotGetNotFoundRestaurant()
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
    public function testShouldCreateRestaurant()
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
    public function testShouldNotCreateInvalidRestaurant()
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
    public function testShouldPutUpdateRestaurant()
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
    public function testShouldNotPutNotFoundRestaurant()
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
    public function testShouldNotPutEmptyChanges()
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
    public function testShouldNotPutUpdateInvalidRestaurant()
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
    public function testShouldPatchUpdateRestaurant()
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
    public function testShouldNotPatchNotFoundRestaurant()
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
    public function testShouldNotPatchEmptyChanges()
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
    public function testShouldNotPatchUpdateInvalidRestaurant()
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
    public function testShouldNotDeleteNotFoundRestaurant()
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
