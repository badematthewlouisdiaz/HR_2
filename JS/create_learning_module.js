// Initialize Quill editor
const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: false // We'll use our custom toolbar
    }
});

// Ensure editor element is typable/focused if Quill not available for fallback
document.addEventListener('DOMContentLoaded', () => {
    const editorEl = document.getElementById('editor');
    if (editorEl) {
        editorEl.setAttribute('contenteditable', 'true');
        // If Quill loaded, Quill will control content; otherwise ensure placeholder content
        if (!window.Quill) {
            editorEl.innerHTML = '<p style="text-align: justify; letter-spacing: 0.05em;">Start creating your learning module content here...</p>';
        } else {
            // If quill is present and empty, set initial content
            if (quill && quill.getLength() === 1) {
                quill.root.innerHTML = '<p style="text-align: justify; letter-spacing: 0.05em;">Start creating your learning module content here...</p>';
            }
        }
    }
});

// Progress tracking variables
let progressSections = [];
let currentProgress = 0;

// DOM Elements
const saveModuleBtn = document.getElementById('saveModuleBtn');
const moduleForm = document.getElementById('moduleForm');
const moduleContent = document.getElementById('moduleContent');
const progressTrackingBtn = document.getElementById('progressTrackingBtn');
const progressTrackingSection = document.getElementById('progressTrackingSection');
const progressSectionsContainer = document.getElementById('progressSections');
const progressBar = document.getElementById('progressBar');
const progressStats = document.getElementById('progressStats');
const progressStatus = document.getElementById('progressStatus');

// Save Module Function
if (saveModuleBtn) {
saveModuleBtn.addEventListener('click', function(e) {
    e.preventDefault();
    console.log('Save button clicked');
    
    // Get form values from hidden fields
    const title = document.querySelector('input[name="title"]').value;
    const topic = document.querySelector('input[name="topic"]').value;
    const department = document.querySelector('input[name="department"]').value;
    const roles = document.querySelector('input[name="roles"]').value;

    console.log('Form values:', { title, topic, department, roles });

    // Validate form
    if (!title || !topic || !department || !roles) {
        Swal.fire({
            icon: 'error',
            title: 'Missing Information',
            text: 'Please fill in all required fields.',
            confirmButtonColor: '#3b82f6'
        });
        return;
    }

    // Set the content from Quill editor (or fallback editor HTML)
    if (moduleContent) {
        try {
            moduleContent.value = (typeof quill !== 'undefined') ? quill.root.innerHTML : document.getElementById('editor').innerHTML;
        } catch (err) {
            moduleContent.value = document.getElementById('editor').innerHTML;
        }
        console.log('Content set:', moduleContent.value.length, 'characters');
    } else {
        console.error('moduleContent element not found');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Cannot save content. Please refresh the page and try again.',
            confirmButtonColor: '#3b82f6'
        });
        return;
    }

    // Show confirmation for pending status
    Swal.fire({
        title: 'Save Module?',
        text: 'The module will be saved with "Pending" status and submitted for review.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save Module',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280'
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            const originalHTML = saveModuleBtn.innerHTML;
            saveModuleBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
            saveModuleBtn.disabled = true;
            
            console.log('Submitting form...');
            
            // Submit the form
            moduleForm.submit();
        }
    });
});
}

// Set up event listeners for toolbar
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - initializing...');
    
    setupEventListeners();
    initializeProgressTracking();
    
    // Initial page calculation
    setTimeout(updatePageCount, 500);
});

// Initialize progress tracking
function initializeProgressTracking() {
    // Add default sections
    progressSections = [
        { id: 1, title: 'Introduction', completed: false },
        { id: 2, title: 'Learning Objectives', completed: false },
        { id: 3, title: 'Main Content', completed: false },
        { id: 4, title: 'Examples/Case Studies', completed: false },
        { id: 5, title: 'Assessment/Quiz', completed: false },
        { id: 6, title: 'Summary/Conclusion', completed: false }
    ];
    
    renderProgressSections();
    updateProgress();
}

// Render progress sections (for the left panel - kept for compatibility)
function renderProgressSections() {
    if (!progressSectionsContainer) return;
    
    progressSectionsContainer.innerHTML = '';
    
    progressSections.forEach(section => {
        const sectionElement = document.createElement('div');
        sectionElement.className = `progress-section ${section.completed ? 'completed' : ''}`;
        sectionElement.innerHTML = `
            <input type="checkbox" class="section-checkbox" ${section.completed ? 'checked' : ''} data-id="${section.id}">
            <div class="section-title">${section.title}</div>
            <div class="section-status ${section.completed ? 'completed' : ''}">${section.completed ? 'Completed' : 'Pending'}</div>
        `;
        
        progressSectionsContainer.appendChild(sectionElement);
    });
    
    // Add event listeners to checkboxes
    document.querySelectorAll('.section-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const sectionId = parseInt(this.getAttribute('data-id'));
            toggleSectionCompletion(sectionId, this.checked);
        });
    });
}

