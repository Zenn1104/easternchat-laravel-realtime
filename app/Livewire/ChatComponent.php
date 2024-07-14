<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Events\NewMessage;
use App\Livewire\Layout\Sidebar;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatComponent extends Component
{
    public Group $group;
    public string $newMessage = ''; // Properti baru untuk input teks pesan
    public array $messages = []; // Properti untuk koleksi pesan

    public function getListeners(): array
    {
        return [
            "echo-private:group.{$this->group->id},MessageSent" => "listenForMessage",
        ];
    }

    public function mount(Group $group): void
    {
        $this->group = $group;
        $this->loadMessages();
    }

    public function loadMessages(): void
    {
        $messages = Message::with('user')->where('group_id', $this->group->id)->get();
        foreach ($messages as $message) {
             $this->messages[] = [
                'username' => $message->user->name,
                'content' => $message->content,
                'created_at' => $message->created_at
            ];
        }
    }

    public function sendMessage(): void
    {
        $this->validate([
            'newMessage' => 'required', // Validasi untuk properti 'newMessage'
        ]);

        $newMessages = new Message();
        $newMessages->group_id = $this->group->id;
        $newMessages->user_id = Auth::id();
        $newMessages->content = $this->newMessage;
        $newMessages->save();

        broadcast(new MessageSent(Auth::id(),$newMessages));
        $this->dispatch('new-message')->to(Sidebar::class);

        // Bersihkan input pesan
        $this->newMessage = '';
    }

    public function listenForMessage(array $event): array
    {
        return $this->messages[] = [
            'username' => $event['username'],
            'content' => $event['content'],
            'created_at' => $event['created_at']
        ];
    }


    public function clearMessage(): void
    {
        $this->group->messages()->where('user_id', Auth::id())->delete();
    }
}