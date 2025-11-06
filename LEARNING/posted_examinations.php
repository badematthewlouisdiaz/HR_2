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

// Check if employees table exists, if not create it
$table_check = $conn->query("SHOW TABLES LIKE 'employees'");
if ($table_check->num_rows == 0) {
    // Create employees table
    $create_table_sql = "CREATE TABLE employees (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        department VARCHAR(100) NOT NULL,
        position VARCHAR(100) NOT NULL,
        status ENUM('active', 'inactive') DEFAULT 'active',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($create_table_sql) === TRUE) {
        // Insert sample data
        $sample_data_sql = "INSERT INTO employees (first_name, last_name, email, department, position) VALUES
            ('John', 'Doe', 'john.doe@company.com', 'human-resources', 'HR Manager'),
            ('Jane', 'Smith', 'jane.smith@company.com', 'operations', 'Operations Supervisor'),
            ('Mike', 'Johnson', 'mike.johnson@company.com', 'information-technology', 'IT Specialist'),
            ('Sarah', 'Wilson', 'sarah.wilson@company.com', 'front-office', 'Receptionist'),
            ('David', 'Brown', 'david.brown@company.com', 'kitchen', 'Chef'),
            ('Emily', 'Davis', 'emily.davis@company.com', 'sales-marketing', 'Sales Executive')";
        
        $conn->query($sample_data_sql);
    }
}

// Fetch only posted examinations
$posted_examinations = [];
$sql = "SELECT * FROM examinations WHERE status = 'posted' ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $posted_examinations[] = $row;
    }
}

// Fetch employee data for assignment
$employees = [];
$employee_sql = "SELECT id, first_name, last_name, department, position FROM employees WHERE status = 'active'";
$employee_result = $conn->query($employee_sql);

if ($employee_result && $employee_result->num_rows > 0) {
    while($row = $employee_result->fetch_assoc()) {
        $employees[] = $row;
    }
}

// Get unique departments for filters
$departments = [];
foreach ($posted_examinations as $exam) {
    if (!in_array($exam['department'], $departments)) {
        $departments[] = $exam['department'];
    }
}

$conn->close();

// Define all roles per department
$department_roles = [
    'front-office' => [
        'Front Desk Manager',
        'Receptionist / Front Desk Officer',
        'Guest Service Agent / Concierge',
        'Reservation Agent',
        'Bellhop / Porter'
    ],
    'housekeeping' => [
        'Executive Housekeeper / Housekeeping Manager',
        'Floor Supervisor',
        'Room Attendant / Housekeeper',
        'Laundry Attendant',
        'Public Area Attendant'
    ],
    'food-beverage' => [
        'F&B Manager / Director',
        'Restaurant Manager / Captain',
        'Waiter / Waitress / Server',
        'Bartender'
    ],
    'kitchen' => [
        'Executive Chef / Head Chef',
        'Sous Chef',
        'Line Cook / Station Chef',
        'Pastry Chef / Baker',
        'Kitchen Steward / Dishwasher'
    ],
    'sales-marketing' => [
        'Sales & Marketing Manager',
        'Revenue Manager',
        'Event / Banquet Sales Coordinator',
        'Social Media / Marketing Executive'
    ],
    'human-resources' => [
        'HR Manager / Director',
        'Recruitment Officer',
        'Training & Development Specialist',
        'Payroll / HR Assistant'
    ],
    'finance' => [
        'Finance Manager / Controller',
        'Accountant',
        'Payroll Officer',
        'Cost Controller'
    ],
    'engineering' => [
        'Chief Engineer / Engineering Manager',
        'Maintenance Technician',
        'Electrician / Plumber',
        'HVAC Technician'
    ],
    'security' => [
        'Security Manager / Supervisor',
        'Security Guard',
        'CCTV / Surveillance Officer'
    ]
];

