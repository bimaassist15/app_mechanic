@props(['label', 'name', 'placeholder'])
<div class="form-group">
    <label for="{{ $label }}">{{ $label }}</label>
    <textarea class="form-control" placeholder="{{ $placeholder }}" name="{{ $name }}"></textarea>
</div>
