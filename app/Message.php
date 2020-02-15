<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'status', 'restaurant_id', 'phone_number',
    ];

    /**
     * Get the restaurant that owns the message.
     */
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
