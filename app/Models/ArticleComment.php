<?php

namespace App\Models;


class ArticleComment extends AppModel
{
    //
    protected $table = "article_comments";

    public function article()
    {
        return $this->belongsTo(Article::class,"article_id","id");

    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");

    }

    public function article_comment()
    {
        return $this->hasMany(ArticleComment::class,"parent_id","id");

    }

}
