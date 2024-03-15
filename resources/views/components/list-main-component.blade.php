@props([
    'title' => '',
    'className' => '',
    'typeModal' => '',
    'urlCreate' => '',
    'icon' => '<i class="bx bx-chevron-right scaleX-n1-rtl"></i>',
    'style' => '',
])

<a
    {{ $attributes->merge([
        'class' => 'dropdown-item d-flex align-items-center ' . $className,
        'data-typemodal' => $typeModal,
        'data-urlcreate' => $urlCreate,
        'style' => $style,
        'href' => '#',
    ]) }}>
    {!! $icon !!} {{ $title }}
</a>
