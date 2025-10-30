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
          <!-- Header -->
          <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            
          </div>

          <!-- Stats Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Regular Hours -->
            <div class="card bg-base-100 shadow">
              <div class="card-body p-4 md:p-6">
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-sm font-medium">Regular Hours</h3>
                    <p class="text-2xl font-bold mt-1">
                      <span id="regular-hours">142.5</span>
                      <span class="text-lg">/ 160</span>
                    </p>
                  </div>
                  <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                    <i data-lucide="clock" class="w-5 h-5"></i>
                  </div>
                </div>
                <progress class="progress progress-primary w-full mt-3" 
                  value="89" max="100"></progress>
              </div>
            </div>
            <!-- Overtime Hours -->
            <div class="card bg-base-100 shadow">
              <div class="card-body p-4 md:p-6">
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-sm font-medium">Overtime Hours</h3>
                    <p class="text-2xl font-bold mt-1">
                      <span id="overtime-hours">2.5</span>
                      <span class="text-lg">/ 0</span>
                    </p>
                  </div>
                  <div class="p-2 rounded-lg bg-orange-100 text-orange-600">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                  </div>
                </div>
                <progress class="progress progress-warning w-full mt-3" 
                  value="100" max="100"></progress>
              </div>
            </div>
            <!-- Days Present -->
            <div class="card bg-base-100 shadow">
              <div class="card-body p-4 md:p-6">
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-sm font-medium">Days Present</h3>
                    <p class="text-2xl font-bold mt-1">
                      <span id="days-present">18</span>
                      <span class="text-lg">/ 20</span>
                    </p>
                  </div>
                  <div class="p-2 rounded-lg bg-green-100 text-green-600">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                  </div>
                </div>
                <progress class="progress progress-success w-full mt-3" 
                  value="90" max="100"></progress>
              </div>
            </div>
            <!-- Days Absent -->
            <div class="card bg-base-100 shadow">
              <div class="card-body p-4 md:p-6">
                <div class="flex justify-between items-start">
                  <div>
                    <h3 class="text-sm font-medium">Days Absent</h3>
                    <p class="text-2xl font-bold mt-1">
                      <span id="days-absent">2</span>
                      <span class="text-lg">/ 0</span>
                    </p>
                  </div>
                  <div class="p-2 rounded-lg bg-red-100 text-red-600">
                    <i data-lucide="x-circle" class="w-5 h-5"></i>
                  </div>
                </div>
                <progress class="progress progress-error w-full mt-3" 
                  value="100" max="100"></progress>
              </div>
            </div>
          </div>

          <!-- Today's Attendance and History -->
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <!-- Today's Attendance -->
            <div class="card bg-base-100 shadow lg:col-span-1">
              <div class="card-body">
                <h2 class="card-title text-lg mb-4">Today's Attendance</h2>
                <div class="space-y-4">
                  <!-- Clock In -->
                  <div>
                    <p class="text-sm">Clock In Time</p>
                    <p class="text-xl font-semibold" id="today-clock-in">08:55 AM</p>
                  </div>
                  <!-- Current Date -->
                  <div>
                    <p class="text-sm">Date</p>
                    <p class="text-xl font-semibold" id="current-date-card">Tuesday, August 19</p>
                  </div>
                  <!-- Clock Out -->
                  <div>
                    <p class="text-sm">Clock Out Time</p>
                    <p class="text-xl font-semibold" id="today-clock-out">--:-- --</p>
                  </div>
                  <!-- Action Buttons -->
                  <div class="flex flex-col gap-2 pt-2">
                    <button id="clock-in-btn" class="btn btn-primary gap-2" onclick="clockIn()">
                      <i data-lucide="log-in" class="w-5 h-5"></i>
                      Clock In
                    </button>
                    <button id="clock-out-btn" class="btn btn-error gap-2 hidden" onclick="clockOut()">
                      <i data-lucide="log-out" class="w-5 h-5"></i>
                      Clock Out
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Timesheet History Tabs -->
            <div class="card bg-base-100 shadow lg:col-span-2">
              <div class="card-body">
                <h2 class="card-title text-lg mb-4">Timesheet History</h2>
                <!-- Tabs for history -->
                <div role="tablist" class="tabs tabs-boxed mb-4">
                  <a role="tab" class="tab tab-active" id="tab-week" onclick="showHistory('week')">By Week</a>
                  <a role="tab" class="tab" id="tab-month" onclick="showHistory('month')">By Month</a>
                  <a role="tab" class="tab" id="tab-year" onclick="showHistory('year')">By Year</a>
                </div>
                <div class="overflow-x-auto">
                  <!-- Week Table -->
                  <table class="table table-zebra" id="history-week">
                    <thead>
                      <tr>
                        <th>Date</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Total Hours</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Mon, 1 May</td>
                        <td>08:55</td>
                        <td>17:05</td>
                        <td>8h 10m</td>
                        <td><span class="badge badge-black">Approved</span></td>
                      </tr>
                      <tr>
                        <td>Tue, 2 May</td>
                        <td>09:02</td>
                        <td>17:00</td>
                        <td>7h 58m</td>
                        <td><span class="badge badge-black">Approved</span></td>
                      </tr>
                      <tr>
                        <td>Wed, 3 May</td>
                        <td>08:50</td>
                        <td>17:10</td>
                        <td>8h 20m</td>
                        <td><span class="badge badge-black">Approved</span></td>
                      </tr>
                      <tr>
                        <td>Thu, 4 May</td>
                        <td>09:05</td>
                        <td>17:00</td>
                        <td>7h 55m</td>
                        <td><span class="badge badge-black">Approved</span></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- Month Table -->
                  <table class="table table-zebra hidden" id="history-month">
                    <thead>
                      <tr>
                        <th>Month</th>
                        <th>Total Days</th>
                        <th>Total Hours</th>
                        <th>Overtime</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>May 2025</td>
                        <td>22</td>
                        <td>170h 30m</td>
                        <td>5h 10m</td>
                        <td><span class="badge badge-black">Approved</span></td>
                      </tr>
                      <tr>
                        <td>June 2025</td>
                        <td>20</td>
                        <td>160h 00m</td>
                        <td>2h 30m</td>
                        <td><span class="badge badge-black">Pending</span></td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- Year Table -->
                  <table class="table table-zebra hidden" id="history-year">
                    <thead>
                      <tr>
                        <th>Year</th>
                        <th>Total Days</th>
                        <th>Total Hours</th>
                        <th>Overtime</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>2024</td>
                        <td>250</td>
                        <td>2000h 00m</td>
                        <td>15h 20m</td>
                        <td><span class="badge badge-black">Approved</span></td>
                      </tr>
                      <tr>
                        <td>2025</td>
                        <td>180</td>
                        <td>1440h 20m</td>
                        <td>8h 40m</td>
                        <td><span class="badge badge-black">Pending</span></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    // Tab switching for timesheet history
    function showHistory(type) {
      document.getElementById('history-week').classList.add('hidden');
      document.getElementById('history-month').classList.add('hidden');
      document.getElementById('history-year').classList.add('hidden');
      document.getElementById('tab-week').classList.remove('tab-active');
      document.getElementById('tab-month').classList.remove('tab-active');
      document.getElementById('tab-year').classList.remove('tab-active');

      if(type === 'week') {
        document.getElementById('history-week').classList.remove('hidden');
        document.getElementById('tab-week').classList.add('tab-active');
      }
      else if(type === 'month') {
        document.getElementById('history-month').classList.remove('hidden');
        document.getElementById('tab-month').classList.add('tab-active');
      }
      else if(type === 'year') {
        document.getElementById('history-year').classList.remove('hidden');
        document.getElementById('tab-year').classList.add('tab-active');
      }
    }
    
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Display Philippine Time in Navbar
    function displayPhilippineTime() {
      const options = {
        timeZone: 'Asia/Manila',
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
      };
      const philippineDateTime = new Date().toLocaleString('en-PH', options);
      const timeElement = document.getElementById('philippineTime');
      if (timeElement) {
        timeElement.textContent = philippineDateTime;
      }
    }
    
    // Update current time every second
    function updateCurrentTime() {
      const now = new Date();
      // Format date for header (Weekday, Month Day, Year)
      const headerOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      const headerDateString = now.toLocaleDateString('en-US', headerOptions);
      const headerElem = document.getElementById('current-date-header');
      if(headerElem) headerElem.textContent = headerDateString;
      // Format date for card (Weekday, Month Day)
      const cardOptions = { weekday: 'long', month: 'long', day: 'numeric' };
      document.getElementById('current-date-card').textContent = now.toLocaleDateString('en-US', cardOptions);
      displayPhilippineTime();
    }
    
    // Clock In function
    function clockIn() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
      document.getElementById('clock-in-btn').classList.add('hidden');
      document.getElementById('clock-out-btn').classList.remove('hidden');
      document.getElementById('today-clock-in').textContent = timeString;
      document.getElementById('today-clock-out').textContent = '--:-- --';
      localStorage.setItem('lastClockIn', now.toISOString());
      localStorage.setItem('isClockedIn', 'true');
      localStorage.removeItem('lastClockOut');
      lucide.createIcons();
    }
    // Clock Out function
    function clockOut() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
      document.getElementById('clock-out-btn').classList.add('hidden');
      document.getElementById('clock-in-btn').classList.remove('hidden');
      document.getElementById('today-clock-out').textContent = timeString;
      localStorage.setItem('lastClockOut', now.toISOString());
      localStorage.setItem('isClockedIn', 'false');
      updateHoursWorked();
      lucide.createIcons();
    }
    // Calculate hours worked
    function updateHoursWorked() {
      const clockIn = localStorage.getItem('lastClockIn');
      const clockOut = localStorage.getItem('lastClockOut');
      if (!clockIn) return;
      const start = new Date(clockIn);
      const end = clockOut ? new Date(clockOut) : new Date();
      const diffMs = end - start;
      const diffHrs = Math.floor(diffMs / 3600000);
      const diffMins = Math.round((diffMs % 3600000) / 60000);
      // You can use these values to update your timesheet
      console.log(`Worked: ${diffHrs}h ${diffMins}m`);
    }
    // Check status on page load
    function initializeStatus() {
      const isClockedIn = localStorage.getItem('isClockedIn') === 'true';
      const lastClockIn = localStorage.getItem('lastClockIn');
      const lastClockOut = localStorage.getItem('lastClockOut');
      if (isClockedIn && lastClockIn) {
        document.getElementById('clock-in-btn').classList.add('hidden');
        document.getElementById('clock-out-btn').classList.remove('hidden');
        const clockInTime = new Date(lastClockIn);
        document.getElementById('today-clock-in').textContent = 
          clockInTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
      } else if (lastClockOut) {
        const clockOutTime = new Date(lastClockOut);
        document.getElementById('today-clock-out').textContent = 
          clockOutTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        if (lastClockIn) {
          const clockInTime = new Date(lastClockIn);
          document.getElementById('today-clock-in').textContent = 
            clockInTime.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }
      }
      lucide.createIcons();
    }
    document.addEventListener('DOMContentLoaded', () => {
      initializeStatus();
      displayPhilippineTime();
      updateCurrentTime();
      setInterval(updateCurrentTime, 1000);
      showHistory('week');
    });
  </script>
  <script src="../soliera.js"></script>
  <script src="../sidebar.js"></script>
</body>
</html>