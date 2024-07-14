<?php

namespace App\Livewire\Action;

use App\Livewire\Forms\GroupChatForm;
use App\Models\Group;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportRedirects\HandlesRedirects;

class AddMember extends Component
{
    public bool $show = false;
    public GroupChatForm $form;

    #[On('addMember')]
    public function addMember(Group $group): void
    {
        $this->form->setGroup($group);
        $this->show = true;
        $this->dispatch('reload');
    }

    #[On('joinGroup')]
    public function joinGroup(string $group_id): void
    {
        $user = Auth::id();
        $group = Group::find($group_id);

        if($group){
            $group->users()->attach($user, ['role' => 'member']);
        }

        $this->redirect('/group/'.$group->id,navigate:true);
    }

    public function save(): void
    {
        $this->form->addMembers();

        $this->dispatch('reload');
        $this->closeGroupModal();
    }
    
    public function closeGroupModal(): void
    {
        $this->show = false;
        $this->form->reset();
        $this->dispatch('reload');
    }
    public function render(): View
    {
        return view('livewire.action.add-member', [
            'users' => User::get(),
        ]);
    }
}