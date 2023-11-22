<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{--    <style>--}}
    {{--        {!! Vite::content('resources/css/mail.css') !!}--}}
    {{--    </style>--}}

    @vite('resources/css/mail.css')
    <title>Document</title>
</head>
<body>
<section class="max-w-2xl px-6 py-8 mx-auto bg-white">
    <header>
        <div class="bg-s-pink-800  flex items-center justify-center p-2">
            <img class="w-auto h-24 sm:h-24" src="{{ Vite::asset('resources/js/assets/logo1637145113.png') }}" alt="">
        </div>
        {{--        <div class="bg-s-pink-800  flex items-center justify-center">--}}
        {{--            <h2 class="text-white text-2xl">Système D'évaluation</h2>--}}
        {{--        </div>--}}
    </header>

    <main class="mt-8 text-center">
        {{ $slot }}
    </main>


    <footer class="mt-8">
        <div class="text-gray-500 text-xs">
            Cet email vous a été envoyé automatiquement par le système d'évaluation.<br/>
            Veuillez ne pas y répondre.<br/>
            {{--            Besoin d'aide ? Veuillez contacter <a class="text-s-pink-600 hover:underline">natou.cisse@senelec.sn.</a>--}}
        </div>
        {{--        <p class="mt-3 text-gray-500">© {{ new Date().getFullYear() }} Meraki UI. All Rights Reserved.</p>--}}
    </footer>
</section>
</body>
</html>
