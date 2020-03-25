<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Url extends Model
{
    public $incrementing = false;
    public $appends = ['originalId'];
    protected $fillable = ['id', 'url'];

    public static function forCurrentUser(){
        $user = Auth::user();
        return self::where('user_id', $user->id);
    }

    public static function idsForCurrentUser(){
        $urls = self::forCurrentUser()->select('id')->get();
        return $urls->map(function($url){
            return $url->id;
        });
    }

    public function getOriginalIdAttribute(){
        return $this->id;
    }
    public function clicks(){
        return $this->hasMany('App\Click');
    }
}
