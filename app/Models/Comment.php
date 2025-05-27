<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{

    protected $guarded = [];

     /**
     * Get the commentable that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable() : MorphTo {
        return $this->morphTo();
    }

    /**
     * Get the user that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     /**
     * Get the comments that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments() : MorphMany {
        return $this->morphMany($this, 'commentable');
    }
}
