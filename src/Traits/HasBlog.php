<?php

namespace irajul\Blogflow\Traits;

use irajul\Blogflow\Models\Post;

trait HasBlog
{
    public function name()
    {
        return $this->{config('blogflow.user.columns.name')};
    }

    public function posts()
    {
        return $this->hasMany(Post::class, config('blogflow.user.foreign_key'));
    }
}
