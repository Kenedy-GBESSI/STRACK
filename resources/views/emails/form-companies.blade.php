<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Strack') }} - RÉPONSE À L'OFFRE OBTENUE</title>
</head>

<body>
    <p>Bonjour,</p>
    <p>Après réflexion, l'étudiant {{ $student->first_name }} {{ $student->last_name }} a declaré ne pouvoir pas continuer le
        stage dans votre local. Merci pour la compréhension.</p>
    <p>Pour plus de détails, veuillez écrire à l'étudiant sur cet email <span
            style="color:#8A2BE2"><em>{{ $student->email }}</em></span> </p>
</body>

</html>
