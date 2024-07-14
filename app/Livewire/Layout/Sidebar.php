<?php

namespace App\Livewire\Layout;

use App\Events\MessageSent;
use App\Livewire\Actions\Logout;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public string $search = "";
    public array $unreadMessageCount = [];

    public function getListeners(): array
    {
        return [
            'echo:group-info,MessageSent' => 'handleRefreshLatestMessage',
            'reload' => '$refresh',
        ];
    }

    public function handleRefreshLatestMessage(array $event): void
    {
        $user = User::where('id', $event['sender_id'])->first();
        $group = Group::find($event['group_id']);

        if ($user->id !== Auth::id()) {      
            $this->dispatch('showAlert', detail: $event);
            $this->dispatch('playNotificationSound');
            $this->updateUnreadCount();
                
        } 
    }

    public function mount(): void
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount(string $group_id = null): void
    {
        if ($group_id) {
            $this->unreadMessageCount[$group_id] = Message::where('group_id', $group_id)
                ->where('user_id', Auth::id())
                ->whereNull('read_at')
                ->latest()
                ->count();
        } else {
            $groups = Auth::user()->groups;
            foreach ($groups as $group) {
                $this->unreadMessageCount[$group->id] = Message::where('group_id', $group->id)
                    ->where('user_id', Auth::id())
                    ->whereNull('read_at')
                    ->latest()
                    ->count();
            }
        }
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }


    public function markAsRead(string $groupId): void
    {
        $group = Group::find($groupId);

        if (isset($group)) {
            $messages = $group->messages()
                ->where('user_id', Auth::id())
                ->whereNull('read_at')
                ->get();

            foreach ($messages as $message) {
                $message->update(['read_at' => now()]);
            }

            $this->updateUnreadCount();
        }
    }


    public function render(): View
    {
        return view('livewire.layout.sidebar', [
            'groups' =>  Group::whereHas('users', function ($query) {
                $query->where('user_id', Auth::id());
            })
                ->when($this->search, function ($query) {
                    $query->where("group_name", "like", "%{$this->search}%");
                })
                ->with(['messages' => function ($query) {
                    $query->latest()->limit(1);
                }])
                ->get()
                ->sortByDesc(function ($query) {
                    return $query->latestMessage->created_at ?? $query->created_at;
                }),
        ]);
    }
}