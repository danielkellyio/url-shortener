<?php

namespace App\Http\Controllers;

use App\Click;
use App\Url;
use Illuminate\Http\Request;

class ClicksController extends Controller
{
    /**
     * Get JSON listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $days = (int) $request->query('days');
        $last = $request->query('forLastXDays') ?: false;
        $query = $last
            ? Click::forLastXDays($days)
            : Click::forXDayAgo($days);

        $clicks = $query->whereIn('url_id', Url::idsForCurrentUser())->get();
        return response()->json($clicks);
    }

    public function count( Request $request ){
        $days = $request->query('days');
        $last = $request->query('forLastXDays') ?: false;
        if(is_array($days)){
            $clicks = [];
            foreach ($days as $day){
                $day = (int) $day;
                $query = $last
                    ? Click::forLastXDays($day)
                    : Click::forXDayAgo($day);
                $clicks[$day] = $query->whereIn('url_id', Url::idsForCurrentUser())->count();
            }
        }else{
            $days = (int) $days;
            $query = $last
                ? Click::forLastXDays($days)
                : Click::forXDayAgo($days);
            $clicks = $query->whereIn('url_id', Url::idsForCurrentUser())->count();
        }

        return response()->json($clicks);
    }
}
