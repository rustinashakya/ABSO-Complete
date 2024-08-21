<div>
    <h4 class="mb-4">Service Accordion</h4>

    @foreach ($rows as $index => $row)
        <div class="row row-container mb-3" wire:key="row-{{ $index }}">
            <div class="col-md-5">
                <label for="title" class="form-label">Title <span class="text-danger"> *</span></label>
                <input type="text" wire:model="rows.{{ $index }}.title" name="rows[{{ $index }}][title]"
                    class="form-control @error('rows.' . $index . '.title') is-invalid @enderror" placeholder="Title">
                @error('rows.' . $index . '.title')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="body" class="form-label">Body <span class="text-danger"> *</span></label>
                <input type="text" wire:model="rows.{{ $index }}.body" name="rows[{{ $index }}][body]"
                    class="form-control @error('rows.' . $index . '.body') is-invalid @enderror" placeholder="Body">
                @error('rows.' . $index . '.body')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-1 mt-4">
                {{-- @if ($index > 0) --}}
                    <button type="button" wire:click="removeRow({{ $index }})" class="btn btn-danger" title="Remove Row">X</button>
                {{-- @endif --}}
            </div>
        </div>
    @endforeach

    <button type="button" wire:click="addRow" class="btn btn-primary mb-3" title="Add Accordion">+</button>
</div>
