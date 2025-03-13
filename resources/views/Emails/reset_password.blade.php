<!DOCTYPE html>
<html>
<head>
    <title>Réinitialisation de votre mot de passe</title>
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
            <h1>Réinitialisation de votre mot de passe</h1>
        </div>
        <div class="content">
            <p>Bonjour,</p>
            <p>Vous avez demandé à réinitialiser votre mot de passe pour EduCenter.</p>
            <p>Veuillez cliquer sur le bouton ci-dessous pour définir un nouveau mot de passe :</p>
            <p>
            <a href="{{ $url }}" class="button" target="_self">Réinitialiser le mot de passe</a>
            </p>
            <p>Si vous n'avez pas fait cette demande, veuillez ignorer cet email.</p>
        </div>
        <div class="footer">
            <p>Merci, l'équipe EduCenter</p>
            <p>Si vous avez des questions, contactez-nous à support@educenter.com.</p>
        </div>
    </div>
</body>
</html>
