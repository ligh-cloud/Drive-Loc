<?php
require_once '../model/Article.php';

$articles = Article::getAllArticles();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">My Articles</h1>
            <nav>
                <a href="client_dashboard.php" class="px-4 py-2 rounded hover:bg-blue-700">Go Back</a>
                <a href="add_article.php" class="px-4 py-2 rounded hover:bg-blue-700">Add Article</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto mt-8 px-4">
        <h1 class="text-2xl font-bold mb-4">All Articles</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($articles as $article): ?>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($article['title']); ?></h2>
                    <p class="mb-2"><?php echo htmlspecialchars($article['content']); ?></p>
                    <?php if ($article['image']): ?>
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image" class="mb-2">
                    <?php endif; ?>
                    <a href="view_article.php?id=<?php echo $article['id_article']; ?>" class="text-blue-500 hover:underline">Read more</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white mt-8 p-4">
        <div class="container mx-auto text-center">
            <p>&copy; <?php echo date('Y'); ?> My Articles. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>