<?php
session_start();
include("../db.php");

// Fetch competencies from database
$competencies = [];
$sql = "SELECT * FROM competency_management ORDER BY category, competency_name";
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $competencies[] = $row;
    }
}

// Calculate stats
$totalCompetencies = count($competencies);
$avgRating = 0;
$progressPercentage = 0;

if ($totalCompetencies > 0) {
    $totalProficiency = 0;
    $totalRequired = 0;
    $achievedRequired = 0;
    
    foreach ($competencies as $comp) {
        $totalProficiency += $comp['proficiency_level'];
        $totalRequired += $comp['required_level'];
        
        if ($comp['proficiency_level'] >= $comp['required_level']) {
            $achievedRequired++;
        }
    }
    
    $avgRating = round($totalProficiency / $totalCompetencies, 1);
    $progressPercentage = round(($achievedRequired / $totalCompetencies) * 100);
}

// Get next assessment date (if any)
$nextAssessment = null;
foreach ($competencies as $comp) {
    if (!empty($comp['assessed_date'])) {
        $date = strtotime($comp['assessed_date']);
        $futureDate = strtotime('+6 months', $date);
        if ($futureDate > time() && (!$nextAssessment || $futureDate < $nextAssessment)) {
            $nextAssessment = $futureDate;
        }
    }
}

