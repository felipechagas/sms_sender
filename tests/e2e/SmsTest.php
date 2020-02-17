<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class SmsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /sms/send [POST]
     * 200
     */
    public function testShouldSendSms()
    {
        $data = [
            'restaurant_id' => 1,
            'phone_number' => getenv("TESTS_PHONE_NUMBER"),
            'type' => 'before',
        ];

        $this->post("sms/send", $data);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonStructure([
            'data' => [
                'id',
                'body',
                'status',
                'restaurant_id',
                'created_at',
                'updated_at'
            ]
        ]);
    }

    /**
     * /sms/send [POST]
     * 422
     */
    public function testShouldReturnUnprocessableEntity()
    {
        $data = [
            'phone_number' => getenv("TESTS_PHONE_NUMBER"),
            'type' => 'before',
        ];

        $this->post("sms/send", $data);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
