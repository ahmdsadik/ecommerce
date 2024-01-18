@props([
    'key' => null
])
@session($key)
<div class="my-2 px-2 text-danger">
    {{ $value }}
</div>
@endsession
