<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class RestaurantTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /restaurants [GET]
     */
    public function testShouldReturnAllRestaurants(){
        $this->get("restaurants", []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            'data' => ['*' =>
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
     */
    public function testShouldReturnRestaurant(){
        $this->get("restaurants/1", []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            ['data' =>
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
     */
    public function testShouldCreateRestaurant(){
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000,
        ];

        $this->post("restaurants", $parameters, []);
        $this->seeStatusCode(Response::HTTP_CREATED);
        $this->seeJsonStructure(
            ['data' =>
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
     */
    public function testShouldPutUpdateRestaurant(){
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1000,
        ];

        $this->put("restaurants/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            ['data' =>
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
     */
    public function testShouldPatchUpdateRestaurant(){
        $parameters = [
            'name' => 'Test',
            'delivery_time' => 1500,
        ];

        $this->patch("restaurants/1", $parameters, []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            ['data' =>
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
     */
    public function testShouldDeleteRestaurant(){
        $this->delete("restaurants/1", [], []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            ['data' =>
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

}
