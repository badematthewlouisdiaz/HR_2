<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Competency Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../soliera.css">
  <link rel="stylesheet" href="../sidebar.css">
  <style>
    .fade-in { animation: fadeIn 0.5s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .progress-bar {
      height: 8px;
      border-radius: 4px;
      background: #e5e7eb;
      overflow: hidden;
    }
    .progress-value {
      height: 100%;
      border-radius: 4px;
      transition: width 0.3s ease;
    }
    .competency-card {
      transition: all 0.3s ease;
    }
    .competency-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

        .competency-table {
            font-size: 0.875rem;
        }
        @media (max-width: 768px) {
            .competency-table {
                font-size: 0.75rem;
            }
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

      <!-- Page Content -->
      <div class="container mx-auto max-w-9xl p-6">

        <!-- Filters and Controls -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="flex flex-wrap gap-4 items-center">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Search competencies</span>
                    </label>
                    <input type="text" placeholder="Search..." class="input input-bordered w-full md:w-auto" />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Filter by gap</span>
                    </label>
                    <select class="select select-bordered w-full md:w-auto">
                        <option>All competencies</option>
                        <option>With gap</option>
                        <option>Without gap</option>
                    </select>
                </div>
                <button class="btn btn-primary mt-6">
                    <i data-lucide="plus" class="w-5 h-5 mr-1"></i>
                    Add Competency
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Responsive Table -->
            <div class="overflow-x-auto">
                <table class="table competency-table">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-3 px-4 font-semibold">Competency</th>
                            <th class="py-3 px-4 font-semibold">Current Level</th>
                            <th class="py-3 px-4 font-semibold">Required Level</th>
                            <th class="py-3 px-4 font-semibold">Gap</th>
                            <th class="py-3 px-4 font-semibold">Action Plan</th>
                            <th class="py-3 px-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">JavaScript Programming</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">3</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium">5</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">-2</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <span>Advanced JS course (Q3), Mentorship</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 2 -->
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">UI/UX Design</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">4</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium">4</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">0</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <span>Maintain current skills</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 3 -->
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">Project Management</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">2</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium">4</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">-2</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <span>PM Fundamentals training, Agile certification</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 4 -->
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">Data Analysis</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">3</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium">5</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full">-2</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <span>Statistics course, SQL training, Power BI workshop</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Row 5 -->
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium">Communication Skills</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-800 font-medium">4</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-white font-medium">5</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded-full">-1</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center">
                                    <span>Presentation skills workshop, Toastmasters</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </button>
                                    <button class="btn btn-sm btn-ghost">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-between items-center p-4 border-t">
                <div class="text-sm text-gray-700">
                    Showing 1 to 5 of 12 results
                </div>
                <div class="join">
                    <button class="join-item btn btn-sm">1</button>
                    <button class="join-item btn btn-sm btn-active">2</button>
                    <button class="join-item btn btn-sm">3</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
    <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>