<?php
require_once '../model/Article.php';
require "../model/theme.php";
require "../model/Tag.php";

$themes = Theme::showAllThemes();
$articles = [];

if (isset($_POST['search_article'])) {
    $articlesByName = Article::searchByName($_POST['search_article']);
    $articlesByTag = Tag::getArticlesByTag($_POST['search_article']);
    $articles = array_merge($articlesByName, $articlesByTag);
} elseif (isset($_POST['theme_filter'])) {
    if ($_POST['theme_filter'] == 'all') {
        $articles = Article::getAllArticles();
    } else {
        $articles = array_unique( Theme::filterByTheme($_POST['theme_filter']));
    }
} else {
    $articles = Article::getAllArticles();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-50 min-h-screen flex flex-col">
  
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">My Articles</h1>
            <nav class="space-x-4">
                <a href="client_dashboard.php" class="px-6 py-2 rounded-lg bg-blue-500 hover:bg-blue-700 transition duration-300">Dashboard</a>
                <a href="add_article.php" class="px-6 py-2 rounded-lg bg-green-500 hover:bg-green-600 transition duration-300">+ New Article</a>
            </nav>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8 flex-grow">
        <h1 class="text-3xl font-bold mb-8 text-gray-800">All Articles</h1>

        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
 
            <div class="grid md:grid-cols-2 gap-6">
           
                <form method="POST" class="space-y-2">
                    <label for="theme_filter" class="block text-gray-700 font-semibold text-lg mb-2">Filter by Theme</label>
                    <div class="flex space-x-4">
                        <select name="theme_filter" id="theme_filter" 
                                class="flex-1 py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                            <option default value="all">All Articles</option>
                            <?php foreach ($themes as $theme): ?>
                                <option value="<?php echo htmlspecialchars($theme['name']); ?>"><?php echo htmlspecialchars($theme['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition duration-300">
                            Filter
                        </button>
                    </div>
                </form>

              
                <form method="POST" class="space-y-2">
                    <label for="search_article" class="block text-gray-700 font-semibold text-lg mb-2">Search Articles</label>
                    <div class="flex space-x-4">
                        <input type="text" name="search_article" id="search_article" placeholder="Enter article name or tag..." 
                               class="flex-1 py-3 px-4 border border-gray-300 rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 transition duration-300">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

      
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($articles as $article): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                    <?php if ($article['image']): ?>
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image" class="w-full h-48 object-cover">
                    <?php endif; ?>
                    <div class="p-6">
                        <h2 class="text-xl font-bold mb-3 text-gray-800"><?php echo htmlspecialchars($article['title']); ?></h2>
                        <p class="text-gray-600 mb-4 line-clamp-3"><?php echo htmlspecialchars($article['content']); ?></p>
                        <a href="view_article.php?id=<?php echo $article['id_article']; ?>" 
                           class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                            Read more
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-blue-800 to-blue-600 text-white py-6">
        <div class="container mx-auto text-center">
            <p class="text-lg">&copy; <?php echo date('Y'); ?> My Articles. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>