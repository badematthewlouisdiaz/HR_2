// Department and Role Data
const departmentRoles = {
  'front-office': [
    'Front Desk Manager',
    'Receptionist / Front Desk Officer',
    'Guest Service Agent / Concierge',
    'Reservation Agent',
    'Bellhop / Porter'
  ],
  'housekeeping': [
    'Executive Housekeeper / Housekeeping Manager',
    'Floor Supervisor',
    'Room Attendant / Housekeeper',
    'Laundry Attendant',
    'Public Area Attendant'
  ],
  'food-beverage': [
    'F&B Manager / Director',
    'Restaurant Manager / Captain',
    'Waiter / Waitress / Server',
    'Bartender',
    'Banquet / Catering Coordinator'
  ],
  'kitchen': [
    'Executive Chef / Head Chef',
    'Sous Chef',
    'Line Cook / Station Chef',
    'Pastry Chef / Baker',
    'Kitchen Steward / Dishwasher'
  ],
  'sales-marketing': [
    'Sales & Marketing Manager',
    'Revenue Manager',
    'Event / Banquet Sales Coordinator',
    'Social Media / Marketing Executive'
  ],
  'hr': [
    'HR Manager / Director',
    'Recruitment Officer',
    'Training & Development Specialist',
    'Payroll / HR Assistant'
  ],
  'finance': [
    'Finance Manager / Controller',
    'Accountant',
    'Payroll Officer',
    'Cost Controller'
  ],
  'engineering': [
    'Chief Engineer / Engineering Manager',
    'Maintenance Technician',
    'Electrician / Plumber',
    'HVAC Technician'
  ],
  'security': [
    'Security Manager / Supervisor',
    'Security Guard'
  ]
};

// DOM Elements
const departmentSelect = document.getElementById('departmentSelect');
const roleSelect = document.getElementById('roleSelect');
const dropZone = document.getElementById('dropZone');
const fileList = document.getElementById('fileList');
const statusFilter = document.getElementById('statusFilter');
const departmentFilter = document.getElementById('departmentFilter');
const moduleCards = document.getElementById('moduleCards');

// Module data storage
let currentModuleId = null;

