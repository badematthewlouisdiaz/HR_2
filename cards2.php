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
    <style>
        .dashboard-card:hover {
            transform: translateY(-3px);
            transition: transform 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .stat-card:hover {
            background-color: #f8fafc;
            transition: background-color 0.3s ease;
        }
        @media (max-width: 768px) {
            .mobile-menu-hidden {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-base-100 min-h-screen bg-white">

  <div class="flex h-screen overflow-hidden">

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Navbar -->
    <!-- Main Content -->
     <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
    <div class="container mx-auto p-6">
<body class="bg-gray-100 min-h-screen">
    <div class="drawer drawer-mobile">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <!-- Main content -->
            <main class="flex-1 p-4 md:p-6">
                <!-- Page title -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold">Welcome back, Admin!</h1>
                </div>

                <!-- Stats overview -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="stat-card stats shadow bg-white">
                        <div class="stat">
                            <div class="stat-figure text-primary">
                                <i data-lucide="book-open" width="28" height="28"></i>
                            </div>
                            <div class="stat-title">Total Courses</div>
                            <div class="stat-value text-primary text-2xl md:text-3xl">126</div>
                            <div class="stat-desc">21% more than last month</div>
                        </div>
                    </div>
                    
                    <div class="stat-card stats shadow bg-white">
                        <div class="stat">
                            <div class="stat-figure text-secondary">
                                <i data-lucide="users" width="28" height="28"></i>
                            </div>
                            <div class="stat-title">Active Learners</div>
                            <div class="stat-value text-secondary text-2xl md:text-3xl">2,483</div>
                            <div class="stat-desc">14% more than last month</div>
                        </div>
                    </div>
                    
                    <div class="stat-card stats shadow bg-white">
                        <div class="stat">
                            <div class="stat-figure text-accent">
                                <i data-lucide="target" width="28" height="28"></i>
                            </div>
                            <div class="stat-title">Competencies</div>
                            <div class="stat-value text-accent text-2xl md:text-3xl">86</div>
                            <div class="stat-desc">7 new added this month</div>
                        </div>
                    </div>
                    
                    <div class="stat-card stats shadow bg-white">
                        <div class="stat">
                            <div class="stat-figure text-info">
                                <i data-lucide="trending-up" width="28" height="28"></i>
                            </div>
                            <div class="stat-title">Succession Plans</div>
                            <div class="stat-value text-info text-2xl md:text-3xl">42</div>
                            <div class="stat-desc">3 in progress</div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard modules -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                    <!-- Learning Management -->
                    <div class="dashboard-card card bg-base-100 shadow-md">
                        <div class="card-body">
                            <h2 class="card-title">
                                <i data-lucide="book-open" class="text-blue-500"></i>
                                Learning Management
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="table table-zebra table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th class="hidden sm:table-cell">Enrolled</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Leadership Skills</td>
                                            <td class="hidden sm:table-cell">142</td>
                                            <td><div class="badge badge-success">Active</div></td>
                                            <td><button class="btn btn-xs btn-outline">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>Project Management</td>
                                            <td class="hidden sm:table-cell">87</td>
                                            <td><div class="badge badge-warning">Draft</div></td>
                                            <td><button class="btn btn-xs btn-outline">Edit</button></td>
                                        </tr>
                                        <tr>
                                            <td>Communication Skills</td>
                                            <td class="hidden sm:table-cell">203</td>
                                            <td><div class="badge badge-success">Active</div></td>
                                            <td><button class="btn btn-xs btn-outline">View</button></td>
                                        </tr>
                                        <tr>
                                            <td>Leadership Skills</td>
                                            <td class="hidden sm:table-cell">142</td>
                                            <td><div class="badge badge-success">Active</div></td>
                                            <td><button class="btn btn-xs btn-outline">View</button></td>
                                        </tr>                                      
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <button class="btn btn-primary btn-sm md:btn-md">View All Courses</button>
                            </div>
                        </div>
                    </div>

                    <!-- Training Management -->
                    <div class="dashboard-card card bg-base-100 shadow-md">
                        <div class="card-body">
                            <h2 class="card-title">
                                <i data-lucide="calendar" class="text-green-500"></i>
                                Training Management
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="table table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th>Training</th>
                                            <th class="hidden md:table-cell">Date</th>
                                            <th>Participants</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Team Building Workshop</td>
                                            <td class="hidden md:table-cell">24 Oct 2023</td>
                                            <td>24/30</td>
                                            <td><div class="badge badge-info">Upcoming</div></td>
                                        </tr>
                                        <tr>
                                            <td>Safety Training</td>
                                            <td class="hidden md:table-cell">15 Oct 2023</td>
                                            <td>30/30</td>
                                            <td><div class="badge badge-success">Completed</div></td>
                                        </tr>
                                        <tr>
                                            <td>Software Training</td>
                                            <td class="hidden md:table-cell">18 Oct 2023</td>
                                            <td>17/25</td>
                                            <td><div class="badge badge-warning">Ongoing</div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-medium">Training Completion Rate</span>
                                    <span class="text-sm">78%</span>
                                </div>
                                <progress class="progress progress-success w-full" value="78" max="100"></progress>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <button class="btn btn-primary btn-sm md:btn-md">Schedule Training</button>
                            </div>
                        </div>
                    </div>

                    <!-- Succession Planning -->
                    <div class="dashboard-card card bg-base-100 shadow-md">
                        <div class="card-body">
                            <h2 class="card-title">
                                <i data-lucide="trending-up" class="text-purple-500"></i>
                                Succession Planning
                            </h2>
                            <div class="overflow-x-auto">
                                <table class="table table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th class="hidden lg:table-cell">Candidate</th>
                                            <th>Readiness</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Project Manager</td>
                                            <td class="hidden lg:table-cell">Sarah Johnson</td>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="w-12 md:w-16 mr-2">
                                                        <progress class="progress progress-info w-full" value="80" max="100"></progress>
                                                    </div>
                                                    <span class="text-sm">80%</span>
                                                </div>
                                            </td>
                                            <td><div class="badge badge-success">Ready</div></td>
                                        </tr>
                                        <tr>
                                            <td>Team Lead</td>
                                            <td class="hidden lg:table-cell">Michael Chen</td>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="w-12 md:w-16 mr-2">
                                                        <progress class="progress progress-warning w-full" value="45" max="100"></progress>
                                                    </div>
                                                    <span class="text-sm">45%</span>
                                                </div>
                                            </td>
                                            <td><div class="badge badge-warning">In Progress</div></td>
                                        </tr>
                                        <tr>
                                            <td>Department Head</td>
                                            <td class="hidden lg:table-cell">Emily Williams</td>
                                            <td>
                                                <div class="flex items-center">
                                                    <div class="w-12 md:w-16 mr-2">
                                                        <progress class="progress progress-error w-full" value="20" max="100"></progress>
                                                    </div>
                                                    <span class="text-sm">20%</span>
                                                </div>
                                            </td>
                                            <td><div class="badge badge-error">Not Ready</div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <button class="btn btn-primary btn-sm md:btn-md">View Plan</button>
                            </div>
                        </div>
                    </div>

                    <!-- Competency Management -->
                    <div class="dashboard-card card bg-base-100 shadow-md">
                        <div class="card-body">
                            <h2 class="card-title">
                                <i data-lucide="target" class="text-orange-500"></i>
                                Competency Management
                            </h2>
                            <div class="flex justify-between mb-4 flex-col sm:flex-row">
                                <div class="mb-2 sm:mb-0">
                                    <h3 class="text-lg font-semibold">Skill Gaps Analysis</h3>
                                    <p class="text-sm text-gray-500">Based on current role requirements</p>
                                </div>
                                <div class="dropdown dropdown-bottom dropdown-end">
                                    <label tabindex="0" class="btn btn-sm btn-ghost">Department</label>
                                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                                        <li><a>IT</a></li>
                                        <li><a>HR</a></li>
                                        <li><a>Finance</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="table table-auto w-full">
                                    <thead>
                                        <tr>
                                            <th>Competency</th>
                                            <th class="hidden md:table-cell">Required</th>
                                            <th class="hidden sm:table-cell">Current</th>
                                            <th>Gap</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Leadership</td>
                                            <td class="hidden md:table-cell">Advanced</td>
                                            <td class="hidden sm:table-cell">Intermediate</td>
                                            <td><div class="badge badge-warning">Medium</div></td>
                                        </tr>
                                        <tr>
                                            <td>Communication</td>
                                            <td class="hidden md:table-cell">Advanced</td>
                                            <td class="hidden sm:table-cell">Advanced</td>
                                            <td><div class="badge badge-success">None</div></td>
                                        </tr>
                                        <tr>
                                            <td>Technical Skills</td>
                                            <td class="hidden md:table-cell">Expert</td>
                                            <td class="hidden sm:table-cell">Advanced</td>
                                            <td><div class="badge badge-error">High</div></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <button class="btn btn-primary btn-sm md:btn-md">View Details</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div> 
        
        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="my-drawer-2" class="drawer-overlay"></label> 
            <ul class="menu p-4 w-80 bg-base-100 text-base-content">
                <!-- Sidebar content here -->
                <li class="mb-4 font-sans font-bold text-xl">
                    <a class="normal-case text-xl">
                        <i data-lucide="layout-dashboard" class="text-primary"></i>
                        HR Dashboard
                    </a>
                </li>
                <li><a class="active"><i data-lucide="home"></i> Overview</a></li>
                <li>
                    <details open>
                        <summary>
                            <i data-lucide="book-open"></i>
                            Learning Management
                        </summary>
                        <ul>
                            <li><a>Courses</a></li>
                            <li><a>Content Library</a></li>
                            <li><a>Assignments</a></li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary>
                            <i data-lucide="calendar"></i>
                            Training Management
                        </summary>
                        <ul>
                            <li><a>Training Programs</a></li>
                            <li><a>Sessions</a></li>
                            <li><a>Attendance</a></li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary>
                            <i data-lucide="trending-up"></i>
                            Succession Planning
                        </summary>
                        <ul>
                            <li><a>Positions</a></li>
                            <li><a>Candidates</a></li>
                            <li><a>Development Plans</a></li>
                        </ul>
                    </details>
                </li>
                <li>
                    <details>
                        <summary>
                            <i data-lucide="target"></i>
                            Competency Management
                        </summary>
                        <ul>
                            <li><a>Skills Matrix</a></li>
                            <li><a>Assessments</a></li>
                            <li><a>Gap Analysis</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Responsive adjustments
        function handleResize() {
            const screenWidth = window.innerWidth;
            const drawer = document.getElementById('my-drawer-2');
            
            if (screenWidth < 1024 && drawer.checked) {
                drawer.checked = false;
            }
        }
        
        window.addEventListener('resize', handleResize);
        window.addEventListener('load', handleResize);
    </script>
</body>
<script src="soliera.js"></script>
</html>