// Toggle section completion
function toggleSectionCompletion(sectionId, completed) {
    const section = progressSections.find(s => s.id === sectionId);
    if (section) {
        section.completed = completed;
        renderProgressSections();
        updateProgress();
    }
}

// Update progress (left panel)
function updateProgress() {
    const completedSections = progressSections.filter(s => s.completed).length;
    const totalSections = progressSections.length;
    currentProgress = totalSections > 0 ? Math.round((completedSections / totalSections) * 100) : 0;
    
    if (progressBar) progressBar.style.width = `${currentProgress}%`;
    if (progressStats) progressStats.textContent = `${currentProgress}% Complete`;
    if (progressStatus) progressStatus.textContent = `Progress: ${currentProgress}%`;
    
    // Change progress bar color based on completion
    if (progressBar) {
        if (currentProgress < 30) {
            progressBar.style.backgroundColor = '#dc3545'; // Red
        } else if (currentProgress < 70) {
            progressBar.style.backgroundColor = '#ffc107'; // Yellow
        } else {
            progressBar.style.backgroundColor = '#28a745'; // Green
        }
    }
}

// Update page count based on content height
function updatePageCount() {
    const editor = document.querySelector('.ql-editor');
    const pageInfo = document.getElementById('pageInfo');
    
    if (!editor || !pageInfo) return;
    
    const contentHeight = editor.scrollHeight;
    const pageHeight = 9 * 96; // 9in in pixels (11in - 2in padding)
    const pages = Math.max(1, Math.ceil(contentHeight / pageHeight));
    
    pageInfo.textContent = `Page 1 of ${pages}`;
}

// Toggle progress tracking section (left panel)
if (progressTrackingBtn && progressTrackingSection) {
    progressTrackingBtn.addEventListener('click', function() {
        const isVisible = progressTrackingSection.style.display !== 'none';
        progressTrackingSection.style.display = isVisible ? 'none' : 'block';
        this.classList.toggle('active', !isVisible);
    });
}

