<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hr2_soliera_usm";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only pending learning modules from database
$pending_modules = [];
$sql = "SELECT * FROM learning_modules WHERE status = 'pending' ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pending_modules[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Learning Module Review</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .centered-hero {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh;
    }
    .module-card {
      transition: all 0.2s ease;
    }
    .module-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    /* Custom button styles */
    .btn-custom {
      background-color: white;
      border: 1px solid #d1d5db;
      color: #374151;
      transition: all 0.2s ease;
    }
    
    .btn-custom:hover {
      background-color: #f9fafb;
      border-color: #9ca3af;
    }
    
    .btn-custom:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }
    
    /* Status badges */
    .status-pending {
      background-color: #f59e0b;
      color: white;
    }
    
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: #6b7280;
    }
    
    .empty-state i {
      font-size: 4rem;
      margin-bottom: 1rem;
      opacity: 0.5;
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
        
        <!-- Main Content -->
        <div class="container mx-auto px-4 py-8">
          <!-- Review Section -->
          <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
              <div>
                <h1 class="text-3xl font-bold mb-2">Learning Module Review</h1>
                <p class="text-gray-600">Review and approve pending learning modules</p>
              </div>
              <div class="flex gap-2">
                <div class="stat">
                  <div class="stat-title">Pending Modules</div>
                  <div class="stat-value"><?php echo count($pending_modules); ?></div>
                  <div class="stat-desc">Awaiting review</div>
                </div>
                <button class="btn btn-custom" onclick="window.location.href='learning_module_repository.php'">
                  <i class="fas fa-arrow-left mr-2"></i>Back to Repository
                </button>
              </div>
            </div>
            
            <!-- Module Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <?php if (empty($pending_modules)): ?>
                <div class="col-span-full empty-state">
                  <i class="fas fa-file-alt"></i>
                  <h3 class="text-xl font-semibold mb-2">No Pending Modules</h3>
                  <p class="text-gray-500 mb-4">There are no learning modules awaiting review at this time.</p>
                  <button class="btn btn-custom" onclick="window.location.href='learning_module_repository.php'">
                    <i class="fas fa-plus mr-2"></i>Create New Module
                  </button>
                </div>
              <?php else: ?>
                <?php foreach ($pending_modules as $module): ?>
                  <div class="card bg-base-100 shadow-md module-card">
                    <div class="card-body">
                      <div class="flex justify-between items-start">
                        <h3 class="card-title"><?php echo htmlspecialchars($module['title']); ?></h3>
                        <div class="badge status-pending">Pending</div>
                      </div>
                      <div class="flex flex-wrap gap-2 my-2">
                        <div class="badge badge-outline"><?php echo ucfirst(str_replace('-', ' ', $module['department'])); ?></div>
                        <div class="badge badge-outline"><?php echo htmlspecialchars($module['roles']); ?></div>
                      </div>
                      <p class="text-sm text-gray-500">Date Added: <?php echo date('Y-m-d', strtotime($module['created_at'])); ?></p>
                      <p class="text-sm text-gray-500">Topic: <?php echo htmlspecialchars($module['topic']); ?></p>
                      <div class="card-actions justify-end mt-4">
                        <button class="btn btn-sm btn-custom" onclick="viewDocument(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>', '<?php echo htmlspecialchars($module['department']); ?>', '<?php echo htmlspecialchars($module['roles']); ?>', '<?php echo htmlspecialchars($module['topic']); ?>', '<?php echo htmlspecialchars($module['content']); ?>')">
                          View Document
                        </button>
                        <button class="btn btn-sm btn-success" onclick="approveModule(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>')">
                          Approve
                        </button>
                        <button class="btn btn-sm btn-error" onclick="rejectModule(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>')">
                          Reject
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="forCompliance(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>')">
                          For Compliance
                        </button>
                        <button class="btn btn-sm btn-custom" onclick="holdModule(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>')">
                          Hold
                        </button>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
    </div>
  </div>

  <!-- MODALS -->

  <!-- View Document Modal -->
  <dialog id="view_document_modal" class="modal modal-middle">
    <div class="modal-box max-w-6xl">
      <h3 class="font-bold text-lg" id="document_title">Module Title</h3>
      <div class="py-4">
        <div class="flex flex-wrap gap-2 mb-4">
          <div class="badge badge-primary" id="document_department">Department</div>
          <div class="badge badge-outline" id="document_roles">Roles</div>
          <div class="badge status-pending">Pending</div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <p class="text-sm text-gray-500">Topic</p>
            <p class="font-medium" id="document_topic">Topic</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Status</p>
            <p class="font-medium">Pending Review</p>
          </div>
        </div>
        
        <div class="mb-4">
          <p class="text-sm text-gray-500">Module Content</p>
          <div class="bg-base-100 p-4 rounded-lg border border-gray-200 mt-2">
            <div id="document_content" class="prose max-w-none">
              <!-- Content will be inserted here -->
            </div>
          </div>
        </div>
        
        <div class="card bg-base-200">
          <div class="card-body">
            <h4 class="card-title">Module Details</h4>
            <div class="flex items-center justify-center h-32 bg-base-300 rounded-lg">
              <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2" id="document_filename">learning_module.pdf</p>
                <p class="text-sm text-gray-500">Ready for Review</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Close</button>
        </form>
        <button class="btn btn-custom" onclick="downloadDocument()">Download</button>
      </div>
    </div>
  </dialog>

  <!-- Reject Modal -->
  <dialog id="reject_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg">Reject Module</h3>
      <div class="py-4">
        <p class="mb-4">Are you sure you want to reject <span id="reject_module_name" class="font-semibold">this module</span>?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Reason for Rejection (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24" id="reject_reason" placeholder="Enter reason for rejection..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Cancel</button>
        </form>
        <button class="btn btn-error" onclick="confirmReject()">Reject Module</button>
      </div>
    </div>
  </dialog>

  <!-- For Compliance Modal -->
  <dialog id="compliance_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg">Mark for Compliance</h3>
      <div class="py-4">
        <p class="mb-4">Mark <span id="compliance_module_name" class="font-semibold">this module</span> for compliance updates?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Compliance Requirements</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-32" id="compliance_requirements" placeholder="Specify compliance requirements..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Cancel</button>
        </form>
        <button class="btn btn-warning" onclick="confirmCompliance()">Mark for Compliance</button>
      </div>
    </div>
  </dialog>

  <!-- Hold Modal -->
  <dialog id="hold_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg">Hold Module</h3>
      <div class="py-4">
        <p class="mb-4">Place <span id="hold_module_name" class="font-semibold">this module</span> on hold?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Reason for Hold (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24" id="hold_reason" placeholder="Enter reason for placing on hold..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Cancel</button>
        </form>
        <button class="btn btn-custom" onclick="confirmHold()">Place on Hold</button>
      </div>
    </div>
  </dialog>

  <script>
    // Module Action Functions
    let currentModuleId = '';
    let currentModuleName = '';
    
    function viewDocument(moduleId, moduleName, department, roles, topic, content) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      
      document.getElementById('document_title').textContent = moduleName;
      document.getElementById('document_department').textContent = department.replace('-', ' ');
      document.getElementById('document_roles').textContent = roles;
      document.getElementById('document_topic').textContent = topic;
      document.getElementById('document_content').innerHTML = content;
      document.getElementById('document_filename').textContent = moduleName.toLowerCase().replace(/ /g, '_') + '.pdf';
      
      view_document_modal.showModal();
    }
    
    function approveModule(moduleId, moduleName) {
      if (confirm(`Approve "${moduleName}"? This module will be ready for posting.`)) {
        // AJAX call to update status
        updateModuleStatus(moduleId, 'approved', `Module "${moduleName}" has been approved.`);
      }
    }
    
    function rejectModule(moduleId, moduleName) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      document.getElementById('reject_module_name').textContent = moduleName;
      document.getElementById('reject_reason').value = '';
      reject_modal.showModal();
    }
    
    function confirmReject() {
      const reason = document.getElementById('reject_reason').value;
      updateModuleStatus(currentModuleId, 'rejected', `Module "${currentModuleName}" has been rejected.`, reason);
      reject_modal.close();
    }
    
    function forCompliance(moduleId, moduleName) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      document.getElementById('compliance_module_name').textContent = moduleName;
      document.getElementById('compliance_requirements').value = '';
      compliance_modal.showModal();
    }
    
    function confirmCompliance() {
      const requirements = document.getElementById('compliance_requirements').value;
      updateModuleStatus(currentModuleId, 'compliance', `Module "${currentModuleName}" has been marked for compliance.`, requirements);
      compliance_modal.close();
    }
    
    function holdModule(moduleId, moduleName) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      document.getElementById('hold_module_name').textContent = moduleName;
      document.getElementById('hold_reason').value = '';
      hold_modal.showModal();
    }
    
    function confirmHold() {
      const reason = document.getElementById('hold_reason').value;
      updateModuleStatus(currentModuleId, 'hold', `Module "${currentModuleName}" has been placed on hold.`, reason);
      hold_modal.close();
    }
    
    function downloadDocument() {
      alert(`Downloading ${currentModuleName}...`);
      // In a real application, this would trigger a file download
    }
    
    // AJAX function to update module status
    function updateModuleStatus(moduleId, newStatus, successMessage, remarks = '') {
      // Create form data
      const formData = new FormData();
      formData.append('module_id', moduleId);
      formData.append('new_status', newStatus);
      formData.append('remarks', remarks);
      
      // Send AJAX request
      fetch('update_module_status.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(successMessage);
          // Reload the page to reflect changes
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          alert('Error updating module: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error updating module status. Please try again.');
      });
    }
  </script>
  
  <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>