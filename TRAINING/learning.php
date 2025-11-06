<?php

session_start()
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Time & Attendance</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <style>
    .centered-hero {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh; /* This will make it take most of the viewport height */
    }
  </style>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
    
           
 <!-- Exam Introduction Section (Replaces Hero Section) -->
        <div id="examIntroduction" class="max-w-12xl w-full bg-white rounded-xl shadow-xl overflow-hidden mx-auto">
          <!-- Header -->
          <div class="bg-white px-8 py-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
              <div class="logo-container w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);">
                <i class="fas fa-book-open text-white text-xl"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">Learning Management</h1>
                <p class="text-sm text-gray-600">Entrance Examination Portal</p>
              </div>
            </div>
            <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium">
              <i class="fas fa-shield-alt mr-2"></i>Secure Session
            </div>
          </div>
          <!-- Progress Steps -->
          <div class="bg-gray-50 px-8 py-4 flex justify-center">
            <div class="flex items-center space-x-8">
              <div class="flex items-center">
                <div class="step-indicator step-active">1</div>
                <div class="ml-2 text-sm font-medium text-blue-700">Exam Overview</div>
              </div>
              <div class="h-0.5 w-16 bg-gray-300"></div>
              <div class="flex items-center">
                <div class="step-indicator step-inactive">2</div>
                <div class="ml-2 text-sm font-medium text-gray-500">Application</div>
              </div>
              <div class="h-0.5 w-16 bg-gray-300"></div>
              <div class="flex items-center">
                <div class="step-indicator step-inactive">3</div>
                <div class="ml-2 text-sm font-medium text-gray-500">Assessment</div>
              </div>
              <div class="h-0.5 w-16 bg-gray-300"></div>
              <div class="flex items-center">
                <div class="step-indicator step-inactive">4</div>
                <div class="ml-2 text-sm font-medium text-gray-500">Onboarding</div>
              </div>
            </div>
          </div>
          <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">Learning Modules Repository</h1>
        <p class="text-gray-600 mb-8">Manage and organize all learning materials for your organization</p>
        
        <!-- Module Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Module Card -->
            <div class="card bg-base-100 shadow-md module-card">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <h3 class="card-title">Employee Handbook</h3>
                        <div class="badge badge-success">Active</div>
                    </div>
                    <div class="flex flex-wrap gap-2 my-2">
                        <div class="badge badge-outline">Human Resources</div>
                        <div class="badge badge-outline">All Employees</div>
                    </div>
                    <p class="text-sm text-gray-500">Date Added: 2023-10-15</p>
                    <p class="text-sm text-gray-500">Topic: Company Policies</p>
                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-sm btn-outline">View</button>
                        <button class="btn btn-sm btn-primary">Download</button>
                    </div>
                </div>
            </div>
            
            <!-- Module Card -->
            <div class="card bg-base-100 shadow-md module-card">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <h3 class="card-title">Safety Protocols</h3>
                        <div class="badge badge-success">Active</div>
                    </div>
                    <div class="flex flex-wrap gap-2 my-2">
                        <div class="badge badge-outline">Operations</div>
                        <div class="badge badge-outline">All Employees</div>
                    </div>
                    <p class="text-sm text-gray-500">Date Added: 2023-09-22</p>
                    <p class="text-sm text-gray-500">Topic: Workplace Safety</p>
                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-sm btn-outline">View</button>
                        <button class="btn btn-sm btn-primary">Download</button>
                    </div>
                </div>
            </div>
            
            <!-- Module Card -->
            <div class="card bg-base-100 shadow-md module-card">
                <div class="card-body">
                    <div class="flex justify-between items-start">
                        <h3 class="card-title">IT Security Guidelines</h3>
                        <div class="badge badge-error">Inactive</div>
                    </div>
                    <div class="flex flex-wrap gap-2 my-2">
                        <div class="badge badge-outline">Information Technology</div>
                        <div class="badge badge-outline">IT Staff</div>
                    </div>
                    <p class="text-sm text-gray-500">Date Added: 2023-11-05</p>
                    <p class="text-sm text-gray-500">Topic: Cybersecurity</p>
                    <div class="card-actions justify-end mt-4">
                        <button class="btn btn-sm btn-outline">View</button>
                        <button class="btn btn-sm btn-primary">Download</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Module Table -->
        <div class="card bg-base-100 shadow-md">
            <div class="card-body">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="card-title">All Learning Modules</h2>
                    <div class="flex gap-2">
                        <div class="dropdown dropdown-end">
                            <label tabindex="0" class="btn btn-outline">Filter</label>
                            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li><a>All Modules</a></li>
                                <li><a>Active Only</a></li>
                                <li><a>Inactive</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr>
                                <th>Module Name</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Date Added</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Employee Handbook</td>
                                <td>Human Resources</td>
                                <td>All Employees</td>
                                <td>2023-10-15</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-xs btn-outline">View</button>
                                        <button class="btn btn-xs btn-primary">Download</button>
                                        <button class="btn btn-xs btn-warning">Edit</button>
                                        <button class="btn btn-xs btn-error">Deactivate</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Safety Protocols</td>
                                <td>Operations</td>
                                <td>All Employees</td>
                                <td>2023-09-22</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-xs btn-outline">View</button>
                                        <button class="btn btn-xs btn-primary">Download</button>
                                        <button class="btn btn-xs btn-warning">Edit</button>
                                        <button class="btn btn-xs btn-error">Deactivate</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>IT Security Guidelines</td>
                                <td>Information Technology</td>
                                <td>IT Staff</td>
                                <td>2023-11-05</td>
                                <td><div class="badge badge-error">Inactive</div></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-xs btn-outline">View</button>
                                        <button class="btn btn-xs btn-primary">Download</button>
                                        <button class="btn btn-xs btn-warning">Edit</button>
                                        <button class="btn btn-xs btn-success">Activate</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Customer Service Training</td>
                                <td>Front Office / Reception</td>
                                <td>Guest Service Agent</td>
                                <td>2023-08-30</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-xs btn-outline">View</button>
                                        <button class="btn btn-xs btn-primary">Download</button>
                                        <button class="btn btn-xs btn-warning">Edit</button>
                                        <button class="btn btn-xs btn-error">Deactivate</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Food Safety Standards</td>
                                <td>Kitchen / Culinary</td>
                                <td>Line Cook</td>
                                <td>2023-10-10</td>
                                <td><div class="badge badge-success">Active</div></td>
                                <td>
                                    <div class="flex gap-2">
                                        <button class="btn btn-xs btn-outline">View</button>
                                        <button class="btn btn-xs btn-primary">Download</button>
                                        <button class="btn btn-xs btn-warning">Edit</button>
                                        <button class="btn btn-xs btn-error">Deactivate</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Modal -->
    <dialog id="upload_modal" class="modal modal-middle">
        <div class="modal-box max-w-4xl">
            <h3 class="font-bold text-lg mb-6">Upload Learning Module</h3>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left: Drag and Drop & File Info -->
                <div>
                    <h4 class="text-lg font-medium mb-4">Upload File</h4>
                    <div id="dropZone" class="drop-zone p-8 text-center cursor-pointer mb-4">
                        <div class="flex flex-col items-center justify-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="text-lg">Drag and drop files here</p>
                            <p class="text-sm text-gray-500">Supports PDF, DOCX, PPT, and more</p>
                            <button class="btn btn-primary mt-2">Browse Files</button>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <div class="text-sm text-gray-500 mb-2">Uploaded files:</div>
                        <div class="space-y-2" id="fileList">
                            <!-- Files will be listed here -->
                        </div>
                    </div>
                </div>
                
                <!-- Right: Module Details Form -->
                <div>
                    <h4 class="text-lg font-medium mb-4">Module Details</h4>
                    <form class="space-y-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Title</span>
                            </label>
                            <input type="text" class="input input-bordered" placeholder="Enter module title">
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Department</span>
                            </label>
                            <select class="select select-bordered" id="departmentSelect">
                                <option disabled selected>Select Department</option>
                                <option value="front-office">Front Office / Reception</option>
                                <option value="housekeeping">Housekeeping</option>
                                <option value="food-beverage">Food & Beverage (F&B)</option>
                                <option value="kitchen">Kitchen / Culinary</option>
                                <option value="sales-marketing">Sales & Marketing</option>
                                <option value="hr">Human Resources (HR)</option>
                                <option value="finance">Finance / Accounting</option>
                                <option value="engineering">Engineering / Maintenance</option>
                                <option value="security">Security</option>
                            </select>
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Role</span>
                            </label>
                            <select class="select select-bordered" id="roleSelect" disabled>
                                <option disabled selected>Select Department First</option>
                            </select>
                        </div>
                        
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Topic</span>
                            </label>
                            <input type="text" class="input input-bordered" placeholder="Enter topic">
                        </div>
                        
                        <div class="form-control mt-6">
                            <button class="btn btn-primary">Save Module</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Cancel</button>
                </form>
            </div>
        </div>
    </dialog>

    <script>
        // Department and Role Data
        const departmentRoles = {
            'front-office': [
                'Front Desk Manager',
                'Receptionist / Front Desk Officer',
                'Guest Service Agent / Concierge',
                'Reservation Agent',
                'Bellhop / Porter'
            ],
            'housekeeping': [
                'Executive Housekeeper / Housekeeping Manager',
                'Floor Supervisor',
                'Room Attendant / Housekeeper',
                'Laundry Attendant',
                'Public Area Attendant'
            ],
            'food-beverage': [
                'F&B Manager / Director',
                'Restaurant Manager / Captain',
                'Waiter / Waitress / Server',
                'Bartender',
                'Banquet / Catering Coordinator'
            ],
            'kitchen': [
                'Executive Chef / Head Chef',
                'Sous Chef',
                'Line Cook / Station Chef',
                'Pastry Chef / Baker',
                'Kitchen Steward / Dishwasher'
            ],
            'sales-marketing': [
                'Sales & Marketing Manager',
                'Revenue Manager',
                'Event / Banquet Sales Coordinator',
                'Social Media / Marketing Executive'
            ],
            'hr': [
                'HR Manager / Director',
                'Recruitment Officer',
                'Training & Development Specialist',
                'Payroll / HR Assistant'
            ],
            'finance': [
                'Finance Manager / Controller',
                'Accountant',
                'Payroll Officer',
                'Cost Controller'
            ],
            'engineering': [
                'Chief Engineer / Engineering Manager',
                'Maintenance Technician',
                'Electrician / Plumber',
                'HVAC Technician'
            ],
            'security': [
                'Security Manager / Supervisor',
                'Security Guard'
            ]
        };

        // DOM Elements
        const departmentSelect = document.getElementById('departmentSelect');
        const roleSelect = document.getElementById('roleSelect');
        const dropZone = document.getElementById('dropZone');
        const fileList = document.getElementById('fileList');

        // Update roles based on department selection
        departmentSelect.addEventListener('change', function() {
            const department = this.value;
            
            // Clear existing options
            roleSelect.innerHTML = '';
            
            if (department && departmentRoles[department]) {
                // Enable the role select
                roleSelect.disabled = false;
                
                // Add default option
                const defaultOption = document.createElement('option');
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.textContent = 'Select Role';
                roleSelect.appendChild(defaultOption);
                
                // Add department-specific roles
                departmentRoles[department].forEach(role => {
                    const option = document.createElement('option');
                    option.value = role;
                    option.textContent = role;
                    roleSelect.appendChild(option);
                });
            } else {
                // Disable the role select if no department is selected
                roleSelect.disabled = true;
                const defaultOption = document.createElement('option');
                defaultOption.disabled = true;
                defaultOption.selected = true;
                defaultOption.textContent = 'Select Department First';
                roleSelect.appendChild(defaultOption);
            }
        });

        // Drag and Drop Functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropZone.classList.add('active');
        }
        
        function unhighlight() {
            dropZone.classList.remove('active');
        }
        
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        function handleFiles(files) {
            ([...files]).forEach(uploadFile);
        }
        
        function uploadFile(file) {
            // In a real application, you would upload the file to a server here
            console.log('Uploading file:', file.name);
            
            // Add file to the file list
            const fileElement = document.createElement('div');
            fileElement.className = 'flex items-center justify-between p-2 bg-gray-50 rounded';
            fileElement.innerHTML = `
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>${file.name}</span>
                </div>
                <div class="text-xs text-gray-500">${formatFileSize(file.size)}</div>
            `;
            fileList.appendChild(fileElement);
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    
     <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>