// Set up all event listeners
function setupEventListeners() {
    console.log('Setting up event listeners...');
    
    // Toolbar buttons
    const saveBtn = document.getElementById('saveBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            Swal.fire({
                icon: 'info',
                title: 'Content Saved Locally',
                text: 'Use "Save Module" button above to save to repository.',
                confirmButtonColor: '#3b82f6'
            });
        });
    }
    
    // Add other toolbar event listeners with null checks
    const printBtn = document.getElementById('printBtn');
    if (printBtn) printBtn.addEventListener('click', printDocument);
    
    const undoBtn = document.getElementById('undoBtn');
    if (undoBtn) undoBtn.addEventListener('click', () => quill.history.undo());
    
    const redoBtn = document.getElementById('redoBtn');
    if (redoBtn) redoBtn.addEventListener('click', () => quill.history.redo());
    
    // Formatting buttons
    const boldBtn = document.getElementById('boldBtn');
    if (boldBtn) boldBtn.addEventListener('click', () => formatText('bold'));
    
    const italicBtn = document.getElementById('italicBtn');
    if (italicBtn) italicBtn.addEventListener('click', () => formatText('italic'));
    
    const underlineBtn = document.getElementById('underlineBtn');
    if (underlineBtn) underlineBtn.addEventListener('click', () => formatText('underline'));
    
    const strikeBtn = document.getElementById('strikeBtn');
    if (strikeBtn) strikeBtn.addEventListener('click', () => formatText('strike'));
    
    // Alignment buttons
    const alignLeftBtn = document.getElementById('alignLeftBtn');
    if (alignLeftBtn) alignLeftBtn.addEventListener('click', () => formatText('align', 'left'));
    
    const alignCenterBtn = document.getElementById('alignCenterBtn');
    if (alignCenterBtn) alignCenterBtn.addEventListener('click', () => formatText('align', 'center'));
    
    const alignRightBtn = document.getElementById('alignRightBtn');
    if (alignRightBtn) alignRightBtn.addEventListener('click', () => formatText('align', 'right'));
    
    const alignJustifyBtn = document.getElementById('alignJustifyBtn');
    if (alignJustifyBtn) alignJustifyBtn.addEventListener('click', () => formatText('align', 'justify'));
    
    // List buttons
    const bulletListBtn = document.getElementById('bulletListBtn');
    if (bulletListBtn) bulletListBtn.addEventListener('click', () => formatText('list', 'bullet'));
    
    const numberListBtn = document.getElementById('numberListBtn');
    if (numberListBtn) numberListBtn.addEventListener('click', () => formatText('list', 'ordered'));
    
    const indentBtn = document.getElementById('indentBtn');
    if (indentBtn) indentBtn.addEventListener('click', () => formatText('indent', '+1'));
    
    const outdentBtn = document.getElementById('outdentBtn');
    if (outdentBtn) outdentBtn.addEventListener('click', () => formatText('indent', '-1'));
    
    // Color pickers
    const textColor = document.getElementById('textColor');
    if (textColor) textColor.addEventListener('change', (e) => formatText('color', e.target.value));
    
    const highlightColor = document.getElementById('highlightColor');
    if (highlightColor) highlightColor.addEventListener('change', (e) => formatText('background', e.target.value));
    
    // Font controls
    const fontFamily = document.getElementById('fontFamily');
    if (fontFamily) fontFamily.addEventListener('change', (e) => formatText('font', e.target.value));
    
    const fontSize = document.getElementById('fontSize');
    if (fontSize) fontSize.addEventListener('change', (e) => formatText('size', e.target.value));
    
    // Insert buttons
    const insertImageBtn = document.getElementById('insertImageBtn');
    if (insertImageBtn) insertImageBtn.addEventListener('click', insertImage);
    
    const insertLinkBtn = document.getElementById('insertLinkBtn');
    if (insertLinkBtn) insertLinkBtn.addEventListener('click', insertLink);
    
    const insertTableBtn = document.getElementById('insertTableBtn');
    if (insertTableBtn) insertTableBtn.addEventListener('click', insertTable);
    
    // Utility buttons
    const findReplaceBtn = document.getElementById('findReplaceBtn');
    if (findReplaceBtn) findReplaceBtn.addEventListener('click', findReplace);
    
    const wordCountBtn = document.getElementById('wordCountBtn');
    if (wordCountBtn) wordCountBtn.addEventListener('click', showWordCount);
    
    // Zoom buttons
    const zoomInBtn = document.getElementById('zoomInBtn');
    if (zoomInBtn) zoomInBtn.addEventListener('click', zoomIn);
    
    const zoomOutBtn = document.getElementById('zoomOutBtn');
    if (zoomOutBtn) zoomOutBtn.addEventListener('click', zoomOut);
    
    // Theme toggle
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) themeToggle.addEventListener('click', toggleTheme);
    
    // Update word count and page count on text change
    if (quill) {
        quill.on('text-change', function() {
            updateWordCount();
            // Delay page count update to ensure DOM is updated
            setTimeout(updatePageCount, 100);
        });
    } else {
        // Fallback for non-Quill editing region
        const editorEl = document.getElementById('editor');
        if (editorEl) {
            editorEl.addEventListener('input', function() {
                updateWordCount();
                setTimeout(updatePageCount, 100);
            });
        }
    }
    
    console.log('Event listeners setup complete');
}

// Format text
function formatText(format, value) {
    if (quill) quill.format(format, value);
}

// Insert image
function insertImage() {
    const url = prompt('Enter image URL:');
    if (url) {
        const range = quill.getSelection() || { index: quill.getLength() };
        quill.insertEmbed(range.index, 'image', url);
    }
}

// Insert link
function insertLink() {
    const url = prompt('Enter link URL:');
    if (url) {
        quill.format('link', url);
    }
}

// Insert table
function insertTable() {
    const rows = parseInt(prompt('Enter number of rows:', '3'));
    const cols = parseInt(prompt('Enter number of columns:', '3'));
    
    if (rows && cols) {
        let tableHTML = '<table style="width: 100%; border-collapse: collapse;">';
        for (let i = 0; i < rows; i++) {
            tableHTML += '<tr>';
            for (let j = 0; j < cols; j++) {
                tableHTML += `<td style="border: 1px solid #ccc; padding: 8px;">&nbsp;</td>`;
            }
            tableHTML += '</tr>';
        }
        tableHTML += '</table>';
        
        const range = quill.getSelection() || { index: quill.getLength() };
        quill.clipboard.dangerouslyPasteHTML(range.index, tableHTML);
    }
}

// Find and replace
function findReplace() {
    const find = prompt('Find:');
    if (find) {
        const replace = prompt('Replace with:');
        const content = quill.getText();
        const newContent = content.replace(new RegExp(find, 'g'), replace);
        
        // This is a simple implementation - in a real app, you'd want more sophisticated find/replace
        quill.setText(newContent);
    }
}

