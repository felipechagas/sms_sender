<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class SmsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /sms/send [POST]
     * 200
     */
    public function testShouldSendAnSms()
    {
        $parameters = [
            'restaurant_id' => 1,
            'phone_number' => '+17609794553',
        ];

        $this->post("/sms/send", $parameters, []);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure(
            [
                'data' =>
                [
                    'status',
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
