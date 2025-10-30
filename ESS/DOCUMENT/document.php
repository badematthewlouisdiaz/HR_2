<?php

session_start()
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Document</title>
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
<body class="bg-gray-100 min-h-screen">
    <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto transition-slow">
         <!-- Header -->
            <div class="mb-10">
              
            </div>
            
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column - Upload Section -->
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Upload New Document</h2>
                    
                    <div class="space-y-9">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document Name</label>
                            <input type="text" placeholder="Enter document name" class="input input-bordered w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                        
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Document</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-400 transition-colors duration-200">
                                <div class="space-y-3 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Click to upload</span>
                                            <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PDF or Word document up to 10MB</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center text-sm text-gray-500">
                            <input id="terms" name="terms" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2">I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">privacy policy</a> and <a href="#" class="text-blue-600 hover:text-blue-500">terms of service</a></label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-full py-3 text-lg">Upload Document</button>
                    </div>
                </div>
                
<!-- Improved Uploaded Documents UI with "View" button and modal for document preview. Replace your right column block with this. -->
<div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col h-full">
  <h2 class="text-xl font-bold text-gray-800 mb-6">Uploaded Documents</h2>
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gray-50">
        <tr>
          <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Document Name</th>
          <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">File Name</th>
          <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Uploaded By</th>
          <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
          <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        <tr class="hover:bg-blue-50 transition">
          <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">Annual Budget</td>
          <td class="px-4 py-3 text-gray-700 whitespace-nowrap">budget_2023.xlsx</td>
          <td class="px-4 py-3 text-gray-700 whitespace-nowrap">ansyo003</td>
          <td class="px-4 py-3">
            <span class="badge badge-warning badge-lg px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
          </td>
          <td class="px-4 py-3 text-center">
            <button class="btn btn-sm btn-outline btn-primary" onclick="viewDocument('Annual Budget', 'budget_2023.xlsx', 'ansyo003', 'Pending', 'xlsx')">View</button>
          </td>
        </tr>
        <tr class="hover:bg-blue-50 transition">
          <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">Employee Handbook</td>
          <td class="px-4 py-3 text-gray-700 whitespace-nowrap">handbook_v2.docx</td>
          <td class="px-4 py-3 text-gray-700 whitespace-nowrap">ansyo003</td>
          <td class="px-4 py-3">
            <span class="badge badge-success badge-lg px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
          </td>
          <td class="px-4 py-3 text-center">
            <button class="btn btn-sm btn-outline btn-primary" onclick="viewDocument('Employee Handbook', 'handbook_v2.docx', 'ansyo003', 'Completed', 'docx')">View</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Responsive Card List for Mobile -->
  <div class="sm:hidden mt-6 space-y-4">
    <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-1">
      <div class="flex justify-between items-center">
        <div>
          <div class="font-semibold text-gray-900">Qt Marketing Report</div>
          <div class="text-xs text-gray-600">marketing_report.pdf • ansyo003</div>
        </div>
        <span class="badge badge-success badge-lg px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
      </div>
      <button class="btn btn-sm btn-outline btn-primary w-full mt-2" onclick="viewDocument('Qt Marketing Report', 'marketing_report.pdf', 'ansyo003', 'Completed', 'pdf')">View</button>
    </div>
    <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-1">
      <div class="flex justify-between items-center">
        <div>
          <div class="font-semibold text-gray-900">Annual Budget</div>
          <div class="text-xs text-gray-600">budget_2023.xlsx • ansyo003</div>
        </div>
        <span class="badge badge-warning badge-lg px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
      </div>
      <button class="btn btn-sm btn-outline btn-primary w-full mt-2" onclick="viewDocument('Annual Budget', 'budget_2023.xlsx', 'ansyo003', 'Pending', 'xlsx')">View</button>
    </div>
    <div class="bg-blue-50 rounded-xl p-4 flex flex-col gap-1">
      <div class="flex justify-between items-center">
        <div>
          <div class="font-semibold text-gray-900">Employee Handbook</div>
          <div class="text-xs text-gray-600">handbook_v2.docx • ansyo003</div>
        </div>
        <span class="badge badge-success badge-lg px-3 py-1 rounded-full text-xs font-semibold">Completed</span>
      </div>
      <button class="btn btn-sm btn-outline btn-primary w-full mt-2" onclick="viewDocument('Employee Handbook', 'handbook_v2.docx', 'ansyo003', 'Completed', 'docx')">View</button>
    </div>
  </div>
