<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wallet_id',
        'status',
        'amount',
        'note',
        'type',
    ];



    public function user() {
        return $this->belongsTo(User::class);
    }

}
