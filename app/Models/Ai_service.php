<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ai_service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url'];

    public $timestamps = false;

    public function photos(): HasMany
    {
        return $this->hasMany(
            related: Photo::class,
            foreignKey: 'ai_service_id',
        );
    }
}
