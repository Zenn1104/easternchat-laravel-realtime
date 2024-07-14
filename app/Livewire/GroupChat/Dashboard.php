<?php

namespace App\Livewire\GroupChat;

use App\Models\Group;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    public int $per_page = 10;
    public string $search = "";

    public function render(): View
    {
        return view('livewire.group-chat.dashboard', [
            'groups' => Group::whereDoesntHave('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->when($this->search, function ($query) {
                    $query->where("group_name", "like", "%{$this->search}%");
                })
                ->paginate($this->per_page),
        ]);
    }
}