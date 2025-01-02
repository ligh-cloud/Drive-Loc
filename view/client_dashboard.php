    <?php include "../controller/user_dashboard.php" ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Car Rental Dashboard</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Include FontAwesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .car-card {
                transition: transform 0.3s ease;
            }
            .car-card:hover {
                transform: translateY(-5px);
            }
        </style>
    </head>
    <body class="bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <span class="text-xl font-bold text-gray-800">Car Rental Service</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Welcome, <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></span>
                        <a href="../controller/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 py-8">
            <!-- Alert Messages -->
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

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-bold mb-4">Filter Cars</h2>
                <form method="GET" class="flex flex-wrap gap-4">
                    <select name="category" class="flex-1 border rounded-lg px-4 py-2">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                    <?php echo ($categoryFilter == $category['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="number" name="max_price" 
                        placeholder="Maximum price per day" 
                        class="flex-1 border rounded-lg px-4 py-2"
                        value="<?php echo htmlspecialchars($maxPriceFilter ?? ''); ?>">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                        Apply Filters
                    </button>
                </form>
            </div>

            <!-- Cars Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($cars as $car): ?>
                <div class="car-card bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if (!empty($car['image'])): ?>
                        <img src="../uploads/cars/<?php echo htmlspecialchars($car['image']); ?>" 
                            alt="<?php echo htmlspecialchars($car['marque'] . ' ' . $car['modele']); ?>"
                            class="w-full h-48 object-cover">
                    <?php endif; ?>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">
                            <?php echo htmlspecialchars($car['marque'] . ' ' . $car['modele']); ?>
                        </h3>
                        <div class="text-gray-600 mb-4">
                            <p><i class="fas fa-tag mr-2"></i>€<?php echo number_format($car['prix'], 2); ?> per day</p>
                            <p><i class="fas fa-car mr-2"></i><?php echo htmlspecialchars($car['category_name']); ?></p>
                            <p><i class="fas fa-users mr-2"></i><?php echo htmlspecialchars($car['places']); ?> seats</p>
                        </div>
                        <button onclick="showReservationModal(<?php echo htmlspecialchars(json_encode($car)); ?>)"
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg">
                            Reserve Now
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </main>

        <!-- Reservation Modal -->
        <div id="reservationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white rounded-lg max-w-md w-full mx-4 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold" id="modalTitle">Make Reservation</h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form method="POST" id="reservationForm">
                    <input type="hidden" name="action" value="make_reservation">
                    <input type="hidden" name="car_id" id="carId">
                    <input type="hidden" name="car_price" id="carPrice">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Start Date</label>
                        <input type="date" name="date_debut" 
                            min="<?php echo date('Y-m-d'); ?>"
                            class="w-full border rounded-lg px-4 py-2" required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">End Date</label>
                        <input type="date" name="date_fin" 
                            min="<?php echo date('Y-m-d'); ?>"
                            class="w-full border rounded-lg px-4 py-2" required>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Confirm Reservation
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Model
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Brand
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Start Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    End Date
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Total Price
                </th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach($reservationClient as $reservation): ?>
            <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    <?php echo htmlspecialchars($reservation['modele']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo htmlspecialchars($reservation['marque']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo htmlspecialchars($reservation['date_debut']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <?php echo htmlspecialchars($reservation['date_fin']); ?>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-emerald-600">
                    €<?php echo number_format(htmlspecialchars($reservation['prix_total']), 2); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(empty($reservationClient)): ?>
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    No reservations found
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>  

        <script>
            function showReservationModal(car) {
                document.getElementById('modalTitle').textContent = `Reserve ${car.marque} ${car.modele}`;
                document.getElementById('carId').value = car.id_car;
                document.getElementById('carPrice').value = car.prix;
                document.getElementById('reservationModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('reservationModal').classList.add('hidden');
                document.getElementById('reservationForm').reset();
            }

    
            document.getElementById('reservationModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

        
            document.getElementById('reservationForm').addEventListener('submit', function(e) {
                const startDate = new Date(this.date_debut.value);
                const endDate = new Date(this.date_fin.value);
                
                if (endDate <= startDate) {
                    e.preventDefault();
                    alert('End date must be after start date');
                }
            });
        </script>
    </body>
    </html>