</div>

<!-- Modal for viewing document -->
<div id="viewDocumentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
  <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-lg relative">
    <button class="absolute right-4 top-4 text-gray-500 hover:text-gray-700" onclick="closeViewModal()">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>
    <h2 class="text-2xl font-bold mb-6 text-center" id="docModalTitle">View Document</h2>
    <div class="mb-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <div class="font-semibold text-gray-700">Document Name:</div>
          <div class="text-gray-900" id="docModalName"></div>
        </div>
        <div>
          <div class="font-semibold text-gray-700">File Name:</div>
          <div class="text-gray-900" id="docModalFile"></div>
        </div>
        <div>
          <div class="font-semibold text-gray-700">Uploaded By:</div>
          <div class="text-gray-900" id="docModalUploader"></div>
        </div>
        <div>
          <div class="font-semibold text-gray-700">Status:</div>
          <span id="docModalStatus" class="badge px-3 py-1 rounded-full text-xs font-semibold"></span>
        </div>
      </div>
    </div>
    <div id="docModalPreview" class="mt-6">
      <!-- Preview area - PDF, image, or icon depending on filetype -->
    </div>
  </div>
</div>

    <script>
        function viewDocument(name, file, uploader, status, filetype) {
  document.getElementById('viewDocumentModal').classList.remove('hidden');
  document.getElementById('docModalTitle').innerText = 'View Document';
  document.getElementById('docModalName').innerText = name;
  document.getElementById('docModalFile').innerText = file;
  document.getElementById('docModalUploader').innerText = uploader;

  // Set badge style for status
  var statusSpan = document.getElementById('docModalStatus');
  statusSpan.innerText = status;
  statusSpan.className = "badge px-3 py-1 rounded-full text-xs font-semibold";
  if (status === "Completed") {
    statusSpan.classList.add("badge-success");
  } else if (status === "Pending") {
    statusSpan.classList.add("badge-warning");
  } else {
    statusSpan.classList.add("badge-neutral");
  }

  // Document preview logic
  var preview = document.getElementById('docModalPreview');
  preview.innerHTML = '';
  // Example asset URLs (replace with your backend URLs)
  let documentUrl = "#"; // Replace with real file URL if available

  if (filetype === "pdf") {
    preview.innerHTML = `<iframe src="${documentUrl}" class="w-full h-72 rounded-md border" title="PDF Preview"></iframe>
    <div class="mt-2 text-xs text-gray-500">PDF preview not available in demo. <a class="text-blue-600 hover:underline" href="${documentUrl}" target="_blank">Download File</a></div>`;
  } else if (filetype === "xlsx" || filetype === "docx") {
    preview.innerHTML = `<div class="flex flex-col items-center justify-center h-40">
      <i data-lucide="${filetype === 'xlsx' ? 'file-spreadsheet' : 'file-text'}" class="w-12 h-12 text-blue-600 mb-2"></i>
      <div class="text-sm text-gray-700 mb-1">${filetype.toUpperCase()} file cannot be previewed here.</div>
      <a class="text-blue-600 hover:underline text-xs" href="${documentUrl}" target="_blank">Download File</a>
    </div>`;
    lucide.createIcons();
  } else {
    preview.innerHTML = `<div class="text-sm text-gray-700">Preview not available.</div>`;
  }
}

function closeViewModal() {
  document.getElementById('viewDocumentModal').classList.add('hidden');
}
</script>
<script>
        // Simple drag and drop highlight effect
        const dropArea = document.querySelector('.border-dashed');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('border-blue-500', 'bg-blue-50');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-blue-500', 'bg-blue-50');
        }
    </script>
    </body>
<script src="../soliera.js"></script>
</html>