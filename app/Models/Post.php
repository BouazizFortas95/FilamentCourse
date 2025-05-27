<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $guarded = [];

    protected $casts = ['tags' => 'array'];

    /**
     * Get the category that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * The authors that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_user', 'user_id', 'post_id')
            ->withPivot('order')
            ->withTimestamps();
    }

     /**
     * Get the comments that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments() : MorphMany {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
