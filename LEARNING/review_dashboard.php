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

// Get selected department from filter
$selected_department = $_GET['department'] ?? 'all';
$selected_exam_department = $_GET['exam_department'] ?? 'all';

// Build SQL query for learning modules based on filter
if ($selected_department === 'all') {
    $sql = "SELECT * FROM learning_modules WHERE status = 'pending' ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
} else {
    $sql = "SELECT * FROM learning_modules WHERE status = 'pending' AND department = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selected_department);
}

// Execute query for learning modules
$pending_modules = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $pending_modules[] = $row;
        }
    }
}

// Build SQL query for examinations based on filter
if ($selected_exam_department === 'all') {
    $exam_sql = "SELECT * FROM examinations WHERE status = 'pending' ORDER BY created_at DESC";
    $exam_stmt = $conn->prepare($exam_sql);
} else {
    $exam_sql = "SELECT * FROM examinations WHERE status = 'pending' AND department = ? ORDER BY created_at DESC";
    $exam_stmt = $conn->prepare($exam_sql);
    $exam_stmt->bind_param("s", $selected_exam_department);
}

// Execute query for examinations
$pending_examinations = [];
if ($exam_stmt->execute()) {
    $exam_result = $exam_stmt->get_result();
    if ($exam_result && $exam_result->num_rows > 0) {
        while($row = $exam_result->fetch_assoc()) {
            $pending_examinations[] = $row;
        }
    }
}

// Get unique departments for filter dropdowns
$departments_sql = "SELECT DISTINCT department FROM learning_modules WHERE status = 'pending' ORDER BY department";
$departments_result = $conn->query($departments_sql);
$departments = [];
if ($departments_result && $departments_result->num_rows > 0) {
    while($row = $departments_result->fetch_assoc()) {
        $departments[] = $row['department'];
    }
}

