<?php
session_start();
// Display success message if exists
if (isset($_SESSION['success_message'])) {
    echo '<div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">' . 
         htmlspecialchars($_SESSION['success_message']) . 
         '</div>';
    unset($_SESSION['success_message']);
}

// Display error message if exists
if (isset($_SESSION['error_message'])) {
    echo '<div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">' . 
         htmlspecialchars($_SESSION['error_message']) . 
         '</div>';
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .car-card {
            transition: transform 0.2s;
            cursor: pointer;
        }
        .car-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="#" class="text-xl font-bold">Car Rental</a>
                <button class="lg:hidden" id="menuToggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-16 6h16"></path>
                    </svg>
                </button>
                <div class="hidden lg:flex items-center space-x-8" id="navMenu">
                    <div class="flex space-x-4">
                        <a href="#available-cars" class="hover:text-gray-300">Available Cars</a>
                        <a href="#my-reservations" class="hover:text-gray-300">My Reservations</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span id="userName">Welcome, User</span>
                        <button onclick="logout()" class="px-4 py-2 border border-white rounded hover:bg-white hover:text-gray-900">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 my-8">
        <div id="alertContainer"></div>

        <!-- Category Filter -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h5 class="text-xl font-bold mb-4">Filter Cars</h5>
                <div class="flex flex-wrap gap-4">
                    <select id="categoryFilter" class="flex-1 border rounded-lg p-2">
                        <option value="">All Categories</option>
                    </select>
                    <input type="number" id="priceFilter" placeholder="Max price per day" 
                           class="flex-1 border rounded-lg p-2">
                    <button onclick="filterCars()" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Available Cars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="available-cars"></div>
    </div>

    <!-- Car Details Modal -->
    <div id="carDetailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg max-w-4xl w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h5 class="text-xl font-bold">Car Details</h5>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="modalContent"></div>
            </div>
        </div>
    </div>

    <script>
    let cars = [];
    let categories = [];

    // Simulate data loading
    async function loadData() {
        // This would be replaced with actual API calls
        categories = [
            { id: 1, nom: 'Luxury' },
            { id: 2, nom: 'Economy' }
        ];
        cars = [
            {
                id_car: 1,
                marque: 'BMW',
                modele: 'X5',
                category_name: 'Luxury',
                prix: 100,
                places: 5,
                image: '/api/placeholder/400/300'
            }
            // Add more sample cars as needed
        ];

        populateCategories();
        renderCars(cars);
    }

    function populateCategories() {
        const select = document.getElementById('categoryFilter');
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.nom;
            select.appendChild(option);
        });
    }

    function renderCars(carsToRender) {
        const container = document.getElementById('available-cars');
        container.innerHTML = carsToRender.map(car => `
            <div class="car-card bg-white rounded-lg shadow-lg overflow-hidden" 
                 onclick="showCarDetails(${car.id_car})">
                <img src="${car.image}" 
                     class="w-full h-48 object-cover" 
                     alt="${car.marque} ${car.modele}">
                <div class="p-4">
                    <h5 class="text-xl font-bold mb-2">${car.marque} ${car.modele}</h5>
                    <p class="text-gray-700">
                        <strong>Category:</strong> ${car.category_name}<br>
                        <strong>Price:</strong> €${car.prix.toFixed(2)} per day<br>
                        <strong>Seats:</strong> ${car.places}
                    </p>
                </div>
            </div>
        `).join('');
    }

    function showCarDetails(carId) {
    const car = cars.find(c => c.id_car === carId);
    const modal = document.getElementById('carDetailsModal');
    const content = document.getElementById('modalContent');
    
    content.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <img src="${car.image}" class="w-full rounded-lg" alt="Car Image">
            <div>
                <h4 class="text-xl font-bold mb-4">${car.marque} ${car.modele}</h4>
                <p class="mb-2"><strong>Category:</strong> ${car.category_name}</p>
                <p class="mb-2"><strong>Price per Day:</strong> €${car.prix.toFixed(2)}</p>
                <p class="mb-4"><strong>Seats:</strong> ${car.places}</p>
                
                <form method="POST" action="../controller/makeReservation.php">
                    <input type="hidden" name="car_id" value="${car.id_car}">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Start Date</label>
                        <input type="date" name="date_debut" 
                               min="${new Date().toISOString().split('T')[0]}"
                               class="w-full border rounded-lg p-2" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">End Date</label>
                        <input type="date" name="date_fin"
                               min="${new Date().toISOString().split('T')[0]}"
                               class="w-full border rounded-lg p-2" required>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                        Make Reservation
                    </button>
                </form>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
}

    function closeModal() {
        document.getElementById('carDetailsModal').classList.add('hidden');
    }

    function filterCars() {
        const category = document.getElementById('categoryFilter').value;
        const maxPrice = document.getElementById('priceFilter').value;
        
        let filtered = cars;
        if (category) {
            filtered = filtered.filter(car => car.category_id === parseInt(category));
        }
        if (maxPrice) {
            filtered = filtered.filter(car => car.prix <= parseFloat(maxPrice));
        }
        
        renderCars(filtered);
    }

    function makeReservation(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    // Get form values for validation
    const startDate = new Date(formData.get('date_debut'));
    const endDate = new Date(formData.get('date_fin'));
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Client-side validation
    if (startDate < today) {
        showAlert('Start date cannot be in the past', 'error');
        return;
    }

    if (endDate <= startDate) {
        showAlert('End date must be after start date', 'error');
        return;
    }

    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Processing...';

    // Send request to server
    fetch('../controller/makeReservation.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showAlert(data.message, 'success');
            closeModal();
            // Reload page after successful reservation
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else {
            showAlert(data.message || 'Error making reservation', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error processing reservation. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('alertContainer');
    const alertClass = type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    
    alertContainer.innerHTML = `
        <div class="p-4 rounded-lg ${alertClass} mb-4">
            ${message}
        </div>
    `;
    
    setTimeout(() => {
        alertContainer.innerHTML = '';
    }, 3000);
}

    function logout() {
     
        window.location.href = '/logout';
    }

 
    document.addEventListener('DOMContentLoaded', loadData);
    </script>
</body>
</html>