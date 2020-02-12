<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Traits\Formatter;
use App\Http\Controllers\RestaurantController;
use Twilio\Rest\Client;

class SmsService implements SmsServiceInterface
{
    private $account_sid;
    private $auth_token;
    private $twilio_number;
    private $restaurant;

    use ApiResponser;
    use Formatter;

    /**
     * Create a new SmsController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->account_sid = getenv("TWILIO_SID");
        $this->auth_token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_number = getenv("TWILIO_NUMBER");
        $this->restaurant = new RestaurantController();
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function send($restaurant_id, $phone_number)
    {
        $json_restaurant = $this->restaurant->show($restaurant_id);
        $restaurant = $json_restaurant->getData(true);

        $restaurant_name = $restaurant['data']['name'];
        $delivery_time = $this->timeFormatter($restaurant['data']['delivery_time']);

        $client = new Client($this->account_sid, $this->auth_token);
        $client->messages->create(
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
