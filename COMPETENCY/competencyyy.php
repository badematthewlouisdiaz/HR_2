<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Competency Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="../soliera.css">
  <link rel="stylesheet" href="../sidebar.css">
  <style>
    .fade-in { animation: fadeIn 0.5s; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .progress-bar {
      height: 8px;
      border-radius: 4px;
      background: #e5e7eb;
      overflow: hidden;
    }
    .progress-value {
      height: 100%;
      border-radius: 4px;
      transition: width 0.3s ease;
    }
    .competency-card {
      transition: all 0.3s ease;
    }
    .competency-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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

      <!-- Page Content -->
      <div class="container mx-auto max-w-9xl p-6">

        <!-- Overview Tab -->
        <div class="tab-content active" id="overview">
          <div class="card bg-base-100 shadow">
            <div class="card-body">
              <h2 class="card-title">
                <i data-lucide="users" class="w-5 h-5"></i>
                Employee Competency Overview
                <button class="btn btn-sm btn-outline btn-primary ml-auto" onclick="addEmployeeModal.showModal()">
                  <i data-lucide="plus" class="w-4 h-4"></i> Add Employee
                </button>
              </h2>
              <div class="overflow-x-auto">
                <table class="table table-zebra">
                  <thead>
                    <tr>
                      <th>Employee</th>
                      <th>Position</th>
                      <th>Performance</th>
                      <th>Competency Score</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody id="employee-table-body">
                    <!-- Employee data will be populated here -->
                  </tbody>
                </table>
              </div>
              <div class="card-actions justify-end mt-4">
                <button class="btn btn-primary btn-sm">View All Employees</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Add Employee Modal -->
      <dialog id="addEmployeeModal" class="modal">
        <div class="modal-box w-11/12 max-w-3xl">
          <h3 class="font-bold text-lg">Add New Employee</h3>
          <form id="add-employee-form" class="py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label"><span class="label-text">First Name</span></label>
                <input type="text" placeholder="First Name" class="input input-bordered" id="first-name" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Last Name</span></label>
                <input type="text" placeholder="Last Name" class="input input-bordered" id="last-name" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Position</span></label>
                <input type="text" placeholder="Position" class="input input-bordered" id="position" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Department</span></label>
                <select class="select select-bordered" id="department">
                  <option disabled selected>Select Department</option>
                  <option>Engineering</option>
                  <option>Marketing</option>
                  <option>Finance</option>
                  <option>HR</option>
                  <option>Operations</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Performance Rating</span></label>
                <input type="range" min="1" max="5" value="3" class="range range-primary" step="1" id="performance-range" />
                <div class="w-full flex justify-between text-xs px-2">
                  <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                </div>
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Competency Score</span></label>
                <input type="number" min="0" max="100" placeholder="0-100" class="input input-bordered" id="competency-score" required />
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Readiness Status</span></label>
                <select class="select select-bordered" id="readiness-status">
                  <option>Ready Now</option>
                  <option>Ready Future</option>
                  <option>1-2 Years</option>
                  <option>Not Ready</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label"><span class="label-text">Key Competencies</span></label>
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
  </div>
  <script>
    lucide.createIcons();

    // Sample data (replace with real backend in production)
    let employees = [
      { id: 1, name: "Sarah Johnson", position: "Senior Manager", performance: 4, competency: 92, status: "Ready Now", competencies: ["Leadership", "Strategic Thinking", "Communication"] },
      { id: 2, name: "Michael Chen", position: "Project Lead", performance: 5, competency: 88, status: "Ready Now", competencies: ["Technical Skills", "Problem Solving", "Project Management"] },
      { id: 3, name: "David Wilson", position: "Analyst", performance: 3, competency: 76, status: "1-2 Years", competencies: ["Data Analysis", "Technical Skills", "Reporting"] },
      { id: 4, name: "Emma Rodriguez", position: "Director", performance: 4, competency: 85, status: "Ready Future", competencies: ["Leadership", "Strategic Thinking", "Business Acumen"] }
    ];

    // Tab functionality
    document.querySelectorAll('.tabs a').forEach(tab => {
      tab.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Update active tab
        document.querySelectorAll('.tabs a').forEach(t => t.classList.remove('tab-active'));
        tab.classList.add('tab-active');
        
        // Show active content
        const tabId = tab.getAttribute('data-tab');
        document.querySelectorAll('.tab-content').forEach(content => {
          content.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');
      });
    });

    function renderEmployeeTable() {
      const employeeTableBody = document.getElementById('employee-table-body');
      employeeTableBody.innerHTML = '';
      employees.forEach(employee => {
        const statusClass = employee.status === "Ready Now" ? "badge-success"
          : employee.status === "Ready Future" ? "badge-info"
          : employee.status === "1-2 Years" ? "badge-warning"
          : "badge-error";

        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${employee.name}</td>
          <td>${employee.position}</td>
          <td>
            <div class="rating rating-sm">
              ${Array(5).fill(0).map((_, i) =>
                `<input type="radio" name="rating-${employee.id}" class="mask mask-star-2 bg-orange-400" ${i < employee.performance ? 'checked' : ''} disabled />`
              ).join('')}
            </div>
          </td>
          <td>
            <div class="radial-progress bg-primary text-primary-content border-4 border-primary" style="--value:${employee.competency}; --size:2rem;">
              ${employee.competency}%
            </div>
          </td>
          <td><div class="badge ${statusClass}">${employee.status}</div></td>
          <td>
            <button class="btn btn-xs btn-info" onclick="viewEmployee(${employee.id})">View</button>
            <button class="btn btn-xs btn-warning" onclick="editEmployee(${employee.id})">Edit</button>
          </td>
        `;
        employeeTableBody.appendChild(row);
      });

      // Populate employee selects in other tabs
      const employeeSelects = document.querySelectorAll('select[id$="employee-select"], #training-employee-select, #tracking-employee-select');
      employeeSelects.forEach(select => {
        select.innerHTML = '<option disabled selected>Select an employee</option>' +
          employees.map(e => `<option value="${e.id}">${e.name} - ${e.position}</option>`).join('');
      });
    }

    // Modal competency badge add/remove
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
    function removeCompetency(button) {
      button.parentElement.remove();
    }

    // Competency requirement functionality
    function addCompetencyRequirement() {
      const container = document.getElementById('required-competencies-container');
      const newId = 'comp-' + Date.now();
      
      const requirementElement = document.createElement('div');
      requirementElement.className = 'competency-card bg-base-100 p-4 rounded-lg shadow-sm';
      requirementElement.innerHTML = `
        <div class="flex justify-between items-start mb-3">
          <h4 class="font-medium">New Competency Requirement</h4>
          <button type="button" class="btn btn-xs btn-ghost text-error" onclick="this.parentElement.parentElement.remove()">
            <i data-lucide="trash-2" class="w-4 h-4"></i>
          </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Competency Name</span>
            </label>
            <input type="text" class="input input-bordered input-sm" placeholder="Competency name" />
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Required Proficiency Level</span>
            </label>
            <select class="select select-bordered select-sm">
              <option>Basic</option>
              <option>Intermediate</option>
              <option>Advanced</option>
              <option>Expert</option>
            </select>
          </div>
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Description</span>
          </label>
          <textarea class="textarea textarea-bordered textarea-sm" placeholder="Describe this competency requirement..."></textarea>
        </div>
      `;
      
      container.appendChild(requirementElement);
      lucide.createIcons();
    }

    // Training activity functionality
    function addTrainingActivity() {
      const container = document.getElementById('training-activities-container');
      
      const activityElement = document.createElement('div');
      activityElement.className = 'bg-base-100 p-3 rounded-lg';
      activityElement.innerHTML = `
        <div class="flex justify-between items-start mb-2">
          <h5 class="font-medium">New Training Activity</h5>
          <button type="button" class="btn btn-xs btn-ghost text-error" onclick="this.parentElement.parentElement.remove()">
            <i data-lucide="trash-2" class="w-3 h-3"></i>
          </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
          <div class="form-control">
            <input type="text" class="input input-bordered input-sm" placeholder="Activity name" />
          </div>
          <div class="form-control">
            <select class="select select-bordered select-sm">
              <option>Online Course</option>
              <option>Workshop</option>
              <option>On-the-job Training</option>
              <option>Mentoring</option>
              <option>Conference</option>
              <option>Self-study</option>
            </select>
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-2">
          <div class="form-control">
            <input type="number" class="input input-bordered input-sm" placeholder="Estimated hours" />
          </div>
          <div class="form-control">
            <input type="text" class="input input-bordered input-sm" placeholder="Resource/Link" />
          </div>
        </div>
      `;
      
      container.appendChild(activityElement);
      lucide.createIcons();
    }

    // Employee view/edit handlers
    function viewEmployee(id) {
      const employee = employees.find(e => e.id === id);
      if (employee) {
        alert(`Viewing details for: ${employee.name}\nPosition: ${employee.position}\nPerformance: ${employee.performance}/5\nCompetency: ${employee.competency}%\nStatus: ${employee.status}`);
      }
    }
    function editEmployee(id) {
      const employee = employees.find(e => e.id === id);
      if (employee) {
        alert(`Edit functionality would open for: ${employee.name}`);
        // In a real application, this would open a modal with the employee's data
      }
    }

    // Generate training plan from gap analysis
    function generateTrainingPlan() {
      // This would use the gap analysis data to create a training plan
      alert("Training plan would be generated based on competency gaps");
      // Switch to training tab
      document.querySelector('[data-tab="training"]').click();
    }

    // Add Employee Form
    document.getElementById('add-employee-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const newId = employees.length > 0 ? Math.max(...employees.map(e => e.id)) + 1 : 1;
      const newEmployee = {
        id: newId,
        name: document.getElementById('first-name').value + " " + document.getElementById('last-name').value,
        position: document.getElementById('position').value,
        performance: parseInt(document.getElementById('performance-range').value),
        competency: parseInt(document.getElementById('competency-score').value),
        status: document.getElementById('readiness-status').value,
        competencies: Array.from(document.getElementById('competencies-container').querySelectorAll('.competency-badge'))
          .map(badge => badge.textContent.replace('×', '').trim())
      };
      employees.push(newEmployee);
      renderEmployeeTable();
      addEmployeeModal.close();
      alert('Employee added successfully!');
    });

    document.addEventListener('DOMContentLoaded', function() {
      lucide.createIcons();
      renderEmployeeTable();
      
      // Initialize with some competency requirements
      addCompetencyRequirement();
    });
  </script>
  <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>