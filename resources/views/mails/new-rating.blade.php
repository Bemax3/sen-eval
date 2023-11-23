<x-base>
    <h2 class="title">Bonjour {{ $evaluated_name}},</h2>

    <p class="content">
        Votre évaluation pour l'année {{ $year }} a été crée.
        <br/>
        {{ $evaluator_name}} sera votre évaluateur.
        <br/>
        Vous pouvez consulter votre évaluation en cliquant sur le bouton suivant.
    </p>

    <a href="http://10.101.1.113:8080/ratings/{{$rating_id}}" target="_blank">
        <button
            class="button">
            Voir mon évaluation
        </button>
    </a>

    <br>
    <p class="content">
        Merci.
    </p>
</x-base>
