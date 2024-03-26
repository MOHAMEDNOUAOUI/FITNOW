<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'weight',
        'hips',
        'chest',
        'waist',
        'performance',
        'status',
    ];


    public function progress() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
