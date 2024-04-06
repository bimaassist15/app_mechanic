@props(['label', 'name', 'placeholder', 'value' => '', 'rows' => 4])
<div class="row mb-3">
    <label class="col-sm-3 col-form-label">{{ $label }}</label>
    <div class="col-sm-9">
        <textarea rows="{{ $rows }}" class="form-control" placeholder="{{ $placeholder }}" name="{{ $name }}">{{ $value }}</textarea>
    </div>
</div>
