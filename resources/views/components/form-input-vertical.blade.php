@props(['label', 'name', 'placeholder', 'type' => 'text', 'value' => ''])
<div class="form-group mb-3">
    <label class="mb-2">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control" name="{{ $name }}" placeholder="{{ $placeholder }}"
        value="{{ $value }}" />
</div>
