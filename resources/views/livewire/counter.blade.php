<div>

    <div class="my-2">
        the value : <span>{{ $count }}</span>
    </div>

    <button class="btn btn-primary" wire:click="inc" >Add</button>
    <button class="btn btn-danger" @click="$wire.count=55">DEC</button>
    <button class="btn btn-danger" @click="$wire.$refresh()">REF</button>

</div>
