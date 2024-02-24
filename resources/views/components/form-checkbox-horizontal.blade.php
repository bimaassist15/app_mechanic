@props(['label', 'name', 'labelInput', 'checked'])
<div class="row">
    <div class="col-sm-3">
        {{ $label }}
    </div>
    <div class="col-sm-9">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" name="{{ $name }}" type="checkbox" id="{{ $name }}" {{ $checked }}>
            <label class="form-check-label" for="{{ $name }}">{{ $labelInput }}</label>
        </div>
    </div>
</div>