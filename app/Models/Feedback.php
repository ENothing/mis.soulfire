<?php

namespace App\Models;


class Feedback extends AppModel
{
    //
    protected $table = "feedback";

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");

    }

}
