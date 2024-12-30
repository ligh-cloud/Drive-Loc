<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drive & Loc - Inscription</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 border-gray-200 shadow-lg fixed w-full z-50">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center space-x-3">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-600 dark:text-blue-400">Drive & Loc</span>
            </a>
        </div>
    </nav>

    <!-- Signup Form -->
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8 bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Créer un compte
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Ou
                    <a href="login.html" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                        connectez-vous à votre compte existant
                    </a>
                </p>
            </div>
            <form class="mt-8 space-y-6" action="#" method="POST">
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="first-name" class="sr-only">Prénom</label>
                        <input id="first-name" name="first-name" type="text" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Prénom">
                    </div>
                    <div>
                        <label for="last-name" class="sr-only">Nom</label>
                        <input id="last-name" name="last-name" type="text" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Nom">
                    </div>
                    <div>
                        <label for="email-address" class="sr-only">Adresse email</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Adresse email">
                    </div>
                    <div>
                        <label for="password" class="sr-only">Mot de passe</label>
                        <input id="password" name="password" type="password" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Mot de passe">
                    </div>
                    <div>
                        <label for="confirm-password" class="sr-only">Confirmer le mot de passe</label>
                        <input id="confirm-password" name="confirm-password" type="password" required 
                               class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                               placeholder="Confirmer le mot de passe">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        J'accepte les <a href="#" class="text-blue-600 hover:text-blue-500 dark:text-blue-400">conditions d'utilisation</a>
                    </label>
                </div>

                <div>
                    <button type="submit" 
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        S'inscrire
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>