// Show word count
function showWordCount() {
    const text = (quill ? quill.getText() : document.getElementById('editor').innerText).trim();
    const words = text ? text.split(/\s+/).length : 0;
    const characters = text.length;
    
    Swal.fire({
        title: 'Document Statistics',
        html: `
            <div class="text-left">
                <p><strong>Words:</strong> ${words}</p>
                <p><strong>Characters:</strong> ${characters}</p>
                <p><strong>Progress:</strong> ${currentProgress}%</p>
            </div>
        `,
        icon: 'info',
        confirmButtonColor: '#3b82f6'
    });
}

// Update word count
function updateWordCount() {
    const text = (quill ? quill.getText() : document.getElementById('editor').innerText).trim();
    const words = text ? text.split(/\s+/).length : 0;
    const characters = text.length;
    
    const wordCountElem = document.getElementById('wordCount');
    const charCountElem = document.getElementById('charCount');
    
    if (wordCountElem) wordCountElem.textContent = `Words: ${words}`;
    if (charCountElem) charCountElem.textContent = `Characters: ${characters}`;
}

// Zoom in
function zoomIn() {
    const editor = document.querySelector('.editor-wrapper');
    if (!editor) return;
    
    const currentZoom = parseFloat(getComputedStyle(editor).zoom) || 1;
    const newZoom = Math.min(currentZoom + 0.1, 2.0);
    editor.style.zoom = newZoom;
    
    const zoomLevel = document.getElementById('zoomLevel');
    if (zoomLevel) zoomLevel.textContent = `${Math.round(newZoom * 100)}%`;
}

// Zoom out
function zoomOut() {
    const editor = document.querySelector('.editor-wrapper');
    if (!editor) return;
    
    const currentZoom = parseFloat(getComputedStyle(editor).zoom) || 1;
    const newZoom = Math.max(currentZoom - 0.1, 0.5);
    editor.style.zoom = newZoom;
    
    const zoomLevel = document.getElementById('zoomLevel');
    if (zoomLevel) zoomLevel.textContent = `${Math.round(newZoom * 100)}%`;
}