$nextAssessmentFormatted = $nextAssessment ? date('M j, Y', $nextAssessment) : 'Not scheduled';
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Competency Management</title>
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
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../navbar.php'; ?>

  <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
      <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Competency Management</h1>
        <p class="text-gray-500 mt-2">Track and develop your professional skills and competencies</p>
      </div>
      <button class="btn btn-primary mt-4 sm:mt-0" onclick="openAssessmentModal()">
        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
        New Assessment
      </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
      <!-- Average Rating Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-4">
          <div class="p-2 rounded-lg bg-blue-100">
            <i data-lucide="star" class="w-5 h-5 text-blue-600"></i>
          </div>
          <h2 class="text-lg font-semibold ml-3">Average Rating</h2>
        </div>
        <div class="flex flex-wrap items-center gap-3">
          <div class="flex space-x-1">
            <?php
            $maxRating = 5;
            for ($i = 1; $i <= $maxRating; $i++) {
                $isSelected = $i <= floor($avgRating);
                $isPartial = ($i - 1 < $avgRating && $i > $avgRating);
                
                echo '<div class="rating-circle ' . ($isSelected ? 'selected' : ($i > $avgRating ? 'inactive' : '')) . '">' . $i . '</div>';
            }
            ?>
          </div>
          <span class="text-xl font-bold text-gray-800"><?php echo $avgRating; ?> / <?php echo $maxRating; ?></span>
        </div>
        <p class="text-sm text-gray-500 mt-2">Based on <?php echo $totalCompetencies; ?> competencies</p>
      </div>

      <!-- Competency Progress Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-4">
          <div class="p-2 rounded-lg bg-green-100">
            <i data-lucide="trending-up" class="w-5 h-5 text-green-600"></i>
          </div>
          <h2 class="text-lg font-semibold ml-3">Competency Progress</h2>
        </div>
        <div class="mb-2">
          <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2.5 rounded-full" style="width: <?php echo $progressPercentage; ?>%"></div>
          </div>
        </div>
        <div class="flex justify-between items-center">
          <p class="text-sm text-gray-600">Progress towards target levels</p>
          <span class="text-sm font-semibold text-gray-800"><?php echo $progressPercentage; ?>%</span>
        </div>
      </div>

      <!-- Next Assessment Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center mb-4">
          <div class="p-2 rounded-lg bg-amber-100">
            <i data-lucide="calendar" class="w-5 h-5 text-amber-600"></i>
          </div>
          <h2 class="text-lg font-semibold ml-3">Next Assessment</h2>
        </div>
        <div class="flex items-center mb-3">
          <div class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
            <?php echo $nextAssessmentFormatted; ?>
          </div>
        </div>
        <p class="text-sm text-gray-600">Prepare for your next competency review</p>
        <button class="btn btn-sm btn-outline btn-primary mt-4">
          <i data-lucide="bell" class="w-4 h-4 mr-1"></i>
          Set Reminder
        </button>
      </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 border border-gray-100">
      <div class="relative w-full sm:w-2/3">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
          <i data-lucide="search" class="w-5 h-5"></i>
        </span>
        <input type="text" id="searchInput" class="input input-bordered w-full pl-10" placeholder="Search competencies..." onkeyup="filterCompetencies()" />
      </div>
      <div class="flex items-center gap-2 w-full sm:w-auto">
        <select id="categoryFilter" class="select select-bordered w-full sm:w-48 font-medium" onchange="filterCompetencies()">
          <option value="all">All Competencies</option>
          <option value="Technical">Technical</option>
          <option value="Core">Core</option>
          <option value="Soft Skills">Soft Skills</option>
          <option value="Management">Management</option>
        </select>
        <button class="btn btn-ghost">
          <i data-lucide="filter" class="w-5 h-5 text-gray-500"></i>
        </button>
      </div>
    </div>

    <!-- Competency List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100" id="competencyList">
      <?php
      $categories = [];
      foreach ($competencies as $comp) {
          if (!in_array($comp['category'], $categories)) {
              $categories[] = $comp['category'];
          }
      }
      
      foreach ($categories as $category) {
          echo "<!-- $category -->";
          foreach ($competencies as $comp) {
              if ($comp['category'] !== $category) continue;
              
              $badgeClass = '';
              switch($comp['category']) {
                  case 'Technical': $badgeClass = 'badge-technical'; break;
                  case 'Core': $badgeClass = 'badge-core'; break;
                  case 'Soft Skills': $badgeClass = 'badge-soft'; break;
                  case 'Management': $badgeClass = 'badge-management'; break;
                  default: $badgeClass = 'badge-technical';
              }
              
              $lastAssessed = !empty($comp['assessed_date']) ? date('M j, Y', strtotime($comp['assessed_date'])) : 'Not assessed';
              $nextAssessment = !empty($comp['assessed_date']) ? date('M j, Y', strtotime('+6 months', strtotime($comp['assessed_date']))) : 'Not scheduled';
              
              echo '
              <div class="competency-item border-b border-gray-100 last:border-b-0" data-category="' . htmlspecialchars($comp['category']) . '" data-name="' . htmlspecialchars(strtolower($comp['competency_name'])) . '">
                <div class="flex flex-col md:flex-row md:items-center justify-between p-6 cursor-pointer hover:bg-gray-50 transition-colors">
                  <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                      <h3 class="font-semibold text-lg text-gray-800">' . htmlspecialchars($comp['competency_name']) . '</h3>
                      <span class="badge ' . $badgeClass . ' text-xs px-2.5 py-1 rounded-full">' . htmlspecialchars($comp['category']) . '</span>
                    </div>
                    <p class="text-sm text-gray-600">' . htmlspecialchars($comp['competency_name']) . ' competency</p>
                  </div>
                  <div class="flex items-center mt-4 md:mt-0">
                    <div class="flex space-x-1 mr-4">';
              
              $maxRating = 5;
              for ($i = 1; $i <= $maxRating; $i++) {
                  $isSelected = $i <= $comp['proficiency_level'];
                  echo '<div class="rating-circle ' . ($isSelected ? 'selected' : '') . '">' . $i . '</div>';
              }
              
              echo '
                    </div>
                    <span class="dropdown-arrow transition-transform duration-300">
                      <i data-lucide="chevron-down" class="w-5 h-5 text-gray-500"></i>
                    </span>
                  </div>
                </div>
                
                <!-- Dropdown Content -->
                <div class="dropdown-content bg-gray-50">
                  <div class="px-6 pb-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Assessment Details -->
                    <div class="bg-white p-5 rounded-lg shadow-xs border border-gray-100">
                      <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                        <i data-lucide="clipboard-list" class="w-5 h-5 text-blue-600"></i>
                        Assessment Details
                      </h3>
                      
                      <div class="space-y-4">
                        <div>
                          <h4 class="text-sm font-medium text-gray-500 mb-1">Current Level</h4>
                          <p class="font-semibold text-gray-800">' . $comp['proficiency_level'] . ' - ' . getProficiencyDescription($comp['proficiency_level']) . '</p>
                        </div>
                        
                        <div>
                          <h4 class="text-sm font-medium text-gray-500 mb-1">Target Level</h4>
                          <p class="font-semibold text-gray-800">' . $comp['required_level'] . ' - ' . getProficiencyDescription($comp['required_level']) . '</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                          <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Last Assessment</h4>
                            <p class="text-sm font-medium text-gray-800">' . $lastAssessed . '</p>
                          </div>
                          <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Next Assessment</h4>
                            <p class="text-sm font-medium text-gray-800">' . $nextAssessment . '</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Development Plan -->
                    <div class="bg-white p-5 rounded-lg shadow-xs border border-gray-100">
                      <h3 class="font-semibold text-lg mb-4 flex items-center gap-2">
                        <i data-lucide="target" class="w-5 h-5 text-green-600"></i>
                        Development Plan
                      </h3>
                      
                      <div class="space-y-4">
                        <div>
                          <h4 class="text-sm font-medium text-gray-500 mb-1">Gap Analysis</h4>
                          <p class="text-sm text-gray-700">';
              
              $gap = $comp['required_level'] - $comp['proficiency_level'];
              if ($gap > 0) {
                  echo 'You need to improve by ' . $gap . ' level' . ($gap > 1 ? 's' : '') . ' to meet the target.';
              } else if ($gap < 0) {
                  echo 'You exceed the target requirement by ' . abs($gap) . ' level' . (abs($gap) > 1 ? 's' : '') . '.';
              } else {
                  echo 'You have met the target requirement.';
              }
              
              echo '</p>
                        </div>
                        
                        <div>
                          <h4 class="text-sm font-medium text-gray-500 mb-2">Recommended Actions</h4>
                          <ol class="list-decimal list-inside text-sm text-gray-700 space-y-1">
                            <li>Review competency framework guidelines</li>
                            <li>Discuss development plan with your manager</li>
                            <li>Identify relevant training opportunities</li>
                          </ol>
                        </div>
                        
                        <div class="pt-2">
                          <button class="btn btn-outline btn-primary btn-sm w-full">
                            <i data-lucide="book-open" class="w-4 h-4 mr-2"></i>
                            View Learning Resources
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>';
          }
      }
      
      if (empty($competencies)) {
          echo '
          <div class="p-8 text-center">
            <i data-lucide="clipboard-list" class="w-12 h-12 text-gray-300 mx-auto"></i>
            <h3 class="mt-4 text-lg font-medium text-gray-500">No competencies found</h3>
            <p class="mt-2 text-gray-400">You don\'t have any competency assessments yet.</p>
            <button class="btn btn-primary mt-4" onclick="openAssessmentModal()">
              <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
              Add Your First Assessment
            </button>
          </div>';
      }
      
      function getProficiencyDescription($level) {
          $descriptions = [
              1 => 'Basic awareness',
              2 => 'Novice - limited experience',
              3 => 'Intermediate - applied experience',
              4 => 'Advanced - can guide others',
              5 => 'Expert - recognized authority'
          ];
          return isset($descriptions[$level]) ? $descriptions[$level] : 'Not specified';
      }
      ?>
    </div>
  </main>

 <!-- Assessment Modal -->
