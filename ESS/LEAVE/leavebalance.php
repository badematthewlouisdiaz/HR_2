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
    <?php include 'sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
         
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-2">
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center space-x-4">
               

</div>

            </div>
            
        </div>
 <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Leave -->
            <div class="card bg-white shadow-md">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="card-title text-black">Total Leave</h2>
                            <p class="text-3xl font-bold text-black">24 <span class="text-lg text-black">days</span></p>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100 text-black">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Used Leave -->
            <div class="card bg-white shadow-md">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="card-title text-black">Used Leave</h2>
                            <p class="text-3xl font-bold text-black">8 <span class="text-lg text-black">days</span></p>
                        </div>
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Remaining Leave -->
            <div class="card bg-white shadow-md">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="card-title text-black">Remaining</h2>
                            <p class="text-3xl font-bold text-black">16 <span class="text-lg text-black">days</span></p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Requests -->
            <div class="card bg-white shadow-md">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="card-title text-black">Pending</h2>
                            <p class="text-3xl font-bold text-black">2 <span class="text-lg text-black">requests</span></p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Leave Breakdown -->
        <div class="card bg-white shadow-md mb-8">
            <div class="card-body">
                <h2 class="card-title text-black mb-6">Leave Breakdown</h2>
                
                <div class="overflow-x-auto text-black">
                    <table class="table">
                        <thead>
                            <tr class="bg-gray-100 text-black">
                                <th>Leave Type</th>
                                <th>Total</th>
                                <th>Used</th>
                                <th>Remaining</th>
                                <th>Validity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Annual Leave -->
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3 text-black">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-8 h-8 bg-blue-100 text-blue-600 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">Annual Leave</div>
                                        </div>
                                    </div>
                                </td>
                                <td>20 days</td>
                                <td>5 days</td>
                                <td>15 days</td>
                                <td>Dec 31, 2023</td>
                            </tr>
                            
                            <!-- Sick Leave -->
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-8 h-8 bg-green-100 text-green-600 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">Sick Leave</div>
                                        </div>
                                    </div>
                                </td>
                                <td>10 days</td>
                                <td>2 days</td>
                                <td>8 days</td>
                                <td>Dec 31, 2023</td>
                            </tr>
                            
                            <!-- Casual Leave -->
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-8 h-8 bg-purple-100 text-purple-600 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">Casual Leave</div>
                                        </div>
                                    </div>
                                </td>
                                <td>5 days</td>
                                <td>1 day</td>
                                <td>4 days</td>
                                <td>Dec 31, 2023</td>
                            </tr>
                            
                            <!-- Unpaid Leave -->
                            <tr>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="avatar">
                                            <div class="mask mask-squircle w-8 h-8 bg-red-100 text-red-600 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-bold">Unpaid Leave</div>
                                        </div>
                                    </div>
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Leave Requests -->
        <div class="card bg-white shadow-md text-black">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="card-title text-black">Recent Leave Requests</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr class="bg-gray-100 text-black">
                                <th>Request Date</th>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Request 1 -->
                            <tr>
                                <td>Oct 15, 2023</td>
                                <td>Annual Leave</td>
                                <td>Nov 1, 2023</td>
                                <td>Nov 5, 2023</td>
                                <td>5 days</td>
                                <td>
                                    <span class="badge badge-success">Approved</span>
                                </td>
                                <td>
                                    <button class="btn btn-ghost btn-xs">Details</button>
                                </td>
                            </tr>
                            
                            <!-- Request 2 -->
                            <tr>
                                <td>Oct 20, 2023</td>
                                <td>Sick Leave</td>
                                <td>Oct 22, 2023</td>
                                <td>Oct 23, 2023</td>
                                <td>2 days</td>
                                <td>
                                    <span class="badge badge-warning">Pending</span>
                                </td>
                                <td>
                                    <button class="btn btn-ghost btn-xs">Details</button>
                                </td>
                            </tr>
                            
                            <!-- Request 3 -->
                            <tr>
                                <td>Sep 5, 2023</td>
                                <td>Casual Leave</td>
                                <td>Sep 10, 2023</td>
                                <td>Sep 10, 2023</td>
                                <td>1 day</td>
                                <td>
                                    <span class="badge badge-error">Rejected</span>
                                </td>
                                <td>
                                    <button class="btn btn-ghost btn-xs">Details</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../soliera.js"></script>
</body>
</html>