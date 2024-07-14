<?php

namespace App\Livewire\Action;

use App\Livewire\Forms\GroupChatForm;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateGroup extends Component
{
    public bool $show = false;
    public GroupChatForm $form;

    #[On('createGroup')]
    public function createGroup(): void
    {
        $this->show = true;
    }

    public function save(): void
    {
        $this->form->store();

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
        return view('livewire.action.create-group',[
            'users' => User::get(),
        ]);
    }
}