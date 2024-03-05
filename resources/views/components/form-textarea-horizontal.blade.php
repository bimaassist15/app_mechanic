@props(['label', 'name', 'placeholder', 'value' => ''])
<div class="row mb-3">
    <label class="col-sm-3 col-form-label">{{ $label }}</label>
    <div class="col-sm-9">
        <textarea class="form-control" placeholder="{{ $placeholder }}" name="{{ $name }}">{{ $value }}</textarea>
    </div>
</div>
