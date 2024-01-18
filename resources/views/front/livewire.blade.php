{{--<x-front title="Livewire">--}}


{{--    <div class="container">--}}
{{--        <div class="my-5 px-4">--}}
{{--            <livewire:counter />--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</x-front>--}}


{{--@extends('dashboard.layouts.app',['title' => 'PAGE'])--}}

{{--@section('content')--}}

@livewireStyles
    <div class="container">
        <div class="my-5 px-4">
            <livewire:counter />
        </div>
    </div>
@livewireScripts
{{--@endsection--}}