// Filtering Functions
function applyFilters() {
  console.log('Applying filters...');
  const statusValue = statusFilter.value;
  const departmentValue = departmentFilter.value;
  
  const cards = moduleCards.querySelectorAll('.module-card');
  console.log('Total cards found:', cards.length);
  
  cards.forEach(card => {
    const cardStatus = card.getAttribute('data-status');
    const cardDepartment = card.getAttribute('data-department');
    
    let statusMatch = statusValue === 'all' || cardStatus === statusValue;
    let departmentMatch = departmentValue === 'all' || cardDepartment === departmentValue;
    
    if (statusMatch && departmentMatch) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}

function clearFilters() {
  statusFilter.value = 'all';
  departmentFilter.value = 'all';
  applyFilters();
}

// Module Action Functions
function viewModule(moduleId) {
  console.log('View module clicked:', moduleId);
  
  // Set current module ID
  currentModuleId = moduleId;
  
  // Get the module card to check its status
  const moduleCard = document.querySelector(`.module-card[data-id="${moduleId}"]`);
  if (!moduleCard) {
    alert('Module not found');
    return;
  }
  
  const status = moduleCard.getAttribute('data-status');
  console.log('Module status:', status);
  
  // Fetch module data
  const moduleData = getModuleData(moduleId);
  moduleData.status = status; // Ensure status is set correctly
  
  // Determine which modal to show based on status
  switch(status) {
    case 'pending':
      showPendingModal(moduleData);
      break;
    case 'approved':
      showApprovedModal(moduleData);
      break;
    case 'rejected':
      showRejectedModal(moduleData);
      break;
    case 'hold':
      showHoldModal(moduleData);
      break;
    case 'compliance':
      showComplianceModal(moduleData);
      break;
    case 'posted':
      showPostedModal(moduleData);
      break;
    default:
      // Fallback - show a basic modal
      alert('Viewing module: ' + moduleId);
  }
}

// Modal Display Functions
function showPendingModal(moduleData) {
  console.log('Showing pending modal for:', moduleData.title);
  
  // Set modal title
  document.getElementById('pending-title').textContent = moduleData.title;
  
  // Set info section
  document.getElementById('pending-exam-title').textContent = moduleData.title;
  document.getElementById('pending-topic').textContent = moduleData.topic;
  document.getElementById('pending-department').textContent = formatDepartment(moduleData.department);
  document.getElementById('pending-role').textContent = moduleData.roles;
  document.getElementById('pending-status').textContent = 'Pending';
  document.getElementById('pending-date').textContent = moduleData.created_at || 'N/A';
  
  // Set document preview (show first 500 characters)
  const previewContent = moduleData.content ? 
    moduleData.content.substring(0, 500) + (moduleData.content.length > 500 ? '...' : '') : 
    '<p>No content available</p>';
  document.getElementById('pending-document-preview').innerHTML = previewContent;
  
  // Set up action buttons
  document.getElementById('pending-review-btn').onclick = function() {
    alert('Reviewing module: ' + moduleData.id);
    // Update status to approved
    updateModuleStatus(moduleData.id, 'approved');
    pending_module_modal.close();
  };
  
  document.getElementById('pending-edit-btn').onclick = function() {
    alert('Editing module: ' + moduleData.id);
    // Redirect to edit page
    window.location.href = 'create_learning_modules.php?edit=' + moduleData.id;
  };
  
  document.getElementById('pending-cancel-btn').onclick = function() {
    if (confirm('Are you sure you want to cancel this module?')) {
      alert('Module cancelled: ' + moduleData.id);
      // Update status to cancelled
      updateModuleStatus(moduleData.id, 'cancelled');
      pending_module_modal.close();
    }
  };
  
  document.getElementById('pending-hold-btn').onclick = function() {
    if (confirm('Are you sure you want to put this module on hold?')) {
      alert('Module put on hold: ' + moduleData.id);
      // Update status to hold
      updateModuleStatus(moduleData.id, 'hold');
      pending_module_modal.close();
    }
  };
  
  document.getElementById('pending-view-document').onclick = function() {
    openFullDocument(moduleData);
  };
  
  document.getElementById('pending-view-full-content').onclick = function() {
    showFullContentModal(moduleData);
  };
  
  // Show the modal
  const modal = document.getElementById('pending_module_modal');
  if (modal) {
    modal.showModal();
  } else {
    console.error('Pending modal not found');
  }
}

function showApprovedModal(moduleData) {
  console.log('Showing approved modal for:', moduleData.title);
  
  // Set modal title
  document.getElementById('approved-title').textContent = moduleData.title;
  
  // Set info section
  document.getElementById('approved-exam-title').textContent = moduleData.title;
  document.getElementById('approved-topic').textContent = moduleData.topic;
  document.getElementById('approved-department').textContent = formatDepartment(moduleData.department);
  document.getElementById('approved-role').textContent = moduleData.roles;
  document.getElementById('approved-status').textContent = 'Approved';
  document.getElementById('approved-date').textContent = moduleData.created_at || 'N/A';
  
  // Set document preview (show first 500 characters)
  const previewContent = moduleData.content ? 
    moduleData.content.substring(0, 500) + (moduleData.content.length > 500 ? '...' : '') : 
    '<p>No content available</p>';
  document.getElementById('approved-document-preview').innerHTML = previewContent;
  
  // Set up action buttons
  document.getElementById('approved-post-btn').onclick = function() {
    if (confirm('Are you sure you want to post this module?')) {
      alert('Module posted: ' + moduleData.id);
      // Update status to posted
      updateModuleStatus(moduleData.id, 'posted');
      approved_module_modal.close();
    }
  };
  
  document.getElementById('approved-hold-btn').onclick = function() {
    if (confirm('Are you sure you want to put this module on hold?')) {
      alert('Module put on hold: ' + moduleData.id);
      // Update status to hold
      updateModuleStatus(moduleData.id, 'hold');
      approved_module_modal.close();
    }
  };
  
  document.getElementById('approved-download-btn').onclick = function() {
    alert('Downloading module: ' + moduleData.id);
    // Trigger download functionality
  };
  
  document.getElementById('approved-convert-btn').onclick = function() {
    alert('Converting module with AI: ' + moduleData.id);
    convert_module_modal.showModal();
  };
  
  document.getElementById('approved-view-document').onclick = function() {
    openFullDocument(moduleData);
  };
  
  document.getElementById('approved-view-full-content').onclick = function() {
    showFullContentModal(moduleData);
  };
  
  // Show the modal
  const modal = document.getElementById('approved_module_modal');
  if (modal) {
    modal.showModal();
  } else {
    console.error('Approved modal not found');
  }
}

function showRejectedModal(moduleData) {
  console.log('Showing rejected modal for:', moduleData.title);
  
  // Set modal title
  document.getElementById('rejected-title').textContent = moduleData.title;
  
  // Set reason section
  document.getElementById('rejected-reason').textContent = moduleData.rejection_reason || 'This module was rejected due to incomplete content and outdated information.';
  
  // Set info section
  document.getElementById('rejected-exam-title').textContent = moduleData.title;
  document.getElementById('rejected-topic').textContent = moduleData.topic;
  document.getElementById('rejected-department').textContent = formatDepartment(moduleData.department);
  document.getElementById('rejected-role').textContent = moduleData.roles;
  document.getElementById('rejected-status').textContent = 'Rejected';
  document.getElementById('rejected-date').textContent = moduleData.created_at || 'N/A';
  
  // Set document preview (show first 500 characters)
  const previewContent = moduleData.content ? 
    moduleData.content.substring(0, 500) + (moduleData.content.length > 500 ? '...' : '') : 
    '<p>No content available</p>';
  document.getElementById('rejected-document-preview').innerHTML = previewContent;
  
  // Set up action buttons
  document.getElementById('rejected-delete-btn').onclick = function() {
    if (confirm('Are you sure you want to delete this module? This action cannot be undone.')) {
      alert('Module deleted: ' + moduleData.id);
      // Delete module functionality
      deleteModule(moduleData.id);
      rejected_module_modal.close();
    }
  };
  
  document.getElementById('rejected-view-document').onclick = function() {
    openFullDocument(moduleData);
  };
  
  document.getElementById('rejected-view-full-content').onclick = function() {
    showFullContentModal(moduleData);
  };
  
  // Show the modal
  const modal = document.getElementById('rejected_module_modal');
  if (modal) {
    modal.showModal();
  } else {
    console.error('Rejected modal not found');
  }
}

function showHoldModal(moduleData) {
  console.log('Showing hold modal for:', moduleData.title);
  
  // Set modal title
  document.getElementById('hold-title').textContent = moduleData.title;
  
  // Set info section
  document.getElementById('hold-exam-title').textContent = moduleData.title;
  document.getElementById('hold-topic').textContent = moduleData.topic;
  document.getElementById('hold-department').textContent = formatDepartment(moduleData.department);
  document.getElementById('hold-role').textContent = moduleData.roles;
  document.getElementById('hold-status').textContent = 'Hold';
  document.getElementById('hold-date').textContent = moduleData.created_at || 'N/A';
  
  // Set document preview (show first 500 characters)
  const previewContent = moduleData.content ? 
    moduleData.content.substring(0, 500) + (moduleData.content.length > 500 ? '...' : '') : 
    '<p>No content available</p>';
  document.getElementById('hold-document-preview').innerHTML = previewContent;
  
  // Set up action buttons
  document.getElementById('hold-post-btn').onclick = function() {
    if (confirm('Are you sure you want to post this module?')) {
      alert('Module posted: ' + moduleData.id);
      // Update status to posted
      updateModuleStatus(moduleData.id, 'posted');
      hold_module_modal.close();
    }
  };
  
  document.getElementById('hold-edit-btn').onclick = function() {
    alert('Editing module: ' + moduleData.id);
    // Redirect to edit page
    window.location.href = 'create_learning_modules.php?edit=' + moduleData.id;
  };
  
  document.getElementById('hold-download-btn').onclick = function() {
    alert('Downloading module: ' + moduleData.id);
    // Trigger download functionality
  };
  
  document.getElementById('hold-convert-btn').onclick = function() {
    alert('Converting module with AI: ' + moduleData.id);
    convert_module_modal.showModal();
  };
  
  document.getElementById('hold-view-document').onclick = function() {
    openFullDocument(moduleData);
  };
  
  document.getElementById('hold-view-full-content').onclick = function() {
    showFullContentModal(moduleData);
  };
  
  // Show the modal
  const modal = document.getElementById('hold_module_modal');
  if (modal) {
    modal.showModal();
  } else {
    console.error('Hold modal not found');
  }
}

function showComplianceModal(moduleData) {
  console.log('Showing compliance modal for:', moduleData.title);
  
  // Set modal title
  document.getElementById('compliance-title').textContent = moduleData.title;
  
  // Set reason section
  document.getElementById('compliance-reason').textContent = moduleData.compliance_reason || 'This module requires updates to meet compliance standards. Please review the following requirements.';
  
  // Set info section
  document.getElementById('compliance-exam-title').textContent = moduleData.title;
  document.getElementById('compliance-topic').textContent = moduleData.topic;
  document.getElementById('compliance-department').textContent = formatDepartment(moduleData.department);
  document.getElementById('compliance-role').textContent = moduleData.roles;
  document.getElementById('compliance-status').textContent = 'For Compliance';
  document.getElementById('compliance-date').textContent = moduleData.created_at || 'N/A';
  
  // Set document preview (show first 500 characters)
  const previewContent = moduleData.content ? 
    moduleData.content.substring(0, 500) + (moduleData.content.length > 500 ? '...' : '') : 
    '<p>No content available</p>';
  document.getElementById('compliance-document-preview').innerHTML = previewContent;
  
  // Set up action buttons
  document.getElementById('compliance-resubmit-btn').onclick = function() {
    if (confirm('Are you sure you want to resubmit this module for review?')) {
      alert('Module resubmitted: ' + moduleData.id);
      // Update status to pending
      updateModuleStatus(moduleData.id, 'pending');
      compliance_module_modal.close();
    }
  };
  
  document.getElementById('compliance-hold-btn').onclick = function() {
    if (confirm('Are you sure you want to put this module on hold?')) {
      alert('Module put on hold: ' + moduleData.id);
      // Update status to hold
      updateModuleStatus(moduleData.id, 'hold');
      compliance_module_modal.close();
    }
  };
  
  document.getElementById('compliance-edit-btn').onclick = function() {
    alert('Editing module: ' + moduleData.id);
    // Redirect to edit page
    window.location.href = 'create_learning_modules.php?edit=' + moduleData.id;
  };
  
  document.getElementById('compliance-delete-btn').onclick = function() {
    if (confirm('Are you sure you want to delete this module? This action cannot be undone.')) {
      alert('Module deleted: ' + moduleData.id);
      // Delete module functionality
      deleteModule(moduleData.id);
      compliance_module_modal.close();
    }
  };
  
  document.getElementById('compliance-view-document').onclick = function() {
    openFullDocument(moduleData);
  };
  
  document.getElementById('compliance-view-full-content').onclick = function() {
    showFullContentModal(moduleData);
  };
  
  // Show the modal
  const modal = document.getElementById('compliance_module_modal');
  if (modal) {
    modal.showModal();
  } else {
    console.error('Compliance modal not found');
  }
}

function showPostedModal(moduleData) {
  // For posted modules, show the approved modal with different actions
  showApprovedModal(moduleData);
}

// New function to show full content in a modal
function showFullContentModal(moduleData) {
  console.log('Showing full content modal for:', moduleData.title);
  
  // Set modal title
  document.getElementById('full-content-title').textContent = moduleData.title + ' - Full Content';
  
  // Set full content
  const fullContentDisplay = document.getElementById('full-content-display');
  if (moduleData.content) {
    fullContentDisplay.innerHTML = moduleData.content;
  } else {
    fullContentDisplay.innerHTML = '<p class="text-gray-500 italic">No content available for this module.</p>';
  }
  
  // Show the modal
  const modal = document.getElementById('full_content_modal');
  if (modal) {
    modal.showModal();
  } else {
    console.error('Full content modal not found');
  }
}

// Helper Functions
function getModuleData(moduleId) {
  console.log('Getting module data for ID:', moduleId);
  
  // In a real application, this would be an AJAX call to fetch module data
  // For demo purposes, we'll return mock data with actual content from database
  const moduleCard = document.querySelector(`.module-card[data-id="${moduleId}"]`);
  const title = moduleCard ? moduleCard.querySelector('.card-title').textContent : 'Sample Learning Module ' + moduleId;
  const topic = moduleCard ? moduleCard.querySelector('p:nth-child(4)').textContent.replace('Topic: ', '') : 'Sample Topic';
  const department = moduleCard ? moduleCard.getAttribute('data-department') : 'human-resources';
  const roles = moduleCard ? moduleCard.querySelector('.badge-outline:nth-child(2)').textContent : 'All Employees';
  const created_at = moduleCard ? moduleCard.querySelector('p:nth-child(3)').textContent.replace('Date Added: ', '') : new Date().toISOString().split('T')[0];
  
  return {
    id: moduleId,
    title: title,
    topic: topic,
    duration: '45 minutes',
    passing_score: '75%',
    department: department,
    roles: roles,
    content: `<div class="prose max-w-none">
      <h2>${title}</h2>
      <p><strong>Topic:</strong> ${topic}</p>
      <p><strong>Department:</strong> ${formatDepartment(department)}</p>
      <p><strong>Role:</strong> ${roles}</p>
      <hr class="my-4">
      <h3>Module Content</h3>
      <p>This is the complete content created in the learning module editor. The content includes all the text, formatting, and media that was added during the module creation process.</p>
      <p>The user typed detailed information about ${topic} specifically for ${roles} in the ${formatDepartment(department)} department.</p>
      <ul>
        <li>Learning objectives related to ${topic}</li>
        <li>Detailed explanations and procedures</li>
        <li>Examples and case studies</li>
        <li>Assessment criteria</li>
        <li>Additional resources and references</li>
      </ul>
      <p>This content was carefully crafted to ensure comprehensive coverage of the topic while maintaining clarity and engagement for the target audience.</p>
    </div>`,
    status: moduleCard ? moduleCard.getAttribute('data-status') : 'pending',
    created_at: created_at,
    rejection_reason: 'Incomplete content and outdated information',
    compliance_reason: 'Needs updated safety protocols according to latest industry standards'
  };
}

function formatDepartment(department) {
  return department.split('-').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
}

function openFullDocument(moduleData) {
  const printWindow = window.open('', '_blank');
  
  printWindow.document.write(`
    <html>
      <head>
        <title>${moduleData.title}</title>
        <style>
          body { 
            font-family: 'Calibri', sans-serif; 
            font-size: 11pt; 
            line-height: 1.15; 
            margin: 0;
            padding: 2rem;
          }
          .document-header {
            border-bottom: 2px solid #333;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
          }
          .document-title {
            font-size: 24pt;
            font-weight: bold;
            margin-bottom: 0.5rem;
          }
          .document-meta {
            color: #666;
            font-size: 10pt;
          }
          .content-area {
            margin-top: 2rem;
          }
        </style>
      </head>
      <body>
        <div class="document-header">
          <div class="document-title">${moduleData.title}</div>
          <div class="document-meta">
            Topic: ${moduleData.topic} | Department: ${formatDepartment(moduleData.department)} | Role: ${moduleData.roles} | Status: ${moduleData.status}
          </div>
        </div>
        <div class="content-area">
          ${moduleData.content}
        </div>
      </body>
    </html>
  `);
  printWindow.document.close();
}

function updateModuleStatus(moduleId, newStatus) {
  // In a real application, this would be an AJAX call to update the module status
  console.log(`Updating module ${moduleId} to status: ${newStatus}`);
  
  // Update the UI
  const moduleCard = document.querySelector(`.module-card[data-id="${moduleId}"]`);
  const statusBadge = document.getElementById(`status-badge-${moduleId}`);
  
  if (moduleCard && statusBadge) {
    moduleCard.setAttribute('data-status', newStatus);
    statusBadge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
    statusBadge.className = `badge status-${newStatus}`;
  }
}

function deleteModule(moduleId) {
  // In a real application, this would be an AJAX call to delete the module
  console.log(`Deleting module: ${moduleId}`);
  
  // Remove from UI
  const moduleCard = document.querySelector(`.module-card[data-id="${moduleId}"]`);
  if (moduleCard) {
    moduleCard.remove();
  }
}

function convertModule() {
  alert('Converting module with AI...');
  // In a real application, this would send a request to an AI conversion service
  convert_module_modal.close();
}

// Update roles based on department selection
if (departmentSelect) {
  departmentSelect.addEventListener('change', function() {
    const department = this.value;
    
    // Clear existing options
    roleSelect.innerHTML = '';
    
    if (department && departmentRoles[department]) {
      // Enable the role select
      roleSelect.disabled = false;
      
      // Add default option
      const defaultOption = document.createElement('option');
      defaultOption.disabled = true;
      defaultOption.selected = true;
      defaultOption.textContent = 'Select Role';
      roleSelect.appendChild(defaultOption);
      
      // Add department-specific roles
      departmentRoles[department].forEach(role => {
        const option = document.createElement('option');
        option.value = role;
        option.textContent = role;
        roleSelect.appendChild(option);
      });
    } else {
      // Disable the role select if no department is selected
      roleSelect.disabled = true;
      const defaultOption = document.createElement('option');
      defaultOption.disabled = true;
      defaultOption.selected = true;
      defaultOption.textContent = 'Select Department First';
      roleSelect.appendChild(defaultOption);
    }
  });
}

// Drag and Drop Functionality
if (dropZone) {
  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
  });

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  ['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
  });

  function highlight() {
    dropZone.classList.add('active');
  }

  function unhighlight() {
    dropZone.classList.remove('active');
  }

  dropZone.addEventListener('drop', handleDrop, false);

  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    handleFiles(files);
  }

  function handleFiles(files) {
    ([...files]).forEach(uploadFile);
  }

  function uploadFile(file) {
    // In a real application, you would upload the file to a server here
    console.log('Uploading file:', file.name);
    
    // Add file to the file list
    const fileElement = document.createElement('div');
    fileElement.className = 'flex items-center justify-between p-2 bg-gray-50 rounded';
    fileElement.innerHTML = `
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span>${file.name}</span>
      </div>
      <div class="text-xs text-gray-500">${formatFileSize(file.size)}</div>
    `;
    fileList.appendChild(fileElement);
  }

  function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
  console.log('Learning Module Repository initialized');
  console.log('Total module cards found:', document.querySelectorAll('.module-card').length);
  
  // Test if viewModule function is accessible
  window.viewModule = viewModule;
  console.log('viewModule function is now accessible globally');
});