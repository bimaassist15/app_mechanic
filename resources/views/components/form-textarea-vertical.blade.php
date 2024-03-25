@props(['label', 'name', 'placeholder', 'value' => ''])
<div class="form-group">
    <label for="{{ $label }}">{{ $label }}</label>
    <textarea class="form-control" placeholder="{{ $placeholder }}" name="{{ $name }}">{{ $value }}</textarea>
</div>
