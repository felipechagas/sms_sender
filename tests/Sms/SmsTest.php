<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class SmsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /sms/send [GET]
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
    }
}
