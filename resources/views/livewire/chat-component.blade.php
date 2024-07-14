<div class="flex-1 flex flex-col">
    <!-- Chat header -->
    <div class="bg-base-100 p-3 flex items-center justify-between py-1 border-b-2 border-base-300">
      <!-- Contact info -->
      <div class="flex items-center gap-1 w-full">
        <a href="{{ route('dashboard') }}" wire:navigate>
          <x-tabler-arrow-narrow-left class="size-5"/>
        </a>
        <a href="{{ route('detail', $group->id) }}" wire:navigate>
        <div class="flex items-center gap-1">
            <div class="avatar placeholder">
              <div class="bg-neutral-focus text-primary rounded-full w-12">
                <span>
                    <x-tabler-users class="size-5"/>
                </span>
              </div>
            </div>
          <div>
            <p class="text-base font-semibold">{{ $group->group_name }}</p>
            <p class="text-xs">{{ count($group->users) }} Members</p>
          </div>
        </div>
      </a>
      </div>
      <div class="gap-1">
        <div class="dropdown dropdown-end">
          <div tabindex="0" role="button" class="m-1">
            <x-tabler-dots-vertical class="size-5"/>
          </div>
          <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
            <li>
              <a href="{{ route('detail', $group->id) }}" wire:navigate>
                <x-tabler-info-circle class="size-5"/>
                <span>Info Group</span>
              </a>
            </li>
            <li>
              <button wire:click="clearMessage" class="text-error">
                <x-tabler-trash class="size-5"/>
                <span>Clear Chat</span>
              </button>
            </li>
            <li>
              <a class="text-error">
                <x-tabler-logout class="size-5"/>
                <span>Left Group</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- Messages container -->
    <div class="flex-1 p-3 min-h-128 max-h-128 overflow-y-scroll scrollbar-hide">
      <!-- Messages -->
      @foreach ($messages as $message)
        <div @class(['chat chat-start', 'chat-end' => Auth::user()->name == $message['username']])>
          <div class="chat-header">
            {{ $message['username'] }}
          </div>
          <div @class(['chat-bubble', 'chat-bubble-primary' => Auth::user()->name == $message['username']])>
            {{ $message['content'] }}
          </div>
          <div class="chat-footer text-xs opacity-50">
            {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
          </div>
        </div>
      @endforeach
    </div>
    <!-- Chat input -->
    <div class="pt-3 border-t border-gray-200 form-control">
      <form class="flex items-center justify-between" wire:submit.prevent="sendMessage">
        <input type="text" placeholder="Type a message..." class="input input-bordered w-full" wire:key="{{ now() }}" wire:model="newMessage">
        <button type="submit" class="btn btn-primary btn-square">
          <x-tabler-send-2 class="size-5"/>
        </button>
      </form>
    </div>
    </div>
