@props([
    'title' => '',
    'className' => '',
    'typeModal' => '',
    'urlCreate' => '',
    'icon' => '<i class="bx bx-plus me-sm-1"></i>',
    'color' => 'btn-primary',
    'style' => '',
    'disabled' => false,
])

<button
    {{ $attributes->merge([
        'class' => 'btn ' . $color . ' ' . $className,
        'data-typemodal' => $typeModal,
        'data-urlcreate' => $urlCreate,
        'style' => $style,
        'disabled' => $disabled,
    ]) }}
    type="button">
    <span>
        {!! $title == 'Lunas' ? '' : $icon !!}
        {{ $title ?? '' }}
    </span>
</button>
