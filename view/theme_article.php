<?php
session_start();
require "../model/theme.php";
require "../model/article.php";
require "../model/tag.php";
require "../model/comments.php";

$themes = Theme::getAllThemes();
$tags = Tag::getAllTags();
$comments = Comments::getAllComments();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Themes, Articles, Tags, and Comments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Admin Dashboard - Manage Themes, Articles, Tags, and Comments</h1>
        <p>En tant qu’administrateur, je peux gérer les thèmes, les articles, les tags, et les commentaires depuis un tableau de bord.</p>
       
        <!-- Session Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <!-- Session Messages -->

        <!-- Add New Theme Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Add New Theme</h2>
            </div>
            <div class="card-body">
                <form action="../controller/submit_theme.php" method="post">
                    <div class="form-group">
                        <label for="theme_name">Theme Name</label>
                        <input type="text" class="form-control" id="theme_name" name="theme_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Theme</button>
                </form>
            </div>
        </div>

        <!-- Manage Themes Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Manage Themes</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($themes as $theme): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($theme['id_theme']); ?></td>
                                <td><?php echo htmlspecialchars($theme['name']); ?></td>
                                <td>
                                    <form action="../controller/delete_theme.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id_theme" value="<?php echo $theme['id_theme']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editTheme('<?php echo $theme['id_theme']; ?>', '<?php echo htmlspecialchars($theme['name']); ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add New Tag Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Add New Tag</h2>
            </div>
            <div class="card-body">
                <form action="../controller/tag_controller.php" method="post">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="tag_name">Tag Name</label>
                        <input type="text" class="form-control" id="tag_name" name="tag_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Tag</button>
                </form>
            </div>
        </div>

        <!-- Manage Tags Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Manage Tags</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tags as $tag): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($tag['id_tag']); ?></td>
                                <td><?php echo htmlspecialchars($tag['tag_name']); ?></td>
                                <td>
                                    <form action="../controller/tag_controller.php" method="post" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id_tag" value="<?php echo $tag['id_tag']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editTag('<?php echo $tag['id_tag']; ?>', '<?php echo htmlspecialchars($tag['tag_name']); ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

                            

        <!-- Manage Comments Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Manage Comments</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Comment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($comment['id_commentaire']); ?></td>
                                <td><?php echo htmlspecialchars($comment['commentaire']); ?></td>
                                <td>
                                    <form action="../controller/comment_controller.php" method="post" style="display:inline;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id_commentaire" value="<?php echo $comment['id_commentaire']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editComment('<?php echo $comment['id_commentaire']; ?>', '<?php echo htmlspecialchars($comment['commentaire']); ?>', '<?php echo $comment['id_article']; ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Theme Modal -->
    <div class="modal fade" id="editThemeModal" tabindex="-1" role="dialog" aria-labelledby="editThemeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editThemeModalLabel">Edit Theme</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../controller/edit_theme.php" method="post">
                        <div class="form-group">
                            <label for="edit_theme_name">Theme Name</label>
                            <input type="text" class="form-control" id="edit_theme_name" name="theme_name" required>
                            <input type="hidden" id="edit_theme_id" name="id_theme">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Article Modal -->
    <div class="modal fade" id="editArticleModal" tabindex="-1" role="dialog" aria-labelledby="editArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editArticleModalLabel">Edit Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="../controller/edit_article.php" method="post">
                        <div class="form-group">
                            <label for="edit_article_title">Article Title</label>
                            <input type="text" class="form-control" id="edit_article_title" name="article_title" required>
                            <input type="hidden" id="edit_article_id" name="id_article">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Tag Modal -->
    <div class="modal fade" id="editTagModal" tabindex="-1" role="dialog" aria-labelledby="editTagModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTagModalLabel">Edit Tag</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../controller/tag_controller.php" method="post">
                    <input type="hidden" name="action" value="edit">
                    <div class="form-group">
                        <label for="edit_tag_name">Tag Name</label>
                        <input type="text" class="form-control" id="edit_tag_name" name="tag_name" required>
                        <input type="hidden" id="edit_tag_id" name="id_tag">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Comment Modal -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../controller/comment_controller.php" method="post">
                    <input type="hidden" name="action" value="edit">
                    <div class="form-group">
                        <label for="edit_comment_text">Comment</label>
                        <textarea class="form-control" id="edit_comment_text" name="comment" required></textarea>
                        <input type="hidden" id="edit_comment_id" name="id_commentaire">
                        <input type="hidden" id="edit_comment_article_id" name="id_article">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
    function editTheme(id, name) {
        document.getElementById('edit_theme_id').value = id;
        document.getElementById('edit_theme_name').value = name;
        $('#editThemeModal').modal('show');
    }

    function editArticle(id, title) {
        document.getElementById('edit_article_id').value = id;
        document.getElementById('edit_article_title').value = title;
        $('#editArticleModal').modal('show');
    }

    function editTag(id, name) {
        document.getElementById('edit_tag_id').value = id;
        document.getElementById('edit_tag_name').value = name;
        $('#editTagModal').modal('show');
    }

    function editComment(id, comment, article_id) {
        document.getElementById('edit_comment_id').value = id;
        document.getElementById('edit_comment_text').value = comment;
        document.getElementById('edit_comment_article_id').value = article_id;
        $('#editCommentModal').modal('show');
    }
</script>
</body>

</html>