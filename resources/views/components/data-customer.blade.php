@props([
    'label' => '',
    'value' => '',
    'class' => '',
    'labelClass' => '',
])

<div class="row mb-2">
    <strong class="col-lg-4 {{ $labelClass }}">{{ $label }}
    </strong>
    <span class="col-lg-8 {{ $class }}">{!! $value !!}</span>
</div>
