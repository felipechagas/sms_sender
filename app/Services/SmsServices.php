<?php

namespace App\Services;

use App\Traits\ApiResponser;

class SmsService implements SmsServiceInterface
{
    private $account_sid;
    private $auth_token;
    private $twilio_number;

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
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function send()
    {
        return $this->successResponse(array('status' => 'sent'));
    }
}
