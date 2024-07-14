<?php

namespace App\Livewire\Forms;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Form;

class GroupChatForm extends Form
{
    public ?string $group_name;
    public ?Group $group;
    public array $selectedMembers = [];
    public $members = [];

    public function setGroup(Group $group): void
    {
        $this->group = $group;
        $this->group_name = $group->group_name;
    }

    public function store(): void
    {
        $this->validate([
            'group_name' => 'required|max:100',
            'members' => 'required|array|min:1',
            'members.*' => 'exists:users,id'
        ]);

        DB::transaction(function () {
            $this->group = Group::create([
                'group_name' => $this->group_name,
                'created_by' => Auth::id()
            ]);
            $this->group->users()->attach(Auth::id(), ['role' => 'admin']);
            $this->group->users()->attach($this->members, ['role' => 'member']);
        });


        $this->reset(['group_name', 'members']);
    }

    public function update(): void
    {
        $validated = $this->validate([
            'group_name' => 'required'
        ]);
        $this->group->update($validated);
        $this->reset();
    }

    public function addMembers(): void
    {
        $this->validate([
            'selectedMembers' => 'required|array',
            'selectedMembers.*' => 'exists:users,id',
        ]);

        $this->group->users()->attach($this->selectedMembers, ['role' => 'member']);
        $this->members = $this->group->users;
        $this->selectedMembers = [];
    }

}