<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'group_id', 'content', 'read_at'
    ];

     // Message dimiliki oleh User
     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }
 
     // Message dimiliki oleh Group
     public function group(): BelongsTo
     {
         return $this->belongsTo(Group::class);
     }
}