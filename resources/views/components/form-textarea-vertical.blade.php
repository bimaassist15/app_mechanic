@props(['label', 'name', 'placeholder', 'value' => '', 'rows' => 3, 'disabled' => ''])
<div class="form-group">
    <label for="{{ $label }}">{{ $label }}</label>
    <textarea class="form-control" placeholder="{{ $placeholder }}" name="{{ $name }}" rows="{{ $rows }}" {{ $disabled }}>{{ $value }}</textarea>
</div>
