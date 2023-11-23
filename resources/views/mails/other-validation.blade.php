<x-base>
    <h2 class="title">Bonjour {{ $other_validator_name}},</h2>
    <p class="content">
        L'évaluation de {{ $evaluated_name }} pour l'année {{ $year }} a été validée par {{ $validator_name }}
        le {{ $validated_at->isoFormat('DD MMMM YYYY à H:m') }}.
        Vous pouvez consulter l'évaluation en cliquant sur le bouton suivant.
    </p>

    @if($other_validator_id == $evaluator_id)
        <a href="http://10.101.1.113:8080/agent/{{ $evaluated_id}}/agent-ratings/{{$rating_id}}" target="_blank">
            <button
                class="button">
                Voir l'évaluation
            </button>
        </a>
    @else
        <a href="http://10.101.1.113:8080/validations/{{$rating_id}}" target="_blank">
            <button
                class="button">
                Voir l'évaluation
            </button>
        </a>
    @endif
    <br>
    <p class="content">
        Merci.
    </p>
</x-base>
