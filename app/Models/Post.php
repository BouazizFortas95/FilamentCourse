<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
