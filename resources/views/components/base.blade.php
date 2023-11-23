<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    {{--    @vite('resources/css/mail.css')--}}
    <style>
        .section {
            max-width: 672px;
            padding: 32px 24px;
            margin-left: auto;
            margin-right: auto;
            background-color: #FFFFFF;
        }


        .image-container {
            margin: auto;
            padding: 8px;
            background-color: rgb(14 116 144 / 1);
            text-align: center;
        }

        .image {
            height: 96px;
            max-width: 25%;
            margin: 0 auto;
            display: inline-block;
        }

        .message-container {
            margin-top: 32px;
            text-align: center;
        }

        .footer {
            margin-top: 32px;

        }

        .footer-message {
            margin-top: 32px;
            color: #9ca3af;
            font-size: 14px;
            line-height: 16px;
        }

        .title {
            color: rgb(55 65 81 / 1);
            font-weight: normal;
            font-size: 20px;
        }

        .content {
            color: rgb(55 65 81 / 1);
            margin-top: 8px;
            line-height: 2;
            font-weight: normal;
            font-size: 18px;
        }

        .button {
            /* 24px */;
            /* 24px */;
            /* 8px */;
            /* 8px */
            border: 0;
            padding: 0.5rem 1.5rem;
            margin-top: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.05em;

            background-color: rgb(14 116 144 / 1);

            color: #ffffff;
        }

        .button:hover {
            background-color: rgb(8 145 178 / 1);
        }

    </style>
    <title>Document</title>
</head>
<body>
<section class="section">
    <header>
        <div class="image-container">
            <img class="image" src="https://www.senelec.sn/assets/uploads/media-uploader/logo1637145113.png" alt="">
        </div>
        {{--        <div class="bg-cyan-600  flex items-center justify-center">--}}
        {{--            <h2 class="text-white text-2xl">Système D'évaluation</h2>--}}
        {{--        </div>--}}
    </header>

    <main class="message-container">
        {{ $slot }}
    </main>

    <footer class="footer">
        <div class="footer-message">
            Cet email vous a été envoyé automatiquement par le système d'évaluation.<br/>
            Veuillez ne pas y répondre.<br/>
            {{--            Besoin d'aide ? Veuillez contacter <a class="text-cyan-600 hover:underline">natou.cisse@senelec.sn.</a>--}}
        </div>
        {{--        <p class="mt-3 text-gray-500">© {{ new Date().getFullYear() }} Meraki UI. All Rights Reserved.</p>--}}
    </footer>
</section>
</body>
</html>
