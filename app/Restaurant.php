<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'delivery_time',
    ];

    /**
     * Get the messages of the restaurant.
     */
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
