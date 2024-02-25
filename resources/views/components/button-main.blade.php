@props([
    'title' => '',
    'className' => '',
    'typeModal' => '',
    'urlCreate' => '',
    'icon' => '<i class="bx bx-plus me-sm-1"></i>',
    'color' => 'btn-primary',
    'style' => '',
])

<button
    {{ $attributes->merge([
        'class' => 'btn ' . $color . ' ' . $className,
        'data-typemodal' => $typeModal,
        'data-urlcreate' => $urlCreate,
        'style' => $style
    ]) }}
    type="button">
    <span>
        {!! $icon !!}
        {{ $title ?? '' }}
    </span>
</button>
