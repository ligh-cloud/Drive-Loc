<?php
session_start();
require "../model/article.php";
require "../model/user.php";


$user_id = $_SESSION['user_id'] ;


$articles = Article::getAllArticles($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_article_id'])) {
    Article::deleteArticle($_POST['delete_article_id']);
    $_SESSION['success'] = 'Article deleted successfully';

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Articles</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Your Articles</h1>

        <!-- Session Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <!-- Session Messages -->

        <div class="card mb-4">
            <div class="card-header">
                <h2>Your Articles</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($article['id_article']); ?></td>
                                <td><?php echo htmlspecialchars($article['title']); ?></td>
                                <td>
                                    <form action="" method="post" style="display:inline;">
                                        <input type="hidden" name="delete_article_id" value="<?php echo $article['id_article']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>