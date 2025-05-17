{{--type : 'success' | 'error' | 'info' | 'warning'--}}
@props(['type'])

@php
    $bgColor = match ($type) {
        'success' => 'success',
        'error' => 'danger',
        'info' => 'info',
        'warning' => 'warning',
        default => 'light',
    };

    $fgColor = match ($type) {
        'success','error' => 'white',
        default => 'dark',
    };
@endphp

<div {{ $attributes->merge(['class' => "toast align-items-center border-0 bg-$bgColor text-$fgColor"]) }} class="" role="alert" aria-live="assertive"
     aria-atomic="true">
    <div class="d-flex">
        <div class="toast-body">
            {{ $slot }}
        </div>
        <button type="button" class="btn-close p-3 me-0 m-auto btn-close-{{$fgColor}}" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>