// Get unique departments for examinations filter dropdown
$exam_departments_sql = "SELECT DISTINCT department FROM examinations WHERE status = 'pending' ORDER BY department";
$exam_departments_result = $conn->query($exam_departments_sql);
$exam_departments = [];
if ($exam_departments_result && $exam_departments_result->num_rows > 0) {
    while($row = $exam_departments_result->fetch_assoc()) {
        $exam_departments[] = $row['department'];
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Learning Module & Examination Review</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .module-card, .exam-card {
      transition: all 0.2s ease;
      border: 1px solid #e5e7eb;
      background: white;
    }
    
    .module-card:hover, .exam-card:hover {
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
    
    .status-pending {
      background-color: #f3f4f6;
      color: #6b7280;
      border: 1px solid #d1d5db;
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
    
    .action-btn.approve:hover {
      background-color: #f0f9f0;
      border-color: #10b981;
    }
    
    .action-btn.reject:hover {
      background-color: #fef2f2;
      border-color: #ef4444;
    }
    
    .action-btn.compliance:hover {
      background-color: #faf5ff;
      border-color: #8b5cf6;
    }
    
    .action-btn.hold:hover {
      background-color: #f3f4f6;
      border-color: #6b7280;
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
    
    .tab-active {
      background-color: #3b82f6;
      color: white;
      border-color: #3b82f6;
    }
    
    .tab-inactive {
      background-color: white;
      color: #6b7280;
      border-color: #d1d5db;
    }
    
    .question-item {
      border: 1px solid #e5e7eb;
      border-radius: 0.375rem;
      padding: 1rem;
      margin-bottom: 1rem;
      background: white;
    }
    
    .correct-answer {
      background-color: #f0f9f0;
      border-color: #10b981;
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
          <!-- Learning Modules Review Section -->
          <div class="mb-12" id="modules-section">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
              <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2 text-gray-800">Learning Module Review</h1>
                <p class="text-gray-600">Review and approve pending learning modules</p>
              </div>
              
              <!-- Tabs for Switching Between Modules and Examinations - Moved to middle -->
              <div class="tabs tabs-boxed bg-white p-1 rounded-lg inline-flex">
                <a class="tab tab-lg font-medium transition-all duration-200 tab-active" id="modules-tab">Learning Modules</a>
                <a class="tab tab-lg font-medium transition-all duration-200 tab-inactive" id="examinations-tab">Examinations</a>
              </div>
              
              <div class="flex gap-4 items-center">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                  <div class="text-sm text-gray-500">Pending Modules</div>
                  <div class="text-2xl font-bold text-gray-800"><?php echo count($pending_modules); ?></div>
                  <div class="text-xs text-gray-400">Awaiting review</div>
                </div>
                <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='learning_module_repository.php'">
                  <i class="fas fa-arrow-left mr-2"></i>Back to Repository
                </button>
              </div>
            </div>

            <!-- Department Filter for Modules -->
            <div class="filter-section mb-6">
              <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Filter by Department
                  </label>
                  <div class="flex flex-col sm:flex-row gap-3">
                    <select class="select select-bordered w-full sm:w-64" id="departmentFilter">
                      <option value="all">All Departments</option>
                      <?php foreach ($departments as $dept): 
                        $display_name = ucwords(str_replace('-', ' ', $dept));
                      ?>
                        <option value="<?php echo $dept; ?>" <?php echo $selected_department === $dept ? 'selected' : ''; ?>>
                          <?php echo $display_name; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    
                    <div class="flex gap-2">
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="applyModuleFilter()">
                        Apply Filter
                      </button>
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="clearModuleFilter()">
                        Clear
                      </button>
                    </div>
                  </div>
                </div>
                
                <!-- Active Filter Badge -->
                <?php if ($selected_department !== 'all'): ?>
                  <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">Active filter:</span>
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                      <?php echo ucwords(str_replace('-', ' ', $selected_department)); ?>
                    </span>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Module Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <?php if (empty($pending_modules)): ?>
                <div class="col-span-full empty-state">
                  <i class="fas fa-file-alt"></i>
                  <h3 class="text-xl font-semibold mb-2 text-gray-700">
                    <?php if ($selected_department !== 'all'): ?>
                      No Pending Modules in <?php echo ucwords(str_replace('-', ' ', $selected_department)); ?>
                    <?php else: ?>
                      No Pending Modules
                    <?php endif; ?>
                  </h3>
                  <p class="text-gray-500 mb-4">
                    <?php if ($selected_department !== 'all'): ?>
                      There are no learning modules awaiting review in this department.
                    <?php else: ?>
                      There are no learning modules awaiting review at this time.
                    <?php endif; ?>
                  </p>
                  <div class="flex gap-2 justify-center">
                    <?php if ($selected_department !== 'all'): ?>
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="clearModuleFilter()">
                        View All Departments
                      </button>
                    <?php endif; ?>
                    <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='learning_module_repository.php'">
                      <i class="fas fa-plus mr-2"></i>Create New Module
                    </button>
                  </div>
                </div>
              <?php else: ?>
                <?php foreach ($pending_modules as $module): ?>
                  <div class="module-card rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                      <h3 class="font-semibold text-lg text-gray-800"><?php echo htmlspecialchars($module['title']); ?></h3>
                      <span class="status-pending text-xs px-2 py-1 rounded-full">Pending</span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 my-3">
                      <span class="badge-outline text-xs px-2 py-1 rounded"><?php echo ucfirst(str_replace('-', ' ', $module['department'])); ?></span>
                      <span class="badge-outline text-xs px-2 py-1 rounded"><?php echo htmlspecialchars($module['roles']); ?></span>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Date Added:</span> 
                        <?php echo date('Y-m-d', strtotime($module['created_at'])); ?>
                      </p>
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Topic:</span> 
                        <?php echo htmlspecialchars($module['topic']); ?>
                      </p>
                    </div>
                    
                    <div class="mt-4">
                      <button class="btn-plain w-full py-2 rounded-lg text-sm" 
                              onclick="viewDocument(<?php echo $module['id']; ?>, '<?php echo htmlspecialchars($module['title']); ?>', '<?php echo htmlspecialchars($module['department']); ?>', '<?php echo htmlspecialchars($module['roles']); ?>', '<?php echo htmlspecialchars($module['topic']); ?>', '<?php echo htmlspecialchars($module['content']); ?>')">
                        <i class="fas fa-eye mr-2"></i>View Document
                      </button>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- Examinations Review Section -->
          <div class="mb-12 hidden" id="examinations-section">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">
              <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2 text-gray-800">Examination Review</h1>
                <p class="text-gray-600">Review and approve pending examinations</p>
              </div>
              
              <!-- Tabs for Switching Between Modules and Examinations - Moved to middle -->
              <div class="tabs tabs-boxed bg-white p-1 rounded-lg inline-flex">
                <a class="tab tab-lg font-medium transition-all duration-200 tab-inactive" id="modules-tab-2">Learning Modules</a>
                <a class="tab tab-lg font-medium transition-all duration-200 tab-active" id="examinations-tab-2">Examinations</a>
              </div>
              
              <div class="flex gap-4 items-center">
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                  <div class="text-sm text-gray-500">Pending Exams</div>
                  <div class="text-2xl font-bold text-gray-800"><?php echo count($pending_examinations); ?></div>
                  <div class="text-xs text-gray-400">Awaiting review</div>
                </div>
                <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='examination_repository.php'">
                  <i class="fas fa-arrow-left mr-2"></i>Back to Exams
                </button>
              </div>
            </div>

            <!-- Department Filter for Examinations -->
            <div class="filter-section mb-6">
              <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                <div class="flex-1">
                  <label class="block text-sm font-medium text-gray-700 mb-2">
                    Filter by Department
                  </label>
                  <div class="flex flex-col sm:flex-row gap-3">
                    <select class="select select-bordered w-full sm:w-64" id="examDepartmentFilter">
                      <option value="all">All Departments</option>
                      <?php foreach ($exam_departments as $dept): 
                        $display_name = ucwords(str_replace('-', ' ', $dept));
                      ?>
                        <option value="<?php echo $dept; ?>" <?php echo $selected_exam_department === $dept ? 'selected' : ''; ?>>
                          <?php echo $display_name; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    
                    <div class="flex gap-2">
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="applyExamFilter()">
                        Apply Filter
                      </button>
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="clearExamFilter()">
                        Clear
                      </button>
                    </div>
                  </div>
                </div>
                
                <!-- Active Filter Badge -->
                <?php if ($selected_exam_department !== 'all'): ?>
                  <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600">Active filter:</span>
                    <span class="bg-gray-100 px-3 py-1 rounded-full text-sm font-medium text-gray-700">
                      <?php echo ucwords(str_replace('-', ' ', $selected_exam_department)); ?>
                    </span>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            
            <!-- Examination Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <?php if (empty($pending_examinations)): ?>
                <div class="col-span-full empty-state">
                  <i class="fas fa-file-alt"></i>
                  <h3 class="text-xl font-semibold mb-2 text-gray-700">
                    <?php if ($selected_exam_department !== 'all'): ?>
                      No Pending Examinations in <?php echo ucwords(str_replace('-', ' ', $selected_exam_department)); ?>
                    <?php else: ?>
                      No Pending Examinations
                    <?php endif; ?>
                  </h3>
                  <p class="text-gray-500 mb-4">
                    <?php if ($selected_exam_department !== 'all'): ?>
                      There are no examinations awaiting review in this department.
                    <?php else: ?>
                      There are no examinations awaiting review at this time.
                    <?php endif; ?>
                  </p>
                  <div class="flex gap-2 justify-center">
                    <?php if ($selected_exam_department !== 'all'): ?>
                      <button class="btn-plain px-4 py-2 rounded-lg" onclick="clearExamFilter()">
                        View All Departments
                      </button>
                    <?php endif; ?>
                    <button class="btn-plain px-4 py-2 rounded-lg" onclick="window.location.href='examinations.php'">
                      <i class="fas fa-plus mr-2"></i>Create New Examination
                    </button>
                  </div>
                </div>
              <?php else: ?>
                <?php foreach ($pending_examinations as $exam): ?>
                  <div class="exam-card rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                      <h3 class="font-semibold text-lg text-gray-800"><?php echo htmlspecialchars($exam['title']); ?></h3>
                      <span class="status-pending text-xs px-2 py-1 rounded-full">Pending</span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 my-3">
                      <span class="badge-outline text-xs px-2 py-1 rounded"><?php echo ucfirst(str_replace('-', ' ', $exam['department'])); ?></span>
                      <!-- FIXED: Check if roles key exists before using it -->
                      <?php if (isset($exam['roles']) && !empty($exam['roles'])): ?>
                        <span class="badge-outline text-xs px-2 py-1 rounded"><?php echo htmlspecialchars($exam['roles']); ?></span>
                      <?php else: ?>
                        <span class="badge-outline text-xs px-2 py-1 rounded">All Roles</span>
                      <?php endif; ?>
                    </div>
                    
                    <div class="space-y-2 mb-4">
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Date Added:</span> 
                        <?php echo date('Y-m-d', strtotime($exam['created_at'])); ?>
                      </p>
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Questions:</span> 
                        <?php echo isset($exam['question_count']) ? $exam['question_count'] : 'N/A'; ?>
                      </p>
                      <p class="text-sm text-gray-600">
                        <span class="font-medium">Duration:</span> 
                        <?php echo isset($exam['duration']) ? $exam['duration'] : 'N/A'; ?> minutes
                      </p>
                    </div>
                    
                    <div class="mt-4">
                      <button class="btn-plain w-full py-2 rounded-lg text-sm" 
                              onclick="viewExam(<?php echo $exam['id']; ?>, '<?php echo htmlspecialchars($exam['title']); ?>', '<?php echo htmlspecialchars($exam['department']); ?>', '<?php echo isset($exam['roles']) ? htmlspecialchars($exam['roles']) : 'All Roles'; ?>', '<?php echo isset($exam['duration']) ? $exam['duration'] : 'N/A'; ?>', '<?php echo isset($exam['question_count']) ? $exam['question_count'] : 'N/A'; ?>')">
                        <i class="fas fa-eye mr-2"></i>View Examination
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

  <!-- View Document Modal -->
  <dialog id="view_document_modal" class="modal">
    <div class="modal-box max-w-6xl p-0">
      <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
          <h3 class="font-bold text-lg text-gray-800" id="document_title">Module Title</h3>
          <button class="btn-plain w-8 h-8 rounded-full flex items-center justify-center" onclick="view_document_modal.close()">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      
      <div class="p-6 max-h-[70vh] overflow-y-auto">
        <!-- Module Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="space-y-1">
            <p class="text-sm text-gray-500">Department</p>
            <p class="font-medium text-gray-800" id="document_department">Department</p>
          </div>
          <div class="space-y-1">
            <p class="text-sm text-gray-500">Roles</p>
            <p class="font-medium text-gray-800" id="document_roles">Roles</p>
          </div>
          <div class="space-y-1">
            <p class="text-sm text-gray-500">Topic</p>
            <p class="font-medium text-gray-800" id="document_topic">Topic</p>
          </div>
        </div>
        
        <!-- Content Preview -->
        <div class="mb-6">
          <p class="text-sm text-gray-500 mb-2">Module Content</p>
          <div class="content-preview" id="document_content">
            <!-- Content will be inserted here -->
          </div>
        </div>
        
        <!-- Action Section -->
        <div class="action-section">
          <p class="text-sm text-gray-500 mb-3">Module Actions</p>
          <div class="action-buttons">
            <button class="action-btn approve" onclick="approveModule()">
              <i class="fas fa-check mr-2"></i>Approve
            </button>
            <button class="action-btn reject" onclick="rejectModule()">
              <i class="fas fa-times mr-2"></i>Reject
            </button>
            <button class="action-btn compliance" onclick="forCompliance()">
              <i class="fas fa-exclamation-triangle mr-2"></i>For Compliance
            </button>
            <button class="action-btn hold" onclick="holdModule()">
              <i class="fas fa-pause mr-2"></i>Hold
            </button>
          </div>
        </div>
      </div>
    </div>
  </dialog>

  <!-- View Examination Modal -->
  <dialog id="view_exam_modal" class="modal">
    <div class="modal-box max-w-6xl p-0">
      <div class="p-6 border-b border-gray-200">
        <div class="flex justify-between items-start">
          <h3 class="font-bold text-lg text-gray-800" id="exam_title">Examination Title</h3>
          <button class="btn-plain w-8 h-8 rounded-full flex items-center justify-center" onclick="view_exam_modal.close()">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      
      <div class="p-6 max-h-[70vh] overflow-y-auto">
        <!-- Exam Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
          <div class="space-y-1">
            <p class="text-sm text-gray-500">Department</p>
            <p class="font-medium text-gray-800" id="exam_department">Department</p>
          </div>
          <div class="space-y-1">
            <p class="text-sm text-gray-500">Roles</p>
            <p class="font-medium text-gray-800" id="exam_roles">Roles</p>
          </div>
          <div class="space-y-1">
            <p class="text-sm text-gray-500">Duration</p>
            <p class="font-medium text-gray-800" id="exam_duration">Duration</p>
          </div>
        </div>
        
        <!-- Exam Questions -->
        <div class="mb-6">
          <p class="text-sm text-gray-500 mb-2">Examination Questions</p>
          <div id="exam_questions" class="space-y-4">
            <!-- Questions will be inserted here -->
          </div>
        </div>
        
        <!-- Action Section -->
        <div class="action-section">
          <p class="text-sm text-gray-500 mb-3">Examination Actions</p>
          <div class="action-buttons">
            <button class="action-btn approve" onclick="approveExam()">
              <i class="fas fa-check mr-2"></i>Approve
            </button>
            <button class="action-btn reject" onclick="rejectExam()">
              <i class="fas fa-times mr-2"></i>Reject
            </button>
            <button class="action-btn compliance" onclick="forExamCompliance()">
              <i class="fas fa-exclamation-triangle mr-2"></i>For Compliance
            </button>
            <button class="action-btn hold" onclick="holdExam()">
              <i class="fas fa-pause mr-2"></i>Hold
            </button>
          </div>
        </div>
      </div>
    </div>
  </dialog>

  <!-- Reject Modal -->
  <dialog id="reject_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Reject Module</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Are you sure you want to reject <span id="reject_module_name" class="font-semibold">this module</span>?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Reason for Rejection (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24 border-gray-300" id="reject_reason" placeholder="Enter reason for rejection..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="reject_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-red-200 text-red-700 hover:bg-red-50" onclick="confirmReject()">Reject Module</button>
      </div>
    </div>
  </dialog>

  <!-- For Compliance Modal -->
  <dialog id="compliance_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Mark for Compliance</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Mark <span id="compliance_module_name" class="font-semibold">this module</span> for compliance updates?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Compliance Requirements</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-32 border-gray-300" id="compliance_requirements" placeholder="Specify compliance requirements..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="compliance_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-purple-200 text-purple-700 hover:bg-purple-50" onclick="confirmCompliance()">Mark for Compliance</button>
      </div>
    </div>
  </dialog>

  <!-- Hold Modal -->
  <dialog id="hold_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Hold Module</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Place <span id="hold_module_name" class="font-semibold">this module</span> on hold?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Reason for Hold (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24 border-gray-300" id="hold_reason" placeholder="Enter reason for placing on hold..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="hold_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-gray-300 text-gray-700 hover:bg-gray-50" onclick="confirmHold()">Place on Hold</button>
      </div>
    </div>
  </dialog>

  <!-- Reject Exam Modal -->
  <dialog id="reject_exam_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Reject Examination</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Are you sure you want to reject <span id="reject_exam_name" class="font-semibold">this examination</span>?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Reason for Rejection (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24 border-gray-300" id="reject_exam_reason" placeholder="Enter reason for rejection..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="reject_exam_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-red-200 text-red-700 hover:bg-red-50" onclick="confirmExamReject()">Reject Examination</button>
      </div>
    </div>
  </dialog>

  <!-- For Exam Compliance Modal -->
  <dialog id="compliance_exam_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Mark for Compliance</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Mark <span id="compliance_exam_name" class="font-semibold">this examination</span> for compliance updates?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Compliance Requirements</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-32 border-gray-300" id="compliance_exam_requirements" placeholder="Specify compliance requirements..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="compliance_exam_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-purple-200 text-purple-700 hover:bg-purple-50" onclick="confirmExamCompliance()">Mark for Compliance</button>
      </div>
    </div>
  </dialog>

  <!-- Hold Exam Modal -->
  <dialog id="hold_exam_modal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-gray-800 mb-4">Hold Examination</h3>
      <div class="mb-4">
        <p class="text-gray-600 mb-3">Place <span id="hold_exam_name" class="font-semibold">this examination</span> on hold?</p>
        <div class="form-control">
          <label class="label">
            <span class="label-text text-gray-700">Reason for Hold (Optional)</span>
          </label>
          <textarea class="textarea textarea-bordered w-full h-24 border-gray-300" id="hold_exam_reason" placeholder="Enter reason for placing on hold..."></textarea>
        </div>
      </div>
      <div class="modal-action">
        <button class="btn-plain px-4 py-2 rounded-lg" onclick="hold_exam_modal.close()">Cancel</button>
        <button class="btn-plain px-4 py-2 rounded-lg border-gray-300 text-gray-700 hover:bg-gray-50" onclick="confirmExamHold()">Place on Hold</button>
      </div>
    </div>
  </dialog>

  <script>
    // Tab Switching Functionality
    function switchToModules() {
      document.getElementById('modules-section').classList.remove('hidden');
      document.getElementById('examinations-section').classList.add('hidden');
      
      // Update both sets of tabs
      document.getElementById('modules-tab').classList.remove('tab-inactive');
      document.getElementById('modules-tab').classList.add('tab-active');
      document.getElementById('examinations-tab').classList.remove('tab-active');
      document.getElementById('examinations-tab').classList.add('tab-inactive');
      
      document.getElementById('modules-tab-2').classList.remove('tab-inactive');
      document.getElementById('modules-tab-2').classList.add('tab-active');
      document.getElementById('examinations-tab-2').classList.remove('tab-active');
      document.getElementById('examinations-tab-2').classList.add('tab-inactive');
    }
    
    function switchToExaminations() {
      document.getElementById('examinations-section').classList.remove('hidden');
      document.getElementById('modules-section').classList.add('hidden');
      
      // Update both sets of tabs
      document.getElementById('examinations-tab').classList.remove('tab-inactive');
      document.getElementById('examinations-tab').classList.add('tab-active');
      document.getElementById('modules-tab').classList.remove('tab-active');
      document.getElementById('modules-tab').classList.add('tab-inactive');
      
      document.getElementById('examinations-tab-2').classList.remove('tab-inactive');
      document.getElementById('examinations-tab-2').classList.add('tab-active');
      document.getElementById('modules-tab-2').classList.remove('tab-active');
      document.getElementById('modules-tab-2').classList.add('tab-inactive');
    }

    // Add event listeners to all tabs
    document.getElementById('modules-tab').addEventListener('click', switchToModules);
    document.getElementById('examinations-tab').addEventListener('click', switchToExaminations);
    document.getElementById('modules-tab-2').addEventListener('click', switchToModules);
    document.getElementById('examinations-tab-2').addEventListener('click', switchToExaminations);

    // Filter Functions for Modules
    function applyModuleFilter() {
      const departmentFilter = document.getElementById('departmentFilter');
      const selectedDepartment = departmentFilter.value;
      window.location.href = `?department=${selectedDepartment}&exam_department=<?php echo $selected_exam_department; ?>`;
    }
    
    function clearModuleFilter() {
      window.location.href = '?department=all&exam_department=<?php echo $selected_exam_department; ?>';
    }

    // Filter Functions for Examinations
    function applyExamFilter() {
      const examDepartmentFilter = document.getElementById('examDepartmentFilter');
      const selectedExamDepartment = examDepartmentFilter.value;
      window.location.href = `?department=<?php echo $selected_department; ?>&exam_department=${selectedExamDepartment}`;
    }
    
    function clearExamFilter() {
      window.location.href = '?department=<?php echo $selected_department; ?>&exam_department=all';
    }

    // Module Action Functions
    let currentModuleId = '';
    let currentModuleName = '';
    let currentModuleDepartment = '';
    let currentModuleRoles = '';
    let currentModuleTopic = '';
    
    function viewDocument(moduleId, moduleName, department, roles, topic, content) {
      currentModuleId = moduleId;
      currentModuleName = moduleName;
      currentModuleDepartment = department;
      currentModuleRoles = roles;
      currentModuleTopic = topic;
      
      document.getElementById('document_title').textContent = moduleName;
      document.getElementById('document_department').textContent = department.replace('-', ' ');
      document.getElementById('document_roles').textContent = roles;
      document.getElementById('document_topic').textContent = topic;
      document.getElementById('document_content').innerHTML = content;
      
      view_document_modal.showModal();
    }
    
    function approveModule() {
      if (confirm(`Approve "${currentModuleName}"? This module will be ready for posting.`)) {
        updateModuleStatus(currentModuleId, 'approved', `Module "${currentModuleName}" has been approved.`);
      }
    }
    
    function rejectModule() {
      document.getElementById('reject_module_name').textContent = currentModuleName;
      document.getElementById('reject_reason').value = '';
      view_document_modal.close();
      reject_modal.showModal();
    }
    
    function confirmReject() {
      const reason = document.getElementById('reject_reason').value;
      updateModuleStatus(currentModuleId, 'rejected', `Module "${currentModuleName}" has been rejected.`, reason);
      reject_modal.close();
    }
    
    function forCompliance() {
      document.getElementById('compliance_module_name').textContent = currentModuleName;
      document.getElementById('compliance_requirements').value = '';
      view_document_modal.close();
      compliance_modal.showModal();
    }
    
    function confirmCompliance() {
      const requirements = document.getElementById('compliance_requirements').value;
      updateModuleStatus(currentModuleId, 'compliance', `Module "${currentModuleName}" has been marked for compliance.`, requirements);
      compliance_modal.close();
    }
    
    function holdModule() {
      document.getElementById('hold_module_name').textContent = currentModuleName;
      document.getElementById('hold_reason').value = '';
      view_document_modal.close();
      hold_modal.showModal();
    }
    
    function confirmHold() {
      const reason = document.getElementById('hold_reason').value;
      updateModuleStatus(currentModuleId, 'hold', `Module "${currentModuleName}" has been placed on hold.`, reason);
      hold_modal.close();
    }
    
    // Examination Action Functions
    let currentExamId = '';
    let currentExamName = '';
    let currentExamDepartment = '';
    let currentExamRoles = '';
    let currentExamDuration = '';
    let currentExamQuestionCount = '';
    
    function viewExam(examId, examName, department, roles, duration, questionCount) {
      currentExamId = examId;
      currentExamName = examName;
      currentExamDepartment = department;
      currentExamRoles = roles;
      currentExamDuration = duration;
      currentExamQuestionCount = questionCount;
      
      document.getElementById('exam_title').textContent = examName;
      document.getElementById('exam_department').textContent = department.replace('-', ' ');
      document.getElementById('exam_roles').textContent = roles;
      document.getElementById('exam_duration').textContent = duration + ' minutes';
      
      // Load exam questions (this would typically be done via AJAX)
      loadExamQuestions(examId);
      
      view_exam_modal.showModal();
    }
    
    function loadExamQuestions(examId) {
      // This would typically be an AJAX call to fetch exam questions
      // For demonstration, we'll use dummy data
      const questionsContainer = document.getElementById('exam_questions');
      questionsContainer.innerHTML = `
        <div class="question-item">
          <p class="font-medium mb-2">1. What is the capital of France?</p>
          <div class="space-y-1 ml-4">
            <div class="flex items-center">
              <input type="radio" class="mr-2" checked disabled>
              <span class="correct-answer px-2 py-1 rounded">Paris</span>
            </div>
            <div class="flex items-center">
              <input type="radio" class="mr-2" disabled>
              <span>London</span>
            </div>
            <div class="flex items-center">
              <input type="radio" class="mr-2" disabled>
              <span>Berlin</span>
            </div>
            <div class="flex items-center">
              <input type="radio" class="mr-2" disabled>
              <span>Madrid</span>
            </div>
          </div>
        </div>
        <div class="question-item">
          <p class="font-medium mb-2">2. What is 2 + 2?</p>
          <div class="space-y-1 ml-4">
            <div class="flex items-center">
              <input type="radio" class="mr-2" disabled>
              <span>3</span>
            </div>
            <div class="flex items-center">
              <input type="radio" class="mr-2" checked disabled>
              <span class="correct-answer px-2 py-1 rounded">4</span>
            </div>
            <div class="flex items-center">
              <input type="radio" class="mr-2" disabled>
              <span>5</span>
            </div>
            <div class="flex items-center">
              <input type="radio" class="mr-2" disabled>
              <span>6</span>
            </div>
          </div>
        </div>
      `;
    }
    
    function approveExam() {
      if (confirm(`Approve "${currentExamName}"? This examination will be ready for posting.`)) {
        updateExamStatus(currentExamId, 'approved', `Examination "${currentExamName}" has been approved.`);
      }
    }
    
    function rejectExam() {
      document.getElementById('reject_exam_name').textContent = currentExamName;
      document.getElementById('reject_exam_reason').value = '';
      view_exam_modal.close();
      reject_exam_modal.showModal();
    }
    
    function confirmExamReject() {
      const reason = document.getElementById('reject_exam_reason').value;
      updateExamStatus(currentExamId, 'rejected', `Examination "${currentExamName}" has been rejected.`, reason);
      reject_exam_modal.close();
    }
    
    function forExamCompliance() {
      document.getElementById('compliance_exam_name').textContent = currentExamName;
      document.getElementById('compliance_exam_requirements').value = '';
      view_exam_modal.close();
      compliance_exam_modal.showModal();
    }
    
    function confirmExamCompliance() {
      const requirements = document.getElementById('compliance_exam_requirements').value;
      updateExamStatus(currentExamId, 'compliance', `Examination "${currentExamName}" has been marked for compliance.`, requirements);
      compliance_exam_modal.close();
    }
    
    function holdExam() {
      document.getElementById('hold_exam_name').textContent = currentExamName;
      document.getElementById('hold_exam_reason').value = '';
      view_exam_modal.close();
      hold_exam_modal.showModal();
    }
    
    function confirmExamHold() {
      const reason = document.getElementById('hold_exam_reason').value;
      updateExamStatus(currentExamId, 'hold', `Examination "${currentExamName}" has been placed on hold.`, reason);
      hold_exam_modal.close();
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
          // Close all modals and reload the page to reflect changes
          view_document_modal.close();
          reject_modal.close();
          compliance_modal.close();
          hold_modal.close();
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
    
    // AJAX function to update exam status
    function updateExamStatus(examId, newStatus, successMessage, remarks = '') {
      // Create form data
      const formData = new FormData();
      formData.append('exam_id', examId);
      formData.append('new_status', newStatus);
      formData.append('remarks', remarks);
      
      // Send AJAX request
      fetch('update_exam_status.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert(successMessage);
          // Close all modals and reload the page to reflect changes
          view_exam_modal.close();
          reject_exam_modal.close();
          compliance_exam_modal.close();
          hold_exam_modal.close();
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          alert('Error updating examination: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error updating examination status. Please try again.');
      });
    }
  </script>
  
  <script src="../JS/soliera.js"></script>
  <script src="../JS/sidebar.js"></script>
</body>
</html>