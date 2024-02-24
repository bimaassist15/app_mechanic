@props(['title', 'className' => '', 'typeModal' => '', 'urlCreate' => ''])

<button
    {{ $attributes->merge([
        'class' => 'btn btn-secondary btn-add btn-primary ' . $className,
        'data-typemodal' => $typeModal,
        'data-urlcreate' => $urlCreate,
    ]) }}
    type="button">
    <span>
        <i class="bx bx-plus me-sm-1"></i>
        {{ $title }}
    </span>
</button>
