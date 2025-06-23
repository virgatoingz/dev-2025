<?php

namespace App\Helper;
use Illuminate\Support\Facades\Crypt;

class EncryptionHelper{
    public static function encrypt($data){
        $key = env('KEY_ECRYPT','default');
        return Crypt::encryptString($data,false);
    }
    public static function decrypt($encryptedData){
        try{
            return Crypt::decryptString($encryptedData);
        } catch (\Exception $e){
            return 'Decription Failed: ' . $e->getMessage();
        }
    }
}