<div id="assessmentModal" class="modal modal-bottom sm:modal-middle">
  <div class="modal-box">
    <h3 class="font-bold text-lg">New Competency Assessment</h3>
    
    <form action="sub-modules/save_assessment.php" method="POST" class="space-y-4">

  <!-- Competency Name -->
  <div class="form-control">
    <label class="label"><span class="label-text">Competency Name</span></label>
    <input type="text" name="competency_name" class="input input-bordered" required>
  </div>

  <!-- Category -->
  <div class="form-control">
    <label class="label"><span class="label-text">Category</span></label>
    <select name="category" class="select select-bordered" required>
      <option value="">-- Select Category --</option>
      <option value="Technical">Technical</option>
      <option value="Core">Core</option>
      <option value="Soft Skills">Soft Skills</option>
      <option value="Management">Management</option>
    </select>
  </div>

  <!-- Proficiency Level -->
  <div class="form-control">
    <label class="label"><span class="label-text">Proficiency Level (1-5)</span></label>
    <input type="number" name="proficiency_level" min="1" max="5" class="input input-bordered" required>
  </div>

  <!-- Required Level -->
  <div class="form-control">
    <label class="label"><span class="label-text">Required Level (1-5)</span></label>
    <input type="number" name="required_level" min="1" max="5" class="input input-bordered" required>
  </div>

  <!-- Required Value -->
  <div class="form-control">
    <label class="label"><span class="label-text">Required Value (1-5)</span></label>
    <input type="number" name="required_value" min="1" max="5" class="input input-bordered" required>
  </div>

  <!-- Assessment Date -->
  <div class="form-control">
    <label class="label"><span class="label-text">Assessment Date</span></label>
    <input type="date" name="assessed_date" class="input input-bordered" required>
  </div>

  <!-- Submit -->
  <button type="submit" class="btn btn-primary w-full">Save Competency</button>
