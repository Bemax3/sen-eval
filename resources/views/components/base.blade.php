<section style="max-width: 672px; padding: 32px 24px; margin-left: auto; margin-right: auto; background-color: #FFFFFF;">
    <header>
        <div style="margin: auto; padding: 8px; background-color: #0E7490FF;text-align: center;">
            <img style="height: 96px; max-width: 25%; margin: 0 auto; display: inline-block;"
                 src="https://www.senelec.sn/assets/uploads/media-uploader/logo1637145113.png" alt="">
        </div>
        {{--        <div class="bg-cyan-600  flex items-center justify-center">--}}
        {{--            <h2 class="text-white text-2xl">Système D'évaluation</h2>--}}
        {{--        </div>--}}
    </header>

    <main style="margin-top: 32px;text-align: center;">
        {{ $slot }}
    </main>

    <footer style="margin-top: 32px;">
        <div style="margin-top: 32px; color: #9ca3af; font-size: 14px; line-height: 16px;">
            Ce mail vous a été envoyé automatiquement par le système d’évaluation.<br/>
            Veuillez ne pas y répondre.<br/>
            {{--            Besoin d'aide ? Veuillez contacter <a class="text-cyan-600 hover:underline">natou.cisse@senelec.sn.</a>--}}
        </div>
        {{--        <p class="mt-3 text-gray-500">© {{ new Date().getFullYear() }} Meraki UI. All Rights Reserved.</p>--}}
    </footer>
</section>
