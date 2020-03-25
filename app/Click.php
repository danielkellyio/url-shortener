<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    public static function newFromRequest(){
        $click = new self();
        $click->ip_address = request()->getClientIp();
        $click->referrer = $_SERVER['HTTP_REFERER'] ?? null;
        $click->url_id = request()->route()->parameters['id'];
        $click->save();
    }

    public static function forXDayAgo($days=-1){
        if($days > 0){
            $daysAgo = date('Y-m-d', strtotime("-$days days"));
            $daysAgoPlusOne = $days - 1;
            $daysAgoTomorrow = date('Y-m-d', strtotime("-$daysAgoPlusOne days"));
            return self::whereBetween('created_at', [$daysAgo, $daysAgoTomorrow]);
        }
        // not a valid number of days or -1 return today
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime("+1 days"));
        return self::whereBetween('created_at', [$today, $tomorrow]);
    }
    public static function forLastXDays($days= -1){
        if($days > -1){
            $tomorrow = date('Y-m-d', strtotime("+1 days"));
            $daysAgo = date('Y-m-d', strtotime("-$days days"));
            return self::whereBetween('created_at', [$daysAgo, $tomorrow]);
        }

        // not a valid number of days or -1 return all
        return self::where('id', '>', 0);
    }
}
