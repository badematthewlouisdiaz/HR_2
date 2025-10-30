<?php

session_start();
include("../db.php")
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HR Portal - Time & Attendance</title>
<link href="https://cdn.jsdelivr.net/npm/daisyui@3.9.4/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
  <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../soliera.css">
        <link rel="stylesheet" href="../sidebar.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3a0ca3;
      --accent: #f72585;
      --light: #f8f9fa;
      --dark: #212529;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
      animation: fadeIn 0.5s ease-out forwards;
    }
    
    .card-hover {
      transition: all 0.3s ease;
    }
    
    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
    }
  </style>
</head>


  <div class="flex h-screen">
    <!-- Sidebar -->
    <?php include '../USM/sidebarr.php'; ?>

    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Navbar -->
        <?php include '../USM/navbar.php'; ?>
  <!-- Main Container -->



    <!-- Content Area -->
    <div class="flex flex-col flex-1 overflow-auto">
    
      <main class="flex-1 p-6 overflow-y-auto">
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
          <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 card-hover">
            <div class="flex justify-between items-center">
              <h3 class="text-gray-500 text-sm font-medium">Hours This Week</h3>
              <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                <i data-lucide="clock" class="text-blue-500"></i>
              </div>
            </div>
            <p class="text-2xl font-bold mt-3">38.5<span class="text-sm font-normal text-gray-500 ml-1">/40 hrs</span></p>
          </div>
          
          <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 card-hover">
            <div class="flex justify-between items-center">
              <h3 class="text-gray-500 text-sm font-medium">Upcoming Time Off</h3>
              <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                <i data-lucide="calendar" class="text-green-500"></i>
              </div>
            </div>
            <p class="text-2xl font-bold mt-3">2<span class="text-sm font-normal text-gray-500 ml-1">days</span></p>
          </div>
          
          <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 card-hover">
            <div class="flex justify-between items-center">
              <h3 class="text-gray-500 text-sm font-medium">Overtime</h3>
              <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                <i data-lucide="alert-circle" class="text-amber-500"></i>
              </div>
            </div>
            <p class="text-2xl font-bold mt-3">3.5<span class="text-sm font-normal text-gray-500 ml-1">hours</span></p>
          </div>
          
          <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 card-hover">
            <div class="flex justify-between items-center">
              <h3 class="text-gray-500 text-sm font-medium">Team Attendance</h3>
              <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                <i data-lucide="users" class="text-purple-500"></i>
              </div>
            </div>
            <p class="text-2xl font-bold mt-3">92<span class="text-sm font-normal text-gray-500 ml-1">%</span></p>
          </div>
        </div>

        <!-- Calendar Header -->
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 mb-6">
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div class="flex items-center space-x-4 mb-4 md:mb-0">
              <h2 class="text-xl font-semibold" id="month-label">August 2025</h2>
              <a href="#" class="text-blue-500 font-medium hover:text-blue-700 transition-colors" onclick="goToToday()">Today</a>
            </div>
            <div class="flex items-center space-x-2">
              <button class="btn btn-sm btn-outline border-gray-300" onclick="prevWeek()">
                <i data-lucide="chevron-left" class="w-4 h-4"></i>
              </button>
              <button class="btn btn-sm bg-blue-500 text-white border-blue-500 hover:bg-blue-600" onclick="nextWeek()">
                <i data-lucide="chevron-right" class="w-4 h-4"></i>
              </button>
            </div>
          </div>

          <!-- Calendar Grid -->
          <div class="overflow-x-auto">
            <div id="calendar-days" class="grid grid-cols-7 text-center text-sm font-medium text-gray-600 min-w-[600px]"></div>
            <div id="calendar-grid" class="grid grid-cols-7 gap-3 mt-4 min-w-[600px]">
              <!-- Calendar cells will be populated by JavaScript -->
            </div>
          </div>
        </div>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Upcoming Shifts -->
          <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-5">
              <h3 class="font-semibold text-lg">Upcoming Shifts</h3>
              <button class="text-sm text-blue-500 hover:text-blue-700 font-medium">View All</button>
            </div>
            <div id="upcoming-shifts" class="space-y-4">
              <!-- Shifts will be populated by JavaScript -->
            </div>
          </div>

          <!-- Recent Activities -->
          <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
            <div class="flex justify-between items-center mb-5">
              <h3 class="font-semibold text-lg">Recent Activities</h3>
              <button class="text-sm text-blue-500 hover:text-blue-700 font-medium">View All</button>
            </div>
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 shrink-0">
                  <i data-lucide="check-circle" class="text-green-500 w-5 h-5"></i>
                </div>
                <div>
                  <p class="font-medium">Clock-in recorded</p>
                  <p class="text-sm text-gray-500">Today at 8:02 AM</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 shrink-0">
                  <i data-lucide="edit" class="text-blue-500 w-5 h-5"></i>
                </div>
                <div>
                  <p class="font-medium">Time-off request submitted</p>
                  <p class="text-sm text-gray-500">Yesterday at 3:45 PM</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center mr-3 shrink-0">
                  <i data-lucide="file-text" class="text-purple-500 w-5 h-5"></i>
                </div>
                <div>
                  <p class="font-medium">Timesheet approved</p>
                  <p class="text-sm text-gray-500">August 15, 2025</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Helper: Map event type to classes
    function getEventClass(type) {
      switch(type) {
        case 'Meeting': return 'bg-green-100 border-l-4 border-green-500 text-green-800';
        case 'Training': return 'bg-pink-100 border-l-4 border-pink-500 text-pink-800';
        case 'Time Off': return 'bg-amber-100 border-l-4 border-amber-500 text-amber-800';
        case 'Shift': default: return 'bg-blue-100 border-l-4 border-blue-500 text-blue-800';
      }
    }

    // Helper: Get start of week (Monday)
    function getMonday(d) {
      d = new Date(d);
      var day = d.getDay(),
          diff = d.getDate() - day + (day === 0 ? -6 : 1);
      return new Date(d.setDate(diff));
    }

    // State for current week
    let currentDate = new Date('2025-08-11'); // Initial week

    function updateMonthLabel() {
      const monthLabel = document.getElementById('month-label');
      const options = { month: 'long', year: 'numeric' };
      monthLabel.textContent = currentDate.toLocaleDateString(undefined, options);
    }

    function renderCalendarDays() {
      const monday = getMonday(currentDate);
      let html = '';
      for(let i=0; i<7; i++) {
        const d = new Date(monday);
        d.setDate(monday.getDate() + i);
        const dayName = d.toLocaleDateString(undefined, { weekday: 'short' });
        const dayNum = d.getDate();
        const isToday = new Date().toDateString() === d.toDateString();
        
        html += `
          <div class="py-2 ${isToday ? 'bg-blue-50 rounded-lg' : ''}">
            ${dayName}<br>
            <span class="text-lg font-bold ${isToday ? 'text-blue-500' : ''}">${dayNum}</span>
          </div>
        `;
      }
      document.getElementById('calendar-days').innerHTML = html;
    }

    // Sample events data
    const sampleEvents = [
      { event_date: '2025-08-11', start_time: '09:00:00', end_time: '17:00:00', title: 'Regular Shift', type: 'Shift' },
      { event_date: '2025-08-12', start_time: '10:00:00', end_time: '11:30:00', title: 'Team Meeting', type: 'Meeting' },
      { event_date: '2025-08-12', start_time: '13:00:00', end_time: '14:30:00', title: 'New Software Training', type: 'Training' },
      { event_date: '2025-08-13', start_time: '09:00:00', end_time: '17:00:00', title: 'Regular Shift', type: 'Shift' },
      { event_date: '2025-08-14', start_time: '09:00:00', end_time: '17:00:00', title: 'Regular Shift', type: 'Shift' },
      { event_date: '2025-08-15', start_time: '08:00:00', end_time: '12:00:00', title: 'Morning Shift', type: 'Shift' },
      { event_date: '2025-08-16', start_time: '00:00:00', end_time: '23:59:00', title: 'Day Off', type: 'Time Off' },
    ];

    function loadEvents() {
      const events = sampleEvents;

      // ========== Calendar Grid ==========
      const calendarGrid = document.getElementById('calendar-grid');
      calendarGrid.innerHTML = '';
      const monday = getMonday(currentDate);

      for(let i=0; i<7; i++) {
        const d = new Date(monday);
        d.setDate(monday.getDate() + i);
        const dateStr = d.toISOString().slice(0,10);
        const dayEvents = events.filter(ev => ev.event_date === dateStr);
        const isToday = new Date().toDateString() === d.toDateString();
        
        let cellContent = '';
        
        if (dayEvents.length === 0) {
          cellContent = '';
        } else if (dayEvents.length === 1) {
          const ev = dayEvents[0];
          cellContent = `
            <div class="${getEventClass(ev.type)} rounded-lg p-3 text-sm">
              <p class="font-semibold truncate">${ev.title}</p>
              <p class="text-xs mt-1">${ev.start_time.substring(0,5)} - ${ev.end_time.substring(0,5)}</p>
            </div>
          `;
        } else {
          let stack = '';
          for (const ev of dayEvents.slice(0, 2)) {
            stack += `
              <div class="${getEventClass(ev.type)} rounded-lg p-2 mb-2 text-sm">
                <p class="font-semibold truncate">${ev.title}</p>
                <p class="text-xs mt-1">${ev.start_time.substring(0,5)}</p>
              </div>
            `;
          }
          if (dayEvents.length > 2) {
            stack += `<p class="text-xs text-gray-500 text-center">+${dayEvents.length - 2} more</p>`;
          }
          cellContent = `<div class="space-y-2">${stack}</div>`;
        }
        
        calendarGrid.innerHTML += `
          <div class="min-h-[120px] p-2 ${isToday ? 'bg-blue-50 rounded-lg border border-blue-200' : ''}">
            ${cellContent}
          </div>
        `;
      }

      // ========== Upcoming Shifts for Visible Week ==========
      const weekMonday = getMonday(currentDate);
      const weekSunday = new Date(weekMonday);
      weekSunday.setDate(weekMonday.getDate() + 6);

      const upcoming = events
        .filter(ev => {
          const d = new Date(ev.event_date);
          return ev.type === 'Shift' && d >= weekMonday && d <= weekSunday;
        })
        .sort((a, b) => new Date(a.event_date) - new Date(b.event_date));

      const upcomingDiv = document.getElementById('upcoming-shifts');
      upcomingDiv.innerHTML = '';
      
      if (upcoming.length === 0) {
        upcomingDiv.innerHTML = `
          <div class="text-center py-4 text-gray-500">
            <i data-lucide="calendar" class="w-12 h-12 mx-auto text-gray-300"></i>
            <p class="mt-2">No shifts scheduled for this week</p>
          </div>
        `;
      } else {
        for (const ev of upcoming) {
          const d = new Date(ev.event_date);
          const options = { weekday: 'short', day: 'numeric', month: 'short' };
          const dateStr = d.toLocaleDateString(undefined, options);
          
          upcomingDiv.innerHTML += `
            <div class="flex items-center border border-gray-200 rounded-lg p-3 hover:bg-gray-50 transition-colors">
              <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-3 shrink-0">
                <i data-lucide="clock" class="text-blue-500 w-5 h-5"></i>
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-semibold">${dateStr}</p>
                <p class="text-sm text-gray-500">${ev.start_time.substring(0,5)} - ${ev.end_time.substring(0,5)} · ${ev.title}</p>
              </div>
            </div>
          `;
        }
      }
      
      lucide.createIcons();
    }

    function renderAll() {
      updateMonthLabel();
      renderCalendarDays();
      loadEvents();
    }

    function prevWeek() {
      currentDate.setDate(currentDate.getDate() - 7);
      renderAll();
    }

    function nextWeek() {
      currentDate.setDate(currentDate.getDate() + 7);
      renderAll();
    }

    function goToToday() {
      currentDate = getMonday(new Date());
      renderAll();
    }

    // Initial render
    renderAll();

  </script>

    <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>

</body>
</html>