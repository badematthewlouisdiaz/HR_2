<?php
session_start();

include("../db.php");

$db_name = "hr2_succession";
$conn = $connections[$db_name] ?? die("❌ Connection not found for $db_name");



// Fetch surveys
$surveys = [];
$result = $conn->query("SELECT * FROM sucession WHERE data_type = 'survey'");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $surveys[] = $row;
    }
}

// Fetch candidates
$candidates = [];
$result = $conn->query("SELECT * FROM sucession WHERE data_type = 'candidate'");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $candidates[] = $row;
    }
}

// Fetch employees for participant selection
$employees = [];
$result = $conn->query("SELECT * FROM sucession WHERE data_type = 'employee'");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

$conn->close();
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="../soliera.css">
  <link rel="stylesheet" href="../sidebar.css">
  <style>
    .progress-bar {
      transition: width 0.5s ease-in-out;
    }
    .fade-in {
      animation: fadeIn 0.5s;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    .card-hover {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
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
      
      <main class="container mx-auto px-4 py-8">
        <!-- Stats Overview -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
          <div class="stat">
            <div class="stat-figure text-primary">
              <i data-lucide="users" class="w-8 h-8"></i>
            </div>
            <div class="stat-title">Total Candidates</div>
            <div class="stat-value"><?php echo count($candidates); ?></div>
            <div class="stat-desc">↗︎ <?php echo count($candidates); ?> (100%)</div>
          </div>
          
          <div class="stat">
            <div class="stat-figure text-secondary">
              <i data-lucide="clipboard-check" class="w-8 h-8"></i>
            </div>
            <div class="stat-title">Active Surveys</div>
            <div class="stat-value"><?php echo count($surveys); ?></div>
            <div class="stat-desc"><?php echo count($surveys); ?> total surveys</div>
          </div>
          
          <div class="stat">
            <div class="stat-figure text-accent">
              <i data-lucide="trending-up" class="w-8 h-8"></i>
            </div>
            <div class="stat-title">Ready for Promotion</div>
            <div class="stat-value"><?php echo count(array_filter($candidates, function($c) { return $c['readiness_timeline'] === 'Ready Now'; })); ?></div>
            <div class="stat-desc">Ready now candidates</div>
          </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 gap-8">
          <!-- Survey Section -->
          <section class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">Leadership Potential Surveys</h2>
              <button class="btn btn-primary" onclick="createSurveyModal.showModal()">
                <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
                Create New Survey
              </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="survey-container">
              <?php if (count($surveys) === 0): ?>
                <div class="text-center py-10 text-gray-500 col-span-2">
                  <i data-lucide="clipboard-list" class="w-12 h-12 mx-auto mb-3"></i>
                  <p>No surveys created yet</p>
                </div>
              <?php else: ?>
                <?php foreach ($surveys as $survey): ?>
                  <div class="card bg-base-100 shadow-md card-hover">
                    <div class="card-body">
                      <div class="flex items-center justify-between mb-4">
                        <h3 class="card-title text-lg"><?php echo $survey['name']; ?></h3>
                        <span class="badge badge-primary badge-sm"><?php echo $survey['status']; ?></span>
                      </div>
                      <p class="text-gray-600 mb-4"><?php echo $survey['survey_type']; ?> Survey</p>
                      <div class="flex items-center text-sm text-gray-500 mb-2">
                        <i data-lucide="bar-chart-3" class="w-4 h-4 mr-2"></i>
                        <span>Measures: <?php echo $survey['competencies']; ?></span>
                      </div>
                      <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>Due: <?php echo date('M j, Y', strtotime($survey['due_date'])); ?></span>
                      </div>
                      <div class="card-actions justify-end">
                        <button class="btn btn-ghost btn-sm">
                          <i data-lucide="eye" class="w-4 h-4 mr-1"></i>
                          View Results
                        </button>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </section>

          <!-- Candidates Section -->
          <section class="bg-white rounded-xl shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-2xl font-semibold text-gray-800">High-Potential Candidates</h2>
              <div class="flex space-x-2">
                <div class="dropdown dropdown-bottom dropdown-end">
                  <label tabindex="0" class="btn btn-outline">
                    <i data-lucide="filter" class="w-4 h-4 mr-2"></i>
                    Filter
                  </label>
                  <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a onclick="filterCandidates('all')">All Candidates</a></li>
                    <li><a onclick="filterCandidates('ready')">Ready Now</a></li>
                    <li><a onclick="filterCandidates('1-2')">1-2 Years</a></li>
                    <li><a onclick="filterCandidates('developing')">Developing</a></li>
                  </ul>
                </div>
                <button class="btn btn-primary" onclick="addCandidateModal.showModal()">
                  <i data-lucide="user-plus" class="w-5 h-5 mr-2"></i>
                  Add Candidate
                </button>
              </div>
            </div>
            
            <div class="overflow-x-auto">
              <table class="table table-zebra w-full" id="candidates-table">
                <thead>
                  <tr>
                    <th>Employee</th>
                    <th>Current Position</th>
                    <th>Potential Role</th>
                    <th>Competency Score</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (count($candidates) === 0): ?>
                    <tr>
                      <td colspan="6" class="text-center py-5 text-gray-500">
                        <i data-lucide="users" class="w-12 h-12 mx-auto mb-3"></i>
                        <p>No candidates added yet</p>
                      </td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($candidates as $candidate): ?>
                      <tr class="fade-in">
                        <td>
                          <div class="flex items-center space-x-3">
                            <div class="avatar">
                              <div class="mask mask-squircle w-12 h-12 bg-primary text-white flex items-center justify-center">
                                <span class="text-lg font-bold"><?php echo $candidate['first_name'][0] . $candidate['last_name'][0]; ?></span>
                              </div>
                            </div>
                            <div>
                              <div class="font-bold"><?php echo $candidate['first_name'] . ' ' . $candidate['last_name']; ?></div>
                              <div class="text-sm opacity-50"><?php echo $candidate['department']; ?></div>
                            </div>
                          </div>
                        </td>
                        <td><?php echo $candidate['current_position']; ?></td>
                        <td><?php echo $candidate['potential_role']; ?></td>
                        <td>
                          <div class="flex items-center">
                            <div class="w-24 bg-gray-200 rounded-full h-2.5 mr-2">
                              <div class="bg-primary h-2.5 rounded-full progress-bar" style="width: <?php echo $candidate['competency_score']; ?>%"></div>
                            </div>
                            <span class="text-sm"><?php echo $candidate['competency_score']; ?>%</span>
                          </div>
                        </td>
                        <td>
                          <span class="badge badge-success badge-sm"><?php echo $candidate['readiness_timeline']; ?></span>
                        </td>
                        <td>
                          <button class="btn btn-ghost btn-xs">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                          </button>
                          <button class="btn btn-ghost btn-xs">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                          </button>
                          <button class="btn btn-ghost btn-xs">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </section>
        </div>
      </main>
    </div>
  </div>

  <!-- Modals -->
  <dialog id="createSurveyModal" class="modal">
    <div class="modal-box w-11/12 max-w-5xl">
      <h3 class="font-bold text-lg">Create New Survey</h3>
      <div class="py-4">
        <form id="survey-form" action="create_survey.php" method="POST">
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text">Survey Name</span>
            </label>
            <input type="text" name="survey_name" placeholder="Enter survey name" class="input input-bordered w-full" required />
          </div>
          
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text">Survey Type</span>
            </label>
            <select class="select select-bordered" name="survey_type" required>
              <option disabled selected>Select survey type</option>
              <option value="Manager Assessment">Manager Assessment</option>
              <option value="Peer Review">Peer Review</option>
              <option value="Mentor Evaluation">Mentor Evaluation</option>
              <option value="360 Feedback">360° Feedback</option>
            </select>
          </div>
          
          <div class="form-control mb-4">
            <label class="label">
              <span class="label-text">Competencies to Measure</span>
            </label>
            <div class="grid grid-cols-2 gap-2">
              <label class="cursor-pointer label justify-start">
                <input type="checkbox" name="competencies[]" value="Strategic Thinking" class="checkbox checkbox-primary mr-2" />
                <span class="label-text">Strategic Thinking</span>
              </label>
              <label class="cursor-pointer label justify-start">
                <input type="checkbox" name="competencies[]" value="Problem-Solving" class="checkbox checkbox-primary mr-2" />
                <span class="label-text">Problem-Solving</span>
              </label>
              <label class="cursor-pointer label justify-start">
                <input type="checkbox" name="competencies[]" value="Decision-Making" class="checkbox checkbox-primary mr-2" />
                <span class="label-text">Decision-Making</span>
              </label>
              <label class="cursor-pointer label justify-start">
                <input type="checkbox" name="competencies[]" value="Adaptability" class="checkbox checkbox-primary mr-2" />
                <span class="label-text">Adaptability</span>
              </label>
              <label class="cursor-pointer label justify-start">
                <input type="checkbox" name="competencies[]" value="Communication" class="checkbox checkbox-primary mr-2" />
                <span class="label-text">Communication</span>
              </label>
              <label class="cursor-pointer label justify-start">
                <input type="checkbox" name="competencies[]" value="Team Leadership" class="checkbox checkbox-primary mr-2" />
                <span class="label-text">Team Leadership</span>
              </label>
            </div>
          </div>
          
         

          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text">Due Date</span>
            </label>
            <input type="date" name="due_date" class="input input-bordered w-full" required />
          </div>
        </form>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-ghost">Cancel</button>
        </form>
        <button type="submit" form="survey-form" class="btn btn-primary">Create Survey</button>
      </div>
    </div>
  </dialog>

  <dialog id="addCandidateModal" class="modal">
    <div class="modal-box w-11/12 max-w-3xl">
      <h3 class="font-bold text-lg">Add New Candidate</h3>
      <div class="py-4">
        <form id="candidate-form" action="add_candidate.php" method="POST">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="form-control">
              <label class="label">
                <span class="label-text">First Name</span>
              </label>
              <input type="text" name="first_name" placeholder="Type here" class="input input-bordered" required />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Last Name</span>
              </label>
              <input type="text" name="last_name" placeholder="Type here" class="input input-bordered" required />
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="form-control">
              <label class="label">
                <span class="label-text">Current Position</span>
              </label>
              <input type="text" name="current_position" placeholder="Type here" class="input input-bordered" required />
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Department</span>
              </label>
              <select class="select select-bordered" name="department" required>
                <option disabled selected>Select department</option>
                <option value="Engineering">Engineering</option>
                <option value="Marketing">Marketing</option>
                <option value="Sales">Sales</option>
                <option value="Product">Product</option>
                <option value="HR">HR</option>
                <option value="Finance">Finance</option>
              </select>
            </div>
          </div>
          
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text">Potential Role</span>
            </label>
            <input type="text" name="potential_role" placeholder="Type here" class="input input-bordered w-full" required />
          </div>
          
          <div class="form-control w-full mb-4">
            <label class="label">
              <span class="label-text">Readiness Timeline</span>
            </label>
            <select class="select select-bordered" name="readiness_timeline" required>
              <option disabled selected>Select timeline</option>
              <option value="Ready Now">Ready Now</option>
              <option value="1-2 Years">1-2 Years</option>
              <option value="3-5 Years">3-5 Years</option>
              <option value="Developing">Developing</option>
            </select>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Key Strengths</span>
            </label>
            <textarea name="strengths" class="textarea textarea-bordered h-20" placeholder="List key strengths"></textarea>
          </div>

          <div class="form-control mt-4">
            <label class="label">
              <span class="label-text">Development Areas</span>
            </label>
            <textarea name="development_areas" class="textarea textarea-bordered h-20" placeholder="List development areas"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-action">
        <form method="dialog">
          <button class="btn btn-ghost">Cancel</button>
        </form>
        <button type="submit" form="candidate-form" class="btn btn-primary">Add Candidate</button>
      </div>
    </div>
  </dialog>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
  </script>

  <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>