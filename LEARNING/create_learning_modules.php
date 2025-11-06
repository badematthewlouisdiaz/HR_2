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

// Get module info from URL parameters
$module_title = $_GET['title'] ?? '';
$module_topic = $_GET['topic'] ?? '';
$module_department = $_GET['department'] ?? '';
$module_role = $_GET['role'] ?? '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? $module_title;
    $topic = $_POST['topic'] ?? $module_topic;
    $department = $_POST['department'] ?? $module_department;
    $roles = $_POST['roles'] ?? $module_role;
    $content = $_POST['content'] ?? '';
    $status = 'pending'; // Set status to pending

    // Insert into database
    $sql = "INSERT INTO learning_modules (title, topic, department, roles, content, status, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $title, $topic, $department, $roles, $content, $status);
    
    if ($stmt->execute()) {
        // Redirect to learning repository without success message
        header("Location: learning_module_repository.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Error saving module: " . $stmt->error;
    }
    
    $stmt->close();
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
  <link rel="stylesheet" href="../CSS/soliera.css">
  <link rel="stylesheet" href="../CSS/sidebar.css">
  <link rel="stylesheet" href="../CSS/create_learning_module.css">
  <style>
    .document-meta {
      display: grid;
      grid-template-columns: 1fr 1fr auto;
      gap: 1rem;
      align-items: end;
      padding: 1.5rem;
      background: white;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .meta-field {
      display: flex;
      flex-direction: column;
    }
    
    .meta-label {
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.5rem;
      font-size: 0.875rem;
    }
    
    .meta-select {
      padding: 0.5rem 0.75rem;
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      font-size: 0.875rem;
    }
    
    .meta-select:focus {
      outline: none;
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .actions-field {
      display: flex;
      gap: 0.5rem;
      align-items: center;
    }
    
    .btn-primary {
      background-color: #3b82f6;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      border: none;
      cursor: pointer;
      font-size: 0.875rem;
      transition: background-color 0.2s;
      display: flex;
      align-items: center;
    }
    
    .btn-primary:hover {
      background-color: #2563eb;
    }
    
    .btn-custom {
      background-color: #6b7280;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      border: none;
      cursor: pointer;
      font-size: 0.875rem;
      transition: background-color 0.2s;
      display: flex;
      align-items: center;
    }
    
    .btn-custom:hover {
      background-color: #4b5563;
    }

    /* Plain tracker table styling (minimal) */
    .embedded-tracker {
      border-collapse: collapse;
      width: 100%;
      margin: 0.5rem 0;
      font-size: 0.95rem;
    }

    .embedded-tracker th,
    .embedded-tracker td {
      border: 1px solid #d1d5db;
      padding: 6px 8px;
      vertical-align: middle;
    }
    .embedded-tracker th {
      background: #f9fafb;
      font-weight: 600;
      text-align: left;
    }
    .embedded-progress {
      font-weight: 600;
      margin-bottom: 6px;
    }

    /* Simple styling for modal custom-section list */
    .custom-section-item {
      display:flex;
      gap:8px;
      align-items:center;
      margin-bottom:6px;
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

        <!-- Error Messages Only (Success messages removed) -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-error mx-4 mt-4">
                <div class="flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-6 h-6 mx-2 stroke-current"> 
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <label><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></label>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Module Info Header with Action Buttons -->
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4">Create Learning Module</h1>
                    
                    <!-- Module Information Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">
                        <!-- Title -->
                        <div>
                            <span class="font-semibold text-gray-600 block mb-2">Title</span>
                            <div class="text-gray-800 bg-gray-50 px-3 py-2 rounded border">
                                <?php echo htmlspecialchars($module_title); ?>
                            </div>
                            <input type="hidden" name="title" value="<?php echo htmlspecialchars($module_title); ?>">
                        </div>

                        <!-- Topic -->
                        <div>
                            <span class="font-semibold text-gray-600 block mb-2">Topic</span>
                            <div class="text-gray-800 bg-gray-50 px-3 py-2 rounded border">
                                <?php echo htmlspecialchars($module_topic); ?>
                            </div>
                            <input type="hidden" name="topic" value="<?php echo htmlspecialchars($module_topic); ?>">
                        </div>

                        <!-- Department -->
                        <div>
                            <span class="font-semibold text-gray-600 block mb-2">Department</span>
                            <div class="text-gray-800 bg-gray-50 px-3 py-2 rounded border">
                                <?php echo htmlspecialchars(ucfirst(str_replace('-', ' ', $module_department))); ?>
                            </div>
                            <input type="hidden" name="department" value="<?php echo htmlspecialchars($module_department); ?>">
                        </div>

                        <!-- Role -->
                        <div>
                            <span class="font-semibold text-gray-600 block mb-2">Role</span>
                            <div class="text-gray-800 bg-gray-50 px-3 py-2 rounded border">
                                <?php echo htmlspecialchars($module_role); ?>
                            </div>
                            <input type="hidden" name="roles" value="<?php echo htmlspecialchars($module_role); ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Status and Action Buttons -->
                <div class="flex flex-col items-end gap-4">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                        Status: Pending
                    </span>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button type="button" class="btn btn-primary" id="saveModuleBtn">
                            <i class="fas fa-save mr-2"></i>Save Module
                        </button>
                        <button type="button" class="btn btn-custom" onclick="window.location.href='learning_module_repository.php'">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form (Hidden fields only) -->
        <form method="POST" action="" id="moduleForm">
            <!-- Hidden fields to preserve the data -->
            <input type="hidden" name="title" value="<?php echo htmlspecialchars($module_title); ?>">
            <input type="hidden" name="topic" value="<?php echo htmlspecialchars($module_topic); ?>">
            <input type="hidden" name="department" value="<?php echo htmlspecialchars($module_department); ?>">
            <input type="hidden" name="roles" value="<?php echo htmlspecialchars($module_role); ?>">
            <input type="hidden" name="content" id="moduleContent">
        </form>

        <!-- Main App Container -->
        <div class="app-container">
            <!-- Main Content -->
            <div class="main-content">
                <!-- Toolbar -->
                <div class="toolbar">
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="saveBtn" title="Save">
                            <i class="fas fa-save"></i>
                        </button>
                        <button class="toolbar-btn" id="printBtn" title="Print">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="undoBtn" title="Undo">
                            <i class="fas fa-undo"></i>
                        </button>
                        <button class="toolbar-btn" id="redoBtn" title="Redo">
                            <i class="fas fa-redo"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-group">
                        <select class="toolbar-select" id="fontFamily">
                            <option value="Arial">Arial</option>
                            <option value="Calibri" selected>Calibri</option>
                            <option value="Times New Roman">Times New Roman</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Verdana">Verdana</option>
                        </select>
                        <select class="toolbar-select" id="fontSize">
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11" selected>11</option>
                            <option value="12">12</option>
                            <option value="14">14</option>
                            <option value="16">16</option>
                            <option value="18">18</option>
                            <option value="20">20</option>
                            <option value="24">24</option>
                        </select>
                    </div>
                    
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="boldBtn" title="Bold">
                            <i class="fas fa-bold"></i>
                        </button>
                        <button class="toolbar-btn" id="italicBtn" title="Italic">
                            <i class="fas fa-italic"></i>
                        </button>
                        <button class="toolbar-btn" id="underlineBtn" title="Underline">
                            <i class="fas fa-underline"></i>
                        </button>
                        <button class="toolbar-btn" id="strikeBtn" title="Strikethrough">
                            <i class="fas fa-strikethrough"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="alignLeftBtn" title="Align Left">
                            <i class="fas fa-align-left"></i>
                        </button>
                        <button class="toolbar-btn" id="alignCenterBtn" title="Align Center">
                            <i class="fas fa-align-center"></i>
                        </button>
                        <button class="toolbar-btn" id="alignRightBtn" title="Align Right">
                            <i class="fas fa-align-right"></i>
                        </button>
                        <button class="toolbar-btn" id="alignJustifyBtn" title="Justify">
                            <i class="fas fa-align-justify"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="bulletListBtn" title="Bullet List">
                            <i class="fas fa-list-ul"></i>
                        </button>
                        <button class="toolbar-btn" id="numberListBtn" title="Numbered List">
                            <i class="fas fa-list-ol"></i>
                        </button>
                        <button class="toolbar-btn" id="indentBtn" title="Increase Indent">
                            <i class="fas fa-indent"></i>
                        </button>
                        <button class="toolbar-btn" id="outdentBtn" title="Decrease Indent">
                            <i class="fas fa-outdent"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-group">
                        <input type="color" class="toolbar-btn" id="textColor" title="Text Color" value="#000000">
                        <input type="color" class="toolbar-btn" id="highlightColor" title="Highlight Color" value="#ffff00">
                    </div>
                    
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="insertImageBtn" title="Insert Image">
                            <i class="fas fa-image"></i>
                        </button>
                        <button class="toolbar-btn" id="insertLinkBtn" title="Insert Link">
                            <i class="fas fa-link"></i>
                        </button>
                        <button class="toolbar-btn" id="insertTableBtn" title="Insert Table">
                            <i class="fas fa-table"></i>
                        </button>
                    </div>
                    
                    <div class="toolbar-group">
                        <button class="toolbar-btn" id="findReplaceBtn" title="Find and Replace">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="toolbar-btn" id="wordCountBtn" title="Word Count">
                            <i class="fas fa-font"></i>
                        </button>
                        <button class="toolbar-btn" id="progressTrackingBtn" title="Progress Tracking" data-bs-toggle="modal" data-bs-target="#trackerModal">
                            <i class="fas fa-tasks"></i>
                        </button>
                    </div>
                </div>

                <!-- Editor Container -->
                <div class="editor-container">
                    <div class="editor-wrapper">
                        <!-- Progress Tracking Section (left for compatibility, but tracker will be inserted into editor when used) -->
                        <div class="progress-tracking" id="progressTrackingSection" style="display: none;">
                            <div class="progress-header">
                                <h3 class="progress-title">Learning Progress Tracker</h3>
                                <div class="progress-stats" id="progressStats">0% Complete</div>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar" id="progressBar" style="width: 0%"></div>
                            </div>
                            <div class="progress-sections" id="progressSections">
                                <!-- Progress sections will be dynamically added here -->
                            </div>
                        </div>
                        
                        <!-- VISIBLE Quill Editor -->
                        <div id="editor" contenteditable="true">
                            <!-- Quill editor will be initialized here -->
                        </div>
                    </div>
                </div>

                <!-- Status Bar -->
                <div class="status-bar">
                    <div class="status-left">
                        <span class="status-item" id="pageInfo">Page 1 of 1</span>
                        <span class="status-item" id="wordCount">Words: 0</span>
                        <span class="status-item" id="charCount">Characters: 0</span>
                        <span class="status-item" id="progressStatus">Progress: 0%</span>
                    </div>
                    <div class="status-right">
                        <span class="status-item" id="zoomLevel">100%</span>
                        <button class="status-item" id="zoomOutBtn"><i class="fas fa-search-minus"></i></button>
                        <button class="status-item" id="zoomInBtn"><i class="fas fa-search-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme Toggle Button -->
        <button class="theme-toggle" id="themeToggle">
            <i class="fas fa-moon"></i>
        </button>

        <!-- TRACKER SELECTION MODAL (Bootstrap) -->
        <div class="modal fade" id="trackerModal" tabindex="-1" aria-labelledby="trackerModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="trackerModalLabel">Insert Progress Tracker</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Select the sections you want to include in the progress tracker, or add custom sections below.</p>

                <div class="row">
                  <div class="col-md-6">
                    <h6>Predefined Sections</h6>
                    <div class="form-check">
                      <input class="form-check-input tracker-section-checkbox" type="checkbox" value="Introduction" id="chkIntro">
                      <label class="form-check-label" for="chkIntro">Introduction</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input tracker-section-checkbox" type="checkbox" value="Learning Objectives" id="chkObjectives">
                      <label class="form-check-label" for="chkObjectives">Learning Objectives</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input tracker-section-checkbox" type="checkbox" value="Main Content" id="chkMain">
                      <label class="form-check-label" for="chkMain">Main Content</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input tracker-section-checkbox" type="checkbox" value="Examples/Case Studies" id="chkExamples">
                      <label class="form-check-label" for="chkExamples">Examples/Case Studies</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input tracker-section-checkbox" type="checkbox" value="Assessment/Quiz" id="chkAssessment">
                      <label class="form-check-label" for="chkAssessment">Assessment/Quiz</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input tracker-section-checkbox" type="checkbox" value="Summary/Conclusion" id="chkSummary">
                      <label class="form-check-label" for="chkSummary">Summary/Conclusion</label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <h6>Custom Sections</h6>
                    <div id="customSectionsContainer"></div>
                    <div class="d-flex gap-2 mt-2">
                      <input type="text" id="customSectionInput" class="form-control" placeholder="Type custom section name">
                      <button type="button" id="addCustomSectionBtn" class="btn btn-outline-primary">Add</button>
                    </div>
                    <small class="text-muted">Added custom sections will appear in the list and can be unchecked before inserting.</small>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" id="insertTrackerBtn" class="btn btn-primary">Insert Tracker</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </div>
          </div>
        </div>
        <!-- END MODAL -->

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Quill JS -->
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <!-- HTML-to-PDF library (client-side) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

        <!-- Custom JS -->
        <script src="../JS/create_learning_module.js"></script>
        <script src="../JS/soliera.js"></script>
        <script src="../JS/sidebar.js"></script>

        <!-- Extra JS: hook Save flow to show download prompt AFTER DB submit is triggered (we keep your original server submit) -->
        <script>
        (function(){
            const saveModuleBtn = document.getElementById('saveModuleBtn');
            const moduleForm = document.getElementById('moduleForm');
            const moduleContent = document.getElementById('moduleContent');

            if (!saveModuleBtn || !moduleForm || !moduleContent) return;

            saveModuleBtn.addEventListener('click', function(e){
                e.preventDefault();
                try {
                    const content = (typeof quill !== 'undefined') ? quill.root.innerHTML : document.getElementById('editor')?.innerHTML || '';
                    moduleContent.value = content;
                } catch (err) {
                    console.warn('Quill not found when preparing content for save.');
                }

                Swal.fire({
                    title: 'Save Module',
                    text: 'Do you want to (1) Save to repository only, (2) Save and download as DOC, or (3) Save and download as PDF?',
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Save only',
                    denyButtonText: 'Save & Download DOC',
                    cancelButtonText: 'Save & Download PDF',
                    customClass: { popup: 'animate__animated animate__fadeIn' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        moduleForm.submit();
                    } else if (result.isDenied) {
                        const content = moduleContent.value;
                        downloadDocFromHtml(content, '<?php echo addslashes($module_title ?: "Learning_Module"); ?>');
                        setTimeout(()=> moduleForm.submit(), 800);
                    } else {
                        const content = moduleContent.value;
                        downloadPdfFromHtml(content, '<?php echo addslashes($module_title ?: "Learning_Module"); ?>');
                        setTimeout(()=> moduleForm.submit(), 1200);
                    }
                });

            });

            function downloadDocFromHtml(htmlContent, baseName) {
                const header = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Document</title></head><body>';
                const footer = '</body></html>';
                const blob = new Blob([header + htmlContent + footer], { type: 'application/msword' });
                const fileName = baseName.replace(/\s+/g,'_') + '_' + new Date().toISOString().slice(0,19).replace(/[:T]/g,'-') + '.doc';
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = fileName;
                document.body.appendChild(link);
                link.click();
                link.remove();
            }

            function downloadPdfFromHtml(htmlContent, baseName) {
                const tempDiv = document.createElement('div');
                tempDiv.style.position = 'fixed';
                tempDiv.style.left = '-10000px';
                tempDiv.style.top = '0';
                tempDiv.innerHTML = htmlContent;
                document.body.appendChild(tempDiv);

                const opt = {
                    margin:       10,
                    filename:     baseName.replace(/\s+/g,'_') + '_' + new Date().toISOString().slice(0,19).replace(/[:T]/g,'-') + '.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2, logging: false, useCORS: true },
                    jsPDF:        { unit: 'pt', format: 'a4', orientation: 'portrait' }
                };

                html2pdf().set(opt).from(tempDiv).save()
                .finally(() => {
                    tempDiv.remove();
                });
            }

        })();
        </script>

    </body>
</html>

<?php
// Close database connection
$conn->close();
?>
