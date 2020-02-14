<?php

namespace App\Traits;

trait Formatter
{
    /**
     * Formats time to hours and minutes
     * @param  int $seconds
     * @return string
     */
    private function timeFormatter($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $minutes = (round($minutes) % 10 === 0) ? round($minutes) :
            round(($minutes + 10 / 2) / 10) * 10;

        if ($minutes == 60) {
            $hours = $hours + 1;
            $minutes = 0;
        }

        $hour_text = $hours == 1 ? 'hour' : 'hours';

        if ($hours > 0 && $minutes > 0) {
            return "$hours $hour_text, $minutes minutes";
        }

        if ($hours > 0 && $minutes == 0) {
            return "$hours $hour_text";
        }

        if ($hours == 0 && $minutes > 0) {
            return "$minutes minutes";
        }

        return "10 minutes";
    }

    public function buildMessageBody($restaurant)
    {
        $restaurant_name = $restaurant['name'];
        $delivery_time = $this->timeFormatter($restaurant['delivery_time']);

        return "Take Away: Your order on $restaurant_name was received." .
            "The estimated delivery time is $delivery_time.";
    }
}
