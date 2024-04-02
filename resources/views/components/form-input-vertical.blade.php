@props(['label', 'name', 'placeholder', 'type' => 'text', 'value' => '', 'class' => ''])
<div class="form-group mb-3">
    <label class="mb-2">{{ $label }}</label>
    <input type="{{ $type }}" class="form-control {{ $class }}" name="{{ $name }}"
        placeholder="{{ $placeholder }}" value="{{ $value }}" />
</div>
