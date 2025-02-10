@props(['active'=>false])
@php
$classes = ($active ?? false) ? 'active' : '';
@endphp
<li>
    <a wire:navigate {{ $attributes->merge(['class'=>$classes]) }} ><i class="fas {{ $icon }}"></i> {{ $slot }}</a>
</li>
