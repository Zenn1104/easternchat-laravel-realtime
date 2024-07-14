<?php

namespace App\Livewire\GroupChat;

use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportRedirects\HandlesRedirects;

class Show extends Component
{
    public Group $group;
    public $members;
    public $created_by;
    
    public function getListeners(): array
    {
        return [
            'reload' => '$refresh',
        ];
    }

    public function mount(Group $group)
    {
        $this->group = $group;
        $this->members = $group->users;
        $this->created_by = $group->users()->where('id', $group->created_by)->first();
    }

    public function kickMember(string $memberId): void 
    {
        $member = User::find($memberId);

        $this->group->users()->detach($member->id);
        $this->members = $this->group->users;
    }

    public function leaveGroup(): void
    {
        $user_id = Auth::id();
        $this->group->users()->detach($user_id);
        $this->members = $this->group->users;
        $this->redirect('dashboard', navigate: true);
    }

    public function render(): View
    {
        return view('livewire.group-chat.show');
    }
}