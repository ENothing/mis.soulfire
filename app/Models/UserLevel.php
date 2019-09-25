<?php

namespace App\Models;


class UserLevel extends AppModel
{
    //
    protected $table = "user_level";

    public function level()
    {
        return $this->hasOne(Level::class,"id",'level_id');

    }

}
