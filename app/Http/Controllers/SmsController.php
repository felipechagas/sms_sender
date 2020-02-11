<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\SmsServiceInterface;

class SmsController extends Controller
{
    use ApiResponser;

    protected $sms;

    /**
     * Create a new SmsController instance.
     *
     * @return void
     */
    public function __construct(SmsServiceInterface $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Send sms
     * @return Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $rules = [
            'restaurant_id' => 'required',
            'phone_number' => 'required',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        return $this->sms->send($data['restaurant_id'], $data['phone_number']);
    }
}
