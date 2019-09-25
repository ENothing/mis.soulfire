<?php

namespace App\Models;


class Article extends AppModel
{
    //
    protected $table = "articles";

    public function article_cate()
    {
        return $this->belongsTo(ArticleCate::class,"cate_id","id");

    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");

    }


}
