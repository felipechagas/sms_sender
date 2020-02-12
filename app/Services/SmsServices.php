<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Traits\Formatter;
use App\Http\Controllers\RestaurantController;
use Exception;
use Illuminate\Http\Response;
use Twilio\Rest\Client;

class SmsService implements SmsServiceInterface
{
    private $account_sid;
    private $auth_token;
    private $twilio_number;
    protected $restaurant_controller;
    protected $client;

    use ApiResponser;
    use Formatter;

    /**
     * Create a new SmsController instance.
     *
     * @return void
     */
    public function __construct($restaurant_controller = null, $client = null)
    {
        $this->account_sid = getenv("TWILIO_SID");
        $this->auth_token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_number = getenv("TWILIO_NUMBER");
        $this->restaurant_controller =
            $restaurant_controller === null ?
            new RestaurantController() :
            $restaurant_controller;
        $this->client =
            $client === null ?
            new Client($this->account_sid, $this->auth_token) :
            $client;
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function send($restaurant_id, $phone_number)
    {
        try {
            $json_restaurant = $this->restaurant_controller->show($restaurant_id);
        } catch (Exception $e) {
            return $this->errorResponse("Does not exist any instance of restaurant with the given id", Response::HTTP_NOT_FOUND);
        }

        $restaurant = $json_restaurant->getData(true);

        $restaurant_name = $restaurant['data']['name'];
        $delivery_time = $this->timeFormatter($restaurant['data']['delivery_time']);

        $this->client->messages->create(
            $phone_number,
            array(
                'from' => $this->twilio_number,
                'body' => "Take Away: Your order on $restaurant_name was received." .
                    "The estimated delivery time is $delivery_time."
            )
        );

        return $this->successResponse(array('status' => 'sent'));
    }
}
