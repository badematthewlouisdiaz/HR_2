<?php
session_start();

// Initialize empty jobs array if not set
if (!isset($_SESSION['jobs'])) {
    $_SESSION['jobs'] = [];
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Find and remove the job with the specified ID
    foreach ($_SESSION['jobs'] as $key => $job) {
        if ($job['id'] === $delete_id) {
            unset($_SESSION['jobs'][$key]);
            
            // Reindex array
            $_SESSION['jobs'] = array_values($_SESSION['jobs']);
            
            // Show success message
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Job has been deleted successfully.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = window.location.pathname;
                });
            </script>";
            break;
        }
    }
}

// Handle view action
$viewingJob = null;
if (isset($_GET['view_id'])) {
    $view_id = intval($_GET['view_id']);
    
    // Find the job with the specified ID
    foreach ($_SESSION['jobs'] as $job) {
        if ($job['id'] === $view_id) {
            $viewingJob = $job;
            break;
        }
    }
}
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
  <style>
    .competency-table {
      border-collapse: separate;
      border-spacing: 0;
    }
    .competency-table th {
      position: sticky;
      top: 0;
      z-index: 10;
      background-color: #f8fafc;
    }
    @media (max-width: 768px) {
      .competency-table thead {
        display: none;
      }
      .competency-table tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
      }
      .competency-table td {
        display: block;
        text-align: right;
        padding: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
      }
      .competency-table td:before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
        color: #6b7280;
      }
    }
    .job-card {
      transition: all 0.3s ease;
    }
    .job-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .hidden-row {
      display: none;
    }
    .empty-state {
      text-align: center;
      padding: 3rem;
      color: #6b7280;
    }
    .empty-state i {
      margin-bottom: 1rem;
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
      
      <div class="container mx-auto px-4 py-8">
        <!-- View Job Modal -->
        <?php if ($viewingJob): ?>
        <div class="modal modal-open">
          <div class="modal-box max-w-3xl">
            <h3 class="font-bold text-lg mb-4">Job Details: <?php echo htmlspecialchars($viewingJob['title']); ?></h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
              <div>
                <h4 class="font-semibold text-gray-700">Department</h4>
                <p><?php echo htmlspecialchars($viewingJob['department']); ?></p>
              </div>
              <div>
                <h4 class="font-semibold text-gray-700">Experience Level</h4>
                <p><?php echo htmlspecialchars($viewingJob['experience']); ?></p>
              </div>
            </div>
            
            <div class="mb-4">
              <h4 class="font-semibold text-gray-700">Description</h4>
              <p><?php echo htmlspecialchars($viewingJob['description']); ?></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <h4 class="font-semibold text-gray-700">Qualifications</h4>
                <ul class="list-disc list-inside">
                  <?php foreach ($viewingJob['qualifications'] as $qualification): ?>
                  <li><?php echo htmlspecialchars($qualification); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div>
                <h4 class="font-semibold text-gray-700">Requirements</h4>
                <ul class="list-disc list-inside">
                  <?php foreach ($viewingJob['requirements'] as $requirement): ?>
                  <li><?php echo htmlspecialchars($requirement); ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            
            <div class="modal-action">
              <a href="?" class="btn">Close</a>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <!-- Filters and Search -->
        <div class="bg-base-100 p-4 rounded-lg shadow-md mb-6">
          <div class="flex flex-col md:flex-row gap-4 items-center">
            <div class="flex-1 w-full">
              <div class="relative">
                <input type="text" id="searchInput" placeholder="Search jobs..." class="input input-bordered w-full pl-10">
                <i data-lucide="search" class="w-4 h-4 absolute left-3 top-3.5 text-gray-400"></i>
              </div>
            </div>
            <div class="flex flex-wrap gap-2">
              <select id="departmentFilter" class="select select-bordered select-sm">
                <option value="all">All Departments</option>
                <option value="Engineering">Engineering</option>
                <option value="Product">Product</option>
                <option value="Design">Design</option>
                <option value="Marketing">Marketing</option>
              </select>
              <select id="experienceFilter" class="select select-bordered select-sm">
                <option value="all">All Experience</option>
                <option value="Entry Level">Entry Level</option>
                <option value="Mid Level">Mid Level</option>
                <option value="Senior Level">Senior Level</option>
              </select>
              <button id="resetFilters" class="btn btn-sm btn-outline">
                <i data-lucide="refresh-cw" class="w-4 h-4 mr-1"></i> Reset
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <div class="stats shadow">
            <div class="stat">
              <div class="stat-figure text-primary">
                <i data-lucide="briefcase" class="w-8 h-8"></i>
              </div>
              <div class="stat-title">Total Jobs</div>
              <div class="stat-value" id="totalJobs"><?php echo count($_SESSION['jobs']); ?></div>
              <div class="stat-desc">All departments</div>
            </div>
          </div>
          
          <div class="stats shadow">
            <div class="stat">
              <div class="stat-figure text-secondary">
                <i data-lucide="users" class="w-8 h-8"></i>
              </div>
              <div class="stat-title">Engineering</div>
              <div class="stat-value" id="engineeringJobs">
                <?php 
                  $count = 0;
                  foreach ($_SESSION['jobs'] as $job) {
                    if ($job['department'] === 'Engineering') $count++;
                  }
                  echo $count;
                ?>
              </div>
              <div class="stat-desc">Technical roles</div>
            </div>
          </div>
          
          <div class="stats shadow">
            <div class="stat">
              <div class="stat-figure text-accent">
                <i data-lucide="palette" class="w-8 h-8"></i>
              </div>
              <div class="stat-title">Design</div>
              <div class="stat-value" id="designJobs">
                <?php 
                  $count = 0;
                  foreach ($_SESSION['jobs'] as $job) {
                    if ($job['department'] === 'Design') $count++;
                  }
                  echo $count;
                ?>
              </div>
              <div class="stat-desc">Creative roles</div>
            </div>
          </div>
          
          <div class="stats shadow">
            <div class="stat">
              <div class="stat-figure text-info">
                <i data-lucide="trending-up" class="w-8 h-8"></i>
              </div>
              <div class="stat-title">Product</div>
              <div class="stat-value" id="productJobs">
                <?php 
                  $count = 0;
                  foreach ($_SESSION['jobs'] as $job) {
                    if ($job['department'] === 'Product') $count++;
                  }
                  echo $count;
                ?>
              </div>
              <div class="stat-desc">Management roles</div>
            </div>
          </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="overflow-x-auto">
            <table class="table competency-table">
              <thead>
                <tr class="bg-base-200">
                  <th class="w-12"></th>
                  <th>Job Title</th>
                  <th>Department</th>
                  <th>Experience Level</th>
                  <th>Qualifications</th>
                  <th>Requirements</th>
                  <th class="w-28">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php if (count($_SESSION['jobs']) > 0): ?>
                  <?php foreach ($_SESSION['jobs'] as $job): 
                    // Determine icon and color based on department
                    $icon = 'briefcase';
                    $colorClass = 'bg-gray-100 text-gray-600';
                    
                    switch($job['department']) {
                      case 'Engineering':
                        $icon = 'code';
                        $colorClass = 'bg-blue-100 text-blue-600';
                        break;
                      case 'Product':
                        $icon = 'trending-up';
                        $colorClass = 'bg-purple-100 text-purple-600';
                        break;
                      case 'Design':
                        $icon = 'palette';
                        $colorClass = 'bg-pink-100 text-pink-600';
                        break;
                      case 'Marketing':
                        $icon = 'megaphone';
                        $colorClass = 'bg-red-100 text-red-600';
                        break;
                    }
                    
                    // Determine badge color based on experience
                    $badgeClass = 'badge-info';
                    if ($job['experience'] === 'Senior Level') $badgeClass = 'badge-warning';
                    if ($job['experience'] === 'Entry Level') $badgeClass = 'badge-success';
                    
                    // Determine department badge color
                    $deptBadgeClass = 'badge-primary';
                    if ($job['department'] === 'Product') $deptBadgeClass = 'badge-secondary';
                    if ($job['department'] === 'Design') $deptBadgeClass = 'badge-accent';
                    if ($job['department'] === 'Marketing') $deptBadgeClass = 'badge-error';
                  ?>
                  <tr class="job-card" data-department="<?php echo $job['department']; ?>" data-experience="<?php echo $job['experience']; ?>" data-search="<?php echo $job['title'] . ' ' . $job['description']; ?>">
                    <td></td>
                    <td data-label="Job Title">
                      <div class="flex items-center">
                        <div class="<?php echo $colorClass; ?> p-2 rounded-full mr-3">
                          <i data-lucide="<?php echo $icon; ?>" class="w-4 h-4"></i>
                        </div>
                        <div>
                          <div class="font-bold"><?php echo $job['title']; ?></div>
                          <div class="text-sm text-gray-500"><?php echo $job['description']; ?></div>
                        </div>
                      </div>
                    </td>
                    <td data-label="Department">
                      <span class="badge <?php echo $deptBadgeClass; ?> badge-sm"><?php echo $job['department']; ?></span>
                    </td>
                    <td data-label="Experience">
                      <span class="badge <?php echo $badgeClass; ?> badge-sm"><?php echo $job['experience']; ?></span>
                    </td>
                    <td data-label="Qualifications">
                      <div class="max-w-xs">
                        <ul class="text-sm">
                          <?php foreach ($job['qualifications'] as $qualification): ?>
                          <li class="flex items-start mb-1">
                            <i data-lucide="check-circle" class="w-3 h-3 text-success mt-1 mr-2 flex-shrink-0"></i>
                            <span><?php echo $qualification; ?></span>
                          </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Requirements">
                      <div class="max-w-xs">
                        <ul class="text-sm">
                          <?php foreach ($job['requirements'] as $requirement): ?>
                          <li class="flex items-start mb-1">
                            <i data-lucide="clipboard-check" class="w-3 h-3 text-info mt-1 mr-2 flex-shrink-0"></i>
                            <span><?php echo $requirement; ?></span>
                          </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </td>
                    <td data-label="Actions">
                      <div class="flex space-x-1">
                        <a href="?view_id=<?php echo $job['id']; ?>" class="btn btn-ghost btn-xs">
                          <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <button class="btn btn-ghost btn-xs" onclick="confirmDelete(<?php echo $job['id']; ?>, '<?php echo addslashes($job['title']); ?>')">
                          <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7">
                      <div class="empty-state py-12">
                        <i data-lucide="briefcase" class="w-16 h-16 mx-auto text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-500 mb-2">No jobs found</h3>
                        <p class="text-gray-400">Get started by adding your first job position.</p>
                      </div>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <?php if (count($_SESSION['jobs']) > 0): ?>
          <div class="flex justify-between items-center p-4 border-t">
            <div class="text-sm text-gray-500">
              Showing <span id="showingCount"><?php echo count($_SESSION['jobs']); ?></span> of <span id="totalCount"><?php echo count($_SESSION['jobs']); ?></span> results
            </div>
            <div class="btn-group">
              <button class="btn btn-sm btn-outline">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
              </button>
              <button class="btn btn-sm btn-active">1</button>
              <button class="btn btn-sm btn-outline">2</button>
              <button class="btn btn-sm btn-outline">3</button>
              <button class="btn btn-sm btn-outline">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
              </button>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('searchInput');
      const departmentFilter = document.getElementById('departmentFilter');
      const experienceFilter = document.getElementById('experienceFilter');
      const resetFilters = document.getElementById('resetFilters');
      const jobCards = document.querySelectorAll('.job-card');
      const totalJobs = document.getElementById('totalJobs');
      const engineeringJobs = document.getElementById('engineeringJobs');
      const designJobs = document.getElementById('designJobs');
      const productJobs = document.getElementById('productJobs');
      const showingCount = document.getElementById('showingCount');
      const totalCount = document.getElementById('totalCount');
      
      // Count jobs by department
      function countJobs() {
        let engineeringCount = 0;
        let designCount = 0;
        let productCount = 0;
        let marketingCount = 0;
        
        jobCards.forEach(card => {
          if (!card.classList.contains('hidden-row')) {
            const department = card.getAttribute('data-department');
            if (department === 'Engineering') engineeringCount++;
            if (department === 'Design') designCount++;
            if (department === 'Product') productCount++;
            if (department === 'Marketing') marketingCount++;
          }
        });
        
        engineeringJobs.textContent = engineeringCount;
        designJobs.textContent = designCount;
        productJobs.textContent = productCount;
        totalJobs.textContent = engineeringCount + designCount + productCount + marketingCount;
      }
      
      // Update showing count
      function updateShowingCount() {
        let visibleCount = 0;
        jobCards.forEach(card => {
          if (!card.classList.contains('hidden-row')) {
            visibleCount++;
          }
        });
        showingCount.textContent = visibleCount;
      }
      
      // Filter jobs based on criteria
      function filterJobs() {
        const searchText = searchInput.value.toLowerCase();
        const departmentValue = departmentFilter.value;
        const experienceValue = experienceFilter.value;
        
        jobCards.forEach(card => {
          const cardText = card.getAttribute('data-search').toLowerCase();
          const cardDepartment = card.getAttribute('data-department');
          const cardExperience = card.getAttribute('data-experience');
          
          const matchesSearch = searchText === '' || cardText.includes(searchText);
          const matchesDepartment = departmentValue === 'all' || cardDepartment === departmentValue;
          const matchesExperience = experienceValue === 'all' || cardExperience === experienceValue;
          
          if (matchesSearch && matchesDepartment && matchesExperience) {
            card.classList.remove('hidden-row');
          } else {
            card.classList.add('hidden-row');
          }
        });
        
        countJobs();
        updateShowingCount();
      }
      
      // Event listeners for filters
      searchInput.addEventListener('input', filterJobs);
      departmentFilter.addEventListener('change', filterJobs);
      experienceFilter.addEventListener('change', filterJobs);
      
      // Reset filters
      resetFilters.addEventListener('click', function() {
        searchInput.value = '';
        departmentFilter.value = 'all';
        experienceFilter.value = 'all';
        filterJobs();
      });
      
      // Initial count
      if (jobCards.length > 0) {
        countJobs();
        updateShowingCount();
        totalCount.textContent = jobCards.length;
      }
    });

    // Delete confirmation function
    function confirmDelete(id, title) {
      Swal.fire({
        title: 'Are you sure?',
        text: `You are about to delete the job: ${title}`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `?delete_id=${id}`;
        }
      });
    }
  </script>
  <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>