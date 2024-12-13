<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    public function posts():BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
