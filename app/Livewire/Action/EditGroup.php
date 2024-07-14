<?php

namespace App\Livewire\Action;

use App\Livewire\Forms\GroupChatForm;
use App\Models\Group;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class EditGroup extends Component
{
    public bool $show = false;
    public GroupChatForm $form;

    #[On('editGroup')]
    public function editGroup(Group $group): void
    {
        $this->form->setGroup($group);
        $this->show = true;
        $this->dispatch('reload');
    }

    public function save(): void
    {
        $this->form->update(); 

        $this->dispatch('reload');
        $this->closeGroupModal();
    }
    
    public function closeGroupModal(): void
    {
        $this->show = false;
        $this->form->reset();
    }

    public function render(): View
    {
        return view('livewire.action.edit-group');
    }
}