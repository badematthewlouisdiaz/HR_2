<?php

session_start();
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Expense Claims</title>
<link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../soliera.css">
        <link rel="stylesheet" href="../sidebar.css">
</head>
    <style>
        .sparkline svg {
            display: block;
        }
        
        /* Custom styles to match the original design */
        .dashboard-container {
            height: calc(100vh - 40px);
        }
        
        .progress-bar {
            height: 6px;
        }
        
        .goal-progress {
            height: 8px;
        }
        
        .metric-value {
            font-size: 2.2rem;
        }
    </style>
</head>
<body class="min-h-screen">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
      <!-- Navbar -->
      <?php include '../USM/navbar.php'; ?>

      <!-- Main content -->
    <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
<body class="bg-gray-100 p-5">
   
        <header class="bg-gradient-to-r from-white-800 to-white-900 text-black p-5 flex justify-between items-center">
            <div class="header-title">
                
            </div>
            <div class="controls flex gap-3">
                <button class="bg-gray-800 bg-opacity-20 text-black px-4 py-2 rounded-full hover:bg-opacity-30 transition"><i class="fas fa-sync-alt mr-2"></i> Refresh</button>
                <button class="bg-gray-800 bg-opacity-20 text-black px-4 py-2 rounded-full hover:bg-opacity-30 transition"><i class="fas fa-download mr-2"></i> Export</button>
            </div>
        </header>
        
        <div class="main-content flex flex-1 overflow-hidden ">
            <div class="sidebar text-black p-5 w-1/4 flex flex-col gap-10">
                <div class="summary-card bg-gray-900 bg-opacity-10 p-4 rounded-lg">
                    <h3 class="text-lg mb-4 flex justify-between items-center">Overall Performance <i class="fas fa-chart-line text-xl"></i></h3>
                    <div class="metric mb-9">
                        <div class="metric-label flex justify-between text-sm mb-1">
                            <span>Score</span>
                            <span>87%</span>
                        </div>
                        <div class="progress-bar bg-gray-900 rounded-full">
                            <div class="progress-fill h-full rounded-full bg-blue-500" style="width: 87%"></div>
                        </div>
                    </div>
                    <div class="metric">
                        <div class="metric-label flex justify-between text-sm mb-1">
                            <span>Target</span>
                            <span>90%</span>
                        </div>
                        <div class="progress-bar bg-gray-700 rounded-full">
                            <div class="progress-fill h-full rounded-full bg-green-500" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="summary-card bg-gray-900 bg-opacity-10 p-4 rounded-lg">
                    <h3 class="text-lg mb-4 flex justify-between items-center">Team Summary <i class="fas fa-users text-xl"></i></h3>
                    <div class="metric mb-3">
                        <div class="metric-label flex justify-between text-sm mb-1">
                            <span>Productivity</span>
                            <span>92%</span>
                        </div>
                        <div class="progress-bar bg-gray-700 rounded-full">
                            <div class="progress-fill h-full rounded-full bg-green-500" style="width: 92%"></div>
                        </div>
                    </div>
                    <div class="metric mb-3">
                        <div class="metric-label flex justify-between text-sm mb-1">
                            <span>Quality</span>
                            <span>85%</span>
                        </div>
                        <div class="progress-bar bg-gray-700 rounded-full">
                            <div class="progress-fill h-full rounded-full bg-yellow-500" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="metric">
                        <div class="metric-label flex justify-between text-sm mb-1">
                            <span>Engagement</span>
                            <span>78%</span>
                        </div>
                        <div class="progress-bar bg-gray-700 rounded-full">
                            <div class="progress-fill h-full rounded-full bg-red-500" style="width: 78%"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="metrics-grid bg-gray-200 grid grid-cols-2 gap-5 p-5 w-3/4">
                <div class="metric-card rounded-xl shadow p-5 flex flex-col">
                    <div class="metric-card-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-black">Revenue</h3>
                        <i class="fas fa-dollar-sign text-green-500 text-xl"></i>
                    </div>
                    <div class="metric-value text-4xl font-bold my-2">142.8K</div>
                    <div class="metric-change text-green-500 text-sm flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i> 12.5% from last month
                    </div>
                    <div class="sparkline h-16 mt-4">
                        <svg width="100%" height="100%" viewBox="0 0 100 40">
                            <polyline points="0,35 20,25 40,15 60,20 80,10 100,5" stroke="#10B981" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="goal-indicator mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                        <span class="text-sm">Goal: $150K</span>
                        <div class="goal-progress w-3/4 bg-gray-200 rounded-full">
                            <div class="goal-progress-fill h-full rounded-full bg-green-500" style="width: 95%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="metric-card bg-gray-200 rounded-xl shadow p-5 flex flex-col">
                    <div class="metric-card-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Conversion Rate</h3>
                        <i class="fas fa-percentage text-blue-500 text-xl"></i>
                    </div>
                    <div class="metric-value text-4xl font-bold my-2">5.2%</div>
                    <div class="metric-change text-green-500 text-sm flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i> 2.1% from last month
                    </div>
                    <div class="sparkline h-16 mt-4">
                        <svg width="100%" height="100%" viewBox="0 0 100 40">
                            <polyline points="0,30 20,20 40,25 60,15 80,20 100,10" stroke="#3B82F6" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="goal-indicator mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                        <span class="text-sm">Goal: 5.5%</span>
                        <div class="goal-progress w-3/4 bg-gray-200 rounded-full">
                            <div class="goal-progress-fill h-full rounded-full bg-blue-500" style="width: 94%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="metric-card bg-gray-200 rounded-xl shadow p-5 flex flex-col">
                    <div class="metric-card-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Customer Satisfaction</h3>
                        <i class="fas fa-smile text-yellow-500 text-xl"></i>
                    </div>
                    <div class="metric-value text-4xl font-bold my-2">4.6/5</div>
                    <div class="metric-change text-red-500 text-sm flex items-center mt-1">
                        <i class="fas fa-arrow-down mr-1"></i> 0.2 from last month
                    </div>
                    <div class="sparkline h-16 mt-4">
                        <svg width="100%" height="100%" viewBox="0 0 100 40">
                            <polyline points="0,10 20,15 40,5 60,10 80,5 100,15" stroke="#F59E0B" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="goal-indicator mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                        <span class="text-sm">Goal: 4.8/5</span>
                        <div class="goal-progress w-3/4 bg-gray-200 rounded-full">
                            <div class="goal-progress-fill h-full rounded-full bg-yellow-500" style="width: 92%"></div>
                        </div>
                    </div>
                </div>
                
                <div class="metric-card bg-gray-200 rounded-xl shadow p-5 flex flex-col">
                    <div class="metric-card-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Operational Efficiency</h3>
                        <i class="fas fa-tachometer-alt text-purple-500 text-xl"></i>
                    </div>
                    <div class="metric-value text-4xl font-bold my-2">78%</div>
                    <div class="metric-change text-green-500 text-sm flex items-center mt-1">
                        <i class="fas fa-arrow-up mr-1"></i> 5% from last month
                    </div>
                    <div class="sparkline h-16 mt-4">
                        <svg width="100%" height="100%" viewBox="0 0 100 40">
                            <polyline points="0,30 20,25 40,20 60,25 80,15 100,10" stroke="#8B5CF6" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                    <div class="goal-indicator mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                        <span class="text-sm">Goal: 80%</span>
                        <div class="goal-progress w-3/4 bg-gray-200 rounded-full">
                            <div class="goal-progress-fill h-full rounded-full bg-purple-500" style="width: 97%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer bg-gray-100 p-4 border-t border-gray-200 flex justify-between items-center text-sm text-gray-600">
            <div class="time-range">
                Showing data for: 
                <button class="active font-semibold text-blue-600 ml-1">This Month</button> 
                <span> | </span>
                <button class="text-blue-600 mx-1">Quarter</button> 
                <span> | </span>
                <button class="text-blue-600 ml-1">Year</button>
            </div>
            <div class="view-options flex gap-4">
                <button class="text-blue-600"><i class="fas fa-table mr-1"></i> Data Table</button>
                <button class="text-blue-600"><i class="fas fa-chart-bar mr-1"></i> Detailed Reports</button>
            </div>
        </div>
    </div>

    <script>
        // Simple script to handle button active states
        document.querySelectorAll('.time-range button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelector('.time-range button.active').classList.remove('active', 'font-semibold', 'text-blue-600');
                this.classList.add('active', 'font-semibold', 'text-blue-600');
            });
        });
    </script>
     <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>