// Define target roles for each examination (for demonstration)
$examination_roles = [
    1 => ['HR Manager', 'Recruitment Officer', 'Training & Development Specialist'],
    2 => ['HR Manager', 'Recruitment Officer'],
    3 => ['HR Manager', 'Training & Development Specialist'],
    4 => ['HR Manager', 'Payroll / HR Assistant'],
    5 => ['HR Manager', 'Payroll / HR Assistant'],
    6 => ['Operations Supervisor', 'Floor Supervisor'],
    7 => ['Operations Supervisor', 'Maintenance Technician'],
    8 => ['Operations Supervisor', 'Quality Control Officer'],
    9 => ['Operations Supervisor', 'Safety Officer'],
    10 => ['Operations Supervisor', 'Process Improvement Specialist'],
    11 => ['IT Specialist', 'System Administrator'],
    12 => ['IT Specialist', 'Software Developer'],
    13 => ['IT Specialist', 'Network Engineer'],
    14 => ['IT Specialist', 'Database Administrator'],
    15 => ['IT Specialist', 'Cloud Engineer'],
    16 => ['Receptionist / Front Desk Officer', 'Guest Service Agent / Concierge'],
    17 => ['Front Desk Manager', 'Receptionist / Front Desk Officer'],
    18 => ['Guest Service Agent / Concierge', 'Reservation Agent'],
    19 => ['Reservation Agent', 'Front Desk Manager'],
    20 => ['Guest Service Agent / Concierge', 'Bellhop / Porter'],
    21 => ['Executive Chef / Head Chef', 'Sous Chef'],
    22 => ['Line Cook / Station Chef', 'Pastry Chef / Baker'],
    23 => ['Executive Chef / Head Chef', 'Kitchen Steward / Dishwasher'],
    24 => ['Sous Chef', 'Line Cook / Station Chef'],
    25 => ['Pastry Chef / Baker', 'Kitchen Steward / Dishwasher'],
    26 => ['Sales & Marketing Manager', 'Sales Executive'],
    27 => ['Social Media / Marketing Executive', 'Sales Executive'],
    28 => ['Revenue Manager', 'Sales & Marketing Manager'],
    29 => ['Event / Banquet Sales Coordinator', 'Sales Executive'],
    30 => ['Social Media / Marketing Executive', 'Event / Banquet Sales Coordinator']
];

