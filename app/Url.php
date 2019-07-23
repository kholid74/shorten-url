<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Url extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public function getShortUrl()
    {
        return url(strtr(rtrim(base64_encode(pack('i', $this->id)), '='), '+/', '-_'));
    }
    public static function findByCode($code)
    {
        $id = unpack('i', base64_decode(str_pad(strtr($code, '-_', '+/'), strlen($code) % 4, '=')));
        return Url::findOrFail($id);
    }
    
}
