<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Traits\Formatter;
use App\Restaurant;
use App\Message;
use Exception;
use Illuminate\Http\Response;
use Twilio\Rest\Client;
use Carbon\Carbon;

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
    public function send($restaurant_id, $phone_number, $type)
    {
        $restaurant = $this->restaurant->findOrFail($restaurant_id);

        $body = $this->buildMessageBody($restaurant, $type);

        $this->message = $this->message->create([
            'body' => $body,
            'status' => 'error',
            'restaurant_id' => $restaurant_id,
            'phone_number' => $phone_number,
            'type' => $type,
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

    /**
     *
     *
     * @param
     * @return
     */
    public function sendScheduledSms() {
        $messages = $this->message->
            join('restaurants', 'messages.restaurant_id', '=', 'restaurants.id')->

            whereRaw(
                'DATE_ADD(messages.updated_at, INTERVAL restaurants.delivery_time SECOND) > '.
                'DATE_SUB(CURRENT_TIME(), INTERVAL 15 MINUTE)'
            )->

            whereRaw(
                'DATE_ADD(messages.updated_at, INTERVAL restaurants.delivery_time SECOND) < '.
                'DATE_SUB(CURRENT_TIME(), INTERVAL 0 MINUTE)'
            )->
            where("type", "=", "before")->
            where("status", "=","delivered")->
            get();

        foreach ($messages as $message) {
            $this->send(
                $message['restaurant_id'],
                $message['phone_number'],
                'after'
            );
        }

        return sizeof($messages);
    }
}
