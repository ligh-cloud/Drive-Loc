<?php include "../controller/admin_dashboard.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }

        .nav-link {
            color: #fff;
        }

        .nav-link:hover {
            color: #f8f9fa;
        }

        .stat-card {
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="position-sticky">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Admin Panel</h4>
                        <small class="text-light">
                            <?php echo htmlspecialchars($_SESSION['nom'] . ' ' . $_SESSION['prenom']); ?>
                        </small>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#dashboard">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users">
                                <i class="bi bi-people"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage_car.php">
                                <i class="bi bi-car-front"></i> Cars
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_reservation.php">
                                <i class="bi bi-calendar-check"></i> Reservations
                            </a>
                        </li>
                    </ul>
                    <div class="absolute bottom-0 start-0 w-100 p-3">
                        <form action="../controller/logout.php" method="POST">
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>


            <main class="col-md-10 ms-sm-auto px-4">
                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger mt-3">
                        <?php echo htmlspecialchars($errorMessage); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($successMessage)): ?>
                    <div class="alert alert-success mt-3">
                        <?php echo htmlspecialchars($successMessage); ?>
                    </div>
                <?php endif; ?>


                <div class="row mt-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Users</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $dashboardStats['total_users']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-people fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Cars</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $dashboardStats['total_cars']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-car-front fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Active Reservations</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $dashboardStats['active_reservations']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card stat-card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Total Reviews</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?php echo $dashboardStats['total_reviews']; ?>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="bi bi-star fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Users Management</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                                            <td>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="action" value="archive_user">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <button type="submit" class="btn btn-warning btn-sm"
                                                        onclick="return confirm('Are you sure you want to archive this user?');">
                                                        <i class="bi bi-archive"></i> Archive
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Add New Cars</h6>
                        <button type="button" class="btn btn-success btn-sm" onclick="addCarForm()">
                            <i class="bi bi-plus-circle"></i> Add Another Car
                        </button>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" id="multipleCarForm">
                            <input type="hidden" name="action" value="add_multiple_cars">
                            <div id="carFormsContainer">
                                <div class="car-form mb-4 border-bottom pb-4">
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Brand</label>
                                            <input type="text" class="form-control" name="cars[0][marque]" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Model</label>
                                            <input type="text" class="form-control" name="cars[0][modele]" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Year</label>
                                            <input type="number" class="form-control" name="cars[0][annee]" required>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Category</label>
                                            <select class="form-control" name="cars[0][categorie_id]" required>
                                                <option value="">Select category</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo htmlspecialchars($category['id']); ?>">
                                                        <?php echo htmlspecialchars($category['nom']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Price</label>
                                            <input type="number" class="form-control" name="cars[0][price]" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Car Image</label>
                                            <input type="file" class="form-control" name="cars[0][image]" accept="image/*" required>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeCarForm(this)" style="display: none;">
                                        <i class="bi bi-trash"></i> Remove Car
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Add Cars</button>
                        </form>
                    </div>
                </div>


                <script>
                    let carFormCount = 1;

                    function addCarForm() {
                        const container = document.getElementById('carFormsContainer');
                        const newForm = document.createElement('div');
                        newForm.className = 'car-form mb-4 border-bottom pb-4';

                        newForm.innerHTML = `
        <div class="row">
            <div class="col-md-3 mb-3">
                <label class="form-label">Brand</label>
                <input type="text" class="form-control" name="cars[${carFormCount}][marque]" required>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Model</label>
                <input type="text" class="form-control" name="cars[${carFormCount}][modele]" required>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Year</label>
                <input type="number" class="form-control" name="cars[${carFormCount}][annee]" required>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Category</label>
                <select class="form-control" name="cars[${carFormCount}][categorie_id]" required>
                    <option value="">Select category</option>
                    ${Array.from(document.querySelector('select[name="cars[0][categorie_id]"]').options)
                        .map(opt => `<option value="${opt.value}">${opt.text}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="cars[${carFormCount}][price]" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Car Image</label>
                <input type="file" class="form-control" name="cars[${carFormCount}][image]" accept="image/*" required>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeCarForm(this)">
            <i class="bi bi-trash"></i> Remove Car
        </button>
    `;

                        container.appendChild(newForm);
                        carFormCount++;


                        updateRemoveButtons();
                    }

                    function removeCarForm(button) {
                        button.closest('.car-form').remove();
                        updateRemoveButtons();
                    }

                    function updateRemoveButtons() {
                        const removeButtons = document.querySelectorAll('.car-form button[onclick*="removeCarForm"]');
                        const shouldShow = removeButtons.length > 1;
                        removeButtons.forEach(button => {
                            button.style.display = shouldShow ? 'block' : 'none';
                        });
                    }


                    document.getElementById('multipleCarForm').addEventListener('submit', function(e) {
                        const forms = document.querySelectorAll('.car-form');
                        let isValid = true;

                        forms.forEach(form => {
                            const inputs = form.querySelectorAll('input[required], select[required]');
                            inputs.forEach(input => {
                                if (!input.value) {
                                    isValid = false;
                                    input.classList.add('is-invalid');
                                } else {
                                    input.classList.remove('is-invalid');
                                }
                            });
                        });

                        if (!isValid) {
                            e.preventDefault();
                            alert('Please fill in all required fields for all cars.');
                        }
                    });
                </script>
            </main>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Category Management</h6>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-circle"></i> Add New Category
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($category['nom']); ?></td>
                                <td><?php echo htmlspecialchars($category['description']); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editCategory(<?php echo $category['id']; ?>)">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" class="d-inline">
                                        <input type="hidden" name="action" value="delete_category">
                                        <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure? This will also delete all cars in this category.');">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_category">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="nom" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="description" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>