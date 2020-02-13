<?php

use App\Restaurant;
use App\Message;
use App\Services\SmsService;
use App\Traits\ApiResponser;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Twilio\Rest\Client;
use \Twilio\Rest\Api\V2010\Account\MessageList;

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
        $mockSmsClient = $this->createMock(Client::class);
        $mockSmsClient->messages = $this->createMock(MessageList::class);
        $mockSmsClient->messages->method("create")->willReturn([]);

        $smsService = new SmsService($mockSmsClient, null, null);

        $result = $smsService->send(1, '+17609794553');

        $this->assertArrayNotHasKey(
            'error',
            json_decode($result->content(), true),
        );
    }
}