// Print document
function printDocument() {
    const content = (quill ? quill.root.innerHTML : document.getElementById('editor').innerHTML);
    const printWindow = window.open('', '_blank');
    
    printWindow.document.write(`
        <html>
            <head>
                <title>Print Document</title>
                <style>
                    @page {
                        size: letter;
                        margin: 1in;
                    }
                    body { 
                        font-family: 'Calibri', sans-serif; 
                        font-size: 11pt; 
                        line-height: 1.15; 
                        letter-spacing: 0.05em;
                        margin: 0;
                        padding: 0;
                    }
                    .content {
                        width: 6.5in;
                        padding: 1in;
                    }
                </style>
            </head>
            <body>
                <div class="content">
                    ${content}
                </div>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

// Toggle theme
function toggleTheme() {
    const isDarkMode = document.body.classList.toggle('dark-mode');
    const themeIcon = document.getElementById('themeToggle');
    if (themeIcon) {
        const icon = themeIcon.querySelector('i');
        if (icon) {
            icon.className = isDarkMode ? 'fas fa-sun' : 'fas fa-moon';
        }
    }
} 

/* ============================================================
   NEW: Embedded Tracker Insertion + Modal handling + progress
   ============================================================ */

document.addEventListener('DOMContentLoaded', function(){
    // Elements in modal
    const insertTrackerBtn = document.getElementById('insertTrackerBtn');
    const trackerModal = document.getElementById('trackerModal');
    const customSectionsContainer = document.getElementById('customSectionsContainer');
    const addCustomSectionBtn = document.getElementById('addCustomSectionBtn');
    const customSectionInput = document.getElementById('customSectionInput');

    // Add custom section to the modal list
    if (addCustomSectionBtn) {
        addCustomSectionBtn.addEventListener('click', function(){
            const name = (customSectionInput.value || '').trim();
            if (!name) return;
            const id = 'custom_' + Date.now();
            const wrapper = document.createElement('div');
            wrapper.className = 'custom-section-item';
            wrapper.innerHTML = `
                <input class="form-check-input tracker-section-checkbox" type="checkbox" value="${escapeHtml(name)}" id="${id}" checked>
                <label class="form-check-label" for="${id}">${escapeHtml(name)}</label>
                <button type="button" class="btn btn-sm btn-outline-danger ms-auto remove-custom-btn">Remove</button>
            `;
            customSectionsContainer.appendChild(wrapper);
            customSectionInput.value = '';
            wrapper.querySelector('.remove-custom-btn').addEventListener('click', function(){
                wrapper.remove();
            });
        });
    }

    // When user clicks "Insert Tracker"
    const modalInsertBtn = document.getElementById('insertTrackerBtn');
    if (modalInsertBtn) {
        modalInsertBtn.addEventListener('click', function(){
            const selected = [];
            document.querySelectorAll('.tracker-section-checkbox').forEach(cb => {
                if (cb.checked) selected.push(cb.value.trim());
            });

            // If custom section inputs exist in modal markup (fallback)
            document.querySelectorAll('#customSectionsContainer .tracker-section-checkbox').forEach(cb => {
                if (cb.checked) selected.push(cb.value.trim());
            });

            if (selected.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No sections selected',
                    text: 'Please select at least one section to insert a tracker.',
                    confirmButtonColor: '#3b82f6'
                });
                return;
            }

            const total = selected.length;
            const tableId = 'tracker_' + Date.now();
            const headerHtml = `<div class="embedded-progress">Overall Progress: <span id="${tableId}_progress">0%</span></div>`;
            let tableHtml = `<table class="embedded-tracker" data-tracker-id="${tableId}" id="${tableId}">`;
            tableHtml += '<thead><tr><th style="width:30px;">Done</th><th>Section</th><th>Status</th></tr></thead><tbody>';
            selected.forEach((sec, idx) => {
                const checkboxId = tableId + '_chk_' + idx;
                tableHtml += `<tr>
                    <td style="text-align:center;"><input type="checkbox" class="embedded-tracker-checkbox" data-tracker="${tableId}" id="${checkboxId}"></td>
                    <td>${escapeHtml(sec)}</td>
                    <td class="tracker-status" data-tracker="${tableId}">Pending</td>
                </tr>`;
            });
            tableHtml += '</tbody></table><p></p>';

            const range = quill.getSelection() || { index: quill.getLength() };
            quill.clipboard.dangerouslyPasteHTML(range.index, headerHtml + tableHtml);

            setTimeout(function(){
                wireEmbeddedTracker(tableId);
                updateEmbeddedTrackerProgress(tableId);
                updateWordCount();
            }, 150);
        });
    }

    function escapeHtml(unsafe) {
        return unsafe
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");
    }

    function wireAllExistingTrackers() {
        document.querySelectorAll('table.embedded-tracker').forEach(tbl => {
            const tid = tbl.dataset.trackerId || tbl.id;
            if (tid) wireEmbeddedTracker(tid);
        });
    }

    wireAllExistingTrackers();

    function wireEmbeddedTracker(trackerId) {
        const checkboxSelector = `input.embedded-tracker-checkbox[data-tracker="${trackerId}"]`;
        const checkboxes = document.querySelectorAll(checkboxSelector);
        checkboxes.forEach(cb => {
            const newCb = cb.cloneNode(true);
            cb.parentNode.replaceChild(newCb, cb);
            newCb.addEventListener('change', function(e){
                const row = newCb.closest('tr');
                if (row) {
                    const status = row.querySelector('.tracker-status');
                    if (newCb.checked) {
                        status.textContent = 'Completed';
                    } else {
                        status.textContent = 'Pending';
                    }
                }
                updateEmbeddedTrackerProgress(trackerId);
            });
        });
    }

    function updateEmbeddedTrackerProgress(trackerId) {
        const tbl = document.getElementById(trackerId);
        if (!tbl) return;
        const checkboxes = tbl.querySelectorAll('input.embedded-tracker-checkbox');
        const total = checkboxes.length || 1;
        let completed = 0;
        checkboxes.forEach(cb => { if (cb.checked) completed++; });

        const percent = Math.round((completed / total) * 100);
        const progressSpan = document.getElementById(trackerId + '_progress');
        if (progressSpan) progressSpan.textContent = percent + '%';
        const progressStatus = document.getElementById('progressStatus');
        if (progressStatus) progressStatus.textContent = `Progress: ${percent}%`;

        if (progressSpan) {
            progressSpan.style.color = (percent < 30) ? '#dc3545' : (percent < 70 ? '#b45309' : '#16a34a');
        }
    }

    const editorContainer = document.querySelector('.ql-editor');
    if (editorContainer) {
        const observer = new MutationObserver(function(mutationsList){
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList' || mutation.type === 'subtree') {
                    wireAllExistingTrackers();
                }
            }
        });
        observer.observe(editorContainer, { childList: true, subtree: true });
    }

}); // DOMContentLoaded end

/* End of new embedded tracker code */
