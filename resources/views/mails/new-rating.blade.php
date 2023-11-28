<x-base>
    <h2 style=" color: #374151FF; font-weight: normal; font-size: 20px;">Bonjour {{ $evaluated_name}},</h2>

    <p style="color: #374151FF; margin-top: 8px; line-height: 2; font-weight: normal; font-size: 18px;">
        Votre évaluation pour l’année {{ $year }} a été crée.
        <br/>
        {{ $evaluator_name}} sera votre évaluateur.
        <br/>
        Vous pouvez consulter votre évaluation en cliquant sur le bouton suivant.
    </p>

    <a href="http://10.101.1.113:8080/ratings/{{$rating_id}}" target="_blank">
        <button
            style="border: 0;
            cursor: pointer;
            padding: 0.5rem 1.5rem;
            margin-top: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            background-color: #0E7490FF;
            color: #ffffff;">
            Voir mon évaluation
        </button>
    </a>

    <br>
    <p style="color: #374151FF;
            margin-top: 8px;
            line-height: 2;
            font-weight: normal;
            font-size: 18px;">
        Merci.
    </p>
</x-base>
