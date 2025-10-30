<?php

session_start();
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
  <style>
    .competency-badge {
      cursor: pointer;
      transition: all 0.2s;
    }
    .competency-badge:hover {
      transform: scale(1.05);
    }
    .fade-in {
      animation: fadeIn 0.5s;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
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

      <div class="bg-gray-50 min-h-screen p-6">
        <div class="container mx-auto max-w-9xl">
          <!-- Main content -->
          <div class="max-w-9xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <!-- Summary Cards -->
              <div class="stats shadow w-full">
                <div class="stat">
                  <div class="stat-figure text-primary">
                    <i data-lucide="users" class="w-8 h-8"></i>
                  </div>
                  <div class="stat-title">Total Employees</div>
                  <div class="stat-value text-primary" id="total-employees">142</div>
                  <div class="stat-desc">↗︎ 12% from last month</div>
                </div>
              </div>

              <div class="stats shadow w-full">
                <div class="stat">
                  <div class="stat-figure text-secondary">
                    <i data-lucide="briefcase" class="w-8 h-8"></i>
                  </div>
                  <div class="stat-title">Key Positions</div>
                  <div class="stat-value text-secondary" id="key-positions">24</div>
                  <div class="stat-desc"><span id="needing-successors">3</span> need successors</div>
                </div>
              </div>

              <div class="stats shadow w-full">
                <div class="stat">
                  <div class="stat-figure text-accent">
                    <i data-lucide="target" class="w-8 h-8"></i>
                  </div>
                  <div class="stat-title">Ready Now</div>
                  <div class="stat-value text-accent" id="ready-now">18</div>
                  <div class="stat-desc">Employees prepared for promotion</div>
                </div>
              </div>
            </div>

            <!-- Main dashboard -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mt-6">
              <!-- Position Matching -->
              <div class="card bg-base-100 shadow">
                <div class="card-body">
                  <h2 class="card-title">
                    <i data-lucide="briefcase" class="w-5 h-5"></i>
                    Position Succession Matching
                    <button class="btn btn-sm btn-outline btn-primary ml-auto" onclick="addPositionModal.showModal()">
                      <i data-lucide="plus" class="w-4 h-4"></i> Add Position
                    </button>
                  </h2>
                  
                  <div class="form-control w-full">
                    <label class="label">
                      <span class="label-text">Select Position</span>
                    </label>
                    <select class="select select-bordered" id="position-select">
                      <option disabled selected>Choose a position</option>
                      <!-- Position options will be populated here -->
                    </select>
                  </div>

                  <div class="mt-4">
                    <h3 class="font-semibold">Recommended Successors</h3>
                    <div class="overflow-x-auto mt-2">
                      <table class="table table-zebra table-sm" id="successor-table">
                        <thead>
                          <tr>
                            <th>Employee</th>
                            <th>Match Score</th>
                            <th>Readiness</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <!-- Successor data will be populated here -->
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mt-6">
              <div class="card bg-base-100 shadow">
                <div class="card-body">
                  <h2 class="card-title">
                    <i data-lucide="bar-chart" class="w-5 h-5"></i>
                    Readiness Status
                  </h2>
                  <div class="h-64 flex items-center justify-center">
                    <canvas id="readinessChart"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Add Employee Modal -->
          <dialog id="addEmployeeModal" class="modal">
            <div class="modal-box w-11/12 max-w-5xl">
              <h3 class="font-bold text-lg">Add New Employee</h3>
              <form id="add-employee-form" class="py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">First Name</span>
                    </label>
                    <input type="text" placeholder="First Name" class="input input-bordered" required />
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Last Name</span>
                    </label>
                    <input type="text" placeholder="Last Name" class="input input-bordered" required />
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Position</span>
                    </label>
                    <input type="text" placeholder="Position" class="input input-bordered" required />
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Department</span>
                    </label>
                    <select class="select select-bordered">
                      <option disabled selected>Select Department</option>
                      <option>Engineering</option>
                      <option>Marketing</option>
                      <option>Finance</option>
                      <option>HR</option>
                      <option>Operations</option>
                    </select>
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Competency Score</span>
                    </label>
                    <input type="number" min="0" max="100" placeholder="0-100" class="input input-bordered" id="competency-score" required />
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Readiness Status</span>
                    </label>
                    <select class="select select-bordered" id="readiness-status">
                      <option>Ready Now</option>
                      <option>Ready Future</option>
                      <option>1-2 Years</option>
                      <option>Not Ready</option>
                    </select>
                  </div>
                  <div class="form-control">
                    <label class="label">
                      <span class="label-text">Key Competencies</span>
                    </label>
                    <div class="flex flex-wrap gap-2 mb-2" id="competencies-container">
                      <span class="badge badge-primary gap-2 competency-badge">Leadership
                        <button type="button" onclick="removeCompetency(this)">×</button>
                      </span>
                      <span class="badge badge-primary gap-2 competency-badge">Strategic Thinking
                        <button type="button" onclick="removeCompetency(this)">×</button>
                      </span>
                    </div>
                    <div class="join w-full">
                      <input type="text" placeholder="Add competency" class="input input-bordered join-item w-full" id="competency-input" />
                      <button type="button" class="btn btn-primary join-item" onclick="addCompetency()">Add</button>
                    </div>
                  </div>
                </div>
                <div class="modal-action">
                  <button type="button" class="btn btn-ghost" onclick="addEmployeeModal.close()">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add Employee</button>
                </div>
              </form>
            </div>
          </dialog>

          <!-- Add Position Modal -->
          <dialog id="addPositionModal" class="modal">
            <div class="modal-box">
              <h3 class="font-bold text-lg">Add New Position</h3>
              <form id="add-position-form" class="py-4">
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Position Title</span>
                  </label>
                  <input type="text" placeholder="Position Title" class="input input-bordered" required />
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Department</span>
                  </label>
                  <select class="select select-bordered">
                    <option disabled selected>Select Department</option>
                    <option>Engineering</option>
                    <option>Marketing</option>
                    <option>Finance</option>
                    <option>HR</option>
                    <option>Operations</option>
                  </select>
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Critical Competencies</span>
                  </label>
                  <div class="flex flex-wrap gap-2 mb-2" id="position-competencies">
                    <span class="badge badge-primary gap-2 competency-badge">Leadership
                      <button type="button" onclick="removeCompetency(this)">×</button>
                    </span>
                    <span class="badge badge-primary gap-2 competency-badge">Strategic Thinking
                      <button type="button" onclick="removeCompetency(this)">×</button>
                    </span>
                  </div>
                  <div class="join w-full">
                    <input type="text" placeholder="Add competency" class="input input-bordered join-item w-full" id="position-competency-input" />
                    <button type="button" class="btn btn-primary join-item" onclick="addPositionCompetency()">Add</button>
                  </div>
                </div>
                <div class="form-control">
                  <label class="label">
                    <span class="label-text">Priority Level</span>
                  </label>
                  <select class="select select-bordered">
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                  </select>
                </div>
                <div class="modal-action">
                  <button type="button" class="btn btn-ghost" onclick="addPositionModal.close()">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add Position</button>
                </div>
              </form>
            </div>
          </dialog>

          <script>
            // Initialize Lucide icons
            lucide.createIcons();

            // Sample data for demonstration
            let employees = [
              { id: 1, name: "Sarah Johnson", position: "Senior Manager", competency: 92, status: "Ready Now", competencies: ["Leadership", "Strategic Thinking", "Communication"] },
              { id: 2, name: "Michael Chen", position: "Project Lead", competency: 88, status: "Ready Now", competencies: ["Technical Skills", "Problem Solving", "Project Management"] },
              { id: 3, name: "David Wilson", position: "Analyst", competency: 76, status: "1-2 Years", competencies: ["Data Analysis", "Technical Skills", "Reporting"] },
              { id: 4, name: "Emma Rodriguez", position: "Director", competency: 85, status: "Ready Future", competencies: ["Leadership", "Strategic Thinking", "Business Acumen"] }
            ];

            let positions = [
              { id: 1, title: "Chief Technology Officer", department: "Engineering", competencies: ["Leadership", "Strategic Thinking", "Technical Skills"], priority: "High" },
              { id: 2, title: "Director of Operations", department: "Operations", competencies: ["Leadership", "Process Improvement", "Strategic Thinking"], priority: "High" },
              { id: 3, title: "Senior Finance Manager", department: "Finance", competencies: ["Financial Analysis", "Strategic Thinking", "Leadership"], priority: "Medium" },
              { id: 4, title: "Marketing Director", department: "Marketing", competencies: ["Leadership", "Strategic Thinking", "Creativity"], priority: "Medium" }
            ];

            // DOM elements
            const positionSelect = document.getElementById('position-select');
            const successorTable = document.getElementById('successor-table');
            const addEmployeeModal = document.getElementById('addEmployeeModal');
            const addPositionModal = document.getElementById('addPositionModal');

            // Function to render position dropdown
            function renderPositionDropdown() {
              positionSelect.innerHTML = '<option disabled selected>Choose a position</option>';
              positions.forEach(position => {
                const option = document.createElement('option');
                option.value = position.id;
                option.textContent = position.title;
                positionSelect.appendChild(option);
              });
            }

            // Function to find successors for a position
            function findSuccessors(positionId) {
              const position = positions.find(p => p.id === parseInt(positionId));
              if (!position) return [];
              
              return employees.map(employee => {
                // Simple matching algorithm based on competency score and shared competencies
                const sharedCompetencies = employee.competencies.filter(c => 
                  position.competencies.includes(c)
                ).length;
                
                const matchScore = Math.min(100, employee.competency + (sharedCompetencies * 5));
                
                return {
                  employee,
                  matchScore,
                  readiness: employee.status
                };
              }).sort((a, b) => b.matchScore - a.matchScore);
            }

            // Function to render successor table
            function renderSuccessorTable(successors) {
              const tbody = successorTable.querySelector('tbody');
              tbody.innerHTML = '';
              
              successors.forEach(successor => {
                const statusClass = successor.readiness === "Ready Now" ? "badge-success" : 
                                  successor.readiness === "Ready Future" ? "badge-info" : 
                                  successor.readiness === "1-2 Years" ? "badge-warning" : "badge-error";
                
                const row = document.createElement('tr');
                row.innerHTML = `
                  <td>${successor.employee.name}</td>
                  <td>
                    <div class="radial-progress bg-primary text-primary-content border-4 border-primary" style="--value:${successor.matchScore}; --size:2rem;">
                      ${successor.matchScore}%
                    </div>
                  </td>
                  <td><div class="badge ${statusClass}">${successor.readiness}</div></td>
                  <td><button class="btn btn-xs btn-primary" onclick="viewEmployee(${successor.employee.id})">View Details</button></td>
                `;
                tbody.appendChild(row);
              });
            }

            // Function to add competency
            function addCompetency() {
              const input = document.getElementById('competency-input');
              const competency = input.value.trim();
              if (competency && !document.getElementById('competencies-container').textContent.includes(competency)) {
                const badge = document.createElement('span');
                badge.className = 'badge badge-primary gap-2 competency-badge';
                badge.innerHTML = `${competency} <button type="button" onclick="removeCompetency(this)">×</button>`;
                document.getElementById('competencies-container').appendChild(badge);
                input.value = '';
              }
            }

            // Function to add position competency
            function addPositionCompetency() {
              const input = document.getElementById('position-competency-input');
              const competency = input.value.trim();
              if (competency && !document.getElementById('position-competencies').textContent.includes(competency)) {
                const badge = document.createElement('span');
                badge.className = 'badge badge-primary gap-2 competency-badge';
                badge.innerHTML = `${competency} <button type="button" onclick="removeCompetency(this)">×</button>`;
                document.getElementById('position-competencies').appendChild(badge);
                input.value = '';
              }
            }

            // Function to remove competency
            function removeCompetency(button) {
              button.parentElement.remove();
            }

            // Function to view employee
            function viewEmployee(id) {
              const employee = employees.find(e => e.id === id);
              if (employee) {
                alert(`Viewing details for: ${employee.name}\nPosition: ${employee.position}\nCompetency: ${employee.competency}%\nStatus: ${employee.status}`);
              }
            }

            // Function to edit employee
            function editEmployee(id) {
              const employee = employees.find(e => e.id === id);
              if (employee) {
                alert(`Edit functionality would open for: ${employee.name}`);
                // In a real application, this would open a modal with the employee's data
              }
            }

            // Event listener for position selection
            positionSelect.addEventListener('change', function() {
              const positionId = this.value;
              const successors = findSuccessors(positionId);
              renderSuccessorTable(successors);
            });

            // Initialize charts
            function initCharts() {
              // Readiness chart
              const readinessCtx = document.getElementById('readinessChart').getContext('2d');
              new Chart(readinessCtx, {
                type: 'bar',
                data: {
                  labels: ['Ready Now', 'Ready Future', '1-2 Years', 'Not Ready'],
                  datasets: [{
                    label: 'Employees',
                    data: [18, 12, 8, 5],
                    backgroundColor: ['#22c55e', '#3b82f6', '#f59e0b', '#ef4444']
                  }]
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                    y: {
                      beginAtZero: true
                    }
                  },
                  plugins: {
                    legend: {
                      display: false
                    }
                  }
                }
              });
            }

            // Form submission handlers
            document.getElementById('add-employee-form').addEventListener('submit', function(e) {
              e.preventDefault();
              // In a real application, you would process the form data here
              const newId = employees.length > 0 ? Math.max(...employees.map(e => e.id)) + 1 : 1;
              const newEmployee = {
                id: newId,
                name: "New Employee", // Would come from form fields
                position: "New Position", // Would come from form fields
                competency: parseInt(document.getElementById('competency-score').value),
                status: document.getElementById('readiness-status').value,
                competencies: Array.from(document.getElementById('competencies-container').querySelectorAll('.competency-badge'))
                  .map(badge => badge.textContent.replace('×', '').trim())
              };
              
              employees.push(newEmployee);
              addEmployeeModal.close();
              
              // Show success message
              alert('Employee added successfully!');
            });

            document.getElementById('add-position-form').addEventListener('submit', function(e) {
              e.preventDefault();
              // In a real application, you would process the form data here
              addPositionModal.close();
              // Show success message
              alert('Position added successfully!');
            });

            // Initialize the application
            function init() {
              renderPositionDropdown();
              initCharts();
              
              // Set up first position as default
              if (positions.length > 0) {
                positionSelect.value = positions[0].id;
                const successors = findSuccessors(positions[0].id);
                renderSuccessorTable(successors);
              }
            }

            // Run initialization when page loads
            document.addEventListener('DOMContentLoaded', init);
          </script>
        </div>
      </div>
    </div>
  </div>
</body>
 <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</html>