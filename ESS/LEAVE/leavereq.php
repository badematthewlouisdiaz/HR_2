<?php

session_start();
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

  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
        
<body class="bg-gray-50">

   
    <style>
        .modal-box {
            background-color: white;
        }
        /* Custom styles for white form elements */
        .select-bordered, .input-bordered, .textarea-bordered, .file-input-bordered {
            background-color: white !important;
            border-color: #d1d5db !important; /* gray-300 */
            color: #000 !important; /* black text */
        }
        .select-bordered:focus, .input-bordered:focus, .textarea-bordered:focus, .file-input-bordered:focus {
            border-color: #3b82f6 !important; /* blue-500 */
            box-shadow: 0 0 0 1px #3b82f6 !important;
        }
        /* Ensure all text is black */
        body, .label-text, .text-gray-500, .text-gray-600, .text-gray-700, .text-gray-800 {
            color: #000 !important;
        }
        /* Style for date input with calendar icon */
        .date-input-container {
            position: relative;
        }
        .date-input-container input[type="date"] {
            padding-right: 2.5rem;
        }
        .date-input-container .calendar-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            cursor: pointer;
            pointer-events: none; /* Allow click to pass through to input */
        }
        /* Hide the default calendar dropdown arrow in some browsers */
        input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: auto;
            height: auto;
            color: transparent;
            background: transparent;
            opacity: 0;
            cursor: pointer;
        }
        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-clear-button {
            display: none;
        }
        /* Custom calendar trigger button */
        .calendar-trigger {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 1.25rem;
            height: 1.25rem;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 10;
        }
        /* Policy content styling */
        .policy-content {
            max-height: 400px;
            overflow-y: auto;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            background-color: #f9fafb;
        }
    </style>
