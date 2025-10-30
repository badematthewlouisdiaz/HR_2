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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#030b81ff',
                        secondary: '#030b81ff',
                        success: '#27ae60',
                        warning: '#f39c12',
                        danger: '#e74c3c',
                    }
                }
            }
        }
    </script>
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
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="bg-secondary text-white rounded-xl shadow-lg mb-8">
            <div class="container mx-auto px-6 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold mb-2">Assign Employee</h1>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="stats shadow bg-base-100 text-base-content">
                            <div class="stat">
                                <div class="stat-title">Total Employees</div>
                                <div class="stat-value text-primary">12</div>
                                <div class="stat-desc">Across 5 departments</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column - Tables -->
            <div class="w-full lg:w-2/3">
                <!-- Filter Section -->
                <div class="bg-base-100 rounded-xl shadow-lg p-4 md:p-6 mb-6">
                    <div class="flex flex-col md:flex-row gap-4 items-center">
                        <div class="w-full md:w-1/3">
                            <label class="label">
                                <span class="label-text font-semibold">Training Type</span>
                            </label>
                            <select id="training-type-filter" class="select select-bordered w-full">
                                <option value="all">All Training Types</option>
                                <option value="retains">Retains</option>
                                <option value="reskillings">Reskillings</option>
                                <option value="upskillings">Upskillings</option>
                                <option value="leadership">Leadership</option>
                                <option value="new-hires">New Hires</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="label">
                                <span class="label-text font-semibold">Department</span>
                            </label>
                            <select id="department-filter" class="select select-bordered w-full">
                                <option value="all">All Departments</option>
                                <option value="IT">IT</option>
                                <option value="Operations">Operations</option>
                                <option value="Analytics">Analytics</option>
                                <option value="Human Resources">Human Resources</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Design">Design</option>
                                <option value="Finance">Finance</option>
                                <option value="Sales">Sales</option>
                                <option value="Support">Support</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/3">
                            <label class="label">
                                <span class="label-text font-semibold">Level</span>
                            </label>
                            <select id="level-filter" class="select select-bordered w-full">
                                <option value="all">All Levels</option>
                                <option value="entry">Entry Level</option>
                                <option value="mid">Mid Level</option>
                                <option value="senior">Senior Level</option>
                                <option value="leadership">Leadership</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="bg-base-100 rounded-xl shadow-lg p-4 md:p-6">
                    <!-- Main Table -->
                    <div id="main-table" class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th class="hidden md:table-cell">Role</th>
                                    <th class="hidden lg:table-cell">Department</th>
                                    <th>Level</th>
                                    <th>Training Type</th>
                                    <th>Competency</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column - Training Progress -->
            <div class="w-full lg:w-1/3">
                <div class="bg-base-100 rounded-xl shadow-lg p-4 md:p-6 sticky top-4">
                    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-tasks text-primary"></i>
                        Training in Progress
                    </h2>
                    <div id="training-progress-container" class="space-y-4 max-h-[600px] overflow-y-auto">
                        <!-- Assigned trainings will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Details Modal -->
    <dialog id="employee-modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box max-w-2xl">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 id="employee-name" class="font-bold text-lg"></h3>
            <p id="employee-details" class="py-2"></p>
            
            <div class="divider"></div>
            
            <div class="training-list">
                <h4 class="font-bold mb-3">Available Training Topics</h4>
                <div id="training-topics" class="space-y-3">
                    <!-- Training topics will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </dialog>

    <!-- Update Progress Modal -->
    <dialog id="progress-modal" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Update Training Progress</h3>
            <p id="progress-training-name" class="py-4"></p>
            <div class="form-control w-full">
                <label class="label">
                    <span class="label-text">Progress Percentage</span>
                </label>
                <input type="range" min="0" max="100" value="0" class="range range-primary" id="progress-range" />
                <div class="w-full flex justify-between text-xs px-2">
                    <span>0%</span>
                    <span>25%</span>
                    <span>50%</span>
                    <span>75%</span>
                    <span>100%</span>
                </div>
                <div class="text-center mt-2">
                    <span id="progress-value" class="text-lg font-bold">0%</span>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog" class="flex gap-2">
                    <button class="btn btn-ghost">Cancel</button>
                    <button class="btn btn-primary" id="save-progress">Save Progress</button>
                </form>
            </div>
        </div>
    </dialog>

    <script>
        // Sample employee data with new hires having 0% competency
        const employees = [
            { id: 1, name: "John Smith", role: "Software Developer", department: "IT", level: "mid", competency: 28, trainingType: "reskillings" },
            { id: 2, name: "Sarah Johnson", role: "Project Manager", department: "Operations", level: "senior", competency: 65, trainingType: "upskillings" },
            { id: 3, name: "Michael Brown", role: "Data Analyst", department: "Analytics", level: "mid", competency: 42, trainingType: "retains" },
            { id: 4, name: "Emily Davis", role: "HR Specialist", department: "Human Resources", level: "senior", competency: 78, trainingType: "leadership" },
            { id: 5, name: "David Wilson", role: "Marketing Coordinator", department: "Marketing", level: "entry", competency: 0, trainingType: "new-hires" },
            { id: 6, name: "Jennifer Lee", role: "UX Designer", department: "Design", level: "mid", competency: 55, trainingType: "reskillings" },
            { id: 7, name: "Robert Taylor", role: "Financial Analyst", department: "Finance", level: "senior", competency: 70, trainingType: "upskillings" },
            { id: 8, name: "Amanda Clark", role: "Sales Representative", department: "Sales", level: "mid", competency: 48, trainingType: "retains" },
            { id: 9, name: "Christopher White", role: "Operations Manager", department: "Operations", level: "leadership", competency: 82, trainingType: "leadership" },
            { id: 10, name: "Jessica Martinez", role: "Customer Support", department: "Support", level: "entry", competency: 0, trainingType: "new-hires" },
            { id: 11, name: "Daniel Anderson", role: "Junior Developer", department: "IT", level: "entry", competency: 0, trainingType: "new-hires" },
            { id: 12, name: "Michelle Garcia", role: "HR Assistant", department: "Human Resources", level: "entry", competency: 0, trainingType: "new-hires" }
        ];

        // Sample training topics by role
        const trainingTopics = {
            "Software Developer": [
                "Advanced JavaScript",
                "Cloud Computing Fundamentals",
                "DevOps Practices",
                "Security Best Practices",
                "Agile Development Methodologies"
            ],
            "Project Manager": [
                "Advanced Project Management",
                "Stakeholder Management",
                "Risk Assessment Techniques",
                "Budget Management",
                "Team Leadership Skills"
            ],
            "Data Analyst": [
                "Advanced SQL Queries",
                "Data Visualization Tools",
                "Statistical Analysis Methods",
                "Machine Learning Basics",
                "Data Governance Principles"
            ],
            "HR Specialist": [
                "Employment Law Updates",
                "Talent Acquisition Strategies",
                "Employee Engagement Techniques",
                "Performance Management Systems",
                "Diversity and Inclusion Training"
            ],
            "Marketing Coordinator": [
                "Digital Marketing Strategies",
                "Social Media Marketing",
                "Content Creation Techniques",
                "Analytics and Reporting",
                "Brand Management"
            ],
            "UX Designer": [
                "User Research Methods",
                "Prototyping Tools",
                "Accessibility Guidelines",
                "Interaction Design Principles",
                "Design System Implementation"
            ],
            "Financial Analyst": [
                "Financial Modeling",
                "Investment Analysis",
                "Risk Management",
                "Regulatory Compliance",
                "Data Analysis for Finance"
            ],
            "Sales Representative": [
                "Advanced Sales Techniques",
                "CRM Software Mastery",
                "Negotiation Skills",
                "Product Knowledge Deep Dive",
                "Customer Relationship Building"
            ],
            "Operations Manager": [
                "Supply Chain Optimization",
                "Process Improvement Methods",
                "Team Management Strategies",
                "Budgeting and Forecasting",
                "Quality Control Systems"
            ],
            "Customer Support": [
                "Advanced Communication Skills",
                "Problem-Solving Techniques",
                "Product Knowledge",
                "Customer Satisfaction Metrics",
                "Conflict Resolution"
            ],
            "Junior Developer": [
                "Programming Fundamentals",
                "Version Control with Git",
                "Debugging Techniques",
                "Software Development Lifecycle",
                "Team Collaboration Tools"
            ],
            "HR Assistant": [
                "HR Administration Basics",
                "Employee Onboarding Process",
                "Record Keeping Best Practices",
                "Communication Skills",
                "Office Software Proficiency"
            ]
        };

        // Training in progress storage
        let trainingInProgress = JSON.parse(localStorage.getItem('trainingInProgress')) || [];
        let currentTrainingId = null;
        let currentFilters = {
            trainingType: 'all',
            department: 'all',
            level: 'all'
        };

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            // Set up filter event listeners
            setupFilters();
            
            // Populate table with employee data
            populateTable();
            
            // Display training in progress
            displayTrainingInProgress();
            
            // Set up progress modal
            setupProgressModal();
        });

        // Function to set up filter event listeners
        function setupFilters() {
            const trainingTypeFilter = document.getElementById('training-type-filter');
            const departmentFilter = document.getElementById('department-filter');
            const levelFilter = document.getElementById('level-filter');
            
            trainingTypeFilter.addEventListener('change', function() {
                currentFilters.trainingType = this.value;
                populateTable();
            });
            
            departmentFilter.addEventListener('change', function() {
                currentFilters.department = this.value;
                populateTable();
            });
            
            levelFilter.addEventListener('change', function() {
                currentFilters.level = this.value;
                populateTable();
            });
        }

        // Function to filter employees based on current filters
        function filterEmployees() {
            return employees.filter(employee => {
                // Filter by training type
                if (currentFilters.trainingType !== 'all' && employee.trainingType !== currentFilters.trainingType) {
                    return false;
                }
                
                // Filter by department
                if (currentFilters.department !== 'all' && employee.department !== currentFilters.department) {
                    return false;
                }
                
                // Filter by level
                if (currentFilters.level !== 'all' && employee.level !== currentFilters.level) {
                    return false;
                }
                
                return true;
            });
        }

        // Function to populate table with employee data
        function populateTable() {
            const filteredEmployees = filterEmployees();
            const tableBody = document.querySelector('#main-table tbody');

            // Clear existing table data
            tableBody.innerHTML = '';

            // Add employees to table
            filteredEmployees.forEach(employee => {
                const row = document.createElement('tr');
                
                // Determine competency rating class
                let competencyClass = 'badge-error';
                if (employee.competency >= 50) competencyClass = 'badge-warning';
                if (employee.competency >= 70) competencyClass = 'badge-success';
                if (employee.competency === 0) competencyClass = 'badge-error';
                
                // Determine level badge class
                let levelClass = 'badge-outline';
                if (employee.level === 'entry') levelClass = 'badge-info';
                if (employee.level === 'mid') levelClass = 'badge-primary';
                if (employee.level === 'senior') levelClass = 'badge-secondary';
                if (employee.level === 'leadership') levelClass = 'badge-accent';
                
                // Determine training type badge class
                let trainingTypeClass = 'badge-outline';
                if (employee.trainingType === 'retains') trainingTypeClass = 'badge-primary';
                if (employee.trainingType === 'reskillings') trainingTypeClass = 'badge-secondary';
                if (employee.trainingType === 'upskillings') trainingTypeClass = 'badge-accent';
                if (employee.trainingType === 'leadership') trainingTypeClass = 'badge-warning';
                if (employee.trainingType === 'new-hires') trainingTypeClass = 'badge-info';
                
                row.innerHTML = `
                    <td>
                        <div class="flex items-center space-x-3">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-8">
                                    <span class="text-xs">${employee.name.split(' ').map(n => n[0]).join('')}</span>
                                </div>
                            </div>
                            <div>
                                <div class="font-bold cursor-pointer hover:text-primary employee-name" data-id="${employee.id}">${employee.name}</div>
                            </div>
                        </div>
                    </td>
                    <td class="hidden md:table-cell">${employee.role}</td>
                    <td class="hidden lg:table-cell">${employee.department}</td>
                    <td>
                        <span class="badge ${levelClass} capitalize">${employee.level}</span>
                    </td>
                    <td>
                        <span class="badge ${trainingTypeClass} capitalize">${employee.trainingType}</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-gray-200 rounded-full h-2.5">
                                <div class="bg-primary h-2.5 rounded-full" style="width: ${employee.competency}%"></div>
                            </div>
                            <span class="badge ${competencyClass}">${employee.competency}%</span>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(row);
            });

            // Add click event listeners to employee names
            document.querySelectorAll('.employee-name').forEach(element => {
                element.addEventListener('click', function() {
                    const employeeId = parseInt(this.getAttribute('data-id'));
                    showEmployeeDetails(employeeId);
                });
            });
        }

        // Function to show employee details in modal
        function showEmployeeDetails(employeeId) {
            const employee = employees.find(emp => emp.id === employeeId);
            if (!employee) return;
            
            // Update modal content
            document.getElementById('employee-name').textContent = employee.name;
            document.getElementById('employee-details').textContent = 
                `${employee.role} | ${employee.department} | Level: ${employee.level} | Competency: ${employee.competency}%`;
            
            // Populate training topics
            const trainingTopicsContainer = document.getElementById('training-topics');
            trainingTopicsContainer.innerHTML = '';
            
            if (trainingTopics[employee.role]) {
                trainingTopics[employee.role].forEach(topic => {
                    const topicElement = document.createElement('div');
                    topicElement.className = 'flex justify-between items-center p-3 bg-base-200 rounded-lg';
                    topicElement.innerHTML = `
                        <span>${topic}</span>
                        <button class="btn btn-primary btn-sm assign-btn" data-employee-id="${employee.id}" data-topic="${topic}">
                            Assign <i class="fas fa-plus ml-1"></i>
                        </button>
                    `;
                    trainingTopicsContainer.appendChild(topicElement);
                });
            } else {
                trainingTopicsContainer.innerHTML = '<p class="text-center py-4">No training topics available for this role.</p>';
            }
            
            // Add event listeners to assign buttons
            document.querySelectorAll('.assign-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const empId = parseInt(this.getAttribute('data-employee-id'));
                    const topic = this.getAttribute('data-topic');
                    assignTraining(empId, topic);
                });
            });
            
            // Show the modal
            document.getElementById('employee-modal').showModal();
        }

        // Function to assign training to an employee
        function assignTraining(employeeId, topic) {
            const employee = employees.find(emp => emp.id === employeeId);
            if (!employee) return;
            
            // Check if this training is already assigned
            const existingTraining = trainingInProgress.find(
                training => training.employeeId === employeeId && training.topic === topic
            );
            
            if (existingTraining) {
                // Show toast notification
                showToast('This training is already assigned to this employee.', 'warning');
                return;
            }
            
            // Add to training in progress
            const newTraining = {
                id: Date.now(), // Simple unique ID
                employeeId: employeeId,
                employeeName: employee.name,
                role: employee.role,
                department: employee.department,
                level: employee.level,
                topic: topic,
                progress: 0,
                startDate: new Date().toLocaleDateString()
            };
            
            trainingInProgress.push(newTraining);
            
            // Save to localStorage
            localStorage.setItem('trainingInProgress', JSON.stringify(trainingInProgress));
            
            // Update the display
            displayTrainingInProgress();
            
            // Close the modal
            document.getElementById('employee-modal').close();
            
            // Show success toast
            showToast(`Training "${topic}" has been assigned to ${employee.name}`, 'success');
        }

        // Function to display training in progress
        function displayTrainingInProgress() {
            const container = document.getElementById('training-progress-container');
            container.innerHTML = '';
            
            if (trainingInProgress.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">No training in progress.</p>
                        <p class="text-sm text-gray-400">Assign training to employees to see them here.</p>
                    </div>
                `;
                return;
            }
            
            trainingInProgress.forEach(training => {
                const trainingElement = document.createElement('div');
                trainingElement.className = 'bg-base-200 rounded-lg p-4 border-l-4 border-primary';
                trainingElement.innerHTML = `
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-bold text-lg text-secondary">${training.topic}</h3>
                        <button class="btn btn-xs btn-ghost text-error delete-training-btn" data-training-id="${training.id}" title="Delete Training">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-2 mb-3">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-primary text-sm"></i>
                            <span class="text-sm"><strong>Employee:</strong> ${training.employeeName}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-briefcase text-primary text-sm"></i>
                            <span class="text-sm"><strong>Role:</strong> ${training.role}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building text-primary text-sm"></i>
                            <span class="text-sm"><strong>Department:</strong> ${training.department}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-layer-group text-primary text-sm"></i>
                            <span class="text-sm"><strong>Level:</strong> ${training.level}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-primary text-sm"></i>
                            <span class="text-sm"><strong>Started:</strong> ${training.startDate}</span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium">Progress</span>
                            <span class="text-sm font-bold">${training.progress}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-primary h-3 rounded-full transition-all duration-300" style="width: ${training.progress}%"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <button class="btn btn-primary btn-sm update-progress-btn" data-training-id="${training.id}">
                            <i class="fas fa-sync-alt mr-1"></i>
                            Update Progress
                        </button>
                        <span class="text-xs text-gray-500">ID: ${training.id}</span>
                    </div>
                `;
                container.appendChild(trainingElement);
            });
            
            // Add event listeners to update progress buttons
            document.querySelectorAll('.update-progress-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const trainingId = parseInt(this.getAttribute('data-training-id'));
                    showUpdateProgressModal(trainingId);
                });
            });
            
            // Add event listeners to delete buttons
            document.querySelectorAll('.delete-training-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const trainingId = parseInt(this.getAttribute('data-training-id'));
                    deleteTraining(trainingId);
                });
            });
        }

        // Function to set up progress modal
        function setupProgressModal() {
            const range = document.getElementById('progress-range');
            const value = document.getElementById('progress-value');
            
            range.addEventListener('input', function() {
                value.textContent = `${this.value}%`;
            });
            
            document.getElementById('save-progress').addEventListener('click', function() {
                if (currentTrainingId !== null) {
                    const progressValue = parseInt(range.value);
                    updateTrainingProgress(currentTrainingId, progressValue);
                }
            });
        }

        // Function to show update progress modal
        function showUpdateProgressModal(trainingId) {
            const training = trainingInProgress.find(t => t.id === trainingId);
            if (!training) return;
            
            currentTrainingId = trainingId;
            
            document.getElementById('progress-training-name').textContent = 
                `Update progress for "${training.topic}" assigned to ${training.employeeName}`;
            
            const range = document.getElementById('progress-range');
            const value = document.getElementById('progress-value');
            
            range.value = training.progress;
            value.textContent = `${training.progress}%`;
            
            document.getElementById('progress-modal').showModal();
        }

        // Function to update training progress
        function updateTrainingProgress(trainingId, progress) {
            const training = trainingInProgress.find(t => t.id === trainingId);
            if (!training) return;
            
            training.progress = progress;
            
            // Save to localStorage
            localStorage.setItem('trainingInProgress', JSON.stringify(trainingInProgress));
            
            // Update the display
            displayTrainingInProgress();
            
            // Close the modal
            document.getElementById('progress-modal').close();
            
            // Show success toast
            showToast(`Progress for "${training.topic}" updated to ${progress}%`, 'success');
        }

        // Function to delete training progress
        function deleteTraining(trainingId) {
            // Use SweetAlert2 for confirmation
            Swal.fire({
                title: 'Delete Training Progress?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#3498db',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove the training from the array
                    trainingInProgress = trainingInProgress.filter(t => t.id !== trainingId);
                    
                    // Save to localStorage
                    localStorage.setItem('trainingInProgress', JSON.stringify(trainingInProgress));
                    
                    // Update the display
                    displayTrainingInProgress();
                    
                    // Show success message
                    Swal.fire(
                        'Deleted!',
                        'Training progress has been deleted.',
                        'success'
                    );
                }
            });
        }

        // Function to show toast notifications
        function showToast(message, type = 'info') {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-top toast-end z-50`;
            
            let alertClass = 'alert-info';
            let icon = 'fas fa-info-circle';
            
            if (type === 'success') {
                alertClass = 'alert-success';
                icon = 'fas fa-check-circle';
            } else if (type === 'warning') {
                alertClass = 'alert-warning';
                icon = 'fas fa-exclamation-triangle';
            } else if (type === 'error') {
                alertClass = 'alert-error';
                icon = 'fas fa-times-circle';
            }
            
            toast.innerHTML = `
                <div class="alert ${alertClass} shadow-lg">
                    <div>
                        <i class="${icon}"></i>
                        <span>${message}</span>
                    </div>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    document.body.removeChild(toast);
                }
            }, 3000);
        }
    </script>
</body>
<script src="../sidebar.js"></script>
</html>