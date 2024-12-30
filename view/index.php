<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Location de Voitures</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-lg fixed w-full z-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-600">Drive & Loc</span>
            </a>
            <div class="flex md:order-2">
                <button type="button" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3">Se connecter</button>
                <button data-collapse-toggle="navbar-search" type="button" class="md:hidden text-gray-500" aria-controls="navbar-search" aria-expanded="false">
                    <span class="sr-only">Menu</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white">
                    <li><a href="#" class="block py-2 pl-3 pr-4 text-blue-600" aria-current="page">Accueil</a></li>
                    <li><a href="#" class="block py-2 pl-3 pr-4 text-gray-900 hover:text-blue-600">Véhicules</a></li>
                    <li><a href="#" class="block py-2 pl-3 pr-4 text-gray-900 hover:text-blue-600">Catégories</a></li>
                    <li><a href="#" class="block py-2 pl-3 pr-4 text-gray-900 hover:text-blue-600">Mes Réservations</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center" style="min-height: 75vh;">
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style='background-image: url("https://picsum.photos/1920/1080");'>
            <span class="w-full h-full absolute opacity-50 bg-black"></span>
        </div>
        <div class="container relative mx-auto">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-6/12 px-4 ml-auto mr-auto text-center">
                    <div class="pr-12">
                        <h1 class="text-white font-semibold text-5xl">
                            Votre voyage commence ici
                        </h1>
                        <p class="mt-4 text-lg text-gray-300">
                            Découvrez notre sélection de véhicules et trouvez celui qui vous convient.
                            Réservation simple et rapide.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="container mx-auto px-4 -mt-24 relative z-10">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option>Toutes les catégories</option>
                        <option>Berline</option>
                        <option>SUV</option>
                        <option>Sport</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">&nbsp;</label>
                    <button class="w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700">Rechercher</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Grid -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Véhicules disponibles</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Vehicle Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://picsum.photos/400/300" alt="Mercedes Classe A" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Mercedes Classe A</h3>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-600">Berline</span>
                        <span class="text-blue-600 font-bold">89€/jour</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1 text-gray-600">4.8 (12 avis)</span>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Réserver
                        </button>
                    </div>
                </div>
            </div>
            <!-- Repeat Vehicle Cards -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://picsum.photos/400/300" alt="BMW X5" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">BMW X5</h3>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-600">SUV</span>
                        <span class="text-blue-600 font-bold">119€/jour</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1 text-gray-600">4.7 (10 avis)</span>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Réserver
                        </button>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img src="https://picsum.photos/400/300" alt="Audi R8" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Audi R8</h3>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-600">Sport</span>
                        <span class="text-blue-600 font-bold">199€/jour</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="ml-1 text-gray-600">4.9 (15 avis)</span>
                        </div>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                            Réserver
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center mt-12">
            <nav class="inline-flex rounded-md shadow">
                <a href="#" class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    Précédent
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-blue-600 hover:bg-gray-50">
                    1
                </a>
                <a href="#" class="px-3 py-2 border-t border-b border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                    2
                </a>
                <a href="#" class="px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 rounded-r-md">
                    Suivant
                </a>
            </nav>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Drive & Loc</h3>
                    <p class="text-gray-400">Location de véhicules premium pour tous vos besoins.</p>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Navigation</h3>
                    <ul class="text-gray-400">
                        <li class="mb-2"><a href="#" class="hover:text-white">Accueil</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Véhicules</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">À propos</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Catégories</h3>
                    <ul class="text-gray-400">
                        <li class="mb-2"><a href="#" class="hover:text-white">Berlines</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">SUV</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Sport</a></li>
                        <li class="mb-2"><a href="#" class="hover:text-white">Électrique</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white text-lg font-bold mb-4">Contact</h3>
                    <ul class="text-gray-400">
                        <li class="mb-2">+33 1 23 45 67 89</li>
                        <li class="mb-2">contact@driveloc.fr</li>
                        <li class="mb-2">123 rue de Paris, 75000 Paris</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8">
                <p class="text-center text-gray-400">© 2024 Drive & Loc. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple JavaScript for handling dynamic interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle mobile menu
            const menuButton = document.querySelector('[data-collapse-toggle="navbar-search"]');
            const menu = document.getElementById('navbar-search');
            
            menuButton.addEventListener('click', function() {
                menu.classList.toggle('hidden');
            });

            // Dynamic date validation
            const startDate = document.querySelector('input[type="date"]:first-of-type');
            const endDate = document.querySelector('input[type="date"]:last-of-type');

            startDate.addEventListener('change', function() {
                endDate.min = this.value;
            });

            endDate.addEventListener('change', function() {
                if (startDate.value && this.value < startDate.value) {
                    this.value = startDate.value;
                }
            });

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            startDate.min = today;
            endDate.min = today;
        });
    </script>
</body>
</html>