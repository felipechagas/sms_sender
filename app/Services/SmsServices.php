<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Traits\Formatter;
use App\Restaurant;
use App\Message;
use Exception;
use Illuminate\Http\Response;
use Twilio\Rest\Client;

class SmsService implements SmsServiceInterface
{
    private $account_sid;
    private $auth_token;
    private $twilio_number;
    protected $message;
    protected $restaurant;
    protected $client;

    use ApiResponser;
    use Formatter;

    /**
     * Create a new SmsController instance.
     *
     * @return void
     */
    public function __construct($client = null, $message = null, $restaurant = null)
    {
        $this->account_sid = getenv("TWILIO_SID");
        $this->auth_token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilio_number = getenv("TWILIO_NUMBER");

        $this->message = $message === null ? new Message() : $message;

        $this->restaurant = $restaurant === null ? new Restaurant() : $restaurant;

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
        $restaurant = $this->restaurant->findOrFail($restaurant_id);

        $body = $this->buildMessageBody($restaurant);

        $this->message = $this->message->create([
            'body' => $body,
            'status' => 'error',
            'restaurant_id' => $restaurant_id,
        ]);

        try {
            $this->client->messages->create(
                $phone_number,
                array(
                    'from' => $this->twilio_number,
                    'body' => $body
                )
            );
        } catch (Exception $e) {
            return $this->errorResponse(
                'SMS Service unavailable.',
                Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        $this->message->fill(['status' => 'delivered']);
        $this->message->save();

        return $this->successResponse($this->message);
    }
}
