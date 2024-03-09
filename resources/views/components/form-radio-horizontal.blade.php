@props(['label', 'name', 'value' => ''])
<div class="form-group row mb-3">
    <label for="{{ $name }}" class="col-sm-3">{{ $label }}</label>
    <div class="col-sm-9">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $name }}L"
                value="L" {{ $value === 'L' ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $name }}L">Laki-laki</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $name }}P"
                value="P" {{ $value === 'P' ? 'checked' : '' }}>
            <label class="form-check-label" for="{{ $name }}P">Perempuan</label>
        </div>
    </div>
</div>
