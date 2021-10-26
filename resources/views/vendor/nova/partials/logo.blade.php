@if ( in_array(last(request()->segments()), ['login', 'reset']) )
    <a class="text-black text-2xl font-bold dim no-underline" href="/">{{ config('app.name') }}</a>
@else
{{--    <div class="w-full text-center">{{ config('app.name') }}</div>--}}
    <div class="flex w-full justify-center">
        <img class="h-12" src="https://laravel.com/img/notification-logo.png">
    </div>
@endif

