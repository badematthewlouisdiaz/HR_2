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

// Fetch examinations from database
$examinations = [];
$sql = "SELECT * FROM examinations ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $examinations[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Examination Management</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <style>
    .examination-card {
      transition: all 0.3s ease;
    }
    .examination-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .status-pending {
      @apply bg-yellow-100 text-yellow-800;
    }
    .status-approved {
      @apply bg-green-100 text-green-800;
    }
    .status-hold {
      @apply bg-orange-100 text-orange-800;
    }
    .status-rejected {
      @apply bg-red-100 text-red-800;
    }
    .status-compliance {
      @apply bg-blue-100 text-blue-800;
    }
    .status-posted {
      @apply bg-purple-100 text-purple-800;
    }
    .btn-custom {
      @apply bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .btn-success {
      @apply bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .btn-warning {
      @apply bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .btn-danger {
      @apply bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200;
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
          <!-- Examinations Section -->
          <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
              <div>
                <h1 class="text-3xl font-bold mb-2">Examination Management</h1>
                <p class="text-gray-600">Create and manage examinations for employee assessment</p>
              </div>
              <div class="flex gap-2">
                <button class="btn btn-custom" onclick="window.location.href='exam_results.php'">
                  <i class="fas fa-chart-bar mr-2"></i>Exam Results 
                </button>
                <button class="btn btn-custom" onclick="window.location.href='create_examination.php'">
                  <i class="fas fa-plus mr-2"></i>Create Examination
                </button>
                  <button class="btn btn-border" onclick="window.location.href='review_dashboard.php'">
                  <i class="fas fa-eye mr-2"></i>Review Page
                </button>
                <button class="btn btn-border" onclick="window.location.href='posted_examinations.php'">
                  <i class="fas fa-list-check mr-2"></i>Posted Examinations
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
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="hold">Hold</option>
                    <option value="rejected">Rejected</option>
                    <option value="compliance">For Compliance</option>
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
                  <button class="btn btn-custom" onclick="applyFilters()">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                  </button>
                </div>
                
                <div class="form-control self-end">
                  <button class="btn btn-custom" onclick="clearFilters()">
                    <i class="fas fa-times mr-2"></i>Clear
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Examination Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="examinationCards">
                <?php if (empty($examinations)): ?>
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">No examinations found. Create your first examination!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($examinations as $exam): ?>
                        <div class="card bg-base-100 shadow-md examination-card" data-status="<?php echo $exam['status']; ?>" data-department="<?php echo $exam['department']; ?>">
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <h3 class="card-title"><?php echo htmlspecialchars($exam['title']); ?></h3>
                                    <div class="badge status-<?php echo $exam['status']; ?>">
                                        <?php echo ucfirst($exam['status']); ?>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2 my-2">
                                    <div class="badge badge-outline"><?php echo ucfirst(str_replace('-', ' ', $exam['department'])); ?></div>
                                    <div class="badge badge-outline"><?php echo htmlspecialchars($exam['question_count']); ?> Questions</div>
                                </div>
                                <p class="text-sm text-gray-500">Created: <?php echo date('Y-m-d', strtotime($exam['created_at'])); ?></p>
                                <p class="text-sm text-gray-500">Duration: <?php echo htmlspecialchars($exam['duration']); ?> minutes</p>
                                <p class="text-sm text-gray-500">Passing Score: <?php echo htmlspecialchars($exam['passing_score']); ?>%</p>
                                
                                <div class="card-actions justify-end mt-4">
                                    <button class="btn btn-sm btn-custom" onclick="viewDocument(<?php echo $exam['id']; ?>, '<?php echo $exam['status']; ?>')">
                                        <i class="fas fa-eye mr-1"></i> View Document
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
    <div class="modal-box max-w-4xl">
      <h3 class="font-bold text-lg mb-4" id="documentTitle">Examination Document</h3>
      
      <!-- Document Preview Section -->
      <div class="bg-base-200 p-6 rounded-lg mb-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h4 class="text-lg font-semibold" id="previewExamTitle">Employee Policy Examination</h4>
            <div class="flex flex-wrap gap-2 mt-2">
              <div class="badge badge-primary" id="previewDepartment">Human Resources</div>
              <div class="badge badge-outline" id="previewQuestionCount">10 Questions</div>
              <div class="badge" id="previewStatusBadge">Pending</div>
            </div>
          </div>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <p class="text-sm text-gray-500">Duration</p>
            <p class="font-medium" id="previewDuration">30 minutes</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Passing Score</p>
            <p class="font-medium" id="previewPassingScore">70%</p>
          </div>
        </div>
        
        <div class="mb-4">
          <p class="text-sm text-gray-500">Description</p>
          <p id="previewDescription">This examination tests knowledge of company policies and procedures.</p>
        </div>
        
        <div class="card bg-white">
          <div class="card-body">
            <h4 class="card-title">Document Preview</h4>
            <div class="flex items-center justify-center h-64 bg-base-100 rounded-lg border-2 border-dashed border-gray-300">
              <div class="text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-2 font-medium">examination_document.pdf</p>
                <p class="text-sm text-gray-500">2.4 MB</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- CRUD Operations Section - Dynamic based on status -->
      <div id="crudOperations">
        <!-- This section will be dynamically populated based on status -->
      </div>
      
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- Compliance Reason Modal -->
  <dialog id="compliance_reason_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg">Compliance Remarks</h3>
      <div class="py-4">
        <p class="mb-4">This examination requires compliance updates. Please review the following remarks:</p>
        <div class="bg-yellow-50 p-4 rounded-lg mb-4">
          <p class="text-sm text-yellow-800" id="complianceRemarksText">The examination needs updated questions according to the latest industry standards. Please ensure all references to company policies are from the 2023 revision.</p>
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Add Additional Remarks</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-32" placeholder="Enter additional remarks..." id="additionalRemarks"></textarea>
        </div>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Close</button>
        </form>
        <button class="btn btn-success" onclick="saveComplianceRemarks()">Save Remarks</button>
      </div>
    </div>
  </dialog>

  <script>
    // Current exam ID for operations
    let currentExamId = null;
    let currentExamStatus = null;

    // Filter functionality
    function applyFilters() {
      const statusFilter = document.getElementById('statusFilter').value;
      const departmentFilter = document.getElementById('departmentFilter').value;
      
      const cards = document.querySelectorAll('.examination-card');
      
      cards.forEach(card => {
        let show = true;
        
        // Status filter
        if (statusFilter !== 'all' && card.dataset.status !== statusFilter) {
          show = false;
        }
        
        // Department filter
        if (departmentFilter !== 'all' && card.dataset.department !== departmentFilter) {
          show = false;
        }
        
        card.style.display = show ? 'block' : 'none';
      });
    }
    
    function clearFilters() {
      document.getElementById('statusFilter').value = 'all';
      document.getElementById('departmentFilter').value = 'all';
      
      const cards = document.querySelectorAll('.examination-card');
      cards.forEach(card => {
        card.style.display = 'block';
      });
    }
    
    // View Document with CRUD operations based on status
    function viewDocument(id, status) {
      currentExamId = id;
      currentExamStatus = status;
      
      // In a real implementation, this would fetch exam details from the server
      document.getElementById('previewExamTitle').textContent = 'Employee Policy Examination ' + id;
      document.getElementById('previewDepartment').textContent = 'Human Resources';
      document.getElementById('previewQuestionCount').textContent = '10 Questions';
      document.getElementById('previewDuration').textContent = '30 minutes';
      document.getElementById('previewPassingScore').textContent = '70%';
      document.getElementById('previewDescription').textContent = 'This examination tests knowledge of company policies and procedures.';
      
      // Update status badge
      const statusBadge = document.getElementById('previewStatusBadge');
      statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
      statusBadge.className = 'badge status-' + status;
      
      // Set CRUD operations based on status
      setupCrudOperations(status);
      
      view_document_modal.showModal();
    }
    
    // Setup CRUD operations based on status
    function setupCrudOperations(status) {
      const crudContainer = document.getElementById('crudOperations');
      let html = '<div class="flex flex-wrap gap-2 justify-end mb-4">';
      
      switch(status) {
        case 'pending':
          html += `
            <button class="btn btn-success" onclick="reviewDocument(${currentExamId})">
              <i class="fas fa-check-circle mr-1"></i> Review Document
            </button>
            <button class="btn btn-warning" onclick="cancelRequest(${currentExamId})">
              <i class="fas fa-times-circle mr-1"></i> Cancel Request
            </button>
            <button class="btn btn-danger" onclick="deleteExam(${currentExamId})">
              <i class="fas fa-trash mr-1"></i> Delete
            </button>
          `;
          break;
          
        case 'approved':
          html += `
            <button class="btn btn-success" onclick="postExam(${currentExamId})">
              <i class="fas fa-share-square mr-1"></i> Post
            </button>
            <button class="btn btn-warning" onclick="holdExam(${currentExamId})">
              <i class="fas fa-pause-circle mr-1"></i> Hold
            </button>
          `;
          break;
          
        case 'hold':
          html += `
            <button class="btn btn-success" onclick="postExam(${currentExamId})">
              <i class="fas fa-share-square mr-1"></i> Post
            </button>
          `;
          break;
          
        case 'rejected':
          html += `
            <button class="btn btn-danger" onclick="deleteExam(${currentExamId})">
              <i class="fas fa-trash mr-1"></i> Delete
            </button>
          `;
          break;
          
        case 'compliance':
          html += `
            <button class="btn btn-custom" onclick="showComplianceReason(${currentExamId})">
              <i class="fas fa-comment-alt mr-1"></i> Reason Why
            </button>
            <button class="btn btn-danger" onclick="deleteExam(${currentExamId})">
              <i class="fas fa-trash mr-1"></i> Delete
            </button>
            <button class="btn btn-success" onclick="editExam(${currentExamId})">
              <i class="fas fa-edit mr-1"></i> Edit
            </button>
          `;
          break;
          
        case 'posted':
          html += `
            <button class="btn btn-warning" onclick="holdExam(${currentExamId})">
              <i class="fas fa-pause-circle mr-1"></i> Hold
            </button>
          `;
          break;
          
        default:
          html += '<p>No actions available for this status.</p>';
      }
      
      html += '</div>';
      crudContainer.innerHTML = html;
    }
    
    // CRUD Operations
    function reviewDocument(id) {
      // Redirect to review dashboard
      window.location.href = 'review_dashboard.php?id=' + id;
    }
    
    function cancelRequest(id) {
      if (confirm('Are you sure you want to cancel this examination request?')) {
        alert('Examination request cancelled with ID: ' + id);
        // Implementation would update status in database
        view_document_modal.close();
        // Refresh the page or update the UI
        location.reload();
      }
    }
    
    function deleteExam(id) {
      if (confirm('Are you sure you want to delete this examination? This action cannot be undone.')) {
        alert('Examination deleted with ID: ' + id);
        // Implementation would delete from database
        view_document_modal.close();
        // Refresh the page or update the UI
        location.reload();
      }
    }
    
    function postExam(id) {
      if (confirm('Are you sure you want to post this examination? It will be visible to employees.')) {
        alert('Examination posted with ID: ' + id);
        // Implementation would update status to 'posted' in database
        view_document_modal.close();
        // Refresh the page or update the UI
        location.reload();
      }
    }
    
    function holdExam(id) {
      if (confirm('Are you sure you want to put this examination on hold? It will not be visible to employees.')) {
        alert('Examination put on hold with ID: ' + id);
        // Implementation would update status to 'hold' in database
        view_document_modal.close();
        // Refresh the page or update the UI
        location.reload();
      }
    }
    
    function editExam(id) {
      alert('Edit examination with ID: ' + id);
      // Implementation would redirect to edit page or open edit modal
      view_document_modal.close();
    }
    
    function showComplianceReason(id) {
      // In a real implementation, this would fetch compliance remarks from the server
      document.getElementById('complianceRemarksText').textContent = 
        'The examination needs updated questions according to the latest industry standards. Please ensure all references to company policies are from the 2023 revision.';
      
      compliance_reason_modal.showModal();
    }
    
    function saveComplianceRemarks() {
      const additionalRemarks = document.getElementById('additionalRemarks').value;
      alert('Compliance remarks saved for examination ID: ' + currentExamId + '\nAdditional Remarks: ' + additionalRemarks);
      compliance_reason_modal.close();
      // Implementation would save remarks to database
    }
  </script>
  <script src="../JS/soliera.js"></script>
  <script src="../JS/sidebar.js"></script>
</body>
</html>