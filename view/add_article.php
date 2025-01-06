<!DOCTYPE html>
<?php session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    if($_SESSION['role'] == 'user'){
        header('Location: ../view/client_dashboard.php');
    }
    header('Location: ../view/login.php');
   
    exit();
} ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Article</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Add New Article</h1>
        <form action="submit_article.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="video">Video</label>
                <input type="file" class="form-control-file" id="video" name="video" accept="video/*">
            </div>
            <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="number" hidden disabled class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']?>">
            </div>
            <div class="form-group">
                <label for="theme_id">Theme ID</label>
                <input type="number" class="form-control" id="theme_id" name="theme_id" required>
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" class="form-control" id="tags" name="tags" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

 
</body>
</html>