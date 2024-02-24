@props(['label', 'name', 'placeholder', 'type' => 'text'])
<div class="row mb-3">
    <label class="col-sm-3 col-form-label">{{ $label }}</label>
    <div class="col-sm-9">
        <input type="{{ $type }}" class="form-control" name="{{ $name }}"
            placeholder="{{ $placeholder }}" />
    </div>
</div>
