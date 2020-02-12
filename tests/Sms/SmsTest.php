<?php

use App\Http\Controllers\RestaurantController;
use App\Restaurant;
use App\Services\SmsService;
use App\Traits\ApiResponser;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
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
     * 422
     */
    public function testShouldNotSendAnSmsWithInvalidData()
    {
        $mockRestaurantController = $this->createMock(RestaurantController::class);
        $mockRestaurantController->method("show")->willReturn(
            $this->errorResponse('', 422)
        );

        $mockSmsClient = $this->createMock(Client::class);
        $mockSmsClient->messages = $this->createMock(MessageList::class);
        $mockSmsClient->messages->method("create")->willReturn([]);

        $parameters = [
            'phone_number' => '+17609794553',
        ];

        $this->post("/sms/send", $parameters, []);
        $this->seeStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        $this->seeJsonStructure(
            [
                'error',
                'code'
            ]
        );
    }

    /**
     * /sms/send [POST]
     * 404
     */
    public function testShouldNotSendAnSmsWithInvalidRestaurant()
    {
        $mockRestaurantController = $this->createMock(RestaurantController::class);
        $mockRestaurantController->method("show")->willReturn(
            $this->errorResponse(
                'Does not exist any instance of restaurant with the given id',
                404
            )
        );

        $mockSmsClient = $this->createMock(Client::class);
        $mockSmsClient->messages = $this->createMock(MessageList::class);
        $mockSmsClient->messages->method("create")->willReturn([]);

        $parameters = [
            'restaurant_id' => 51,
            'phone_number' => '+17609794553',
        ];

        $this->post("/sms/send", $parameters, []);
        $this->seeStatusCode(Response::HTTP_NOT_FOUND);
        $this->seeJsonStructure(
            [
                'error',
                'code'
            ]
        );
    }
}
