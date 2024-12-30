<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Premium Car Rental</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <style>
        @keyframes slideIn {
            from {
                transform: translateY(100px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .slide-in {
            animation: slideIn 1s ease forwards;
        }

        .dark .dark-mode-bg {
            background-color: #111827;
        }

        .dark .dark-mode-text {
            color: #ffffff;
        }

        .gradient-text {
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            -webkit-background-clip: text;
            color: transparent;
        }
    </style>
</head>

<body class="bg-white dark:bg-gray-900 transition-colors duration-300">
    <nav class="fixed w-full z-50 backdrop-blur-md bg-white/80 dark:bg-gray-900/80">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="#" class="text-3xl font-bold gradient-text">Drive & Loc</a>

                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-800 dark:text-white hover:text-blue-600 transition-colors">Accueil</a>
                    <a href="#" class="text-gray-800 dark:text-white hover:text-blue-600 transition-colors">Véhicules</a>
                    <a href="#" class="text-gray-800 dark:text-white hover:text-blue-600 transition-colors">Services</a>
                    <a href="#" class="text-gray-800 dark:text-white hover:text-blue-600 transition-colors">Contact</a>
                </div>

                <div class="flex items-center space-x-4">
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-gray-800 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                        </svg>
                    </button>
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                        Réserver
                    </button>
                    <button class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                    <a href="login.php">login</a>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="relative min-h-screen flex items-center pt-20">
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-black/30 z-10"></div>
                <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8" alt="Mercedes AMG GT" class="w-full h-64 object-cover">
            </div>

            <div class="container mx-auto px-6 relative z-20">
                <div class="max-w-3xl slide-in">
                    <h1 class="text-6xl md:text-7xl font-bold text-white mb-8">
                        Découvrez le Luxe Automobile
                    </h1>
                    <p class="text-xl text-gray-200 mb-12">
                        Une collection exclusive de véhicules haut de gamme pour une expérience de conduite inoubliable
                    </p>
                    <div class="flex flex-wrap gap-6">
                        <button class="px-8 py-4 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all hover:scale-105">
                            Découvrir la flotte
                        </button>
                        <button class="px-8 py-4 bg-white/10 text-white rounded-full hover:bg-white/20 transition-all hover:scale-105 backdrop-blur-sm">
                            En savoir plus
                        </button>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="py-24 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-6">
        <h2 class="text-4xl font-bold text-gray-900 dark:text-white text-center mb-16">
            Véhicules Premium
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Mercedes Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8" alt="Mercedes AMG GT" class="w-full h-64 object-cover">
                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-1 rounded-full">
                        À partir de 299€/jour
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Mercedes AMG GT</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Performance et élégance redéfinies
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-2 text-gray-600 dark:text-gray-400">4.9</span>
                        </div>
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                        <a href="login.php">Réserver</a>
                        </button>
                        
                    </div>
                </div>
            </div>

            <!-- Porsche Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70" alt="Porsche 911" class="w-full h-64 object-cover">
                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-1 rounded-full">
                        À partir de 349€/jour
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Porsche 911</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        L'icône sportive par excellence
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-2 text-gray-600 dark:text-gray-400">5.0</span>
                        </div>
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                            <a href="login.php">Réserver</a>
                        </button>
                    </div>
                </div>
            </div>

            <!-- BMW Card -->
            <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all hover:-translate-y-2">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e" alt="BMW M4" class="w-full h-64 object-cover">
                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-4 py-1 rounded-full">
                        À partir de 279€/jour
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">BMW M4</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Puissance et précision allemande
                    </p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <span class="ml-2 text-gray-600 dark:text-gray-400">4.8</span>
                        </div>
                        <button class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                        <a href="login.php">Réserver</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    </main>

    <footer class="bg-gray-900 dark:bg-gray-950 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h3 class="text-2xl font-bold gradient-text mb-4">Drive & Loc</h3>
                <p class="text-gray-400">L'excellence dans la location automobile</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            const themeToggleBtn = document.getElementById('theme-toggle');

            if (localStorage.getItem('color-theme') === 'dark' ||
                (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggleLightIcon.classList.add('hidden');
                themeToggleDarkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function () {
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            });
        });
    </script>
</body>

</html>