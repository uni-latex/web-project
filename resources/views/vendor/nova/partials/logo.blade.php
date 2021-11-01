@if ( in_array(last(request()->segments()), ['login', 'reset']) )
    <a class="text-black text-2xl font-bold dim no-underline" href="/">{{ config('app.name') }}</a>
@else
{{--    <div class="w-full text-center">{{ config('app.name') }}</div>--}}
    <div class="flex w-full justify-center">
        @php
            $novaLogo = nova_get_setting('logo');
            if ($novaLogo) {
                $novaLogo = asset("storage/{$novaLogo}");
            }
            else {
                $novaLogo = config('web.logo');
            }
        @endphp
        <img class="h-8" src="{{ $novaLogo }}">
    </div>
@endif

