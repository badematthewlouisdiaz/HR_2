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

// Fetch learning modules from database
$modules = [];
$sql = "SELECT * FROM learning_modules ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $modules[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Learning Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <link rel="stylesheet" href="../CSS/learning_module_repository.css">
  <style>
    /* Custom styles for border-only buttons */
    .btn-border {
      background-color: transparent;
      border: 1px solid #d1d5db;
      color: #374151;
      transition: all 0.2s ease-in-out;
    }
    
    .btn-border:hover {
      background-color: #f9fafb;
      border-color: #9ca3af;
    }
    
    .btn-border:focus {
      outline: none;
      box-shadow: 0 0 0 2px rgba(156, 163, 175, 0.2);
    }
    
    .btn-sm-border {
      background-color: transparent;
      border: 1px solid #d1d5db;
      color: #374151;
      padding: 0.375rem 0.75rem;
      font-size: 0.875rem;
      border-radius: 0.375rem;
      transition: all 0.2s ease-in-out;
    }
    
    .btn-sm-border:hover {
      background-color: #f9fafb;
      border-color: #9ca3af;
    }
    
    /* Status badge styles */
    .status-approved {
      background-color: #d1fae5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }
    
    .status-rejected {
      background-color: #fee2e2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }
    
    .status-compliance {
      background-color: #fef3c7;
      color: #92400e;
      border: 1px solid #fde68a;
    }
    
    .status-pending {
      background-color: #e0e7ff;
      color: #3730a3;
      border: 1px solid #c7d2fe;
    }
    
    .status-hold {
      background-color: #f3f4f6;
      color: #374151;
      border: 1px solid #d1d5db;
    }
    
    .status-posted {
      background-color: #dbeafe;
      color: #1e40af;
      border: 1px solid #93c5fd;
    }
    
    /* Modal styles */
    .modal-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }
    
    .info-section {
      background-color: #f8fafc;
      padding: 1.5rem;
      border-radius: 0.5rem;
      border: 1px solid #e2e8f0;
    }
    
    .info-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.75rem;
      padding-bottom: 0.75rem;
      border-bottom: 1px solid #e2e8f0;
    }
    
    .info-label {
      font-weight: 600;
      color: #4b5563;
    }
    
    .info-value {
      color: #1f2937;
    }
    
    .document-section {
      background-color: #f8fafc;
      padding: 1.5rem;
      border-radius: 0.5rem;
      border: 1px solid #e2e8f0;
      margin-top: 1.5rem;
    }
    
    .document-preview {
      height: 300px;
      overflow-y: auto;
      background-color: white;
      border: 1px solid #e2e8f0;
      border-radius: 0.375rem;
      padding: 1rem;
    }
    
    .reason-section {
      background-color: #fef3c7;
      padding: 1rem;
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
      border: 1px solid #fde68a;
    }
    
    .reason-title {
      font-weight: 600;
      color: #92400e;
      margin-bottom: 0.5rem;
    }
    
    .reason-text {
      color: #92400e;
    }
    
    .drop-zone {
      border: 2px dashed #d1d5db;
      border-radius: 0.5rem;
      transition: all 0.3s ease;
    }
    
    .drop-zone.active {
      border-color: #3b82f6;
      background-color: #eff6ff;
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
          <!-- Learning Modules Section -->
          <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
              <div>
                <h1 class="text-3xl font-bold mb-2">Learning Modules Repository</h1>
                <p class="text-gray-600">Manage and organize all learning materials for your organization</p>
              </div>
              <div class="flex gap-2">
                <button class="btn btn-border" onclick="window.location.href='review_dashboard.php'">
                  <i class="fas fa-eye mr-2"></i>Review Page
                </button>
                <button class="btn btn-border" onclick="upload_modal.showModal()">
                  <i class="fas fa-plus mr-2"></i>Upload Module
                </button>
                <button class="btn btn-border" onclick="window.location.href='employee_progress.php'">
                  <i class="fas fa-chart-line mr-2"></i>Employee Progress
                </button>
                <button class="btn btn-border" onclick="window.location.href='posted_modules.php'">
                  <i class="fas fa-list-check mr-2"></i>Posted Modules
                </button>
              </div>
            </div>
            
            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
              <div class="flex flex-wrap gap-4">
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium">Status</span>
                  </label>
                  <select class="select select-bordered w-40" id="statusFilter">
                    <option value="all">All Status</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="compliance">For Compliance</option>
                    <option value="pending">Pending</option>
                    <option value="hold">Hold</option>
                    <option value="posted">Posted</option>
                  </select>
                </div>
                
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium">Department</span>
                  </label>
                  <select class="select select-bordered w-48" id="departmentFilter">
                    <option value="all">All Departments</option>
                    <option value="human-resources">Human Resources</option>
                    <option value="operations">Operations</option>
                    <option value="information-technology">Information Technology</option>
                    <option value="front-office">Front Office</option>
                    <option value="kitchen">Kitchen</option>
                    <option value="sales-marketing">Sales & Marketing</option>
                  </select>
                </div>
                
                <div class="form-control self-end">
                  <button class="btn btn-border" onclick="applyFilters()">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                  </button>
                </div>
                
                <div class="form-control self-end">
                  <button class="btn btn-border" onclick="clearFilters()">
                    <i class="fas fa-times mr-2"></i>Clear
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Module Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="moduleCards">
                <?php if (empty($modules)): ?>
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">No learning modules found. Create your first module!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($modules as $module): ?>
                        <div class="card bg-base-100 shadow-md module-card" data-status="<?php echo $module['status']; ?>" data-department="<?php echo $module['department']; ?>" data-id="<?php echo $module['id']; ?>">
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <h3 class="card-title"><?php echo htmlspecialchars($module['title']); ?></h3>
                                    <div class="badge status-<?php echo $module['status']; ?>" id="status-badge-<?php echo $module['id']; ?>">
                                        <?php echo ucfirst($module['status']); ?>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 my-2">
                                    <div class="badge badge-outline"><?php echo ucfirst(str_replace('-', ' ', $module['department'])); ?></div>
                                    <div class="badge badge-outline"><?php echo htmlspecialchars($module['roles']); ?></div>
                                </div>
                                <p class="text-sm text-gray-500">Date Added: <?php echo date('Y-m-d', strtotime($module['created_at'])); ?></p>
                                <p class="text-sm text-gray-500">Topic: <?php echo htmlspecialchars($module['topic']); ?></p>
                                <div class="card-actions justify-end mt-4">
                                    <button class="btn-sm-border" onclick="viewModule(<?php echo $module['id']; ?>)">View</button>
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

  <!-- Upload Module Modal -->
  <dialog id="upload_modal" class="modal modal-middle">
    <div class="modal-box max-w-4xl">
      <h3 class="font-bold text-lg mb-6">Upload Learning Module</h3>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left: Drag and Drop & File Info -->
        <div>
          <h4 class="text-lg font-medium mb-4">Upload File</h4>
          <div id="dropZone" class="drop-zone p-8 text-center cursor-pointer mb-4">
            <div class="flex flex-col items-center justify-center gap-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
              <p class="text-lg">Drag and drop files here</p>
              <p class="text-sm text-gray-500">Supports PDF, DOCX, PPT, and more</p>
              <button class="btn btn-border mt-2">Browse Files</button>
            </div>
          </div>
          
          <div class="mt-4">
            <div class="text-sm text-gray-500 mb-2">Uploaded files:</div>
            <div class="space-y-2" id="fileList">
              <!-- Files will be listed here -->
            </div>
          </div>
        </div>
        
        <!-- Right: Module Details Form -->
        <div>
          <h4 class="text-lg font-medium mb-4">Module Details</h4>
          <form class="space-y-4" id="uploadForm">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Title</span>
              </label>
              <input type="text" name="title" class="input input-bordered" placeholder="Enter module title" required>
            </div>
            
            <div class="form-control">
              <label class="label">
                <span class="label-text">Department</span>
              </label>
              <select class="select select-bordered" id="departmentSelect" name="department" required>
                <option disabled selected>Select Department</option>
                <option value="front-office">Front Office / Reception</option>
                <option value="housekeeping">Housekeeping</option>
                <option value="food-beverage">Food & Beverage (F&B)</option>
                <option value="kitchen">Kitchen / Culinary</option>
                <option value="sales-marketing">Sales & Marketing</option>
                <option value="hr">Human Resources (HR)</option>
                <option value="finance">Finance / Accounting</option>
                <option value="engineering">Engineering / Maintenance</option>
                <option value="security">Security</option>
              </select>
            </div>
            
            <div class="form-control">
              <label class="label">
                <span class="label-text">Role</span>
              </label>
              <select class="select select-bordered" id="roleSelect" name="role" disabled required>
                <option disabled selected>Select Department First</option>
              </select>
            </div>
            
            <div class="form-control">
              <label class="label">
                <span class="label-text">Topic</span>
              </label>
              <input type="text" name="topic" class="input input-bordered" placeholder="Enter topic" required>
            </div>
          </form>
        </div>
      </div>
      
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-border">Cancel</button>
        </form>
        <button class="btn btn-primary" onclick="startModuleCreation()">
          <i class="fas fa-play mr-2"></i>Start Module
        </button>
      </div>
    </div>
  </dialog>

  <!-- PENDING MODULE MODAL -->
  <dialog id="pending_module_modal" class="modal">
    <div class="modal-box max-w-5xl">
      <h3 class="font-bold text-lg mb-4" id="pending-title">Module Title</h3>
      
      <div class="modal-grid">
        <!-- Info Section -->
        <div class="info-section">
          <h4 class="font-semibold text-lg mb-4">Info</h4>
          <div class="info-item">
            <span class="info-label">Title:</span>
            <span class="info-value" id="pending-exam-title">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Topic:</span>
            <span class="info-value" id="pending-topic">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Department:</span>
            <span class="info-value" id="pending-department">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Role:</span>
            <span class="info-value" id="pending-role">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="info-value" id="pending-status">Pending</span>
          </div>
          <div class="info-item">
            <span class="info-label">Date Created:</span>
            <span class="info-value" id="pending-date">-</span>
          </div>
        </div>
        
        <!-- Document Section -->
        <div>
          <div class="document-section">
            <h4 class="font-semibold text-lg mb-4">DOCUMENT PREVIEW</h4>
            <div class="document-preview" id="pending-document-preview">
              <!-- Document content will be displayed here -->
            </div>
            <div class="mt-4 flex gap-2">
              <button class="btn btn-border flex-1" id="pending-view-full-content">View Full Content</button>
              <button class="btn btn-border flex-1" id="pending-view-document">View Document</button>
            </div>
          </div>
          
          <!-- CRUD Actions -->
          <div class="mt-4 flex gap-2">
            <button class="btn btn-border flex-1" id="pending-review-btn">Review</button>
            <button class="btn btn-border flex-1" id="pending-edit-btn">Edit</button>
            <button class="btn btn-border flex-1" id="pending-cancel-btn">Cancel</button>
            <button class="btn btn-border flex-1" id="pending-hold-btn">Hold</button>
          </div>
        </div>
      </div>
      
      <div class="modal-action mt-6">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- APPROVED MODULE MODAL -->
  <dialog id="approved_module_modal" class="modal">
    <div class="modal-box max-w-5xl">
      <h3 class="font-bold text-lg mb-4" id="approved-title">Module Title</h3>
      
      <div class="modal-grid">
        <!-- Info Section -->
        <div class="info-section">
          <h4 class="font-semibold text-lg mb-4">Info</h4>
          <div class="info-item">
            <span class="info-label">Title:</span>
            <span class="info-value" id="approved-exam-title">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Topic:</span>
            <span class="info-value" id="approved-topic">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Department:</span>
            <span class="info-value" id="approved-department">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Role:</span>
            <span class="info-value" id="approved-role">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="info-value" id="approved-status">Approved</span>
          </div>
          <div class="info-item">
            <span class="info-label">Date Created:</span>
            <span class="info-value" id="approved-date">-</span>
          </div>
        </div>
        
        <!-- Document Section -->
        <div>
          <div class="document-section">
            <h4 class="font-semibold text-lg mb-4">DOCUMENT PREVIEW</h4>
            <div class="document-preview" id="approved-document-preview">
              <!-- Document content will be displayed here -->
            </div>
            <div class="mt-4 flex gap-2">
              <button class="btn btn-border flex-1" id="approved-view-full-content">View Full Content</button>
              <button class="btn btn-border flex-1" id="approved-view-document">View Document</button>
            </div>
          </div>
          
          <!-- CRUD Actions -->
          <div class="mt-4 flex gap-2">
            <button class="btn btn-border flex-1" id="approved-post-btn">Post</button>
            <button class="btn btn-border flex-1" id="approved-hold-btn">Hold</button>
            <button class="btn btn-border flex-1" id="approved-download-btn">Download</button>
            <button class="btn btn-border flex-1" id="approved-convert-btn">Convert</button>
          </div>
        </div>
      </div>
      
      <div class="modal-action mt-6">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- REJECTED MODULE MODAL -->
  <dialog id="rejected_module_modal" class="modal">
    <div class="modal-box max-w-5xl">
      <h3 class="font-bold text-lg mb-4" id="rejected-title">Module Title</h3>
      
      <!-- Reason Section -->
      <div class="reason-section">
        <div class="reason-title">Reason for Rejection</div>
        <div class="reason-text" id="rejected-reason">This module was rejected due to incomplete content and outdated information.</div>
      </div>
      
      <div class="modal-grid">
        <!-- Info Section -->
        <div class="info-section">
          <h4 class="font-semibold text-lg mb-4">Info</h4>
          <div class="info-item">
            <span class="info-label">Title:</span>
            <span class="info-value" id="rejected-exam-title">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Topic:</span>
            <span class="info-value" id="rejected-topic">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Department:</span>
            <span class="info-value" id="rejected-department">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Role:</span>
            <span class="info-value" id="rejected-role">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="info-value" id="rejected-status">Rejected</span>
          </div>
          <div class="info-item">
            <span class="info-label">Date Created:</span>
            <span class="info-value" id="rejected-date">-</span>
          </div>
        </div>
        
        <!-- Document Section -->
        <div>
          <div class="document-section">
            <h4 class="font-semibold text-lg mb-4">DOCUMENT PREVIEW</h4>
            <div class="document-preview" id="rejected-document-preview">
              <!-- Document content will be displayed here -->
            </div>
            <div class="mt-4 flex gap-2">
              <button class="btn btn-border flex-1" id="rejected-view-full-content">View Full Content</button>
              <button class="btn btn-border flex-1" id="rejected-view-document">View Document</button>
            </div>
          </div>
          
          <!-- CRUD Actions -->
          <div class="mt-4">
            <button class="btn btn-border w-full" id="rejected-delete-btn">Delete</button>
          </div>
        </div>
      </div>
      
      <div class="modal-action mt-6">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- HOLD MODULE MODAL -->
  <dialog id="hold_module_modal" class="modal">
    <div class="modal-box max-w-5xl">
      <h3 class="font-bold text-lg mb-4" id="hold-title">Module Title</h3>
      
      <div class="modal-grid">
        <!-- Info Section -->
        <div class="info-section">
          <h4 class="font-semibold text-lg mb-4">Info</h4>
          <div class="info-item">
            <span class="info-label">Title:</span>
            <span class="info-value" id="hold-exam-title">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Topic:</span>
            <span class="info-value" id="hold-topic">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Department:</span>
            <span class="info-value" id="hold-department">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Role:</span>
            <span class="info-value" id="hold-role">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="info-value" id="hold-status">Hold</span>
          </div>
          <div class="info-item">
            <span class="info-label">Date Created:</span>
            <span class="info-value" id="hold-date">-</span>
          </div>
        </div>
        
        <!-- Document Section -->
        <div>
          <div class="document-section">
            <h4 class="font-semibold text-lg mb-4">DOCUMENT PREVIEW</h4>
            <div class="document-preview" id="hold-document-preview">
              <!-- Document content will be displayed here -->
            </div>
            <div class="mt-4 flex gap-2">
              <button class="btn btn-border flex-1" id="hold-view-full-content">View Full Content</button>
              <button class="btn btn-border flex-1" id="hold-view-document">View Document</button>
            </div>
          </div>
          
          <!-- CRUD Actions -->
          <div class="mt-4 flex gap-2">
            <button class="btn btn-border flex-1" id="hold-post-btn">Post</button>
            <button class="btn btn-border flex-1" id="hold-edit-btn">Edit</button>
            <button class="btn btn-border flex-1" id="hold-download-btn">Download</button>
            <button class="btn btn-border flex-1" id="hold-convert-btn">Convert</button>
          </div>
        </div>
      </div>
      
      <div class="modal-action mt-6">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- FOR COMPLIANCE MODULE MODAL -->
  <dialog id="compliance_module_modal" class="modal">
    <div class="modal-box max-w-5xl">
      <h3 class="font-bold text-lg mb-4" id="compliance-title">Module Title</h3>
      
      <!-- Reason Section -->
      <div class="reason-section">
        <div class="reason-title">Compliance Requirements</div>
        <div class="reason-text" id="compliance-reason">This module requires updates to meet compliance standards. Please review the following requirements.</div>
      </div>
      
      <div class="modal-grid">
        <!-- Info Section -->
        <div class="info-section">
          <h4 class="font-semibold text-lg mb-4">Info</h4>
          <div class="info-item">
            <span class="info-label">Title:</span>
            <span class="info-value" id="compliance-exam-title">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Topic:</span>
            <span class="info-value" id="compliance-topic">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Department:</span>
            <span class="info-value" id="compliance-department">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Role:</span>
            <span class="info-value" id="compliance-role">-</span>
          </div>
          <div class="info-item">
            <span class="info-label">Status:</span>
            <span class="info-value" id="compliance-status">For Compliance</span>
          </div>
          <div class="info-item">
            <span class="info-label">Date Created:</span>
            <span class="info-value" id="compliance-date">-</span>
          </div>
        </div>
        
        <!-- Document Section -->
        <div>
          <div class="document-section">
            <h4 class="font-semibold text-lg mb-4">DOCUMENT PREVIEW</h4>
            <div class="document-preview" id="compliance-document-preview">
              <!-- Document content will be displayed here -->
            </div>
            <div class="mt-4 flex gap-2">
              <button class="btn btn-border flex-1" id="compliance-view-full-content">View Full Content</button>
              <button class="btn btn-border flex-1" id="compliance-view-document">View Document</button>
            </div>
          </div>
          
          <!-- CRUD Actions -->
          <div class="mt-4 flex gap-2">
            <button class="btn btn-border flex-1" id="compliance-resubmit-btn">Resubmit Request</button>
            <button class="btn btn-border flex-1" id="compliance-hold-btn">Hold</button>
            <button class="btn btn-border flex-1" id="compliance-edit-btn">Edit</button>
            <button class="btn btn-border flex-1" id="compliance-delete-btn">Delete</button>
          </div>
        </div>
      </div>
      
      <div class="modal-action mt-6">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- FULL CONTENT MODAL -->
  <dialog id="full_content_modal" class="modal modal-middle">
    <div class="modal-box max-w-6xl max-h-[80vh]">
      <h3 class="font-bold text-lg mb-4" id="full-content-title">Full Module Content</h3>
      
      <div class="bg-white border rounded-lg p-6 max-h-[60vh] overflow-y-auto">
        <div id="full-content-display">
          <!-- Full content will be displayed here -->
        </div>
      </div>
      
      <div class="modal-action mt-6">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- Remarks Modal -->
  <dialog id="remarks_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg">Remarks for Compliance</h3>
      <div class="py-4">
        <p class="mb-4">This module requires compliance updates. Please review the following remarks:</p>
        <div class="bg-yellow-50 p-4 rounded-lg mb-4">
          <p class="text-sm text-yellow-800">The module needs updated safety protocols according to the latest industry standards. Please ensure all references to OSHA guidelines are from the 2023 revision.</p>
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Add Additional Remarks</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-32" placeholder="Enter additional remarks..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-border">Close</button>
        </form>
        <button class="btn btn-border">Save Remarks</button>
      </div>
    </div>
  </dialog>

  <script>
    function startModuleCreation() {
      const title = document.querySelector('input[name="title"]').value;
      const department = document.getElementById('departmentSelect').value;
      const role = document.getElementById('roleSelect').value;
      const topic = document.querySelector('input[name="topic"]').value;
      
      if (!title || !department || !role || !topic) {
        alert('Please fill in all required fields.');
        return;
      }
      
      // Create URL parameters
      const params = new URLSearchParams({
        title: title,
        department: department,
        role: role,
        topic: topic
      });
      
      // Close modal and redirect
      upload_modal.close();
      window.location.href = 'create_learning_modules.php?' + params.toString();
    }
  </script>

  <!-- Include JavaScript file -->
  <script src="../JS/learning_modules_repository.js"></script>25
  <script src="../JS/soliera.js"></script>
  <script src="../JS/sidebar.js"></script>
</body>
</html>