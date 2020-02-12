<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Http\Controllers\RestaurantController;

class SmsService implements SmsServiceInterface
{
    private $account_sid;
    private $auth_token;
    private $twilio_number;
    private $restaurant;

    use ApiResponser;

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

        return $this->successResponse(array('status' => 'sent'));
    }
}
