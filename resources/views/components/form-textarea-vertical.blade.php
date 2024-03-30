@props(['label', 'name', 'placeholder', 'value' => '', 'rows' => 3])
<div class="form-group">
    <label for="{{ $label }}">{{ $label }}</label>
    <textarea class="form-control" placeholder="{{ $placeholder }}" name="{{ $name }}" rows="{{ $rows }}">{{ $value }}</textarea>
</div>
