<?php
session_start();
require_once '../model/Article.php';
require_once '../model/Favorite.php';

if (isset($_GET['id'])) {
    $article_id = intval($_GET['id']);
    $article_details = Article::getArticleById($article_id);
} else {
    header("Location: list_articles.php");
    exit();
}


$user_id = $_SESSION['user_id']; 
$is_favorite = false;
$favorites = Favorite::getUserFavorites($user_id);
foreach ($favorites as $favorite) {
    if ($favorite['id_article'] == $article_id) {
        $is_favorite = true;
        break;
    }
}


$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';


unset($_SESSION['success_message']);
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .article-title {
            background: linear-gradient(to right, rgb(206, 212, 219), #50e3c2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .star-button {
            cursor: pointer;
            font-size: 1.5rem;
            color: #FFD700; 
        }
        .star-button.filled {
            color: #FFD700;
        }
        .star-button.empty {
            color: #ccc;
        }
    </style>
</head>

<body class="bg-gray-100">
 
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">My Articles</h1>
            <nav>
                <a href="list_article.php" class="px-4 py-2 rounded hover:bg-blue-700">Home</a>
                <a href="add_article.php" class="px-4 py-2 rounded hover:bg-blue-700">Add Article</a>
            </nav>
        </div>
    </header>

    <div class="container mx-auto mt-8 px-4">
     
        <?php if ($success_message): ?>
            <div class="bg-green-500 text-white p-4 mb-4 rounded">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="bg-red-500 text-white p-4 mb-4 rounded">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

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
            <div class="flex justify-center mt-6">
                <form action="../controller/add_favorite.php" method="POST" id="favorite-form">
                    <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                    <button type="submit" name="<?php echo $is_favorite ? 'remove_favorite' : 'add_favorite'; ?>" class="star-button <?php echo $is_favorite ? 'filled' : 'empty'; ?>">
                        <i class="fas fa-star"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div id="commentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 w-1/3">
            <h2 class="text-2xl font-bold mb-4">Add Comment</h2>
            <form action="../controller/article_comment.php" method="POST">
                <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                <textarea name="comment" rows="4" class="w-full p-2 border border-gray-300 rounded-lg mb-4" placeholder="Enter your comment..."></textarea>
                <div class="flex justify-end space-x-4">
                    <button type="button" id="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">Cancel</button>
                    <button name="submit" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white mt-8 p-4">
        <div class="container mx-auto text-center">
            <p>&copy; <?php echo date('Y'); ?> My Articles. All rights reserved.</p>
        </div>
    </footer>

    <script>
        document.getElementById('add_comment').addEventListener('click', function() {
            document.getElementById('commentModal').classList.remove('hidden');
        });

        document.getElementById('closeModal').addEventListener('click', function() {
            document.getElementById('commentModal').classList.add('hidden');
        });
    </script>
</body>

</html>