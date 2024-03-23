@props([
    'label' => '',
    'value' => '',
])

<div class="row mb-2">
    <strong class="col-lg-4">{{ $label }} </strong>
    <span class="col-lg-8">{!! $value !!}</span>
</div>
