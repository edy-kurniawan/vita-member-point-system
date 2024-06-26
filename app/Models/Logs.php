<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'created_by',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
