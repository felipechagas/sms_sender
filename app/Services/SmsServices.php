<?php

namespace App\Services;

use App\Traits\ApiResponser;

class SmsService implements SmsServiceInterface
{
    use ApiResponser;

    /**
     * Create a new SmsController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     *
     *
     * @param
     * @return
     */
    public function send()
    {
        return $this->successResponse([]);
    }
}
