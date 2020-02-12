<?php

use App\Http\Controllers\RestaurantController;
use App\Restaurant;
use App\Services\SmsService;
use App\Traits\ApiResponser;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        $mockRestaurantController = $this->createMock(RestaurantController::class);
        $mockRestaurantController->method("show")->willReturn(
            $this->successResponse(
                factory(Restaurant::class)->make()
            )
        );

        $mockSmsClient = $this->createMock(Client::class);
        $mockSmsClient->messages = $this->createMock(MessageList::class);
        $mockSmsClient->messages->method("create")->willReturn([]);

        $smsService = new SmsService($mockRestaurantController, $mockSmsClient);

        $result = $smsService->send(1, '+17609794553');

        $this->assertJsonStringEqualsJsonString(
            $result->content(),
            $this->successResponse(array('status' => 'sent'))->content()
        );
    }

    /**
     * /sms/send [POST]
     * 404
     */
    public function testShouldNotSendAnSmsWithInvalidRestaurant()
    {
        $mockRestaurantController = $this->createMock(RestaurantController::class);
        $mockRestaurantController->method("show")->willThrowException(
            new NotFoundHttpException()
        );

        $mockSmsClient = $this->createMock(Client::class);
        $mockSmsClient->messages = $this->createMock(MessageList::class);
        $mockSmsClient->messages->method("create")->willReturn([]);

        $smsService = new SmsService($mockRestaurantController, $mockSmsClient);

        $result = $smsService->send(51, '+17609794553');

        $this->assertJsonStringEqualsJsonString(
            $result->content(),
            $this->errorResponse(
                'Does not exist any instance of restaurant with the given id',
                404
            )->content()
        );
    }
}
