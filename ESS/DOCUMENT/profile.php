<?php

session_start()
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Document</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
<body class="bg-gray-100 min-h-screen">
    <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
        <!-- Header with Edit Button -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800"></h1>
            <button class="btn btn-primary" onclick="document.getElementById('edit-modal').showModal()">
                <i class="fas fa-edit mr-2"></i>
                Edit Profile
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column - Profile Card -->
            <div class="lg:w-1/3">
                <div class="card bg-white shadow-lg rounded-xl">
                    <div class="card-body">
                        <!-- Profile Header -->
                        <div class="flex flex-col items-center mb-6">
                            <div class="avatar mb-4">
                                <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white text-2xl font-bold">
                                    MS
                                </div>
                            </div>
                            <h2 class="card-title text-2xl font-bold" id="display-fullname">Maria Santos</h2>
                            <p class="text-gray-500">Senior Software Engineer</p>
                            <p class="text-gray-500 text-sm">Makati City, Metro Manila</p>
                        </div>

                        <!-- Message Button -->
                        <div class="mb-6">
                            <button class="btn btn-primary w-full">
                                <i class="fas fa-envelope mr-2"></i>
                                Send Message
                            </button>
                        </div>

                        <!-- Social Links -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-globe text-blue-500 w-6"></i>
                                <a href="#" class="text-gray-700 ml-2 hover:text-blue-500">https://marisantos.dev</a>
                            </div>
                            <div class="flex items-center">
                                <i class="fab fa-github text-gray-800 w-6"></i>
                                <a href="#" class="text-gray-700 ml-2 hover:text-blue-500">maria-santos</a>
                            </div>
                            <div class="flex items-center">
                                <i class="fab fa-linkedin text-blue-600 w-6"></i>
                                <a href="#" class="text-gray-700 ml-2 hover:text-blue-500">maria-santos-ph</a>
                            </div>
                            <div class="flex items-center">
                                <i class="fab fa-twitter text-blue-400 w-6"></i>
                                <a href="#" class="text-gray-700 ml-2 hover:text-blue-500">@maria_santos</a>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <div>
                                <label class="text-gray-500 text-sm">Employee ID</label>
                                <p class="font-medium">EMP-2023-0456</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm">Department</label>
                                <p class="font-medium">IT & Software Development</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm">Email</label>
                                <p class="font-medium" id="display-email">msantos@company.com.ph</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm">Mobile</label>
                                <p class="font-medium" id="display-mobile">+63 912 345 6789</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm">Address</label>
                                <p class="font-medium" id="display-address">Bel-Air, Makati City, Metro Manila</p>
                            </div>
                            <div>
                                <label class="text-gray-500 text-sm">Date Hired</label>
                                <p class="font-medium">March 15, 2020</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Employee Details -->
            <div class="lg:w-2/3">
                <div class="card bg-white shadow-lg rounded-xl mb-6">
                    <div class="card-body">
                        <h2 class="card-title text-xl font-bold mb-6">Employment Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-gray-500 text-sm">Position</label>
                                    <p class="font-medium">Senior Software Engineer</p>
                                </div>
                                <div>
                                    <label class="text-gray-500 text-sm">Employment Status</label>
                                    <p class="font-medium"><span class="badge badge-success">Regular</span></p>
                                </div>
                                <div>
                                    <label class="text-gray-500 text-sm">SSS Number</label>
                                    <p class="font-medium">34-4567890-1</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-gray-500 text-sm">Manager</label>
                                    <p class="font-medium">Juan Dela Cruz</p>
                                </div>
                                <div>
                                    <label class="text-gray-500 text-sm">TIN</label>
                                    <p class="font-medium">123-456-789-000</p>
                                </div>
                                <div>
                                    <label class="text-gray-500 text-sm">PhilHealth</label>
                                    <p class="font-medium">02-345678901-2</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Projects -->
                <div class="card bg-white shadow-lg rounded-xl">
                    <div class="card-body">
                        <h2 class="card-title text-xl font-bold mb-6">Current Projects</h2>
                        
                        <!-- Project Status -->
                        <div class="mb-8">
                            <h3 class="font-semibold text-lg mb-4">Project Status</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium">E-Commerce Platform</span>
                                        <span class="badge badge-primary">In Progress</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: 75%"></div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2">Due: Dec 15, 2023</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-medium">Mobile Banking App</span>
                                        <span class="badge badge-secondary">Completed</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-2">Completed: Oct 30, 2023</p>
                                </div>
                            </div>
                        </div>

                        <!-- Other Tasks -->
                        <div class="space-y-4">
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div>
                                    <span class="font-medium">API Integration - Payment Gateway</span>
                                    <p class="text-sm text-gray-500">GCash and PayMaya integration</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-500 mr-3">
                                    <i class="fas fa-mobile-alt"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Mobile App Optimization</span>
                                    <p class="text-sm text-gray-500">Performance improvements</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 mr-3">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <span class="font-medium">Security Audit</span>
                                    <p class="text-sm text-gray-500">Data protection compliance</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <dialog id="edit-modal" class="modal">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg mb-6">Edit Employee Profile</h3>
            
            <form id="profile-form" class="space-y-4">
                <!-- Employee ID - Fixed/Non-editable -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Employee ID</span>
                    </label>
                    <div class="input input-bordered bg-gray-100 text-gray-600 flex items-center">
                        EMP-2023-0456
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Employee ID cannot be changed</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Last Name</span>
                        </label>
                        <input type="text" id="last-name" class="input input-bordered" value="Santos" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">First Name</span>
                        </label>
                        <input type="text" id="first-name" class="input input-bordered" value="Maria" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Middle Name</span>
                        </label>
                        <input type="text" id="middle-name" class="input input-bordered" value="Reyes" />
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" id="email" class="input input-bordered" value="msantos@company.com.ph" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Mobile</span>
                        </label>
                        <input type="text" id="mobile" class="input input-bordered" value="+63 912 345 6789" />
                    </div>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Address</span>
                    </label>
                    <input type="text" id="address" class="input input-bordered" value="Bel-Air, Makati City, Metro Manila" />
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Website</span>
                    </label>
                    <input type="text" id="website" class="input input-bordered" value="https://marisantos.dev" />
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">GitHub</span>
                        </label>
                        <input type="text" id="github" class="input input-bordered" value="maria-santos" />
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">LinkedIn</span>
                        </label>
                        <input type="text" id="linkedin" class="input input-bordered" value="maria-santos-ph" />
                    </div>
                </div>
                
                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" onclick="document.getElementById('edit-modal').close()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
        
        <!-- Backdrop to close modal when clicking outside -->
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        // Handle form submission
        document.getElementById('profile-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const lastName = document.getElementById('last-name').value;
            const firstName = document.getElementById('first-name').value;
            const middleName = document.getElementById('middle-name').value;
            const email = document.getElementById('email').value;
            const mobile = document.getElementById('mobile').value;
            const address = document.getElementById('address').value;
            const website = document.getElementById('website').value;
            const github = document.getElementById('github').value;
            const linkedin = document.getElementById('linkedin').value;
            
            // Combine names for display
            const fullName = `${firstName} ${lastName}`;
            
            // Update display values
            document.getElementById('display-fullname').textContent = fullName;
            document.getElementById('display-email').textContent = email;
            document.getElementById('display-mobile').textContent = mobile;
            document.getElementById('display-address').textContent = address;
            
            // Update social links
            document.querySelector('a[href*="marisantos.dev"]').textContent = website;
            document.querySelector('a[href*="github"]').textContent = github;
            document.querySelector('a[href*="linkedin"]').textContent = linkedin;
            
            // Update avatar initials
            const initials = `${firstName.charAt(0)}${lastName.charAt(0)}`;
            document.querySelector('.avatar div').textContent = initials;
            
            // Close modal
            document.getElementById('edit-modal').close();
            
            // Show success message
            alert('Profile updated successfully!');
        });
    </script>
</body>
<script src="../soliera.js"></script>
</html>