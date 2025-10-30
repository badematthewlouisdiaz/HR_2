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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 main-grid">
          <!-- Claim Form -->
          <div class="card bg-white shadow-md lg:col-span-2 fade-in">
            <div class="card-body p-6">
              <h2 class="card-title text-xl font-bold text-gray-800 mb-6">Submit New Claim</h2>
              
              <form id="claim-form" class="space-y-6">
                <!-- Claim Type -->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-black">Claim Type</span>
                  </label>
                  <select class="select select-bordered w-full bg-white text-black" id="claim-type" required>
                    <option value="" disabled selected>Select claim type</option>
                    <option value="travel">Travel Expenses</option>
                    <option value="meal">Meal Allowance</option>
                    <option value="supplies">Office Supplies</option>
                    <option value="training">Training & Development</option>
                    <option value="medical">Medical Reimbursement</option>
                    <option value="other">Other</option>
                  </select>
                </div>
                
                <!-- Date and Amount -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text font-medium text-black">Date of Expense</span>
                    </label>
                    <input type="date" class="input input-bordered w-full bg-white" id="expense-date" required />
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text font-medium text-black">Amount</span>
                    </label>
                    <div class="relative">
                      <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600">₱</span>
                      <input type="number" placeholder="0.00" step="0.01" min="0" class="input input-bordered w-full pl-8 bg-white" id="expense-amount" required />
                    </div>
                  </div>
                </div>
                
                <!-- Description -->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-black">Description</span>
                  </label>
                  <textarea class="textarea textarea-bordered h-20 bg-white text-black" id="expense-description" placeholder="Provide details about this expense..." required></textarea>
                </div>
                
                <!-- File Upload -->
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium text-black">Receipt/Supporting Document</span>
                  </label>
                  <div class="upload-area" id="upload-area">
                    <input type="file" class="hidden" id="file-input" accept=".pdf,.jpg,.jpeg,.png" />
                    <div class="flex flex-col items-center justify-center pt-2 pb-4 px-4">
                      <i data-lucide="upload-cloud" class="w-10 h-10 text-gray-400 mb-2"></i>
                      <p class="text-sm text-gray-500 mt-2 text-black">
                        <span class="font-semibold">Click to upload</span> or drag and drop
                      </p>
                      <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB</p>
                    </div>
                  </div>
                  <div id="file-list" class="mt-3 hidden">
                    <div class="flex items-center justify-between bg-blue-50 p-3 rounded-lg">
                      <div class="flex items-center">
                        <i data-lucide="file-text" class="w-5 h-5 text-blue-500 mr-2"></i>
                        <span class="text-sm font-medium" id="file-name"></span>
                      </div>
                      <button type="button" class="text-red-500 hover:text-red-700" id="remove-file">
                        <i data-lucide="x" class="w-4 h-4"></i>
                      </button>
                    </div>
                  </div>
                </div>
                
                <!-- Submit Button -->
                <div class="flex justify-end mt-8">
                  <button type="submit" class="btn btn-primary px-8 gap-2">
                    <i data-lucide="send" class="w-5 h-5"></i>
                    Submit Claim
                  </button>
                </div>
              </form>
            </div>
          </div>
          
          <!-- Sidebar with guidelines and recent claims -->
          <div class="space-y-6">
            <!-- Guidelines Card -->
            <div class="card bg-white shadow-md fade-in">
              <div class="card-body p-6">
                <h2 class="card-title text-xl font-bold text-gray-800 mb-4">Claim Guidelines</h2>
                <ul class="space-y-4 text-sm text-gray-600">
                  <li class="flex items-start">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Submit claims within 30 days of expense</span>
                  </li>
                  <li class="flex items-start">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Attach clear receipts for all expenses</span>
                  </li>
                  <li class="flex items-start">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Meal expenses over ₱2,500 require itemized receipts</span>
                  </li>
                  <li class="flex items-start">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Travel claims require approval prior to trip</span>
                  </li>
                  <li class="flex items-start">
                    <i data-lucide="check-circle" class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Office supply claims limited to ₱5,000 per month</span>
                  </li>
                </ul>
              </div>
            </div>
            
            <!-- Recent Claims Card -->
            <div class="card bg-white shadow-md fade-in">
              <div class="card-body p-6">
                <div class="flex justify-between items-center mb-4">
                  <h2 class="card-title text-xl font-bold text-gray-800">Recent Claims</h2>
                  <a href="#" class="link link-primary text-sm font-medium">View all</a>
                </div>
                <div class="space-y-4" id="recent-claims">
                  <div class="claim-item">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="font-medium text-gray-800">Travel - Client Meeting</p>
                        <p class="text-sm text-gray-500">June 10, 2023</p>
                      </div>
                      <div class="text-right">
                        <span class="badge badge-success">Approved</span>
                        <p class="text-sm font-medium text-gray-800 mt-1">₱3,450.00</p>
                      </div>
                    </div>
                  </div>
                  <div class="claim-item">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="font-medium text-gray-800">Office Supplies</p>
                        <p class="text-sm text-gray-500">May 28, 2023</p>
                      </div>
                      <div class="text-right">
                        <span class="badge badge-success">Approved</span>
                        <p class="text-sm font-medium text-gray-800 mt-1">₱1,235.00</p>
                      </div>
                    </div>
                  </div>
                  <div class="claim-item">
                    <div class="flex justify-between items-center">
                      <div>
                        <p class="font-medium text-gray-800">Team Lunch</p>
                        <p class="text-sm text-gray-500">May 15, 2023</p>
                      </div>
                      <div class="text-right">
                        <span class="badge badge-warning">Pending</span>
                        <p class="text-sm font-medium text-gray-800 mt-1">₱2,800.00</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Claim Statistics Card -->
            <div class="card bg-white shadow-md fade-in">
              <div class="card-body p-6">
                <h2 class="card-title text-xl font-bold text-gray-800 mb-4">Claim Statistics</h2>
                <div class="grid grid-cols-2 gap-4">
                  <div class="bg-blue-50 p-4 rounded-lg text-center">
                    <i data-lucide="check-circle" class="w-6 h-6 text-blue-500 mx-auto mb-2"></i>
                    <p class="text-sm text-gray-600">Approved</p>
                    <p class="text-xl font-bold text-gray-800">12</p>
                  </div>
                  <div class="bg-amber-50 p-4 rounded-lg text-center">
                    <i data-lucide="clock" class="w-6 h-6 text-amber-500 mx-auto mb-2"></i>
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-xl font-bold text-gray-800">3</p>
                  </div>
                  <div class="bg-red-50 p-4 rounded-lg text-center">
                    <i data-lucide="x-circle" class="w-6 h-6 text-red-500 mx-auto mb-2"></i>
                    <p class="text-sm text-gray-600">Rejected</p>
                    <p class="text-xl font-bold text-gray-800">1</p>
                  </div>
                  <div class="bg-green-50 p-4 rounded-lg text-center">
                    <i data-lucide="dollar-sign" class="w-6 h-6 text-green-500 mx-auto mb-2"></i>
                    <p class="text-sm text-gray-600">Total</p>
                    <p class="text-xl font-bold text-gray-800">₱24,560</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // DOM Elements
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    const fileName = document.getElementById('file-name');
    const removeFileBtn = document.getElementById('remove-file');
    const claimForm = document.getElementById('claim-form');

    // Event Listeners
    uploadArea.addEventListener('click', () => {
      fileInput.click();
    });

    uploadArea.addEventListener('dragover', (e) => {
      e.preventDefault();
      uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
      uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
      e.preventDefault();
      uploadArea.classList.remove('dragover');
      
      if (e.dataTransfer.files.length) {
        handleFileUpload(e.dataTransfer.files[0]);
      }
    });

    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length) {
        handleFileUpload(e.target.files[0]);
      }
    });

    removeFileBtn.addEventListener('click', () => {
      fileInput.value = '';
      fileList.classList.add('hidden');
    });

    claimForm.addEventListener('submit', (e) => {
      e.preventDefault();
      
      // Validate form
      const claimType = document.getElementById('claim-type').value;
      const expenseDate = document.getElementById('expense-date').value;
      const expenseAmount = document.getElementById('expense-amount').value;
      const expenseDescription = document.getElementById('expense-description').value;
      
      if (!claimType || !expenseDate || !expenseAmount || !expenseDescription) {
        showNotification('Please fill in all required fields', 'error');
        return;
      }
      
      if (!fileInput.files.length) {
        showNotification('Please attach a receipt', 'error');
        return;
      }
      
      // Simulate form submission
      const submitBtn = claimForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      
      submitBtn.innerHTML = `
        <i data-lucide="loader" class="w-5 h-5 animate-spin"></i>
        Processing...
      `;
      lucide.createIcons();
      submitBtn.disabled = true;
      
      // Simulate API call
      setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        lucide.createIcons();
        
        showNotification('Claim submitted successfully!', 'success');
        claimForm.reset();
        fileList.classList.add('hidden');
        
        // Add to recent claims (simulated)
        addToRecentClaims({
          title: document.getElementById('claim-type').selectedOptions[0].text,
          date: formatDate(new Date()),
          amount: expenseAmount,
          status: 'Pending'
        });
      }, 2000);
    });

    // Functions
    function handleFileUpload(file) {
      // Validate file type and size
      const validTypes = ['image/jpeg', 'image/png', 'application/pdf'];
      const maxSize = 5 * 1024 * 1024; // 5MB
      
      if (!validTypes.includes(file.type)) {
        showNotification('Please select a PDF, JPG, or PNG file', 'error');
        return;
      }
      
      if (file.size > maxSize) {
        showNotification('File size must be less than 5MB', 'error');
        return;
      }
      
      // Display file name
      fileName.textContent = file.name;
      fileList.classList.remove('hidden');
    }

    function showNotification(message, type = 'info') {
      // Create notification element
      const notification = document.createElement('div');
      notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg text-white font-medium flex items-center gap-2 transition-transform transform translate-x-full ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'}`;
      notification.innerHTML = `
        <i data-lucide="${type === 'success' ? 'check-circle' : type === 'error' ? 'x-circle' : 'info'}" class="w-5 h-5"></i>
        <span>${message}</span>
      `;
      
      // Add to document
      document.body.appendChild(notification);
      
      // Animate in
      setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
      }, 10);
      
      // Animate out and remove after 3 seconds
      setTimeout(() => {
        notification.classList.remove('translate-x-0');
        notification.classList.add('translate-x-full');
        
        setTimeout(() => {
          document.body.removeChild(notification);
        }, 300);
      }, 3000);
      
      // Initialize icon
      lucide.createIcons();
    }

    function formatDate(date) {
      return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
      });
    }

    function addToRecentClaims(claim) {
      const recentClaims = document.getElementById('recent-claims');
      const statusClass = claim.status === 'Approved' ? 'badge-success' : 
                         claim.status === 'Pending' ? 'badge-warning' : 'badge-error';
      
      const claimElement = document.createElement('div');
      claimElement.className = 'claim-item';
      claimElement.innerHTML = `
        <div class="flex justify-between items-center">
          <div>
            <p class="font-medium text-gray-800">${claim.title}</p>
            <p class="text-sm text-gray-500">${claim.date}</p>
          </div>
          <div class="text-right">
            <span class="badge ${statusClass}">${claim.status}</span>
            <p class="text-sm font-medium text-gray-800 mt-1">₱${parseFloat(claim.amount).toLocaleString('en-US', {minimumFractionDigits: 2})}</p>
          </div>
        </div>
      `;
      
      recentClaims.prepend(claimElement);
      
      // If there are more than 3 items, remove the last one
      if (recentClaims.children.length > 3) {
        recentClaims.removeChild(recentClaims.lastChild);
      }
    }

    // Set today's date as default for the date field
    document.getElementById('expense-date').valueAsDate = new Date();
  </script>
  
      <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>