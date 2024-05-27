<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    protected $fillable = [
        'reward_id',
        'member_id',
        'qty',
        'user_id',
    ];

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'reward_id');
    }
}
