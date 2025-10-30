<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
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
          <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
            <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            color: #000;
        }
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .table-row:hover {
            background-color: #f9fafb;
        }
        .currency-badge {
            background-color: #1e40af;
            color: white;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.75rem;
            margin-left: 8px;
            vertical-align: middle;
        }
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background: #e5e7eb;
            overflow: hidden;
            position: relative;
        }
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            position: absolute;
            left: 0;
            top: 0;
            transition: width 1s ease-in-out;
        }
        .percentage-display {
            font-size: 0.85rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 12px;
            background: #f3f4f6;
        }
    </style>
    </head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-2">
<body class="p-4 md:p-8 min-h-screen">
    <div class="max-w-9xl mx-auto bg-white rounded-xl shadow-md p-3 md:p-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
        </div>
        
        <!-- Compensation Cards in Single Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <!-- Base Salary Card -->
            <div class="card p-6 bg-white">
                <div class="flex items-center mb-2">
                    <i data-lucide="banknote" class="w-5 h-5 mr-2 text-blue-600"></i>
                    <h2 class="text-lg font-semibold">Base Salary</h2>
                </div>
                <p class="text-2xl font-bold mb-2">₱4,760,000</p>
                <div class="flex items-center text-sm text-green-600 mt-1">
                    <i data-lucide="arrow-up" class="w-4 h-4 mr-1"></i>
                    <span>+5.2% from last year</span>
                </div>
            </div>
            
            <!-- Total Bonus Card -->
            <div class="card p-6 bg-white">
                <div class="flex items-center mb-2">
                    <i data-lucide="gift" class="w-5 h-5 mr-2 text-blue-600"></i>
                    <h2 class="text-lg font-semibold">Total Bonus</h2>
                </div>
                <p class="text-2xl font-bold mb-2">₱714,000</p>
                <p class="text-sm text-gray-600 mt-1">Year to date</p>
            </div>
            
            <!-- Stock Options Card -->
            <div class="card p-6 bg-white">
                <div class="flex items-center mb-2">
                    <i data-lucide="trending-up" class="w-5 h-5 mr-2 text-blue-600"></i>
                    <h2 class="text-lg font-semibold">Stock Options</h2>
                </div>
                <p class="text-2xl font-bold mb-1">250 units</p>
                <p class="text-sm text-gray-600">Current value: ₱882,000</p>
            </div>
            
            <!-- Total Compensation Card -->
            <div class="card p-6 bg-white">
                <div class="flex items-center mb-2">
                    <i data-lucide="wallet" class="w-5 h-5 mr-2 text-blue-600"></i>
                    <h2 class="text-lg font-semibold">Total Compensation</h2>
                </div>
                <p class="text-2xl font-bold mb-2">₱6,356,000</p>
                <p class="text-sm text-gray-600 mt-1">Annual package</p>
            </div>
        </div>
    
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center">
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Left Column: Compensation History -->
            <div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-gray-100">
                            <tr>
                                <th class="px-4 py-3">YEAR</th>
                                <th class="px-4 py-3">BASE SALARY</th>
                                <th class="px-4 py-3">TOTAL BONUS</th>
                                <th class="px-4 py-3">STOCK VALUE</th>
                                <th class="px-4 py-3">TOTAL COMP</th>
                                <th class="px-4 py-3">YOY CHANGE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b table-row">
                                <td class="px-4 py-3 font-semibold">2023</td>
                                <td class="px-4 py-3">₱4,700,000</td>
                                <td class="px-4 py-3">₱714,000</td>
                                <td class="px-4 py-3">₱852,000</td>
                                <td class="px-4 py-3 font-semibold">₱6,356,000</td>
                                <td class="px-4 py-3 text-green-600 font-semibold">+18.1%</td>
                            </tr>
                            <tr class="border-b table-row">
                                <td class="px-4 py-3 font-semibold">2022</td>
                                <td class="px-4 py-3">₱4,322,000</td>
                                <td class="px-4 py-3">₱567,000</td>
                                <td class="px-4 py-3">₱764,000</td>
                                <td class="px-4 py-3 font-semibold">₱5,873,000</td>
                                <td class="px-4 py-3 text-green-600 font-semibold">+12.5%</td>
                            </tr>
                            <tr class="border-b table-row">
                                <td class="px-4 py-3 font-semibold">2021</td>
                                <td class="px-4 py-3">₱4,284,000</td>
                                <td class="px-4 py-3">₱500,000</td>
                                <td class="px-4 py-3">₱672,000</td>
                                <td class="px-4 py-3 font-semibold">₱5,456,000</td>
                                <td class="px-4 py-3 text-green-600 font-semibold">+15.2%</td>
                            </tr>
                            <tr class="table-row">
                                <td class="px-4 py-3 font-semibold">2020</td>
                                <td class="px-4 py-3">₱4,118,000</td>
                                <td class="px-4 py-3">₱443,000</td>
                                <td class="px-4 py-3">₱644,000</td>
                                <td class="px-4 py-3 font-semibold">₱5,180,000</td>
                                <td class="px-4 py-3">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
            
            <!-- Right Column: Compensation Breakdown -->
            <div>
                <h2 class="text-xl font-bold mb-1">Compensation Breakdown</h2>
                <div class="card p-6">
                    <!-- Base Salary -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i data-lucide="credit-card" class="w-5 h-5 mr-2 text-blue-600"></i>
                                <span class="font-medium">Base Salary</span>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">₱4,700,000</p>
                                <span class="percentage-display text-blue-700">74.0%</span>
                            </div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-blue-600" style="width: 74%"></div>
                        </div>
                    </div>
                    
                    <!-- Annual Bonus -->
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i data-lucide="gift" class="w-5 h-5 mr-2 text-green-600"></i>
                                <span class="font-medium">Annual Bonus</span>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">₱714,000</p>
                                <span class="percentage-display text-green-700">11.2%</span>
                            </div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-green-600" style="width: 11.2%"></div>
                        </div>
                    </div>
                    
                    <!-- Stock Options -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i data-lucide="trending-up" class="w-5 h-5 mr-2 text-amber-600"></i>
                                <span class="font-medium">Stock Options</span>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">₱852,000</p>
                                <span class="percentage-display text-amber-700">13.4%</span>
                            </div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-amber-600" style="width: 13.4%"></div>
                        </div>
                    </div>
                    
                    <!-- Other Compensation -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center">
                                <i data-lucide="award" class="w-5 h-5 mr-2 text-purple-600"></i>
                                <span class="font-medium">Other Benefits</span>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold">₱90,000</p>
                                <span class="percentage-display text-purple-700">1.4%</span>
                            </div>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill bg-purple-600" style="width: 1.4%"></div>
                        </div>
                    </div>
                    
                    <!-- Divider -->
                    <div class="h-px bg-gray-200 my-4"></div>
                    
                    <!-- Total Annual Compensation -->
                    <div class="bg-black-50 p-5  rounded-lg border border-blue-100 mt-2">
                        <p class="text-lg font-semibold text-blue-800 text-center mb-2">Total Annual Compensation</p>
                        <p class="text-3xl font-bold text-blue-900 text-center">₱6,356,000</p>
                    </div>
                </div>
        <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Animate progress bars on page load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
<script src="../soliera.js"></script>
</html>