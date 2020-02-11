<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class SmsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * /restaurants [GET]
     * 200
     */
    public function testShouldSendAnSms()
    {
        $this->post("/sms/send", []);
        $this->seeStatusCode(Response::HTTP_OK);
    }
}
