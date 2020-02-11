<?php

namespace App\Http\Controllers;

use App\Restaurant;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SmsController extends Controller
{
    use ApiResponser;

    /**
     * Create a new RestaurantController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Send sms
     * @return Illuminate\Http\Response
     */
    public function send()
    {
        return $this->successResponse([]);
    }
}
