<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Greeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'descriptions',
        'image',
        'video',
        'date',
        'time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
