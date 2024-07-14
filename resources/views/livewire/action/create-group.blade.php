<x-action-modal>
    <input type="checkbox" id="my_modal_6" class="modal-toggle" @checked($show)/>
    <div class="modal" role="dialog">
        <form class="modal-box" wire:submit.prevent="save">
            <h3 class="font-bold text-lg">Create Group</h3>
            <div class="py-4 space-y-2">
                <label @class(['form-control', 'hidden' => method_exists($this, 'addMembers')])>
                    <div class="label">
                        <div class="label-text">Group Name</div>
                    </div>
                    <input type="text" placeholder="type here..." @class(['input input-bordered', 'input-error' => $errors->first('form.group_name')]) wire:model="form.group_name">
                </label>
                <div class="selected-members mt-6">
                    @foreach($form->members as $selectedMemberId)
                    <div class="avatar placeholder">
                          <div class="bg-neutral-focus text-primary rounded-full w-10 h-10 ring-1 ring-inset ring-primary-700/10 flex items-center justify-center">
                            <span>{{ Str::substr($users->find($selectedMemberId)->name, 0, 2) }}</span>
                          </div>
                          <span class="selected-member mt-2 mx-2">{{ $users->find($selectedMemberId)->name }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="py-4 space-y-2 w-full">
                    <div id="members" class="flex flex-col space-y-2">
                      <div class="form-control">
                        <div class="label">
                          <span class="label-text">Pilih Anggota</span>
                        </div>
                        <ul class="max-h-64 overflow-y-auto scrollbar-hide">
                          @foreach($users as $user)
                            <li class="border-b border-base-300 py-2">
                              <label class="flex items-center p-2 hover:bg-base-200">
                                <input id="user{{ $user->id }}" type="checkbox" value="{{ $user->id }}" aria-label="{{ $user->name }}" wire:key="{{ $user->id }}" wire:model.live="form.members" class="mr-3 checkbox checkbox-primary">
                                <div class="avatar placeholder">
                                  <div class="bg-neutral-focus text-primary rounded-full w-10 h-10 ring-1 ring-inset ring-primary-700/10 flex items-center justify-center">
                                    <span>{{ Str::substr($user->name, 0, 2) }}</span>
                                  </div>
                                </div>
                                <div class="flex-grow pl-3">
                                  <span class="text-sm font-bold {{ $form->members && in_array($user->id, $form->members) ? 'text-primary' : '' }}" wire:click.prevent>{{ $user->name }}</span>
                                </div>
                              </label>
                            </li>
                          @endforeach
                        </ul>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="modal-action justify-between">
            <button type="button" class="btn btn-ghost" wire:click="closeGroupModal">Close</button>
            <button type="submit" class="btn btn-primary">
                <x-tabler-check class="size-5"/>
                <span>Save</span>
            </button>
            </div>
        </form>
    </div>
</x-action-modal>
