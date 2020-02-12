<?php

use App\Http\Controllers\RestaurantController;
use App\Restaurant;
use App\Traits\ApiResponser;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class SmsTest extends TestCase
{
    use DatabaseTransactions;
    use ApiResponser;

    /**
     * /sms/send [POST]
     * 200
     */
    public function testShouldSendAnSms()
    {
        $mockcontext = $this->createMock(RestaurantController::class);
        $mockcontext->method("show")->willReturn(
            $this->successResponse(
                factory(Restaurant::class)->make()
            )
        );

        $parameters = [
            'restaurant_id' => 1,
            'phone_number' => '+17609794553',
        ];

        $this->post("/sms/send", $parameters, []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonEquals(
            [
                'data' =>
                [
                    'status' => 'sent',
                ]
            ]
        );
    }

    /**
     * /sms/send [POST]
     * 422
     */
    public function testShouldNotSendAnSmsWithInvalidData()
    {
        $parameters = [
            'phone_number' => '+17609794553',
        ];

        $this->post("/sms/send", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error'
            ]
        );
    }
}
