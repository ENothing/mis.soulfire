<?php

namespace App\Models;


class User extends AppModel
{
    //
    protected $table = "users";

    public function user_level()
    {
        return $this->hasOne(UserLevel::class,"user_id",'id');

    }

}
