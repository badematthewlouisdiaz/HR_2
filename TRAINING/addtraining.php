<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Training Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .training-card {
            transition: all 0.2s ease;
        }
        
        .training-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
      <!-- Navbar -->
      <?php include '../USM/navbar.php'; ?>
      
      <main class="container mx-auto px-4 py-8">
        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <!-- Action Bar -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700">Training Programs</h2>
                    <p class="text-gray-500 text-sm">Manage all training programs across departments</p>
                </div>
                <button id="add-training-btn" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Add Training
                </button>
            </div>

            <!-- Training List -->
            <div id="training-list-container">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Training Name</th>
                                <th>Category</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Topic</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="training-list">
                            <!-- Training items will be dynamically added here -->
                        </tbody>
                    </table>
                </div>

                <!-- Empty State -->
                <div id="empty-state" class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No training programs yet</h3>
                    <p class="text-gray-500 mb-4">Get started by creating your first training program.</p>
                    <button id="empty-add-btn" class="btn btn-primary">Add Training</button>
                </div>
            </div>
        </div>

        <!-- Department Training Overview -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Department Training Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Front Office Card -->
                <div class="card bg-base-100 shadow-md training-card">
                    <div class="card-body">
                        <h3 class="card-title ">Front Office / Reception</h3>
                        <p class="text-gray-600">Roles: Front Desk Manager, Receptionist, Guest Service Agent, Bellhop, Reservation Agent</p>
                        <div class="mt-4">
                            <h4 class="font-medium text-gray-700 mb-2">Training Topics:</h4>
                            <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                                <li>Customer Service & Communication</li>
                                <li>Reservation & Front Desk Systems</li>
                                <li>Check-in/out Procedures</li>
                                <li>Upselling & Cross-selling</li>
                                <li>Problem Solving & Conflict Resolution</li>
                                <li>Safety & Emergency Procedures</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Housekeeping Card -->
                <div class="card bg-base-100 shadow-md training-card">
                    <div class="card-body">
                        <h3 class="card-title">Housekeeping</h3>
                        <p class="text-gray-600">Roles: Executive Housekeeper, Room Attendant, Laundry Attendant</p>
                        <div class="mt-4">
                            <h4 class="font-medium text-gray-700 mb-2">Training Topics:</h4>
                            <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                                <li>Cleaning & Sanitation Standards</li>
                                <li>Inventory & Supplies Management</li>
                                <li>Time Management</li>
                                <li>Health & Safety Compliance</li>
                                <li>Customer Interaction Skills</li>
                                <li>Quality Control</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Training Modal -->
    <dialog id="training-modal" class="modal">
        <div class="modal-box w-11/12 max-w-3xl">
            <h3 class="font-bold text-2xl mb-2">Add New Training</h3>
            <p class="text-gray-600 mb-6">Create a new training program by selecting department, role and topic</p>
            
            <form id="training-form" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Training Category</span>
                        </label>
                        <select id="training-category" class="select select-bordered w-full" required>
                            <option value="" disabled selected>Select a category</option>
                            <option value="Retain">Retain</option>
                            <option value="Reskilling">Reskilling</option>
                            <option value="Upskilling">Upskilling</option>
                            <option value="Leadership">Leadership</option>
                            <option value="New Hire on Board">New Hire on Board</option>
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Training Name</span>
                        </label>
                        <input id="training-name" type="text" placeholder="Enter training name" class="input input-bordered w-full" required>
                    </div>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Department</span>
                    </label>
                    <select id="training-department" class="select select-bordered w-full" required>
                        <option value="" disabled selected>Select a department</option>
                        <option value="Front Office / Reception">Front Office / Reception</option>
                        <option value="Housekeeping">Housekeeping</option>
                    </select>
                </div>
                
                <div id="role-container" class="form-control hidden fade-in">
                    <label class="label">
                        <span class="label-text font-semibold">Role</span>
                    </label>
                    <select id="training-role" class="select select-bordered w-full" required>
                        <option value="" disabled selected>Select a role</option>
                        <!-- Roles will be dynamically populated based on department -->
                    </select>
                </div>
                
                <div id="topic-container" class="form-control hidden fade-in">
                    <label class="label">
                        <span class="label-text font-semibold">Training Topic</span>
                    </label>
                    <select id="training-topic" class="select select-bordered w-full" required>
                        <option value="" disabled selected>Select a training topic</option>
                        <!-- Topics will be dynamically populated based on role -->
                    </select>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Description</span>
                    </label>
                    <textarea id="training-description" class="textarea textarea-bordered h-24" placeholder="Enter training description"></textarea>
                </div>
            </form>
            
            <div class="modal-action">
                <button id="cancel-btn" class="btn btn-ghost">Cancel</button>
                <button id="save-training-btn" class="btn btn-primary">Save Training</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        // Department data structure
        const departmentData = {
            "Front Office / Reception": {
                roles: {
                    "Front Desk Manager": {
                        topics: [
                            "Customer Service & Communication",
                            "Reservation & Front Desk Systems",
                            "Check-in/out Procedures",
                            "Upselling & Cross-selling",
                            "Problem Solving & Conflict Resolution",
                            "Safety & Emergency Procedures"
                        ]
                    },
                    "Receptionist": {
                        topics: [
                            "Customer Service & Communication",
                            "Reservation & Front Desk Systems",
                            "Check-in/out Procedures",
                            "Upselling & Cross-selling",
                            "Problem Solving & Conflict Resolution",
                            "Safety & Emergency Procedures"
                        ]
                    },
                    "Guest Service Agent": {
                        topics: [
                            "Customer Service & Communication",
                            "Reservation & Front Desk Systems",
                            "Check-in/out Procedures",
                            "Upselling & Cross-selling",
                            "Problem Solving & Conflict Resolution",
                            "Safety & Emergency Procedures"
                        ]
                    },
                    "Bellhop": {
                        topics: [
                            "Customer Service & Communication",
                            "Check-in/out Procedures",
                            "Safety & Emergency Procedures"
                        ]
                    },
                    "Reservation Agent": {
                        topics: [
                            "Customer Service & Communication",
                            "Reservation & Front Desk Systems",
                            "Upselling & Cross-selling",
                            "Problem Solving & Conflict Resolution"
                        ]
                    }
                }
            },
            "Housekeeping": {
                roles: {
                    "Executive Housekeeper": {
                        topics: [
                            "Cleaning & Sanitation Standards",
                            "Inventory & Supplies Management",
                            "Time Management",
                            "Health & Safety Compliance",
                            "Customer Interaction Skills",
                            "Quality Control"
                        ]
                    },
                    "Room Attendant": {
                        topics: [
                            "Cleaning & Sanitation Standards",
                            "Time Management",
                            "Health & Safety Compliance",
                            "Customer Interaction Skills",
                            "Quality Control"
                        ]
                    },
                    "Laundry Attendant": {
                        topics: [
                            "Cleaning & Sanitation Standards",
                            "Inventory & Supplies Management",
                            "Health & Safety Compliance"
                        ]
                    }
                }
            }
        };

        // DOM Elements
        const addTrainingBtn = document.getElementById('add-training-btn');
        const emptyAddBtn = document.getElementById('empty-add-btn');
        const trainingModal = document.getElementById('training-modal');
        const cancelBtn = document.getElementById('cancel-btn');
        const saveTrainingBtn = document.getElementById('save-training-btn');
        const trainingForm = document.getElementById('training-form');
        const trainingList = document.getElementById('training-list');
        const emptyState = document.getElementById('empty-state');
        const trainingDepartment = document.getElementById('training-department');
        const trainingRole = document.getElementById('training-role');
        const trainingTopic = document.getElementById('training-topic');
        const roleContainer = document.getElementById('role-container');
        const topicContainer = document.getElementById('topic-container');

        // Sample training data
        let trainings = [];

        // Event Listeners
        addTrainingBtn.addEventListener('click', () => trainingModal.showModal());
        emptyAddBtn.addEventListener('click', () => trainingModal.showModal());
        cancelBtn.addEventListener('click', () => {
            trainingModal.close();
            resetForm();
        });

        // Department change event
        trainingDepartment.addEventListener('change', function() {
            const department = this.value;
            
            if (department) {
                // Show role container
                roleContainer.classList.remove('hidden');
                
                // Populate roles
                trainingRole.innerHTML = '<option value="" disabled selected>Select a role</option>';
                Object.keys(departmentData[department].roles).forEach(role => {
                    trainingRole.innerHTML += `<option value="${role}">${role}</option>`;
                });
                
                // Reset and hide topic container
                topicContainer.classList.add('hidden');
                trainingTopic.innerHTML = '<option value="" disabled selected>Select a training topic</option>';
            } else {
                roleContainer.classList.add('hidden');
                topicContainer.classList.add('hidden');
            }
        });

        // Role change event
        trainingRole.addEventListener('change', function() {
            const department = trainingDepartment.value;
            const role = this.value;
            
            if (department && role) {
                // Show topic container
                topicContainer.classList.remove('hidden');
                
                // Populate topics
                trainingTopic.innerHTML = '<option value="" disabled selected>Select a training topic</option>';
                departmentData[department].roles[role].topics.forEach(topic => {
                    trainingTopic.innerHTML += `<option value="${topic}">${topic}</option>`;
                });
            } else {
                topicContainer.classList.add('hidden');
            }
        });

        saveTrainingBtn.addEventListener('click', () => {
            if (trainingForm.checkValidity()) {
                const category = document.getElementById('training-category').value;
                const name = document.getElementById('training-name').value;
                const department = document.getElementById('training-department').value;
                const role = document.getElementById('training-role').value;
                const topic = document.getElementById('training-topic').value;
                const description = document.getElementById('training-description').value;
                
                // Create new training object
                const newTraining = {
                    id: Date.now(),
                    name,
                    category,
                    department,
                    role,
                    topic,
                    description,
                    status: 'Active'
                };
                
                // Add to trainings array
                trainings.push(newTraining);
                
                // Update UI
                updateTrainingList();
                
                // Reset form and close modal
                trainingModal.close();
                resetForm();
            } else {
                trainingForm.reportValidity();
            }
        });

        // Function to reset form
        function resetForm() {
            trainingForm.reset();
            roleContainer.classList.add('hidden');
            topicContainer.classList.add('hidden');
        }

        // Function to update training list
        function updateTrainingList() {
            if (trainings.length === 0) {
                trainingList.innerHTML = '';
                emptyState.classList.remove('hidden');
                return;
            }
            
            emptyState.classList.add('hidden');
            
            trainingList.innerHTML = trainings.map(training => `
                <tr>
                    <td>
                        <div class="font-bold">${training.name}</div>
                        <div class="text-sm text-gray-500">${training.description}</div>
                    </td>
                    <td>
                        <span class="badge badge-outline">${training.category}</span>
                    </td>
                    <td>${training.department}</td>
                    <td>${training.role}</td>
                    <td>${training.topic}</td>
                    <td>
                        <span class="badge badge-success">${training.status}</span>
                    </td>
                    <td>
                        <button class="btn btn-ghost btn-xs" onclick="editTraining(${training.id})">Edit</button>
                        <button class="btn btn-ghost btn-xs text-error" onclick="deleteTraining(${training.id})">Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        // Function to delete training
        window.deleteTraining = function(id) {
            if (confirm('Are you sure you want to delete this training?')) {
                trainings = trainings.filter(training => training.id !== id);
                updateTrainingList();
            }
        }

        // Function to edit training
        window.editTraining = function(id) {
            const training = trainings.find(t => t.id === id);
            if (training) {
                document.getElementById('training-category').value = training.category;
                document.getElementById('training-name').value = training.name;
                document.getElementById('training-department').value = training.department;
                
                // Trigger change event to populate roles
                trainingDepartment.dispatchEvent(new Event('change'));
                
                // Set role after a small delay to allow roles to populate
                setTimeout(() => {
                    document.getElementById('training-role').value = training.role;
                    
                    // Trigger change event to populate topics
                    trainingRole.dispatchEvent(new Event('change'));
                    
                    // Set topic after a small delay
                    setTimeout(() => {
                        document.getElementById('training-topic').value = training.topic;
                        document.getElementById('training-description').value = training.description;
                        
                        // Remove the training from the list
                        trainings = trainings.filter(t => t.id !== id);
                        
                        // Open modal
                        trainingModal.showModal();
                        
                        // Update the list
                        updateTrainingList();
                    }, 100);
                }, 100);
            }
        }

        // Initialize
        updateTrainingList();
    </script>
</body>
<script src="../sidebar.js"></script>
</html>