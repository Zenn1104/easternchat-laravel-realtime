<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('group.{group_id}', function (User $user, $group_id) {
    // Retrieve the group
    $group = Group::find($group_id);

    // Check if the group contains the user
    return $group && $group->users->contains($user->id);
});

Broadcast::channel('message-group.{group_id}', function (User $user, $group_id) {
    // Retrieve the group
    $group = Group::find($group_id);

    // Check if the group contains the user
    return $group && $group->users->contains($user->id);
});

Broadcast::channel('group-info', function(){
    return true;
});