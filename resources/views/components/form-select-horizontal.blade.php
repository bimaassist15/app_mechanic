@props(['label', 'name', 'data'])

<div class="row mb-3">
    <label for="{{ $name }}" class="form-label col-sm-3">{{ $label }}</label>
    <div class="col-sm-9">
        <select name="{{ $name }}" class="form-select" id="{{ $name }}">
            <option selected>-- Pilih {{ $label }} --</option>
            @foreach ($data as $index => $item)
                @php
                    $item = (object) $item;
                @endphp
                <option value="{{ $item->id }}">{{ $item->label }}</option>
            @endforeach
        </select>
    </div>
</div>
