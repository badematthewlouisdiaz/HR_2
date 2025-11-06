<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Employee Progress Tracking</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    .step-progress {
      display: flex;
      align-items: center;
      gap: 4px;
    }
    .step-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background-color: #e5e7eb;
    }
    .step-dot.completed {
      background-color: #10b981;
    }
    .step-dot.current {
      background-color: #3b82f6;
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
          <div class="flex justify-between items-center mb-6">
            <div>
              <h1 class="text-3xl font-bold mb-2">Employee Progress Tracking</h1>
              <p class="text-gray-600">Monitor employee learning progress and completion rates</p>
            </div>
            <div class="flex gap-2">
              <button class="btn btn-custom" onclick="window.location.href='learning_module_repository.php'">
                <i class="fas fa-arrow-left mr-2"></i>Back to Modules
              </button>
            </div>
          </div>
          
          <!-- Employee Progress Table -->
          <div class="card bg-base-100 shadow-md">
            <div class="card-body">
              <div class="flex justify-between items-center mb-4">
                <h2 class="card-title">Employee Learning Progress</h2>
                <div class="flex gap-2">
                  <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-custom">Filter by Module</label>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                      <li><a>All Modules</a></li>
                      <li><a>Employee Handbook</a></li>
                      <li><a>Safety Protocols</a></li>
                      <li><a>IT Security Guidelines</a></li>
                      <li><a>Customer Service Training</a></li>
                      <li><a>Food Safety Standards</a></li>
                      <li><a>Sales Techniques</a></li>
                    </ul>
                  </div>
                  <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-custom">Filter by Department</label>
                    <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                      <li><a>All Departments</a></li>
                      <li><a>Human Resources</a></li>
                      <li><a>Operations</a></li>
                      <li><a>Information Technology</a></li>
                      <li><a>Front Office</a></li>
                      <li><a>Kitchen</a></li>
                      <li><a>Sales & Marketing</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              
              <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                  <thead>
                    <tr>
                      <th>Employee Name</th>
                      <th>Department</th>
                      <th>Role</th>
                      <th>Learning Module</th>
                      <th>Progress (Steps)</th>
                      <th>Status</th>
                      <th>Last Activity</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-2@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">John Doe</div>
                            <div class="text-sm opacity-50">ID: EMP001</div>
                          </div>
                        </div>
                      </td>
                      <td>Human Resources</td>
                      <td>HR Manager</td>
                      <td>Employee Handbook</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <span class="text-sm ml-2">10/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-success">Completed</div></td>
                      <td>2023-11-15</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-3@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">Jane Smith</div>
                            <div class="text-sm opacity-50">ID: EMP002</div>
                          </div>
                        </div>
                      </td>
                      <td>Operations</td>
                      <td>Operations Manager</td>
                      <td>Safety Protocols</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <span class="text-sm ml-2">7/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-warning">InProgress</div></td>
                      <td>2023-11-14</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-4@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">Robert Johnson</div>
                            <div class="text-sm opacity-50">ID: EMP003</div>
                          </div>
                        </div>
                      </td>
                      <td>Information Technology</td>
                      <td>IT Specialist</td>
                      <td>IT Security Guidelines</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot current"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <span class="text-sm ml-2">6/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-warning">InProgress</div></td>
                      <td>2023-11-16</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-5@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">Emily Davis</div>
                            <div class="text-sm opacity-50">ID: EMP004</div>
                          </div>
                        </div>
                      </td>
                      <td>Front Office</td>
                      <td>Guest Service Agent</td>
                      <td>Customer Service Training</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <span class="text-sm ml-2">10/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-success">Completed</div></td>
                      <td>2023-11-13</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-1@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">Michael Wilson</div>
                            <div class="text-sm opacity-50">ID: EMP005</div>
                          </div>
                        </div>
                      </td>
                      <td>Kitchen</td>
                      <td>Line Cook</td>
                      <td>Food Safety Standards</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <span class="text-sm ml-2">4/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-warning">InProgress</div></td>
                      <td>2023-11-15</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-2@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">Sarah Brown</div>
                            <div class="text-sm opacity-50">ID: EMP006</div>
                          </div>
                        </div>
                      </td>
                      <td>Sales & Marketing</td>
                      <td>Sales Executive</td>
                      <td>Sales Techniques</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot completed"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <span class="text-sm ml-2">3/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-warning">InProgress</div></td>
                      <td>2023-11-16</td>
                    </tr>
                    <tr>
                      <td>
                        <div class="flex items-center gap-3">
                          <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                              <img src="https://img.daisyui.com/tailwind-css-component-profile-3@56w.png" alt="Avatar Tailwind CSS Component" />
                            </div>
                          </div>
                          <div>
                            <div class="font-bold">David Miller</div>
                            <div class="text-sm opacity-50">ID: EMP007</div>
                          </div>
                        </div>
                      </td>
                      <td>Operations</td>
                      <td>Maintenance Staff</td>
                      <td>Safety Protocols</td>
                      <td>
                        <div class="step-progress">
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <div class="step-dot"></div>
                          <span class="text-sm ml-2">0/10</span>
                        </div>
                      </td>
                      <td><div class="badge badge-error">NotStarted</div></td>
                      <td>2023-11-10</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>
</html>