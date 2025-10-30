<?php

session_start()
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Time & Attendance</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.6.0/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#9333ea',
                        accent: '#ec4899',
                        neutral: '#1f2937',
                        info: '#06b6d4',
                        success: '#10b981',
                        warning: '#f59e0b',
                        error: '#ef4444',
                    }
                }
            }
        }
    </script>
</head>
            <!-- Main content -->
            <main class="p-6">
                <!-- Page header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Welcome, Mark Nathaniel</h1>
                        <p class="text-sm text-gray-600">Position: <span class="font-semibold text-primary">HR Manager Candidate</span></p>
                    </div>
                    <div class="flex gap-2">
                        <button class="btn btn-primary" onclick="progressModal.showModal()">
                            <i class="fas fa-chart-line mr-2"></i> My Progress
                        </button>
                    </div>
                </div>

                <!-- Progress summary -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">HR Manager Training Progress</h2>
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        <div class="flex-1">
                            <div class="flex items-center justify-center">
                                <div class="radial-progress text-primary" style="--value:65; --size:12rem;" role="progressbar">
                                    <span class="text-lg font-bold">65%<br><span class="text-sm font-normal">Complete</span></span>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium">Required Trainings</span>
                                    <span class="text-sm">6 of 8 completed</span>
                                </div>
                                <progress class="progress progress-primary w-full" value="75" max="100"></progress>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium">Certifications</span>
                                    <span class="text-sm">2 of 3 completed</span>
                                </div>
                                <progress class="progress progress-secondary w-full" value="66" max="100"></progress>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium">Compliance</span>
                                    <span class="text-sm">100% compliant</span>
                                </div>
                                <progress class="progress progress-success w-full" value="100" max="100"></progress>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Required trainings -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Required Trainings for HR Manager</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                                <tr>
                                    <th>Training</th>
                                    <th>Category</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12 bg-blue-500 text-white flex items-center justify-center">
                                                    <i class="fas fa-scale-balanced"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">Employment Law Fundamentals</div>
                                                <div class="text-sm opacity-50">Compliance</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Legal</td>
                                    <td>Oct 15, 2023</td>
                                    <td><div class="badge badge-success badge-lg">Completed</div></td>
                                    <td>
                                        <button class="btn btn-ghost btn-xs" onclick="viewTraining('Employment Law Fundamentals')">View</button>
                                        <button class="btn btn-ghost btn-xs" onclick="certificateModal.showModal()">Certificate</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12 bg-green-500 text-white flex items-center justify-center">
                                                    <i class="fas fa-people-arrows"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">Recruitment & Selection</div>
                                                <div class="text-sm opacity-50">Hiring</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Talent Acquisition</td>
                                    <td>Oct 22, 2023</td>
                                    <td><div class="badge badge-success badge-lg">Completed</div></td>
                                    <td>
                                        <button class="btn btn-ghost btn-xs" onclick="viewTraining('Recruitment & Selection')">View</button>
                                        <button class="btn btn-ghost btn-xs" onclick="certificateModal.showModal()">Certificate</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12 bg-purple-500 text-white flex items-center justify-center">
                                                    <i class="fas fa-hand-holding-dollar"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">Compensation & Benefits</div>
                                                <div class="text-sm opacity-50">Compensation</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Compensation</td>
                                    <td>Oct 30, 2023</td>
                                    <td><div class="badge badge-success badge-lg">Completed</div></td>
                                    <td>
                                        <button class="btn btn-ghost btn-xs" onclick="viewTraining('Compensation & Benefits')">View</button>
                                        <button class="btn btn-ghost btn-xs" onclick="certificateModal.showModal()">Certificate</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12 bg-red-500 text-white flex items-center justify-center">
                                                    <i class="fas fa-heart-pulse"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">Employee Wellness Programs</div>
                                                <div class="text-sm opacity-50">Wellbeing</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Wellbeing</td>
                                    <td>Nov 5, 2023</td>
                                    <td><div class="badge badge-success badge-lg">Completed</div></td>
                                    <td>
                                        <button class="btn btn-ghost btn-xs" onclick="viewTraining('Employee Wellness Programs')">View</button>
                                        <button class="btn btn-ghost btn-xs" onclick="certificateModal.showModal()">Certificate</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12 bg-yellow-500 text-white flex items-center justify-center">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">HR Analytics & Metrics</div>
                                                <div class="text-sm opacity-50">Analytics</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Analytics</td>
                                    <td>Nov 15, 2023</td>
                                    <td><div class="badge badge-warning badge-lg">In Progress</div></td>
                                    <td>
                                        <button class="btn btn-ghost btn-xs" onclick="viewTraining('HR Analytics & Metrics')">Continue</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="avatar">
                                                <div class="mask mask-squircle w-12 h-12 bg-indigo-500 text-white flex items-center justify-center">
                                                    <i class="fas fa-shield-halved"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="font-bold">Workplace Safety & Compliance</div>
                                                <div class="text-sm opacity-50">Safety</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Compliance</td>
                                    <td>Nov 25, 2023</td>
                                    <td><div class="badge badge-warning badge-lg">Not Started</div></td>
                                    <td>
                                        <button class="btn btn-primary btn-xs" onclick="startTraining('Workplace Safety & Compliance')">Start</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recommended trainings -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Recommended for HR Managers</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="card bg-base-100 shadow-md">
                            <div class="card-body">
                                <h3 class="card-title">Conflict Resolution</h3>
                                <p class="text-sm text-gray-600">Learn techniques to resolve workplace conflicts effectively.</p>
                                <div class="card-actions justify-end">
                                    <button class="btn btn-primary btn-sm">Start Training</button>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-base-100 shadow-md">
                            <div class="card-body">
                                <h3 class="card-title">Diversity & Inclusion</h3>
                                <p class="text-sm text-gray-600">Create an inclusive workplace culture that values diversity.</p>
                                <div class="card-actions justify-end">
                                    <button class="btn btn-primary btn-sm">Start Training</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
                <!-- Sidebar content -->
                <div class="flex items-center mb-8">
                    <div class="w-10 rounded-full bg-primary text-white flex items-center justify-center mr-3">
                        <span class="font-semibold">JD</span>
                    </div>
                    <div>
                        <p class="font-bold">John Doe</p>
                        <p class="text-sm">HR Manager Candidate</p>
                    </div>
                </div>

                <ul class="space-y-2">
                    <li>
                        <a class="active">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a>
                            <i class="fas fa-chalkboard-teacher"></i> My Trainings
                        </a>
                    </li>
                    <li>
                        <a>
                            <i class="fas fa-certificate"></i> Certifications
                        </a>
                    </li>
                    <li>
                        <a>
                            <i class="fas fa-calendar-alt"></i> Schedule
                        </a>
                    </li>
                    <li>
                        <a>
                            <i class="fas fa-file-alt"></i> Resources
                        </a>
                    </li>
                    <li>
                        <a>
                            <i class="fas fa-question-circle"></i> Support
                        </a>
                    </li>
                </ul>

                <div class="divider"></div>

                <div class="p-4 bg-base-300 rounded-lg">
                    <h3 class="font-semibold mb-2">HR Manager Path</h3>
                    <p class="text-sm">Completion: 65%</p>
                    <div class="mt-2">
                        <progress class="progress progress-primary w-full" value="65" max="100"></progress>
                    </div>
                    <button class="btn btn-sm btn-primary mt-2 w-full">View Career Path</button>
                </div>

                <div class="mt-auto pt-4">
                    <div class="flex justify-between items-center">
                        <p class="text-sm">Need help with training?</p>
                        <button class="btn btn-sm btn-outline">Contact Coach</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Modal -->
    <dialog id="progressModal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-lg">My Progress - HR Manager Training</h3>
            <div class="py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-lg mb-4">Completion Status</h4>
                        <div class="flex items-center justify-center mb-6">
                            <div class="radial-progress text-primary" style="--value:65; --size:12rem;" role="progressbar">
                                <span class="text-lg font-bold">65%<br><span class="text-sm font-normal">Complete</span></span>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium">Required Trainings</span>
                                    <span class="text-sm">6 of 8 completed</span>
                                </div>
                                <progress class="progress progress-primary w-full" value="75" max="100"></progress>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium">Certifications</span>
                                    <span class="text-sm">2 of 3 completed</span>
                                </div>
                                <progress class="progress progress-secondary w-full" value="66" max="100"></progress>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-medium">Compliance</span>
                                    <span class="text-sm">100% compliant</span>
                                </div>
                                <progress class="progress progress-success w-full" value="100" max="100"></progress>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-lg mb-4">Upcoming Deadlines</h4>
                        <ul class="timeline timeline-vertical">
                            <li>
                                <div class="timeline-start timeline-box">
                                    <p class="font-bold">HR Analytics & Metrics</p>
                                    <p>Due: Nov 15, 2023</p>
                                    <span class="text-xs text-warning">In Progress</span>
                                </div>
                                <div class="timeline-middle">
                                    <i class="fas fa-chart-line text-warning"></i>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-middle">
                                    <i class="fas fa-shield-halved text-error"></i>
                                </div>
                                <div class="timeline-end timeline-box">
                                    <p class="font-bold">Workplace Safety</p>
                                    <p>Due: Nov 25, 2023</p>
                                    <span class="text-xs text-error">Not Started</span>
                                </div>
                            </li>
                            <li>
                                <div class="timeline-start timeline-box">
                                    <p class="font-bold">Conflict Resolution</p>
                                    <p>Due: Dec 5, 2023</p>
                                    <span class="text-xs">Recommended</span>
                                </div>
                                <div class="timeline-middle">
                                    <i class="fas fa-handshake text-info"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-primary">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Certificate Modal -->
    <dialog id="certificateModal" class="modal">
        <div class="modal-box w-11/12 max-w-3xl">
            <h3 class="font-bold text-lg">Training Certificate</h3>
            <div class="py-4">
                <div class="certificate border-2 border-primary p-8 rounded-lg text-center">
                    <h1 class="text-3xl font-bold mb-2">Certificate of Completion</h1>
                    <p class="text-lg mb-6">This certifies that</p>
                    <h2 class="text-2xl font-bold text-primary mb-6">John Doe</h2>
                    <p class="text-lg mb-4">has successfully completed the training course</p>
                    <h3 class="text-xl font-semibold mb-6" id="certificateCourse">Employment Law Fundamentals</h3>
                    <div class="flex justify-between items-center mb-8">
                        <div class="text-center">
                            <p class="font-semibold">Date Completed</p>
                            <p>October 10, 2023</p>
                        </div>
                        <div class="text-center">
                            <p class="font-semibold">Certificate ID</p>
                            <p>HRM-2023-089456</p>
                        </div>
                    </div>
                    <div class="flex justify-center gap-10">
                        <div class="text-center">
                            <p class="font-semibold">Training Director</p>
                            <div class="h-0.5 bg-gray-800 w-32 my-2 mx-auto"></div>
                            <p>Sarah Johnson</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <button class="btn btn-outline"><i class="fas fa-print mr-2"></i> Print</button>
                <button class="btn btn-primary"><i class="fas fa-download mr-2"></i> Download</button>
                <form method="dialog">
                    <button class="btn btn-ghost">Close</button>
                </form>
            </div>
        </div>
    </dialog>

    <!-- Training Modal -->
    <dialog id="trainingModal" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-lg" id="trainingTitle">Training Title</h3>
            <div class="py-4">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <div class="w-full bg-gray-200 rounded-lg h-64 mb-4 flex items-center justify-center">
                            <i class="fas fa-video text-5xl text-gray-400"></i>
                        </div>
                        <div class="flex justify-between mb-4">
                            <div>
                                <p class="font-semibold">Estimated Time</p>
                                <p>2 hours 15 minutes</p>
                            </div>
                            <div>
                                <p class="font-semibold">Your Progress</p>
                                <p>0%</p>
                            </div>
                        </div>
                        <progress class="progress progress-primary w-full mb-6" value="0" max="100"></progress>
                        
                        <h4 class="font-semibold mb-2">Course Content</h4>
                        <div class="collapse collapse-arrow bg-base-200 mb-2">
                            <input type="radio" name="my-accordion-1" checked="checked" /> 
                            <div class="collapse-title text-md font-medium">
                                Introduction to HR Management
                            </div>
                            <div class="collapse-content"> 
                                <p>Overview of HR functions, roles, and responsibilities in modern organizations.</p>
                            </div>
                        </div>
                        <div class="collapse collapse-arrow bg-base-200 mb-2">
                            <input type="radio" name="my-accordion-1" /> 
                            <div class="collapse-title text-md font-medium">
                                Key Concepts and Principles
                            </div>
                            <div class="collapse-content"> 
                                <p>Fundamental principles that guide effective human resource management.</p>
                            </div>
                        </div>
                        <div class="collapse collapse-arrow bg-base-200">
                            <input type="radio" name="my-accordion-1" /> 
                            <div class="collapse-title text-md font-medium">
                                Practical Applications
                            </div>
                            <div class="collapse-content"> 
                                <p>Real-world applications of HR management principles.</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold mb-4">About This Training</h4>
                        <p class="mb-4" id="trainingDescription">This training provides comprehensive knowledge and skills required for effective HR Management.</p>
                        
                        <div class="bg-blue-50 p-4 rounded-lg mb-4">
                            <h5 class="font-semibold mb-2 flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                What You'll Learn
                            </h5>
                            <ul class="list-disc pl-5">
                                <li class="mb-1">Key HR management principles</li>
                                <li class="mb-1">Employment law fundamentals</li>
                                <li class="mb-1">Recruitment and selection strategies</li>
                                <li class="mb-1">Employee relations techniques</li>
                            </ul>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h5 class="font-semibold mb-2 flex items-center">
                                <i class="fas fa-certificate text-yellow-500 mr-2"></i>
                                Certification
                            </h5>
                            <p>Complete this training and pass the assessment to earn your HR Management Certificate.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-action">
                <form method="dialog">
                    <button class="btn btn-ghost">Close</button>
                </form>
                <button class="btn btn-primary">Start Training</button>
            </div>
        </div>
    </dialog>

    <script>
        // Get modal elements
        const progressModal = document.getElementById('progressModal');
        const certificateModal = document.getElementById('certificateModal');
        const trainingModal = document.getElementById('trainingModal');
        
        // Function to view training details
        function viewTraining(trainingName) {
            document.getElementById('trainingTitle').textContent = trainingName;
            
            // Set training description based on name
            const descriptions = {
                "Employment Law Fundamentals": "This training covers essential employment laws and regulations that every HR manager needs to know to ensure compliance and mitigate legal risks.",
                "Recruitment & Selection": "Learn effective strategies for attracting, selecting, and onboarding top talent to build a strong organizational workforce.",
                "Compensation & Benefits": "Understand how to design and manage competitive compensation and benefits packages that attract and retain employees.",
                "Employee Wellness Programs": "Discover how to develop and implement wellness initiatives that support employee health and wellbeing.",
                "HR Analytics & Metrics": "Learn to use data and analytics to make informed HR decisions and demonstrate the value of HR initiatives."
            };
            
            document.getElementById('trainingDescription').textContent = 
                descriptions[trainingName] || "This training provides essential knowledge and skills for HR professionals.";
                
            trainingModal.showModal();
        }
        
        // Function to start a training
        function startTraining(trainingName) {
            document.getElementById('trainingTitle').textContent = trainingName;
            document.getElementById('trainingDescription').textContent = "Get started with this required training for HR managers.";
            trainingModal.showModal();
        }
        
        // Update certificate course name
        document.getElementById('certificateCourse').textContent = "Employment Law Fundamentals";
        
        // Add active class to sidebar items
        const sidebarItems = document.querySelectorAll('.menu li');
        sidebarItems.forEach(item => {
            item.addEventListener('click', function() {
                sidebarItems.forEach(i => i.querySelector('a').classList.remove('active'));
                this.querySelector('a').classList.add('active');
            });
        });
    </script>
    <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>