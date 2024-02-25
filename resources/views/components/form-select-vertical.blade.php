@props(['label', 'name', 'data'])

<div class="form-group mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
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
