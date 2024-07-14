<x-action-modal>
    <input type="checkbox" id="my_modal_6" class="modal-toggle" @checked($show)/>
    <div class="modal" role="dialog">
        <form class="modal-box" wire:submit.prevent="save">
            <h3 class="font-bold text-lg">Edit Group Name</h3>
            <div class="py-4 space-y-2">
                <label class="form-control">
                    <div class="label">
                        <div class="label-text">Group Name</div>
                    </div>
                    <input type="text" placeholder="type here..." @class(['input input-bordered', 'input-error' => $errors->first('form.group_name')]) wire:model="form.group_name">
                </label>
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
