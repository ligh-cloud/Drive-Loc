<?php
require_once '../model/Article.php';

if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']);
    
    $article_details = Article::getArticleById($article_id); // Note: Ensure the class name is Article
} else {
    header("Location: list_articles.php");
    exit();
}





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        .article-title {
            background: linear-gradient(to right,rgb(206, 212, 219), #50e3c2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">My Articles</h1>
            <nav>
                <a href="list_article.php" class="px-4 py-2 rounded hover:bg-blue-700">Home</a>
                <a href="add_article.php" class="px-4 py-2 rounded hover:bg-blue-700">Add Article</a>
            </nav>
        </div>

    </header>

    <!-- Main Content -->
    <div class="container mx-auto mt-8 px-4">
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h1 class="text-4xl font-bold mb-4 text-center article-title"><?php echo htmlspecialchars($article_details['title']); ?></h1>
            <div class="flex justify-center mb-4">
                <?php if ($article_details['image']): ?>
                    <img src="<?php echo htmlspecialchars($article_details['image']); ?>" alt="Article Image" class="rounded-lg w-full md:w-2/3">
                <?php endif; ?>
            </div>
            <div class="prose prose-lg max-w-none mb-4">
                <p><?php echo nl2br(htmlspecialchars($article_details['content'])); ?></p>
            </div>
            <?php if ($article_details['video']): ?>
                <div class="flex justify-center mb-4">
                    <video controls class="rounded-lg w-full md:w-2/3">
                        <source src="<?php echo htmlspecialchars($article_details['video']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php endif; ?>
            <div class="flex justify-center mt-6">
                <a href="list_article.php" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition duration-200">Back to articles</a>
            </div>
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