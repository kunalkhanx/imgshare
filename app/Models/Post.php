<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    public function images():HasMany{
        return $this->hasMany(Image::class);
    }

    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }

    public function reports():HasMany{
        return $this->hasMany(Report::class);
    }
}
