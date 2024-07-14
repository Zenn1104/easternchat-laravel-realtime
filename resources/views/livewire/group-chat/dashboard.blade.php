<div class="container w-full max-w-6xl p-6 mx-auto space-y-6">
    <div class="bg-base-100 border-2 border-base-300 rounded-lg whitespace-nowrap p-4 space-y-4">
        <div class="flex flex-col justify-center items-center w-full">
            <div class="flex justify-center items-center mb-8 mt-4 gap-2">
                <x-tabler-message-chatbot class="size-12"/>
                <p class="text-center text-4xl font-bold"> {{ config('app.name') }}</p>
            </div>
            <input type="search" class="input input-bordered w-3/4" placeholder="Search Group..." wire:model.live="search">
        </div>
        <div class="flex flex-wrap mx-auto p-4 justify-center items-center gap-4">
            @forelse ($groups as $group)
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="flex flex-col items-center pb-10">
                    <div class="avatar placeholder mx-4">
                        <div class="bg-neutral-focus text-primary text-4xl font-bold rounded-full uppercase w-24 h-24 shadow-lg">
                          <span>
                            {{ Str::substr($group->group_name, 0, 2) }}
                          </span>
                        </div>
                      </div>
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $group->group_name }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $group->users()->count() }} Members</span>
                    <div class="flex mt-4 md:mt-6">
                        <button type="button" class="btn btn-primary" wire:click="$dispatch('joinGroup', {group_id: {{ $group->id }}})">Join Group</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="flex flex-col justify-center items-center mx-auto my-12">
                <p class="uppercase font-bold mb-8">No Group found...</p>
                <button wire:click="$dispatch('createGroup')" class="btn btn-outline btn-primary">
                    <x-tabler-plus class="size-5"/>
                    <span>Create Group</span>
                </button>
            </div>
        @endforelse
        </div>
        <div class="w-3/4 m-auto">
            {{ $groups->links('pagination::daisyui') }}
        </div>
    </div>
</div>
