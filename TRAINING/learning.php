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
    <style>
    .centered-hero {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh; /* This will make it take most of the viewport height */
    }
  </style>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
    
           
 <!-- Exam Introduction Section (Replaces Hero Section) -->
        <div id="examIntroduction" class="max-w-12xl w-full bg-white rounded-xl shadow-xl overflow-hidden mx-auto">
          <!-- Header -->
          <div class="bg-white px-8 py-6 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
              <div class="logo-container w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);">
                <i class="fas fa-book-open text-white text-xl"></i>
              </div>
              <div>
                <h1 class="text-2xl font-bold text-gray-800">Learning Management</h1>
                <p class="text-sm text-gray-600">Entrance Examination Portal</p>
              </div>
            </div>
            <div class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg text-sm font-medium">
              <i class="fas fa-shield-alt mr-2"></i>Secure Session
            </div>
          </div>
          <!-- Progress Steps -->
          <div class="bg-gray-50 px-8 py-4 flex justify-center">
            <div class="flex items-center space-x-8">
              <div class="flex items-center">
                <div class="step-indicator step-active">1</div>
                <div class="ml-2 text-sm font-medium text-blue-700">Exam Overview</div>
              </div>
              <div class="h-0.5 w-16 bg-gray-300"></div>
              <div class="flex items-center">
                <div class="step-indicator step-inactive">2</div>
                <div class="ml-2 text-sm font-medium text-gray-500">Application</div>
              </div>
              <div class="h-0.5 w-16 bg-gray-300"></div>
              <div class="flex items-center">
                <div class="step-indicator step-inactive">3</div>
                <div class="ml-2 text-sm font-medium text-gray-500">Assessment</div>
              </div>
              <div class="h-0.5 w-16 bg-gray-300"></div>
              <div class="flex items-center">
                <div class="step-indicator step-inactive">4</div>
                <div class="ml-2 text-sm font-medium text-gray-500">Onboarding</div>
              </div>
            </div>
          </div>
          <!-- Main Content -->
          <div class="px-8 py-8">
            <div class="text-center mb-10">
              <h2 class="text-3xl font-bold text-gray-800 mb-4">EXAM</h2>
              <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Complete this exam to assess your foundational knowledge before beginning the new hire onboarding process.
              </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
              <!-- Exam Details Card -->
              <div class="exam-card rounded-xl p-6 shadow-md">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                  <i class="fas fa-info-circle mr-3 text-blue-500"></i>Examination Details
                </h3>
                <ul class="space-y-3">
                  <li class="flex items-start">
                    <i class="fas fa-clock mt-1 mr-3 text-blue-500"></i>
                    <span><span class="font-medium">Duration:</span> 15 minutes</span>
                  </li>
                  <li class="flex items-start">
                    <i class="fas fa-question-circle mt-1 mr-3 text-blue-500"></i>
                    <span><span class="font-medium">Questions:</span> 10 role-specific items</span>
                  </li>
                  <li class="flex items-start">
                    <i class="fas fa-check-circle mt-1 mr-3 text-blue-500"></i>
                    <span><span class="font-medium">Format:</span> Multiple choice</span>
                  </li>
                  <li class="flex items-start">
                    <i class="fas fa-lock mt-1 mr-3 text-blue-500"></i>
                    <span><span class="font-medium">Security:</span> Timed session, no backtracking</span>
                  </li>
                </ul>
              </div>
              
              <!-- Instructions Card -->
              <div class="bg-white rounded-xl p-6 shadow-md border border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                  <i class="fas fa-clipboard-list mr-3 text-blue-500"></i>Instructions
                </h3>
                <ol class="list-decimal pl-5 space-y-3">
                  <li>Ensure you have a stable internet connection</li>
                  <li>This exam must be completed in one session</li>
                  <li>Answers cannot be changed after submission</li>
                  <li>Use of external resources is prohibited</li>
                  <li>The timer will begin when you start the exam</li>
                </ol>
              </div>
            </div>
            
            <!-- Purpose Section -->
            <div class="bg-blue-50 rounded-xl p-6 mb-10">
              <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center justify-center">
                <i class="fas fa-graduation-cap mr-3 text-blue-500"></i>Purpose of This Examination
              </h3>
              <p class="text-gray-700 text-center">
                This entrance exam helps us understand your current knowledge level and tailor your onboarding experience to ensure your success. Your results will determine the appropriate starting point in our learning management system.
              </p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-center">
              <button id="beginExamBtn" class="btn btn-primary text-white font-medium rounded-lg px-8 py-3 shadow-sm flex items-center">
                <i class="fas fa-play-circle mr-3"></i>Begin Examination
              </button>
            </div>
          </div>
        </div>


               <!-- Application Form -->
        <div id="applicationForm" class="hidden">
            <div class="card bg-base-100 shadow-xl mb-12">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-6">
                        <i class="fas fa-user-circle mr-2"></i>Applicant Information
                    </h2>
                    <form id="applicantForm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">First Name</span>
                                </label>
                                <input type="text" placeholder="Enter your First Name" class="input input-bordered" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Last Name</span>
                                </label>
                                <input type="text" placeholder="Enter your Last Name" class="input input-bordered" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <input type="email" placeholder="Enter Email" class="input input-bordered" required />
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Phone</span>
                                </label>
                                <input type="tel" placeholder="Enter your number" class="input input-bordered" required />
                            </div>
                            <div class="form-control md:col-span-2">
                                <label class="label">
                                    <span class="label-text">Position Applying For</span>
                                </label>
                                <select class="select select-bordered" id="roleSelect" required>
                            <option disabled selected>Select a position</option>
                         <option value="chef">Chef</option>
                         <option value="hr_manager">HR Manager</option>
                         <option value="staffs">Staffs</option>
                         </select>
                            </div>
                        </div>
                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-arrow-right mr-2"></i>Proceed to Exam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Role Description -->
        <div id="roleDescription" class="hidden">
            <div class="card bg-base-100 shadow-xl mb-8">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-4" id="roleTitle"></h2>
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">Role Overview</h3>
                            <p id="roleOverview" class="mb-4"></p>
                            <h3 class="text-lg font-semibold mb-2">Exam Details</h3>
                            <ul class="list-disc pl-5" id="examDetails">
                            </ul>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">Skills Tested</h3>
                            <div class="flex flex-wrap gap-2 mb-4" id="skillsTested">
                            </div>
                            <div class="mt-6">
                                <button class="btn btn-primary w-full" onclick="startExam()">
                                    <i class="fas fa-play mr-2"></i>Start Exam Now
                                </button>
                                <button class="btn btn-outline mt-4 w-full" onclick="backToApplication()">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to Application
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Section -->
        <div id="examSection" class="hidden">
            <div class="card bg-base-100 shadow-xl mb-12">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="card-title text-2xl" id="examTitle">Knowledge Assessment</h2>
                        <div class="badge badge-primary badge-lg p-4" id="timer">Time: 15:00</div>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <p class="font-semibold">Instructions:</p>
                        <ul class="list-disc pl-5 mt-2">
                            <li>This exam consists of <span id="totalQuestions">10</span> multiple-choice questions</li>
                            <li>You have 15 minutes to complete the exam</li>
                            <li>Each question has only one correct answer</li>
                            <li>You cannot go back to previous questions</li>
                            <li>Your results will be displayed immediately after completion</li>
                        </ul>
                    </div>
                    
                    <div class="flex justify-between items-center mb-6">
                        <div class="text-lg font-semibold">
                            Question <span id="currentQuestionNumber">1</span> of <span id="totalQuestionsCount">10</span>
                        </div>
                        <div class="flex gap-2">
                            <div class="badge badge-info" id="questionCategory">Frontend Development</div>
                            <div class="badge badge-secondary" id="questionDifficulty">Medium</div>
                        </div>
                    </div>
                    
                    <form id="examForm">
                        <div class="space-y-8" id="questionsContainer">
                            <!-- Questions will be dynamically inserted here -->
                        </div>
                        
                        <div class="flex justify-between mt-8">
                            <button type="button" class="btn btn-outline" id="prevBtn" onclick="prevQuestion()" disabled>
                                <i class="fas fa-arrow-left mr-2"></i>Previous
                            </button>
                            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextQuestion()">
                                Next<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            <button type="submit" class="btn btn-success hidden" id="submitBtn">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Exam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div id="resultsSection" class="hidden">
            <div class="card bg-base-100 shadow-xl mb-12">
                <div class="card-body">
                    <h2 class="card-title text-2xl mb-6">Exam Results</h2>
                    
                    <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-8">
                        <div class="flex justify-center">
                            <div class="radial-progress bg-primary text-primary-content border-4 border-primary" style="--value:0; --size:12rem;" id="scoreCircle">0%</div>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold mb-2" id="resultMessage"></h3>
                            <p id="scoreText" class="text-lg mb-4"></p>
                            <div class="stats shadow">
                                <div class="stat">
                                    <div class="stat-title">Correct Answers</div>
                                    <div class="stat-value text-success" id="correctAnswers">0</div>
                                    <div class="stat-desc">out of <span id="totalAnswers">10</span> questions</div>
                                </div>
                                <div class="stat">
                                    <div class="stat-title">Time Taken</div>
                                    <div class="stat-value text-info" id="timeTaken">00:00</div>
                                    <div class="stat-desc">minutes:seconds</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <h4 class="font-semibold text-lg mb-4">Detailed Results:</h4>
                        <div class="space-y-4" id="detailedResults">
                            <!-- Detailed results will be inserted here -->
                        </div>
                    </div>
                    
                    <div class="flex justify-center gap-4">
                        <button class="btn btn-outline" onclick="restartExam()">
                            <i class="fas fa-redo mr-2"></i>Retake Exam
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-download mr-2"></i>Download Certificate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
     <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>