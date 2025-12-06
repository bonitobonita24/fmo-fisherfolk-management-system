@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'dropdown-content'])

@php
$alignmentClasses = match ($align) {
    'left' => 'dropdown-start',
    'top' => 'dropdown-top',
    default => 'dropdown-end',
};
@endphp

<div class="dropdown {{ $alignmentClasses }}">
    <div tabindex="0" role="button">
        {{ $trigger }}
    </div>
    <ul tabindex="0" class="dropdown-menu {{ $contentClasses }}">
        {{ $content }}
    </ul>
</div>
