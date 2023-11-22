<x-base>
    @if( $validator_id === $evaluated_id)
        <h2 class="text-gray-700 font-bold text-xl">Bonjour {{ $evaluated_name}},</h2>
        <p class="mt-2 leading-loose text-gray-600">
            Vous avez valider votre évaluation pour l'année {{ $year }}
            le {{ $validated_at->isoFormat('DD MMMM YYYY à H:m') }}.
            {{--            <br/>--}}
            {{--            {{ $evaluator_name}} sera votre évaluateur.--}}
            {{--            <br/>--}}
            Vous pouvez consulter votre évaluation en cliquant sur le bouton suivant.
        </p>
        <a href="{{route('ratings.show',['rating' => $rating_id])}}">
            <button
                class="px-6 py-2 mt-3 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-s-pink-800  rounded-lg hover:bg-s-pink-900     focus:outline-none focus:ring focus:ring-s-pink-300 focus:ring-opacity-80">
                Voir mon évaluation
            </button>
        </a>
        <br>
        <p class="mt-2 text-gray-600">
            Merci.
        </p>
    @else
        <h2 class="text-gray-700 font-bold text-xl">Bonjour {{ $evaluated_name}},</h2>

        <p class="mt-2 leading-loose text-gray-600">
            Votre évaluation pour l'année {{ $year }} a été validée par .
            <br/>
            {{ $evaluator_name}} sera votre évaluateur.
            <br/>
            Vous pouvez consulter votre évaluation en cliquant sur le bouton suivant.
        </p>

        <a href="{{route('ratings.show',['rating' => $rating_id])}}">
            <button
                class="px-6 py-2 mt-3 text-sm font-medium tracking-wider text-white capitalize transition-colors duration-300 transform bg-s-pink-800  rounded-lg hover:bg-s-pink-900     focus:outline-none focus:ring focus:ring-s-pink-300 focus:ring-opacity-80">
                Voir mon évaluation
            </button>
        </a>

        <br>
        <p class="mt-2 text-gray-600">
            Merci.
        </p>
    @endif
</x-base>
