<?php

namespace App\Services;

interface SmsServiceInterface
{
    /**
     *
     *
     * @param int
     */
    public function send($restaurant_id, $phone_number);
}
