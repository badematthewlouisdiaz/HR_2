<?php

session_start()
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Payslip Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    .payslip-container {
      width: 95%;
      margin: 0 auto;
    }
    .wide-table {
      width: 100%;
      table-layout: fixed;
    }
    .wide-table th, .wide-table td {
      padding: 12px 15px;
    }
    .period-col {
      width: 18%;
    }
    .date-col {
      width: 15%;
    }
    .salary-col {
      width: 14%;
    }
    .netpay-col {
      width: 14%;
    }
    .status-col {
      width: 12%;
    }
    .actions-col {
      width: 20%;
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
      <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
        <!-- Header -->
        <div class="mb-6">

    <!-- Content Area -->
    <div class="flex-1 overflow-auto">
      <!-- Navbar -->
      <div class="bg-white shadow-sm">

      <!-- Main Content -->
      <main class="p-6">
        <div class="payslip-container">
          <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Payslip Records</h1>
            
            <!-- Filter and Search Section -->
            <div class="bg-blue-50 rounded-xl shadow-sm p-5 mb-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Select Period</label>
                  <select class="select select-bordered w-full">
                    <option disabled selected>Choose period</option>
                    <option>Last 3 months</option>
                    <option>Last 6 months</option>
                    <option>2023</option>
                    <option>2022</option>
                    <option>All payslips</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                  <div class="relative">
                    <input type="text" placeholder="Search payslips..." class="input input-bordered w-full pl-10">
                    <span class="absolute left-3 top-3 text-gray-400">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="flex  mt-5">
                <button class="btn btn-primary mr-2">
                  <i class="fas fa-filter mr-2"></i> Apply Filters
                </button>
                <button class="btn btn-outline">
                  <i class="fas fa-sync mr-2"></i> Reset
                </button>
              </div>
            </div>
            
            <!-- Payslip List -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
              <div class="overflow-x-auto">
                <table class="wide-table table">
                  <thead>
                    <tr class="bg-gray-100">
                      <th class="period-col">Period</th>
                      <th class="date-col">Payment Date</th>
                      <th class="salary-col">Basic Salary</th>
                      <th class="netpay-col">Net Pay</th>
                      <th class="status-col">Status</th>
                      <th class="actions-col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Current Month Payslip -->
                    <tr>
                      <td>
                        <div class="font-medium">August 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>August 31, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱22,850.75</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Previous Month Payslip -->
                    <tr>
                      <td>
                        <div class="font-medium">July 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>July 31, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,820.50</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Older Payslip -->
                    <tr>
                      <td>
                        <div class="font-medium">June 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>June 30, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,800.25</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Additional Example 1 -->
                    <tr>
                      <td>
                        <div class="font-medium">May 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>May 31, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,750.30</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Additional Example 2 -->
                    <tr>
                      <td>
                        <div class="font-medium">April 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>April 28, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,600.40</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Additional Example 3 -->
                    <tr>
                      <td>
                        <div class="font-medium">March 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>March 31, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,550.20</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Additional Example 4 -->
                    <tr>
                      <td>
                        <div class="font-medium">February 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>February 28, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,500.10</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                    
                    <!-- Additional Example 5 -->
                    <tr>
                      <td>
                        <div class="font-medium">January 2023</div>
                        <div class="text-sm text-gray-500">Full month</div>
                      </td>
                      <td>January 31, 2023</td>
                      <td>₱25,500.00</td>
                      <td class="font-semibold">₱23,450.00</td>
                      <td>
                        <span class="badge badge-success text-white py-2">Paid</span>
                      </td>
                      <td>
                        <div class="flex gap-2">
                          <button class="btn btn-sm btn-outline btn-primary">
                            <i class="fas fa-eye mr-1"></i> View
                          </button>
                          <button class="btn btn-sm btn-outline btn-secondary">
                            <i class="fas fa-download mr-1"></i> Download
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            
            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6">
              <div class="text-sm text-gray-500">
                Showing 1 to 8 of 32 records
              </div>
              <div class="join">
                <button class="join-item btn btn-sm">«</button>
                <button class="join-item btn btn-sm btn-active">1</button>
                <button class="join-item btn btn-sm">2</button>
                <button class="join-item btn btn-sm">3</button>
                <button class="join-item btn btn-sm">4</button>
                <button class="join-item btn btn-sm">»</button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  
  <!-- Payslip Detail Modal -->
  <input type="checkbox" id="payslip-modal" class="modal-toggle" />
  <div class="modal">
    <div class="modal-box max-w-5xl">
      <h3 class="font-bold text-2xl mb-2">Payslip - August 2023</h3>
      <div class="flex justify-between items-center mb-6">
        <div>
          <p class="text-gray-500">Employee ID: EMP-1001</p>
          <p class="text-gray-500">Payment Date: August 31, 2023</p>
        </div>
        <div class="badge badge-success text-white gap-2 py-3">
          <i class="fas fa-check-circle"></i> Paid
        </div>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-50 p-5 rounded-xl">
          <h4 class="font-bold mb-3 text-lg">Employee Details</h4>
          <div class="space-y-2">
            <p><span class="text-gray-500">Name:</span> John Doe</p>
            <p><span class="text-gray-500">Department:</span> Engineering</p>
            <p><span class="text-gray-500">Position:</span> Senior Developer</p>
            <p><span class="text-gray-500">Bank Account:</span> **** **** **** 1234</p>
          </div>
        </div>
        
        <div class="bg-gray-50 p-5 rounded-xl">
          <h4 class="font-bold mb-3 text-lg">Payroll Summary</h4>
          <div class="space-y-2">
            <p><span class="text-gray-500">Pay Period:</span> August 1 - August 31, 2023</p>
            <p><span class="text-gray-500">Payment Method:</span> Bank Transfer</p>
            <p><span class="text-gray-500">Tax ID:</span> TX-987654321</p>
            <p><span class="text-gray-500">Working Days:</span> 22/22</p>
          </div>
        </div>
      </div>
      
      <!-- Earnings and Deductions -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-green-50 p-5 rounded-xl">
          <h4 class="font-bold mb-3 text-green-800 text-lg">Earnings</h4>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span>Basic Salary</span>
              <span class="font-medium">₱25,500.00</span>
            </div>
            <div class="flex justify-between">
              <span>Overtime Pay</span>
              <span class="font-medium">₱2,250.00</span>
            </div>
            <div class="flex justify-between">
              <span>Bonus</span>
              <span class="font-medium">₱1,500.00</span>
            </div>
            <div class="flex justify-between">
              <span>Allowances</span>
              <span class="font-medium">₱1,200.00</span>
            </div>
            <div class="border-t pt-2 mt-2 flex justify-between font-bold text-lg">
              <span>Total Earnings</span>
              <span>₱30,450.00</span>
            </div>
          </div>
        </div>
        
        <div class="bg-red-50 p-5 rounded-xl">
          <h4 class="font-bold mb-3 text-red-800 text-lg">Deductions</h4>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span>Tax</span>
              <span class="font-medium">₱4,250.00</span>
            </div>
            <div class="flex justify-between">
              <span>Social Security</span>
              <span class="font-medium">₱1,250.00</span>
            </div>
            <div class="flex justify-between">
              <span>Health Insurance</span>
              <span class="font-medium">₱850.00</span>
            </div>
            <div class="flex justify-between">
              <span>Other Deductions</span>
              <span class="font-medium">₱249.25</span>
            </div>
            <div class="border-t pt-2 mt-2 flex justify-between font-bold text-lg">
              <span>Total Deductions</span>
              <span>₱6,599.25</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Net Pay -->
      <div class="bg-blue-50 p-5 rounded-xl mb-6">
        <div class="flex justify-between items-center">
          <h4 class="font-bold text-blue-800 text-lg">Net Pay</h4>
          <span class="text-3xl font-bold text-blue-800">₱23,850.75</span>
        </div>
        <p class="text-sm text-gray-500 mt-1">Amount transferred to your bank account</p>
      </div>
      
      <div class="modal-action">
        <button class="btn btn-primary">
          <i class="fas fa-print mr-2"></i> Print
        </button>
        <button class="btn btn-secondary">
          <i class="fas fa-download mr-2"></i> Download PDF
        </button>
        <label for="payslip-modal" class="btn">Close</label>
      </div>
    </div>
  </div>
  
  <script>
    // This would be replaced with actual functionality in a real application
    document.addEventListener('DOMContentLoaded', function() {
      // Simulate opening the payslip modal when view button is clicked
      const viewButtons = document.querySelectorAll('.btn-outline.btn-primary');
      viewButtons.forEach(button => {
        button.addEventListener('click', function() {
          document.getElementById('payslip-modal').checked = true;
        });
      });
    });
  </script>
</body>
 <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</html>