</head>

    <div class="container mx-auto p-4 md:p-8 max-w-9xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold">Leave Management</h1>
            <button onclick="document.getElementById('policy_modal').showModal()" class="btn btn-primary gap-2">
                <i data-lucide="plus"></i>
                New Request
            </button>
        </div>

        <!-- Leave Balance Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i data-lucide="calendar-days"></i>
                Leave Balance
            </h2>
            <p class="mb-4">Current leave entitlements and usage</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Annual Leave Card -->
                <div class="card bg-blue-50 border border-blue-100">
                    <div class="card-body">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold">Annual Leave</h3>
                                <p class="text-sm">5 used / 20 total</p>
                            </div>
                            <div class="radial-progress text-blue-600" style="--value:75; --size:3rem; --thickness: 6px;">15</div>
                        </div>
                        <progress class="progress progress-primary w-full mt-2" value="25" max="100"></progress>
                    </div>
                </div>
                
                <!-- Sick Leave Card -->
                <div class="card bg-orange-50 border border-orange-100">
                    <div class="card-body">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold">Sick Leave</h3>
                                <p class="text-sm">2 used / 10 total</p>
                            </div>
                            <div class="radial-progress text-orange-600" style="--value:80; --size:3rem; --thickness: 6px;">8</div>
                        </div>
                        <progress class="progress progress-warning w-full mt-2" value="20" max="100"></progress>
                    </div>
                </div>
                
                <!-- Personal Leave Card -->
                <div class="card bg-green-50 border border-green-100">
                    <div class="card-body">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold">Personal Leave</h3>
                                <p class="text-sm">0 used / 3 total</p>
                            </div>
                            <div class="radial-progress text-green-600" style="--value:100; --size:3rem; --thickness: 6px;">3</div>
                        </div>
                        <progress class="progress progress-success w-full mt-2" value="0" max="100"></progress>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave History Section -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                <i data-lucide="history"></i>
                Leave History
            </h2>
            <p class="mb-4">Your recent leave requests and their status</p>
            
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="font-medium">TYPE</th>
                            <th class="font-medium">DATES</th>
                            <th class="font-medium">DAYS</th>
                            <th class="font-medium">STATUS</th>
                            <th class="font-medium">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Approved Annual Leave -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <span class="font-medium">Annual Leave</span>
                                </div>
                            </td>
                            <td>May 1, 2023 to May 5, 2023</td>
                            <td>5</td>
                            <td>
                                <span class="badge badge-success text-white">Approved</span>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-xs gap-1">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    View
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Approved Sick Leave -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                    <span class="font-medium">Sick Leave</span>
                                </div>
                            </td>
                            <td>Mar 15, 2023 to Mar 16, 2023</td>
                            <td>2</td>
                            <td>
                                <span class="badge badge-success text-white">Approved</span>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-xs gap-1">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    View
                                </button>
                            </td>
                        </tr>
                        
                        <!-- Pending Annual Leave -->
                        <tr>
                            <td>
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    <span class="font-medium">Annual Leave</span>
                                </div>
                            </td>
                            <td>Jun 20, 2023 to Jun 22, 2023</td>
                            <td>3</td>
                            <td>
                                <span class="badge badge-warning text-white">Pending</span>
                            </td>
                            <td>
                                <button class="btn btn-ghost btn-xs gap-1">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                    View
                                </button>
                                <button class="btn btn-ghost btn-xs gap-1 text-error">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    Cancel
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Policy Modal -->
    <dialog id="policy_modal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl bg-white">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg flex items-center gap-2">
                <i data-lucide="file-text"></i>
                Leave Company Policy
            </h3>
            
            <div class="divider"></div>
            
            <div class="policy-content">
                <h4 class="font-bold text-lg mb-2">Company Leave Policy</h4>
                <p class="mb-4">Please read and understand our company's leave policy before submitting a leave request.</p>
                
                <h5 class="font-semibold mt-4 mb-2">1. Annual Leave</h5>
                <ul class="list-disc pl-5 mb-4">
                    <li>Employees are entitled to 20 days of annual leave per year</li>
                    <li>Minimum of 5 consecutive days must be taken at least once per year</li>
                    <li>At least 2 weeks notice required for planned leave</li>
                </ul>
                
                <h5 class="font-semibold mt-4 mb-2">2. Sick Leave</h5>
                <ul class="list-disc pl-5 mb-4">
                    <li>10 days of paid sick leave per year</li>
                    <li>Medical certificate required for absences of 3 or more consecutive days</li>
                    <li>Must notify supervisor as soon as possible when taking sick leave</li>
                </ul>
                
                <h5 class="font-semibold mt-4 mb-2">3. Personal Leave</h5>
                <ul class="list-disc pl-5 mb-4">
                    <li>3 days of personal leave per year for urgent personal matters</li>
                    <li>Not required to disclose reason but must notify supervisor in advance when possible</li>
                </ul>
                
                <h5 class="font-semibold mt-4 mb-2">General Policies</h5>
                <ul class="list-disc pl-5 mb-4">
                    <li>All leave requests must be submitted through this system</li>
                    <li>Approval is at the discretion of management</li>
                    <li>Unused annual leave may be carried over up to 5 days to the next year</li>
                    <li>Excessive absenteeism may result in disciplinary action</li>
                </ul>
                
                <div class="alert alert-info mt-4">
                    <i data-lucide="info" class="w-5 h-5"></i>
                    <span>By continuing, you acknowledge that you have read and understood the company's leave policy.</span>
                </div>
            </div>
            
            <div class="modal-action">
                <button class="btn btn-ghost" onclick="document.getElementById('policy_modal').close()">Cancel</button>
                <button class="btn btn-primary gap-2" onclick="document.getElementById('policy_modal').close(); document.getElementById('new_request_modal').showModal()">
                    <i data-lucide="arrow-right"></i>
                    Continue to New Leave Request
                </button>
            </div>
        </div>
        
        <!-- Click outside to close -->
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <!-- New Request Modal -->
    <dialog id="new_request_modal" class="modal">
        <div class="modal-box w-11/12 max-w-4xl bg-white">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="font-bold text-lg flex items-center gap-2">
                <i data-lucide="file-plus"></i>
                New Leave Request
            </h3>
            
            <div class="divider"></div>
            
            <form class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Leave Type -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Leave Type</span>
                    </label>
                    <select class="select select-bordered w-full bg-white">
                        <option disabled selected>Select leave type</option>
                        <option>Annual Leave</option>
                        <option>Sick Leave</option>
                        <option>Personal Leave</option>
                        <option>Maternity Leave</option>
                        <option>Paternity Leave</option>
                        <option>Bereavement Leave</option>
                        <option>Marriage Leave</option>
                        <option>Emergency Leave</option>
                    </select>
                </div>
                
                <!-- Leave Duration -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Duration</span>
                    </label>
                    <select class="select select-bordered w-full bg-white">
                        <option disabled selected>Select duration</option>
                        <option>Full Day</option>
                        <option>Half Day (Morning)</option>
                        <option>Half Day (Afternoon)</option>
                        <option>Multiple Days</option>
                    </select>
                </div>
                
                <!-- Start Date -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Start Date</span>
                    </label>
                    <div class="date-input-container relative">
                        <input type="date" class="input input-bordered w-full bg-white" id="start_date" />
                        <button type="button" class="calendar-trigger" onclick="document.getElementById('start_date').showPicker()">
                            <i data-lucide="calendar" class="w-5 h-5 absolute top-0 left-0 text-gray-500"></i>
                        </button>
                    </div>
                </div>
                
                <!-- End Date -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">End Date</span>
                    </label>
                    <div class="date-input-container relative">
                        <input type="date" class="input input-bordered w-full bg-white" id="end_date" />
                        <button type="button" class="calendar-trigger" onclick="document.getElementById('end_date').showPicker()">
                            <i data-lucide="calendar" class="w-5 h-5 absolute top-0 left-0 text-gray-500"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Days Count -->
                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text">Total Days</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <input type="text" class="input input-bordered w-full bg-white" id="days_count" readonly placeholder="Will calculate automatically" />
                        <span>days</span>
                    </div>
                </div>
                
                <!-- Reason -->
                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text">Reason</span>
                    </label>
                    <textarea class="textarea textarea-bordered h-24 bg-white" placeholder="Briefly explain the reason for your leave"></textarea>
                </div>
                
                
                <!-- Documents -->
                <div class="form-control md:col-span-2">
                    <label class="label">
                        <span class="label-text">Supporting Documents (if any)</span>
                    </label>
                    <input type="file" class="file-input file-input-bordered w-full bg-white" />
                </div>
            </form>
            
            <div class="modal-action">
                <button class="btn btn-ghost" onclick="document.getElementById('new_request_modal').close()">Cancel</button>
                <button class="btn btn-primary gap-2">
                    <i data-lucide="send"></i>
                    Submit Request
                </button>
            </div>
        </div>
        
        <!-- Click outside to close -->
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Function to calculate days between dates
        function calculateDays() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            if (startDate && endDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('days_count').value = diffDays;
            }
        }
        
        // Add event listeners for date changes
        document.getElementById('start_date').addEventListener('change', function() {
            calculateDays();
            // Set min date for end date
            document.getElementById('end_date').min = this.value;
        });
        
        document.getElementById('end_date').addEventListener('change', calculateDays);
        
        // Set today's date as default for both fields
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('start_date').value = today;
            document.getElementById('end_date').value = today;
            document.getElementById('end_date').min = today;
            calculateDays();
        });
    </script>
</body>
<script src="../soliera.js"></script>
</html>
