<?php
require_once "../model/car.php";


session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$errorMessage = $_SESSION['error'] ?? null;
$successMessage = $_SESSION['success'] ?? null;

try {
    $carObj = new Car("", "", "", "", "", "");
    

    if (isset($_POST['action']) && $_POST['action'] === 'delete_car') {
        if (isset($_POST['car_id'])) {
            if ($carObj->deleteCar($_POST['car_id'])) {
                $_SESSION['success'] = "Car deleted successfully";
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }
    

    $cars = $carObj->getAllCars();
    
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    $_SESSION['error'] = $errorMessage;
}

unset($_SESSION['error'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-xl font-bold text-gray-800">Car Management</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="add_car.php" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Add New Car
                    </a>
                    <a href="client_dashboard.php" class="text-gray-600 hover:text-gray-900">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-8">
        <?php if ($errorMessage): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?php echo htmlspecialchars($errorMessage); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($successMessage): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><?php echo htmlspecialchars($successMessage); ?></p>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($cars as $car): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if (!empty($car['image'])): ?>
                                <img src="../uploads/cars/<?php echo htmlspecialchars($car['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($car['marque'] . ' ' . $car['modele']); ?>"
                                     class="h-16 w-24 object-cover rounded">
                            <?php else: ?>
                                <div class="h-16 w-24 bg-gray-200 rounded flex items-center justify-center">
                                    No Image
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo htmlspecialchars($car['modele']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo htmlspecialchars($car['marque']); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            €<?php echo number_format($car['prix'], 2); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                       <?php echo $car['disponibilite'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $car['disponibilite'] ? 'Available' : 'Not Available'; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="edit_car.php?id=<?php echo $car['id_car']; ?>" 
                               class="text-indigo-600 hover:text-indigo-900 mr-4">Edit</a>
                            <button onclick="confirmDelete(<?php echo $car['id_car']; ?>)" 
                                    class="text-red-600 hover:text-red-900">Delete</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>

                    <?php if (empty($cars)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No cars found
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
    function confirmDelete(carId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete_car">
                    <input type="hidden" name="car_id" value="${carId}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>
</body>
</html>