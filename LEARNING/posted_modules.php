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

// Handle POST request to update module status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['module_id']) && isset($_POST['new_status'])) {
    $module_id = $_POST['module_id'];
    $new_status = $_POST['new_status'];
    $remarks = $_POST['remarks'] ?? '';
    
    $update_sql = "UPDATE learning_modules SET status = ?, remarks = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $new_status, $remarks, $module_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Module status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating module status']);
    }
    exit;
}

// Fetch only posted modules from database
$posted_modules = [];
$sql = "SELECT * FROM learning_modules WHERE status = 'posted' ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posted_modules[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Posted Modules</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <style>
    .module-card {
      transition: all 0.2s ease;
      border: 1px solid #e5e7eb;
      background: white;
    }
    
    .module-card:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .btn-plain {
      background-color: white;
      border: 1px solid #d1d5db;
      color: #374151;
      transition: all 0.2s ease;
    }
    
    .btn-plain:hover {
      background-color: #f9fafb;
      border-color: #9ca3af;
    }
    
    .status-posted {
      background-color: #dbeafe;
      color: #1e40af;
      border: 1px solid #93c5fd;
    }
    
    .badge-outline {
      background-color: white;
      border: 1px solid #d1d5db;
      color: #6b7280;
    }
    
    .empty-state {
      text-align: center;
      padding: 4rem 2rem;
      color: #6b7280;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      background: white;
    }
    
    .empty-state i {
      font-size: 4rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }
    
    .modal-box {
      border: 1px solid #e5e7eb;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .action-section {
      border-top: 1px solid #e5e7eb;
      padding-top: 1.5rem;
      margin-top: 1.5rem;
    }
    
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      flex-wrap: wrap;
    }
    
    .action-btn {
      flex: 1;
      min-width: 120px;
      border: 1px solid #d1d5db;
      background: white;
      padding: 0.75rem 1rem;
      border-radius: 0.375rem;
      cursor: pointer;
      transition: all 0.2s;
      text-align: center;
    }
    
    .action-btn:hover {
      background-color: #f9fafb;
      border-color: #9ca3af;
    }
    
    .action-btn.hold:hover {
      background-color: #f3f4f6;
      border-color: #6b7280;
    }
    
    .action-btn.unpost:hover {
      background-color: #fef2f2;
      border-color: #ef4444;
    }
    
    .content-preview {
      border: 1px solid #e5e7eb;
      border-radius: 0.375rem;
      padding: 1rem;
      background: #f9fafb;
      max-height: 300px;
      overflow-y: auto;
    }
    
    .filter-section {
      background-color: white;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      padding: 1rem;
    }
    
    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    
    .info-item {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }
    
    .info-label {
      font-size: 0.875rem;
      color: #6b7280;
      font-weight: 500;
    }
    
    .info-value {
      font-weight: 600;
      color: #1f2937;
    }
    
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 1.5rem;
    }
    
    .stat-card {
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      padding: 1.5rem;
      text-align: center;
    }
    
    .stat-number {
      font-size: 2rem;
      font-weight: bold;
      color: #1f2937;
      margin-bottom: 0.25rem;
    }
    
    .stat-label {
      font-size: 0.875rem;
      color: #6b7280;
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
          <!-- Posted Modules Section -->
          <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
              <div>
                <h1 class="text-3xl font-bold mb-2 text-gray-800">Posted Learning Modules</h1>
                <p class="text-gray-600">All currently active and posted learning materials available to employees</p>
              </div>
              <div class="flex gap-2">
                <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='learning_module_repository.php'">
                  <i class="fas fa-arrow-left mr-2"></i>Back to Repository
                </button>
                <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='review_dashboard.php'">
                  <i class="fas fa-eye mr-2"></i>Review Page
                </button>
              </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-grid mb-6">
              <div class="stat-card">
                <div class="stat-number"><?php echo count($posted_modules); ?></div>
                <div class="stat-label">Total Posted Modules</div>
              </div>
              <div class="stat-card">
                <div class="stat-number">
                  <?php 
                    $current_month = date('Y-m');
                    $monthly_count = 0;
                    foreach ($posted_modules as $module) {
                      if (date('Y-m', strtotime($module['created_at'])) === $current_month) {
                        $monthly_count++;
                      }
                    }
                    echo $monthly_count;
                  ?>
                </div>
                <div class="stat-label">Posted This Month</div>
              </div>
              <div class="stat-card">
                <div class="stat-number">
                  <?php
                    $departments = [];
                    foreach ($posted_modules as $module) {
                      if (!in_array($module['department'], $departments)) {
                        $departments[] = $module['department'];
                      }
                    }
                    echo count($departments);
                  ?>
                </div>
                <div class="stat-label">Active Departments</div>
              </div>
              <div class="stat-card">
                <div class="stat-number">
                  <?php 
                    if (!empty($posted_modules)) {
                      echo date('M j', strtotime($posted_modules[0]['created_at']));
                    } else {
                      echo 'N/A';
                    }
                  ?>
                </div>
                <div class="stat-label">Latest Post</div>
              </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section mb-6">
              <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Filter by Department
                  </label>
                  <div class="flex flex-col sm:flex-row gap-3">
                    <select class="select select-bordered w-full sm:w-64" id="departmentFilter">
                      <option value="all">All Departments</option>
                      <?php
                      $departments = array_unique(array_column($posted_modules, 'department'));
                      foreach ($departments as $dept) {
                          $display_name = ucwords(str_replace('-', ' ', $dept));
                          echo "<option value='$dept'>$display_name</option>";
                      }
                      ?>
                    </select>
                    
                    <div class="flex gap-2">
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="applyFilters()">
                        Apply Filter
                      </button>
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="clearFilters()">
                        Clear
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Posted Modules Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <?php if (empty($posted_modules)): ?>
                <div class="col-span-full empty-state">
                  <i class="fas fa-file-alt"></i>
                  <h3 class="text-xl font-semibold mb-2 text-gray-700">No Posted Modules</h3>
                  <p class="text-gray-500 mb-4">
                    There are no learning modules currently posted. Modules need to be approved and posted before they become available to employees.
                  </p>
                  <div class="flex gap-2 justify-center">
                    <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='learning_module_repository.php'">
                      <i class="fas fa-plus mr-2"></i>Create New Module
                    </button>
                    <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='review_dashboard.php'">
                      <i class="fas fa-eye mr-2"></i>Review Pending Modules
                    </button>
                  </div>
                </div>
              <?php else: ?>
                <?php foreach ($posted_modules as $module): ?>
                  <div class="module-card rounded-lg p-6" data-department="<?php echo $module['department']; ?>" data-id="<?php echo $module['id']; ?>">
                    <div class="flex justify-between items-start mb-4">
                      <h3 class="font-semibold text-lg text-gray-800"><?php echo htmlspecialchars($module['title']); ?></h3>
                      <span class="status-posted text-xs px-2 py-1 rounded-full">Posted</span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 my-3">
                      <span class="badge-outline text-xs px-2 py-1 rounded"><?php echo ucfirst(str_replace('-', ' ', $module['department'])); ?></span>
                      <span class="badge-outline text-xs px-2 py-1 rounded"><?php echo htmlspecialchars($module['roles']); ?></span>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Date Posted:</span> 
                        <?php echo date('Y-m-d', strtotime($module['created_at'])); ?>
                      </p>
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Topic:</span> 
                        <?php echo htmlspecialchars($module['topic']); ?>
                      </p>
                      <?php if (!empty($module['remarks'])): ?>
                        <p class="text-sm text-gray-600">
                          <span class="font-medium">Notes:</span> 
                          <?php echo htmlspecialchars($module['remarks']); ?>
                        </p>
                      <?php endif; ?>
                    </div>
                    
                    <div class="mt-4 flex gap-2">
                      <button class="btn-plain flex-1 py-2 rounded-lg text-sm" 
                              onclick="viewModule(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>', '<?php echo htmlspecialchars($module['department']); ?>', '<?php echo htmlspecialchars($module['roles']); ?>', '<?php echo htmlspecialchars($module['topic']); ?>', `<?php echo addslashes($module['content']); ?>`)">
                        <i class="fas fa-eye mr-2"></i>View
                      </button>
                      <button class="btn-plain flex-1 py-2 rounded-lg text-sm border-red-200 text-red-700 hover:bg-red-50" 
                              onclick="unpostModule(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>')">
                        <i class="fas fa-times mr-2"></i>Unpost
                      </button>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
    </div>
  </div>

  <!-- View Posted Module Modal -->
  <dialog id="view_posted_modal" class="modal">
    <div class="modal-box max-w-6xl p-0">
      <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
          <h3 class="font-bold text-lg text-gray-800" id="posted_title">Module Title</h3>
          <button class="btn-plain w-8 h-8 rounded-full flex items-center justify-center" onclick="view_posted_modal.close()">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      
      <div class="p-6 max-h-[70vh] overflow-y-auto">
        <!-- Module Info -->
        <div class="info-grid">
          <div class="info-item">
            <span class="info-label">Department</span>
            <span class="info-value" id="posted_department">Department</span>
          </div>
          <div class="info-item">
            <span class="info-label">Roles</span>
            <span class="info-value" id="posted_roles">Roles</span>
          </div>
          <div class="info-item">
            <span class="info-label">Topic</span>
            <span class="info-value" id="posted_topic">Topic</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status</span>
            <span class="info-value" id="posted_status">Posted</span>
          </div>
        </div>
        
        <!-- Content Preview -->
        <div class="mb-6">
          <p class="text-sm text-gray-500 mb-2">Module Content</p>
          <div class="content-preview" id="posted_content">
            <!-- Content will be inserted here -->
          </div>
        </div>
        
        <!-- Action Section -->
        <div class="action-section">
          <p class="text-sm text-gray-500 mb-3">Module Actions</p>
          <div class="action-buttons">
            <button class="action-btn hold" onclick="holdModule()">
              <i class="fas fa-pause mr-2"></i>Put on Hold
            </button>
            <button class="action-btn unpost" onclick="unpostCurrentModule()">
              <i class="fas fa-times mr-2"></i>Unpost Module
            </button>
            <button class="action-btn" onclick="downloadModule()">
              <i class="fas fa-download mr-2"></i>Download
            </button>
          </div>
        </div>
      </div>
    </div>
  </dialog>

  <!-- Unpost Confirmation Modal -->
  <dialog id="unpost_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Unpost Module</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Are you sure you want to unpost <span id="unpost_module_name" class="font-semibold">this module</span>?</p>
        <p class="text-sm text-gray-500 mb-4">This will make the module unavailable to employees and change its status back to "Approved".</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Reason for Unposting (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24 border-gray-300" id="unpost_reason" placeholder="Enter reason for unposting..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="unpost_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-red-200 text-red-700 hover:bg-red-50" onclick="confirmUnpost()">Unpost Module</button>
      </div>
    </div>
  </dialog>

  <!-- Hold Confirmation Modal -->
  <dialog id="hold_posted_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Put Module on Hold</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Are you sure you want to put <span id="hold_posted_name" class="font-semibold">this module</span> on hold?</p>
        <p class="text-sm text-gray-500 mb-4">This will make the module unavailable to employees and change its status to "Hold".</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Reason for Hold (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24 border-gray-300" id="hold_posted_reason" placeholder="Enter reason for placing on hold..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="hold_posted_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-gray-300 text-gray-700 hover:bg-gray-50" onclick="confirmHoldPosted()">Put on Hold</button>
      </div>
    </div>
  </dialog>

  <script>
    // Module Action Functions
    let currentModuleId = '';
    let currentModuleName = '';
    let currentModuleDepartment = '';
    let currentModuleRoles = '';
    let currentModuleTopic = '';
    let currentModuleContent = '';
    
    function viewModule(moduleId, moduleName, department, roles, topic, content) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      currentModuleDepartment = department;
      currentModuleRoles = roles;
      currentModuleTopic = topic;
      currentModuleContent = content;
      
      document.getElementById('posted_title').textContent = moduleName;
      document.getElementById('posted_department').textContent = department.replace('-', ' ');
      document.getElementById('posted_roles').textContent = roles;
      document.getElementById('posted_topic').textContent = topic;
      document.getElementById('posted_content').innerHTML = content;
      
      view_posted_modal.showModal();
    }
    
    function unpostModule(moduleId, moduleName) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      
      document.getElementById('unpost_module_name').textContent = moduleName;
      document.getElementById('unpost_reason').value = '';
      unpost_modal.showModal();
    }
    
    function unpostCurrentModule() {
      view_posted_modal.close();
      unpostModule(currentModuleId, currentModuleName);
    }
    
    function confirmUnpost() {
      const reason = document.getElementById('unpost_reason').value;
      updateModuleStatus(currentModuleId, 'approved', `Module "${currentModuleName}" has been unposted.`, reason)
        .then(result => {
          if (result.success) {
            alert(`Module "${currentModuleName}" has been unposted successfully!`);
            unpost_modal.close();
            // Reload the page to reflect changes
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          } else {
            alert('Error: ' + result.message);
          }
        });
    }
    
    function holdModule() {
      document.getElementById('hold_posted_name').textContent = currentModuleName;
      document.getElementById('hold_posted_reason').value = '';
      view_posted_modal.close();
      hold_posted_modal.showModal();
    }
    
    function confirmHoldPosted() {
      const reason = document.getElementById('hold_posted_reason').value;
      updateModuleStatus(currentModuleId, 'hold', `Module "${currentModuleName}" has been placed on hold.`, reason)
        .then(result => {
          if (result.success) {
            alert(`Module "${currentModuleName}" has been placed on hold!`);
            hold_posted_modal.close();
            // Reload the page to reflect changes
            setTimeout(() => {
              window.location.reload();
            }, 1000);
          } else {
            alert('Error: ' + result.message);
          }
        });
    }
    
    function downloadModule() {
      alert('Download functionality for: ' + currentModuleName);
      // Implement download logic here
    }
    
    // Filter Functions
    function applyFilters() {
      const departmentFilter = document.getElementById('departmentFilter');
      const selectedDepartment = departmentFilter.value;
      
      const moduleCards = document.querySelectorAll('.module-card');
      moduleCards.forEach(card => {
        const cardDepartment = card.getAttribute('data-department');
        
        if (selectedDepartment === 'all' || cardDepartment === selectedDepartment) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    }
    
    function clearFilters() {
      document.getElementById('departmentFilter').value = 'all';
      applyFilters();
    }
    
    // AJAX function to update module status
    function updateModuleStatus(moduleId, newStatus, successMessage, remarks = '') {
      // Create form data
      const formData = new FormData();
      formData.append('module_id', moduleId);
      formData.append('new_status', newStatus);
      formData.append('remarks', remarks);
      
      // Send AJAX request
      return fetch('posted_modules.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          return { success: true, message: data.message };
        } else {
          return { success: false, message: data.message };
        }
      })
      .catch(error => {
        console.error('Error:', error);
        return { success: false, message: 'Error updating module status. Please try again.' };
      });
    }

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
      console.log('Posted Modules page initialized');
    });
  </script>
  
  <script src="../JS/soliera.js"></script>
  <script src="../JS/sidebar.js"></script>
</body>
</html>