<ul class="menu p-4 w-80 min-h-screen overflow-y-scroll bg-base-100 text-base-content">
  <div class="pb-2 mb-4 border-b border-base-300">
    <div class="flex justify-between">
      <a href="{{ route('dashboard') }}" wire:navigate>
        <x-application-logo class="block h-9 m-auto w-auto fill-current text-gray-800 dark:text-gray-200" />
      </a>
      <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="m-1">
          <x-tabler-dots-vertical class="size-4"/>
        </div>
        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
          <li><button wire:click="$dispatch('createGroup')">
            <x-tabler-plus class="size-5"/>
            <span>Buat Group</span>
          </button></li>
          <li>
            <a>
              <x-tabler-users-plus class="size-5"/>
              <span>Contact Baru</span>
            </a>
          </li>
          <li>
            <a href="{{ route('profile') }}">
              <x-tabler-user class="size-5"/>
              <span>Profile</span>
            </a>
          </li>
          <li><button wire:click="logout" class="text-error">
            <x-tabler-logout-2 class="size-5"/>
            <span>Logout</span>
          </button></li>
          <li>
        </ul>
      </div>
    </div>
  </div>
  <li>
    <input type="search" placeholder="Search Group..." class="input input-bordered w-full mb-2" wire:model.live="search">
  </li>
  @forelse ($groups as $group)
  <li class="border-b border-base-300" wire:click="markAsRead({{ $group->id }})">
    <a href="{{ route('group', $group) }}" class="flex items-center p-2 hover:bg-base-200" wire:navigate>
      <div class="avatar placeholder mr-3">
        <div class="bg-neutral-focus text-primary rounded-full w-12 ring-1 ring-inset ring-primary-700/10">
          <span>
              <x-tabler-users-group class="size-5"/>
          </span>
        </div>
      </div>
      <div class="flex-grow">
        <div class="text-sm font-bold">{{ $group->group_name }}</div>
        <div class="text-xs font-light line-clamp-1">
           @if ($group->latestMessage) 
              {{ $group->latestMessage->user->name }} : {{ Str::limit($group->latestMessage->content) }}
              @else 
              Be the first to message
          @endif
        </div>
      </div>
      <div class="flex flex-col items-end">
          <div class="text-xs text-black/50">
            @isset($group->latestMessage->created_at)
                {{ $group->latestMessage->created_at->format('H:i') }}
            @endisset
          </div>
          @if (isset($unreadMessageCount[$group->id]) && $unreadMessageCount[$group->id] > 0)
              <span class="inline-flex items-center rounded-md bg-purple-50/50 px-2 py-1 text-xs font-medium text-primary ring-1 ring-inset ring-primary-700/10">
                  {{ $unreadMessageCount[$group->id] }}
              </span> <!-- Unread messages badge -->
          @endif
      </div>
    </a>
  </li>
  @empty
    <div class="flex flex-col justify-center items-center mx-auto my-12">
      <p class="uppercase font-bold mb-4">No Group found...</p>
      <button wire:click="$dispatch('createGroup')" class="btn btn-outline btn-primary">
          <x-tabler-plus class="size-5"/>
          <span>Create Group</span>
      </button>
    </div>
  @endforelse
  @push('script')
      <script>
        $wire.on('group-info', (e) => {
            console.log(e);
            $wire.dispatch("showAlert", { detail: e });
            $wire.dispatch("playNotificationSound");
        });
      </script>
  @endpush
</ul>