</form>

  </div>
</div>

    </div>
  </div>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#3b82f6',
            secondary: '#2563eb',
          }
        }
      }
    }
    
    function openAssessmentModal() {
      document.getElementById('assessmentModal').classList.add('modal-open');
    }
    
    function closeAssessmentModal() {
      document.getElementById('assessmentModal').classList.remove('modal-open');
    }
    
    function filterCompetencies() {
      const searchText = document.getElementById('searchInput').value.toLowerCase();
      const categoryFilter = document.getElementById('categoryFilter').value;
      const competencies = document.querySelectorAll('.competency-item');
      
      competencies.forEach(comp => {
        const name = comp.getAttribute('data-name');
        const category = comp.getAttribute('data-category');
        
        const matchesSearch = name.includes(searchText);
        const matchesCategory = categoryFilter === 'all' || category === categoryFilter;
        
        if (matchesSearch && matchesCategory) {
          comp.style.display = 'block';
        } else {
          comp.style.display = 'none';
        }
      });
    }
  </script>
  
  <style>
    :root {
      --primary: #3b82f6;
      --primary-light: #eff6ff;
      --secondary: #2563eb;
      --success: #10b981;
      --warning: #f59e0b;
      --error: #ef4444;
    }
    
    body {
      font-family: 'Inter', sans-serif;
    }
    
    .rating-circle {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 500;
      font-size: 14px;
      border: 1.5px solid #dbeafe;
      background: #f1f5fd;
      color: #3b82f6;
      transition: all 0.2s ease;
    }
    
    .rating-circle.selected {
      background: #3b82f6;
      color: white;
      border-color: #3b82f6;
      box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
    }
    
    .rating-circle.inactive {
      background: #f3f4f6;
      color: #d1d5db;
      border-color: #e5e7eb;
    }
    
    .badge-technical {
      background: #eff6ff;
      color: #2563eb;
      font-weight: 500;
    }
    
    .badge-core {
      background: #dcfce7;
      color: #16a34a;
      font-weight: 500;
    }
    
    .badge-soft {
      background: #f3e8ff;
      color: #a21caf;
      font-weight: 500;
    }
    
    .badge-management {
      background: #fef9c3;
      color: #b45309;
      font-weight: 500;
    }
    
    .dropdown-arrow.open {
      transform: rotate(180deg);
    }
    
    .dropdown-content {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease;
    }
    
    .dropdown-content.open {
      max-height: 1000px;
    }
    
    .modal {
      visibility: hidden;
      opacity: 0;
      transition: all 0.3s ease;
    }
    
    .modal.modal-open {
      visibility: visible;
      opacity: 1;
    }
    
    @media (max-width: 640px) {
      .rating-circle {
        width: 28px;
        height: 28px;
        font-size: 12px;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Lucide icons
      lucide.createIcons();
      
      const competencyItems = document.querySelectorAll('.competency-item');
      
      competencyItems.forEach(item => {
        const header = item.querySelector('.cursor-pointer');
        const arrow = item.querySelector('.dropdown-arrow');
        const content = item.querySelector('.dropdown-content');
        
        header.addEventListener('click', () => {
          // Close all other open items
          competencyItems.forEach(otherItem => {
            if (otherItem !== item) {
              otherItem.querySelector('.dropdown-content').classList.remove('open');
              otherItem.querySelector('.dropdown-arrow').classList.remove('open');
            }
          });
          
          // Toggle current item
          content.classList.toggle('open');
          arrow.classList.toggle('open');
        });
      });
    });
  </script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const assessmentForm = document.getElementById('assessmentForm');
    
    if (assessmentForm) {
        assessmentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            const submitBtn = assessmentForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i data-lucide="loader" class="w-4 h-4 mr-2 animate-spin"></i> Saving...';
            submitBtn.disabled = true;
            
            // Submit form via AJAX
            fetch('sub-modules/save_assessment.php', {
                method: 'POST',
                body: new FormData(assessmentForm)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Close modal and refresh page
                        closeAssessmentModal();
                        location.reload();
                    });
                } else {
                    // Show error message
                    let errorMessage = data.message;
                    if (data.errors) {
                        errorMessage += '<br><br>' + data.errors.join('<br>');
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred: ' + error
                });
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
  <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>