<?php

class RestaurantTest extends TestCase
{
    /**
     * /restaurants [GET]
     */
    public function testShouldReturnAllRestaurants(){
        $this->get("restaurants", []);
        $this->seeStatusCode(200);
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
        $this->seeStatusCode(200);
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
        $this->seeStatusCode(200);
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
    public function testShouldUpdateRestaurant(){

    }

    /**
     * /restaurants/id [DELETE]
     */
    public function testShouldDeleteRestaurant(){

    }

}
