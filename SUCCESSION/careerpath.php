<?php
session_start();
include("../db.php");
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Succession Planning</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../soliera.css">
  <link rel="stylesheet" href="../sidebar.css">
  <style>
    .icon-bg {
      background: #eff6ff;
      color: #2563eb;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 0.5rem;
      width: 2.5rem;
      height: 2.5rem;
      margin-right: 1rem;
    }
    html,
    body,
    #__next,
    .dashboard-root {
      height: 100%;
      min-height: 100dvh;
    }
    body {
      font-family: 'Inter', sans-serif;
      color: #000;
      background-color: #f9fafb;
    }
    .section-divider {
      border-top: 1px solid #e5e7eb;
      margin: 2rem 0;
    }
    .skill-tag {
      display: inline-flex;
      align-items: center;
      background-color: #f3f4f6;
      border-radius: 6px;
      padding: 6px 12px;
      margin: 4px;
      font-size: 0.875rem;
      gap: 4px;
    }
    .competency-bar {
      height: 8px;
      background-color: #e5e7eb;
      border-radius: 4px;
      margin: 8px 0;
      overflow: hidden;
    }
    .competency-fill {
      height: 100%;
      background-color: #3b82f6;
      border-radius: 4px;
      transition: width 1s ease-in-out;
    }
    .icon-container {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 24px;
      height: 24px;
      border-radius: 6px;
      margin-right: 8px;
    }
    .training-card {
      transition: all 0.3s ease;
    }
    .training-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    .opportunity-card {
      border-left: 4px solid #3b82f6;
    }
    .coming-soon {
      opacity: 0.8;
      filter: grayscale(0.2);
    }
    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
      }
    }
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
      gap: 1.5rem;
      margin-bottom: 2rem;
    }
    .stat-card {
      background: white;
      border-radius: 0.5rem;
      padding: 1.5rem;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }
    .successor-item {
      border-left: 4px solid #3b82f6;
      padding-left: 1rem;
      margin-bottom: 1rem;
    }
    .readiness-high {
      border-left-color: #10B981;
    }
    .readiness-medium {
      border-left-color: #F59E0B;
    }
    .readiness-low {
      border-left-color: #EF4444;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
      
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
          <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-8">
              <h1 class="text-3xl font-bold text-gray-900">Succession Planning</h1>
              <p class="text-gray-600 mt-2">Manage and track potential successors for key positions</p>
            </div>
            
            <!-- Stats Cards -->
            <div class="stats-grid">
              <div class="stat-card">
                <div class="flex items-center">
                  <div class="icon-bg bg-blue-100 text-blue-600">
                    <i data-lucide="users" class="w-6 h-6"></i>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Total Plans</p>
                    <h3 class="text-2xl font-bold text-gray-900">24</h3>
                  </div>
                </div>
              </div>
              
              <div class="stat-card">
                <div class="flex items-center">
                  <div class="icon-bg bg-green-100 text-green-600">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">High Readiness</p>
                    <h3 class="text-2xl font-bold text-gray-900">8</h3>
                  </div>
                </div>
              </div>
              
              <div class="stat-card">
                <div class="flex items-center">
                  <div class="icon-bg bg-yellow-100 text-yellow-600">
                    <i data-lucide="user-x" class="w-6 h-6"></i>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Needs Development</p>
                    <h3 class="text-2xl font-bold text-gray-900">12</h3>
                  </div>
                </div>
              </div>
              
              <div class="stat-card">
                <div class="flex items-center">
                  <div class="icon-bg bg-purple-100 text-purple-600">
                    <i data-lucide="calendar" class="w-6 h-6"></i>
                  </div>
                  <div>
                    <p class="text-sm font-medium text-gray-600">Updated This Month</p>
                    <h3 class="text-2xl font-bold text-gray-900">5</h3>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="flex flex-col lg:flex-row gap-8 main-container">
              <!-- Left Column - Succession Plans -->
              <div class="w-full lg:w-2/3 bg-white rounded-lg shadow-sm p-6 md:p-8">
                <div class="flex justify-between items-center mb-6">
                  <h2 class="text-xl font-bold text-gray-900">Succession Plans</h2>
                  <button class="btn btn-primary" onclick="document.getElementById('add-plan-modal').showModal()">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Add New Plan
                  </button>
                </div>
                
                <!-- Succession Plan List -->
                <div class="overflow-x-auto">
                  <table class="table table-zebra w-full">
                    <thead>
                      <tr>
                        <th>Employee</th>
                        <th>Position</th>
                        <th>Potential Successor</th>
                        <th>Readiness</th>
                        <th>Last Assessment</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Data will be populated from database -->
                      <?php
                     
                      // Fetch data from database
                      $sql = "SELECT * FROM succession_planning ORDER BY created_at DESC";
                      $result = $conn->query($sql);
                      
                      if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                          $readiness_class = '';
                          if ($row['readiness_level'] == 'High') $readiness_class = 'badge-success';
                          elseif ($row['readiness_level'] == 'Medium') $readiness_class = 'badge-warning';
                          else $readiness_class = 'badge-error';
                          
                          echo "<tr>
                            <td>
                              <div class='font-bold'>{$row['employee_name']}</div>
                              <div class='text-sm text-gray-500'>ID: {$row['employee_id']}</div>
                            </td>
                            <td>{$row['position']}</td>
                            <td>
                              <div class='font-bold'>{$row['potential_successor_name']}</div>
                              <div class='text-sm text-gray-500'>ID: {$row['potential_successor_id']}</div>
                            </td>
                            <td><span class='badge {$readiness_class}'>{$row['readiness_level']}</span></td>
                            <td>{$row['assessment_date']}</td>
                            <td>
                              <div class='flex space-x-2'>
                                <button class='btn btn-sm btn-outline btn-info' onclick='editPlan({$row['employee_id']})'>
                                  <i data-lucide='edit' class='w-4 h-4'></i>
                                </button>
                                <button class='btn btn-sm btn-outline btn-error' onclick='deletePlan({$row['employee_id']})'>
                                  <i data-lucide='trash' class='w-4 h-4'></i>
                                </button>
                              </div>
                            </td>
                          </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='6' class='text-center py-8 text-gray-500'>No succession plans found</td></tr>";
                      }
                      
                      $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              
              <!-- Right Column - Development Activities -->
              <div class="w-full lg:w-1/3">
                <!-- Development Plans Section -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                  <h2 class="text-xl font-bold text-black mb-6 flex items-center">
                    <i data-lucide="book-open" class="w-6 h-6 mr-2 text-blue-600"></i>
                    Development Activities
                  </h2>
                  
                  <div class="space-y-4">
                
                  </div>
                </div>
                
                <!-- Recent Assessments Section -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                  <h2 class="text-xl font-bold text-black mb-6 flex items-center">
                    <i data-lucide="calendar" class="w-6 h-6 mr-2 text-blue-600"></i>
                    Recent Assessments
                  </h2>
                  
                  <div class="space-y-4">
                
                
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
    </div>
  </div>

  <dialog id="add-plan-modal" class="modal">
  <div class="modal-box w-11/12 max-w-5xl">
    <h3 class="font-bold text-lg mb-6">Succession Plan Form</h3>

    <form id="succession-form" method="post" action="sub-modules/save_plan.php">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Employee Information -->
        <div>
          <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
            <i data-lucide="user" class="w-4 h-4 mr-2 text-blue-600"></i> Employee Information
          </h4>

          <div class="form-control mb-4">
            <label class="label"><span class="label-text">Employee ID</span></label>
            <input type="text" name="employee_id" class="input input-bordered" required>
          </div>

          <div class="form-control mb-4">
            <label class="label"><span class="label-text">Employee Name</span></label>
            <input type="text" name="employee_name" class="input input-bordered" required>
          </div>

          <div class="form-control mb-4">
            <label class="label"><span class="label-text">Position</span></label>
            <input type="text" name="position" class="input input-bordered" required>
          </div>
        </div>

        <!-- Successor Information -->
        <div>
          <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
            <i data-lucide="user-plus" class="w-4 h-4 mr-2 text-blue-600"></i> Successor Information
          </h4>

          <div class="form-control mb-4">
            <label class="label"><span class="label-text">Potential Successor ID</span></label>
            <input type="text" name="potential_successor_id" class="input input-bordered" required>
          </div>

          <div class="form-control mb-4">
            <label class="label"><span class="label-text">Potential Successor Name</span></label>
            <input type="text" name="potential_successor_name" class="input input-bordered" required>
          </div>

          <div class="form-control mb-4">
            <label class="label"><span class="label-text">Readiness Level</span></label>
            <select class="select select-bordered w-full" name="readiness_level" required>
              <option value="">Select readiness level</option>
              <option value="Ready Now">Ready Now</option>
              <option value="1-2 Years">1-2 Years</option>
              <option value="3-5 Years">3-5 Years</option>
              <option value="Not Ready">Not Ready</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Development Plan -->
      <div class="form-control mb-6">
        <label class="label"><span class="label-text">Development Plan</span></label>
        <textarea class="textarea textarea-bordered h-24" name="development_plan" placeholder="Detail the development plan for this successor"></textarea>
      </div>

      <!-- Assessment Date -->
      <div class="form-control mb-6 w-full max-w-xs">
        <label class="label"><span class="label-text">Assessment Date</span></label>
        <input type="date" name="assessment_date" class="input input-bordered" required>
      </div>

      <div class="modal-action">
        <button type="button" class="btn btn-ghost" onclick="document.getElementById('add-plan-modal').close()">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Plan</button>
      </div>
    </form>
  </div>
</dialog>

  <script>
   // Initialize Lucide icons
lucide.createIcons();

// Form submission handling
document.getElementById('succession-form').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch(form.action, {
    method: "POST",
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === "success") {
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: data.message,
        timer: 2000,
        showConfirmButton: false
      });

      setTimeout(function() {
        document.getElementById('add-plan-modal').close();
        location.reload(); // reload table/list after save
      }, 2000);
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: data.message
      });
    }
  })
  .catch(error => {
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: 'Something went wrong: ' + error
    });
  });
});

// Function to edit a plan (would fetch data and populate form)
function editPlan(employeeId) {
  // later you can call your backend to get employee data
  alert('Edit functionality would load plan data for employee ID: ' + employeeId);
  document.getElementById('add-plan-modal').showModal();
}

// Function to delete a plan
function deletePlan(employeeId) {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      // Example AJAX call for delete
      fetch("sub-modules/delete_plan.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "employee_id=" + encodeURIComponent(employeeId)
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          Swal.fire("Deleted!", data.message, "success");
          setTimeout(() => location.reload(), 1500);
        } else {
          Swal.fire("Error", data.message, "error");
        }
      })
      .catch(err => Swal.fire("Error", err, "error"));
    }
  });
}

  </script>
    <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>