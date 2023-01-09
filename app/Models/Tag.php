<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public $timestamps = false;

    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Photo::class,
            table: 'photo_tag',
        );
    }
}
