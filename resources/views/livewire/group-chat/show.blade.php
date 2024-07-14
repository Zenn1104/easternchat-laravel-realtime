<div class="flex-1 flex flex-col">
  <div class="bg-base-100 p-3 flex items-center justify-between py-1 border-b-2 border-base-300">
    <!-- Contact info -->
    <div class="flex items-center gap-1 w-full">
      <a href="{{ route('group', $group->id) }}" wire:navigate>
        <x-tabler-arrow-narrow-left class="size-5"/>
      </a>
    </div>
    <div class="gap-1">
      <div class="dropdown dropdown-end">
        <div tabindex="0" role="button" class="m-1">
          <x-tabler-dots-vertical class="size-5"/>
        </div>
        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
          <li>
            <button wire:click="$dispatch('editGroup', {group: {{ $group->id }}})">
              <x-tabler-edit class="size-5"/>
              <span>Edit Groupname</span>
            </button>
          </li>
          <li>
            <button wire:click="$dispatch('addMember', {group: {{ $group->id }}})">
              <x-tabler-user-plus class="size-5"/>
              <span>Add Member</span>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="bg-base-100">
    <div class="flex flex-col items-center pt-4">
      <div class="avatar placeholder mx-4">
        <div class="bg-neutral-focus text-primary text-6xl font-bold rounded-full uppercase w-24 h-24 ring-1 ring-inset ring-primary-700/10">
          <span>
            {{ Str::substr($group->group_name, 0, 1) }}
          </span>
        </div>
      </div>
        <h2 class="text-xl font-bold mb-2">{{ $group->group_name }}</h2>
        <p class="text-sm text-gray-500 mb-4">{{ $members->count() }} Members</p>
        <p class="text-xs text-gray-400 mb-2">Dibuat oleh {{ $created_by->name }}, {{ $group->created_at->format('d/m/y') }}</p>
  </div>        <!-- Member List -->
   <div class="flow-root">
    <div class="text-base font-bold mx-6 my-4">{{ $members->count() }} Members</div>
      <ul role="list" class="devide-y devide-gray-200 mx-6">
        @foreach ($members as $member)
          <li class="py-3 sm:py-4 flex items-center justify-between hover:bg-base-200">
              <div class="avatar placeholder flex items-center space-x-2">
                <div class="bg-neutral-focus text-primary rounded-full w-12 ring-1 ring-inset ring-primary-700/10">
                  <span>
                    {{ Str::substr($member->name, 0, 2) }}
                  </span>
                </div>
                <span class="text-sm font-medium">{{ $member->name }}</span>
              </div>
              <div class="flex">
                @if ($group->created_by === $member->id)
                <span class='inline-flex items-center rounded-md bg-purple-50 px-2 py-1 text-xs font-medium text-primary ring-1 ring-inset ring-primary-700/10'>
                  Owner
                </span>
                @endif
                <div @class(['dropdown dropdown-end bottom-4', 'hidden' => Auth::id() === $member->id || Auth::id() !== $group->created_by])>
                  <div tabindex="0" role="button" class="m-1">
                    <x-tabler-chevron-down class="size-5"/>
                  </div>
                  <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                      <button wire:click="kickMember({{ $member->id }})">
                        <span>Kick</span>
                      </button>
                    </li>
                  </ul>
                </div>
              </div>
          </li>
        @endforeach
    </ul>  
  </div>
  <div class="bg-base-100">
    <!-- Leave Group Button -->
    <button wire:click="leaveGroup" class="btn btn-ghost text-error w-full">
      <x-tabler-logout class="size-5"/>
      <span>Keluar Grup</span>
    </button>
  </div>
  </div>
</div>