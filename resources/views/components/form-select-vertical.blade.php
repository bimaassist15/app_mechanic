@props(['label', 'name', 'data' => [], 'value' => '', 'disabled' => ''])

<div class="form-group mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" class="form-select" id="{{ $name }}" {{ $disabled }}>
        <option selected value="">-- Pilih {{ $label }} --</option>
        @foreach ($data as $index => $item)
            @php
                $item = (object) $item;
            @endphp
            <option value="{{ $item->id }}" {{ $item->id == $value ? 'selected' : '' }}>{{ $item->label }}</option>
        @endforeach
    </select>
</div>
