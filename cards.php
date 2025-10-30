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
<body class="bg-base-100 min-h-screen bg-white">

  <div class="flex h-screen overflow-hidden">

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Navbar -->
    <!-- Main Content -->
     <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
    <div class="container mx-auto p-6">
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Pending Leaves</div>
                    <div class="stat-value text-primary">3</div>
                    <div class="stat-desc">Waiting approval</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Upcoming Reviews</div>
                    <div class="stat-value text-secondary">1</div>
                    <div class="stat-desc">This month</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Pending Claims</div>
                    <div class="stat-value text-accent">2</div>
                    <div class="stat-desc">For processing</div>
                </div>
            </div>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Training Hours</div>
                    <div class="stat-value text-info">12</div>
                    <div class="stat-desc">This quarter</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <!-- Request Leave -->
                    <button class="btn btn-outline btn-primary flex flex-col h-24">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-xs">Request Leave</span>
                    </button>

                    <!-- View Payslip -->
                    <button class="btn btn-outline btn-success flex flex-col h-24">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-xs">View Payslip</span>
                    </button>

                    <!-- Submit Claim -->
                    <button class="btn btn-outline btn-accent flex flex-col h-24">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        <span class="text-xs">Submit Claim</span>
                    </button>

                    <!-- Log Time -->
                    <button class="btn btn-outline btn-warning flex flex-col h-24">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-xs">Log Time</span>
                    </button>

                    <!-- Recognition -->
                    <button class="btn btn-outline btn-info flex flex-col h-24">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-xs">Give Recognition</span>
                    </button>

                    <!-- Training -->
                    <button class="btn btn-outline btn-secondary flex flex-col h-24">
                        <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path>
                        </svg>
                        <span class="text-xs">Training</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Leave Management -->
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-primary text-primary-content">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="card-title">Leave Management</h2>
                    <p class="text-base-content/70">Apply and track your leaves</p>
                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge badge-primary badge-outline">3 pending</span>
                        <a href="LEAVE/leavereq.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>

            <!-- Performance Management -->
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-secondary text-secondary-content">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="card-title">Performance Management</h2>
                    <p class="text-base-content/70">Reviews and feedback system</p>
                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge badge-secondary badge-outline">1 review</span>
                        <a href="PERFORMANCE/myperformance.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>

            <!-- Compensation & Claims -->
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-accent text-accent-content">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="card-title">Claims</h2>
                    <p class="text-base-content/70">Salary and reimbursement</p>
                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge badge-accent badge-outline">2 claims</span>
                         <a href="CLAIMS/newclaim.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>


            <!-- Payroll -->
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-success text-success-content">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="card-title">Payroll</h2>
                    <p class="text-base-content/70">Salary and payslip access</p>
                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge badge-success badge-outline">Updated</span>
                        <a href="PAYROLL/payslip.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>


            <!-- Timesheet & Attendance -->
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-primary text-primary-content">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="card-title">Timesheet & Attendance</h2>
                    <p class="text-base-content/70">Time tracking and scheduling</p>
                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge badge-primary badge-outline">Active</span>
                        <a href="TIMESHEET/shifting.php" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>

            <!-- Learning & Training -->
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow cursor-pointer">
                <div class="card-body">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-lg bg-accent text-accent-content">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="card-title">Learning & Training</h2>
                    <p class="text-base-content/70">Courses and development</p>
                    <div class="card-actions justify-between items-center mt-4">
                        <span class="badge badge-accent badge-outline">12 hours</span>
                        <a href="" class="btn btn-primary btn-sm">View</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="soliera.js"></script>
</html>