<?php

namespace App\Helper;
use Illuminate\Support\Facades\Crypt;

class EncryptionHelper{
    public static function encrypt($data){
        $key = env('KEY_ECRYPT','default')
        return Crypt::encryptString()
    }
    public static function decrypt($encrypt){
        try{
            return Crypt
        }
    }
}