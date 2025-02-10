@props(['size','type','icon'])


@if(isset($href))
<a wire:navigate {{ $attributes }} ><i class="fas {{ $icon }}"></i> {{ $slot }}</a>
@else
<button {{ $attributes }} ><i class="fas {{ $icon }}"></i> {{ $slot }}</button>
@endif

