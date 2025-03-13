<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue à EduCenter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue, {{ $name }}!</h1>
        </div>
        <div class="content">
            <p>Nous sommes ravis de vous accueillir à EduCenter.</p>
            <p>Votre adresse email est : {{ $email }}</p>
            <p>Votre mot de passe temporaire est : <strong>{{ $password }}</strong></p>
            <p>Nous vous recommandons de changer votre mot de passe après votre première connexion.</p>
            <p>
                <a href="{{ url('/login') }}" class="button">Se connecter maintenant</a>
            </p>
        </div>
        <div class="footer">
            <p>Merci de nous avoir rejoint ! Si vous avez des questions, contactez-nous à support@educenter.com.</p>
        </div>
    </div>
</body>
</html>
