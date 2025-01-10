<?php
session_start();
require "../model/theme.php";

// Retrieve all themes
$themes = Theme::getAllThemes();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Themes</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Admin Dashboard - Manage Themes</h1>
        
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
        <div class="card">
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        function editTheme(id, name) {
            document.getElementById('edit_theme_id').value = id;
            document.getElementById('edit_theme_name').value = name;
            $('#editThemeModal').modal('show');
        }
    </script>
</body>

</html>