// Function to get roles for an examination
function getExaminationRoles($exam_id, $examination_roles) {
    return isset($examination_roles[$exam_id]) ? $examination_roles[$exam_id] : ['All Roles'];
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Posted Examinations</title>
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
    .btn-custom {
      @apply border border-gray-300 hover:border-gray-400 bg-white text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .btn-success {
      @apply border border-green-600 hover:border-green-700 bg-white text-green-600 font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .btn-warning {
      @apply border border-yellow-600 hover:border-yellow-700 bg-white text-yellow-600 font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .btn-danger {
      @apply border border-red-600 hover:border-red-700 bg-white text-red-600 font-medium py-2 px-4 rounded-lg transition-colors duration-200;
    }
    .table-container {
      max-height: 400px;
      overflow-y: auto;
    }
    .badge-outline {
      @apply border border-gray-300 bg-transparent text-gray-700;
    }
    .badge-role {
      @apply border border-blue-300 bg-blue-50 text-blue-700 text-xs;
    }
    .status-badge {
      @apply px-2 py-1 rounded-full text-xs font-medium border;
    }
    .status-posted { @apply border-purple-300 bg-purple-50 text-purple-700; }
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
          <!-- Posted Examinations Section -->
          <div class="mb-12">
            <div class="flex justify-between items-center mb-6">
              <div>
                <h1 class="text-3xl font-bold mb-2">Posted Examinations</h1>
                <p class="text-gray-600">Manage and assign posted examinations to employees</p>
              </div>
              <div class="flex gap-2">
                <button class="btn btn-custom" onclick="window.location.href='examination_repository.php'">
                  <i class="fas fa-arrow-left mr-2"></i>Back to Examinations
                </button>
                <button class="btn btn-custom" onclick="window.location.href='exam_results.php'">
                  <i class="fas fa-chart-bar mr-2"></i>Results Dashboard
                </button>
              </div>
            </div>
            
            <!-- Filter Section -->
            <div class="bg-white p-4 rounded-lg border border-gray-200 mb-6">
              <div class="flex flex-wrap gap-4 items-end">
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium">Department</span>
                  </label>
                  <select class="select select-bordered w-48" id="departmentFilter">
                    <option value="all">All Departments</option>
                    <?php foreach($departments as $dept): ?>
                      <option value="<?php echo htmlspecialchars($dept); ?>">
                        <?php echo ucfirst(str_replace('-', ' ', $dept)); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="form-control">
                  <label class="label">
                    <span class="label-text font-medium">Role</span>
                  </label>
                  <select class="select select-bordered w-48" id="roleFilter">
                    <option value="all">All Roles</option>
                    <?php foreach($department_roles as $dept => $roles): ?>
                      <optgroup label="<?php echo ucfirst(str_replace('-', ' ', $dept)); ?>">
                        <?php foreach($roles as $role): ?>
                          <option value="<?php echo htmlspecialchars($role); ?>"><?php echo htmlspecialchars($role); ?></option>
                        <?php endforeach; ?>
                      </optgroup>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="form-control">
                  <button class="btn btn-custom" onclick="applyFilters()">
                    <i class="fas fa-filter mr-2"></i>Apply Filters
                  </button>
                </div>
                
                <div class="form-control">
                  <button class="btn btn-custom" onclick="clearFilters()">
                    <i class="fas fa-times mr-2"></i>Clear
                  </button>
                </div>
              </div>
            </div>
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
              <div class="stat bg-white rounded-lg border border-gray-200 p-6">
                <div class="stat-figure text-gray-600">
                  <i class="fas fa-file-alt text-3xl"></i>
                </div>
                <div class="stat-title text-gray-600">Total Posted</div>
                <div class="stat-value text-gray-800"><?php echo count($posted_examinations); ?></div>
                <div class="stat-desc text-gray-500">Active examinations</div>
              </div>
              
              <div class="stat bg-white rounded-lg border border-gray-200 p-6">
                <div class="stat-figure text-gray-600">
                  <i class="fas fa-users text-3xl"></i>
                </div>
                <div class="stat-title text-gray-600">Available Employees</div>
                <div class="stat-value text-gray-800"><?php echo count($employees); ?></div>
                <div class="stat-desc text-gray-500">For assignment</div>
              </div>
              
              <div class="stat bg-white rounded-lg border border-gray-200 p-6">
                <div class="stat-figure text-gray-600">
                  <i class="fas fa-calendar-check text-3xl"></i>
                </div>
                <div class="stat-title text-gray-600">This Month</div>
                <div class="stat-value text-gray-800">
                  <?php 
                    $current_month = date('Y-m');
                    $month_count = 0;
                    foreach($posted_examinations as $exam) {
                      if (date('Y-m', strtotime($exam['created_at'])) === $current_month) {
                        $month_count++;
                      }
                    }
                    echo $month_count;
                  ?>
                </div>
                <div class="stat-desc text-gray-500">New postings</div>
              </div>
            </div>
            
            <!-- Examinations Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8" id="examinationCards">
                <?php if (empty($posted_examinations)): ?>
                    <div class="col-span-full text-center py-8">
                        <i class="fas fa-file-alt text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500">No posted examinations found.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($posted_examinations as $exam): 
                        $exam_roles = getExaminationRoles($exam['id'], $examination_roles);
                        $roles_string = implode(',', $exam_roles);
                    ?>
                        <div class="card bg-base-100 border border-gray-200 examination-card" 
                             data-department="<?php echo $exam['department']; ?>"
                             data-roles="<?php echo htmlspecialchars($roles_string); ?>">
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <h3 class="card-title text-gray-800"><?php echo htmlspecialchars($exam['title']); ?></h3>
                                    <div class="status-badge status-posted">
                                        Posted
                                    </div>
                                </div>
                                
                                <!-- Department and Role Badges -->
                                <div class="flex flex-wrap gap-2 my-2">
                                    <div class="badge badge-outline"><?php echo ucfirst(str_replace('-', ' ', $exam['department'])); ?></div>
                                    <div class="badge badge-outline"><?php echo htmlspecialchars($exam['question_count']); ?> Questions</div>
                                    <?php foreach($exam_roles as $role): ?>
                                        <div class="badge badge-role" title="Target Role"><?php echo htmlspecialchars($role); ?></div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <p class="text-sm text-gray-500">Created: <?php echo date('Y-m-d', strtotime($exam['created_at'])); ?></p>
                                <p class="text-sm text-gray-500">Duration: <?php echo htmlspecialchars($exam['duration']); ?> minutes</p>
                                <p class="text-sm text-gray-500">Passing Score: <?php echo htmlspecialchars($exam['passing_score']); ?>%</p>
                                
                                <div class="card-actions justify-end mt-4">
                                    <button class="btn btn-sm btn-custom" onclick="viewDocument(<?php echo $exam['id']; ?>)">
                                        <i class="fas fa-eye mr-1"></i> View Details
                                    </button>
                                    <button class="btn btn-sm btn-success" onclick="assignExam(<?php echo $exam['id']; ?>)">
                                        <i class="fas fa-user-plus mr-1"></i> Assign
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
      <h3 class="font-bold text-lg mb-4">Examination Details</h3>
      
      <!-- Document Preview Section -->
      <div class="bg-base-200 p-6 rounded-lg mb-6">
        <div class="flex justify-between items-start mb-4">
          <div>
            <h4 class="text-lg font-semibold" id="previewExamTitle">Employee Policy Examination</h4>
            <div class="flex flex-wrap gap-2 mt-2">
              <div class="badge badge-outline" id="previewDepartment">Human Resources</div>
              <div class="badge badge-outline" id="previewQuestionCount">10 Questions</div>
              <div class="status-badge status-posted">Posted</div>
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
          <div>
            <p class="text-sm text-gray-500">Created Date</p>
            <p class="font-medium" id="previewCreatedDate">2023-10-15</p>
          </div>
          <div>
            <p class="text-sm text-gray-500">Posted Date</p>
            <p class="font-medium" id="previewPostedDate">2023-10-20</p>
          </div>
        </div>
        
        <div class="mb-4">
          <p class="text-sm text-gray-500">Description</p>
          <p id="previewDescription">This examination tests knowledge of company policies and procedures.</p>
        </div>
        
        <!-- Target Roles Section -->
        <div class="mb-4">
          <p class="text-sm text-gray-500">Target Roles</p>
          <div class="flex flex-wrap gap-2 mt-2" id="previewRoles">
            <div class="badge badge-role">HR Manager</div>
            <div class="badge badge-role">Recruitment Officer</div>
          </div>
        </div>
        
        <div class="card bg-white border border-gray-200">
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
      
      <!-- Actions Section -->
      <div class="flex flex-wrap gap-2 justify-end mb-4">
        <button class="btn btn-success" onclick="assignExam(currentExamId)">
          <i class="fas fa-user-plus mr-1"></i> Assign to Employees
        </button>
        <button class="btn btn-warning" onclick="holdExam(currentExamId)">
          <i class="fas fa-pause-circle mr-1"></i> Put on Hold
        </button>
        <button class="btn btn-custom" onclick="viewResults(currentExamId)">
          <i class="fas fa-chart-bar mr-1"></i> View Results
        </button>
      </div>
      
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  <!-- Assign Exam Modal -->
  <dialog id="assign_exam_modal" class="modal modal-middle">
    <div class="modal-box max-w-4xl">
      <h3 class="font-bold text-lg mb-4">Assign Examination to Employees</h3>
      
      <div class="mb-6">
        <h4 class="font-semibold mb-2" id="assignExamTitle">Employee Policy Examination</h4>
        <div class="flex flex-wrap gap-2">
          <div class="badge badge-outline" id="assignDepartment">Human Resources</div>
          <div class="badge badge-outline" id="assignQuestionCount">10 Questions</div>
          <div class="status-badge status-posted">Posted</div>
        </div>
        <div class="mt-2">
          <p class="text-sm text-gray-500">Target Roles:</p>
          <div class="flex flex-wrap gap-1 mt-1" id="assignRoles">
            <div class="badge badge-role">HR Manager</div>
          </div>
        </div>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Available Employees -->
        <div>
          <h5 class="font-medium mb-3">Available Employees</h5>
          <div class="table-container border border-gray-200 rounded-lg">
            <table class="table table-zebra table-sm">
              <thead>
                <tr>
                  <th><input type="checkbox" id="selectAllEmployees" onchange="toggleSelectAllEmployees()"></th>
                  <th>Name</th>
                  <th>Department</th>
                  <th>Position</th>
                </tr>
              </thead>
              <tbody id="employeesTable">
                <?php foreach($employees as $employee): ?>
                  <tr>
                    <td><input type="checkbox" class="employee-checkbox" value="<?php echo $employee['id']; ?>" data-position="<?php echo htmlspecialchars($employee['position']); ?>"></td>
                    <td><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($employee['department']); ?></td>
                    <td><?php echo htmlspecialchars($employee['position']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        
        <!-- Assignment Details -->
        <div>
          <h5 class="font-medium mb-3">Assignment Details</h5>
          <div class="form-control mb-4">
            <label class="label">
              <span class="label-text">Due Date</span>
            </label>
            <input type="date" class="input input-bordered" id="dueDate">
          </div>
          
          <div class="form-control mb-4">
            <label class="label">
              <span class="label-text">Time Limit (minutes)</span>
            </label>
            <input type="number" class="input input-bordered" id="timeLimit" value="60" min="5" max="480">
          </div>
          
          <div class="form-control">
            <label class="label">
              <span class="label-text">Instructions (Optional)</span>
            </label>
            <textarea class="textarea textarea-bordered h-24" id="assignmentInstructions" placeholder="Add any special instructions for this assignment..."></textarea>
          </div>
        </div>
      </div>
      
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-custom">Cancel</button>
        </form>
        <button class="btn btn-success" onclick="confirmAssignment()">
          <i class="fas fa-check mr-1"></i> Assign Examination
        </button>
      </div>
    </div>
  </dialog>

  <!-- Success Modal -->
  <dialog id="success_modal" class="modal">
    <div class="modal-box">
      <div class="flex flex-col items-center text-center">
        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
          <i class="fas fa-check text-gray-600 text-2xl"></i>
        </div>
        <h3 class="font-bold text-lg mb-2">Assignment Successful!</h3>
        <p class="py-4" id="successMessage">The examination has been assigned to selected employees.</p>
      </div>
      <div class="modal-action justify-center">
        <form method="dialog">
          <button class="btn btn-custom">Continue</button>
        </form>
      </div>
    </div>
  </dialog>

  <script>
    // Current exam ID for operations
    let currentExamId = null;

    // Filter functionality
    function applyFilters() {
      const departmentFilter = document.getElementById('departmentFilter').value;
      const roleFilter = document.getElementById('roleFilter').value;
      
      const cards = document.querySelectorAll('.examination-card');
      
      cards.forEach(card => {
        let show = true;
        
        // Department filter
        if (departmentFilter !== 'all' && card.dataset.department !== departmentFilter) {
          show = false;
        }
        
        // Role filter
        if (roleFilter !== 'all') {
          const cardRoles = card.dataset.roles.split(',');
          if (!cardRoles.includes(roleFilter)) {
            show = false;
          }
        }
        
        card.style.display = show ? 'block' : 'none';
      });
    }
    
    function clearFilters() {
      document.getElementById('departmentFilter').value = 'all';
      document.getElementById('roleFilter').value = 'all';
      
      const cards = document.querySelectorAll('.examination-card');
      cards.forEach(card => {
        card.style.display = 'block';
      });
    }

    // View Document Details
    function viewDocument(id) {
      currentExamId = id;
      
      // Get the card element to extract roles
      const card = document.querySelector(`.examination-card[data-department][data-roles]`);
      const roles = card ? card.dataset.roles.split(',') : ['HR Manager', 'Recruitment Officer'];
      
      // In a real implementation, this would fetch exam details from the server
      // For now, we'll use mock data
      document.getElementById('previewExamTitle').textContent = 'Employee Policy Examination ' + id;
      document.getElementById('previewDepartment').textContent = 'Human Resources';
      document.getElementById('previewQuestionCount').textContent = '10 Questions';
      document.getElementById('previewDuration').textContent = '30 minutes';
      document.getElementById('previewPassingScore').textContent = '70%';
      document.getElementById('previewCreatedDate').textContent = '2023-10-15';
      document.getElementById('previewPostedDate').textContent = '2023-10-20';
      document.getElementById('previewDescription').textContent = 'This examination tests knowledge of company policies and procedures.';
      
      // Update roles in the modal
      const rolesContainer = document.getElementById('previewRoles');
      rolesContainer.innerHTML = '';
      roles.forEach(role => {
        const roleBadge = document.createElement('div');
        roleBadge.className = 'badge badge-role';
        roleBadge.textContent = role;
        rolesContainer.appendChild(roleBadge);
      });
      
      view_document_modal.showModal();
    }
    
    // Assign Exam to Employees
    function assignExam(id) {
      currentExamId = id;
      
      // Get the card element to extract roles
      const card = document.querySelector(`.examination-card[data-department][data-roles]`);
      const roles = card ? card.dataset.roles.split(',') : ['HR Manager'];
      
      // Set exam details in the modal
      document.getElementById('assignExamTitle').textContent = 'Employee Policy Examination ' + id;
      document.getElementById('assignDepartment').textContent = 'Human Resources';
      document.getElementById('assignQuestionCount').textContent = '10 Questions';
      
      // Update roles in the assignment modal
      const rolesContainer = document.getElementById('assignRoles');
      rolesContainer.innerHTML = '';
      roles.forEach(role => {
        const roleBadge = document.createElement('div');
        roleBadge.className = 'badge badge-role';
        roleBadge.textContent = role;
        rolesContainer.appendChild(roleBadge);
      });
      
      // Set default due date to 7 days from now
      const dueDate = new Date();
      dueDate.setDate(dueDate.getDate() + 7);
      document.getElementById('dueDate').value = dueDate.toISOString().split('T')[0];
      
      assign_exam_modal.showModal();
    }
    
    // Toggle select all employees
    function toggleSelectAllEmployees() {
      const selectAll = document.getElementById('selectAllEmployees');
      const checkboxes = document.querySelectorAll('.employee-checkbox');
      
      checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
      });
    }
    
    // Confirm assignment
    function confirmAssignment() {
      const selectedEmployees = [];
      const selectedRoles = [];
      const checkboxes = document.querySelectorAll('.employee-checkbox:checked');
      
      checkboxes.forEach(checkbox => {
        selectedEmployees.push(checkbox.value);
        selectedRoles.push(checkbox.dataset.position);
      });
      
      if (selectedEmployees.length === 0) {
        alert('Please select at least one employee.');
        return;
      }
      
      const dueDate = document.getElementById('dueDate').value;
      const timeLimit = document.getElementById('timeLimit').value;
      const instructions = document.getElementById('assignmentInstructions').value;
      
      // In a real implementation, this would send the assignment data to the server
      console.log('Assigning exam:', {
        examId: currentExamId,
        employees: selectedEmployees,
        roles: selectedRoles,
        dueDate: dueDate,
        timeLimit: timeLimit,
        instructions: instructions
      });
      
      // Show success message
      document.getElementById('successMessage').textContent = 
        `The examination has been assigned to ${selectedEmployees.length} employee(s).`;
      
      assign_exam_modal.close();
      success_modal.showModal();
    }
    
    // Put exam on hold
    function holdExam(id) {
      if (confirm('Are you sure you want to put this examination on hold? It will no longer be available for assignment.')) {
        // In a real implementation, this would update the exam status in the database
        alert('Examination put on hold with ID: ' + id);
        view_document_modal.close();
        // Refresh the page or update the UI
        location.reload();
      }
    }
    
    // View exam results
    function viewResults(id) {
      // Redirect to results page for this exam
      window.location.href = 'exam_results.php?exam_id=' + id;
    }
  </script>
  <script src="../JS/soliera.js"></script>
  <script src="../JS/sidebar.js"></script>
</body>
</html>