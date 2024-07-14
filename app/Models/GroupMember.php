<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'group_id', 'role' , 'last_read_at'   
    ];

     // GroupMember terkait dengan User
     public function user(): BelongsTo
     {
         return $this->belongsTo(User::class);
     }
 
     // GroupMember terkait dengan Group
     public function group(): BelongsTo
     {
         return $this->belongsTo(Group::class);
     }
}