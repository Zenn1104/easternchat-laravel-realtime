<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name', 'created_by'
    ];

    // Group memiliki banyak Message
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function unreadMessages()
    {
        return $this->messages()->where('created_at' , '>', isset($this->pivot->last_read_at));
    }

    // Group memiliki banyak User melalui GroupMember
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot('last_read_at')->withTimestamps();
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}