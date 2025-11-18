<!doctype html>
<html lang="en">
 <head>
  <title>StudyBuddy Admin Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- External CSS -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"><!-- Custom CSS -->
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script src="{{ asset('js/script.js') }}"></script>

  <style>@view-transition { navigation: auto; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
  <script src="/_sdk/element_sdk.js" type="text/javascript"></script>
  <script src="https://cdn.tailwindcss.com" type="text/javascript"></script>
 </head>
 <body><!-- Admin Sidebar -->
  <div class="admin-sidebar" id="sidebar">
   <div class="sidebar-header">
    <h3><span class="sidebar-text">StudyBuddy</span></h3>
   </div>
   <ul class="sidebar-menu">
    <li><a href="#" class="active" onclick="showSection('dashboard')"><i class="fa fa-dashboard"></i><span class="sidebar-text">Dashboard</span></a></li>
    <li><a href="#" onclick="showSection('contributors')"><i class="fa fa-users"></i><span class="sidebar-text">Contributors</span></a></li>
    <li><a href="#" onclick="showSection('activity')"><i class="fa fa-activity"></i><span class="sidebar-text">Contributor Activities</span></a></li>
    <li><a href="#" onclick="showSection('reports')"><i class="fa fa-file-text"></i><span class="sidebar-text">Reports</span></a></li>
    <li><a href="#" onclick="showSection('settings')"><i class="fa fa-cog"></i><span class="sidebar-text">Settings</span></a></li>
   </ul>
  </div><!-- Main Content -->
  <div class="main-content" id="mainContent"><!-- Admin Header -->
   <div class="admin-header"><button class="toggle-btn" onclick="toggleSidebar()"> <i class="fa fa-bars"></i> </button>
    <div class="admin-user"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Ccircle cx='20' cy='20' r='20' fill='%23667eea'/%3E%3Ctext x='20' y='26' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'%3EA%3C/text%3E%3C/svg%3E" alt="Admin">
     <div>
      <div style="font-weight: 600;">
       Admin User
      </div><small class="text-muted">Administrator</small>
     </div>
    </div>
   </div><!-- Dashboard Content -->
   <div class="dashboard-content"><!-- Dashboard Section -->
    <div id="dashboard-section" class="content-section">
     <h1 class="page-title">Dashboard Overview</h1>
     <div class="row">
      <div class="col-md-3">
       <div class="stats-card">
        <div class="stats-number text-primary">
         342
        </div>
        <div class="stats-label">
         Active Contributors
        </div><i class="fa fa-users card-icon text-primary"></i>
       </div>
      </div>
      <div class="col-md-3">
       <div class="stats-card">
        <div class="stats-number text-success">
         1,847
        </div>
        <div class="stats-label">
         Total Contributions
        </div><i class="fa fa-edit card-icon text-success"></i>
       </div>
      </div>
      <div class="col-md-3">
       <div class="stats-card">
        <div class="stats-number text-warning">
         156
        </div>
        <div class="stats-label">
         Pending Reviews
        </div><i class="fa fa-clock card-icon text-warning"></i>
       </div>
      </div>
      <div class="col-md-3">
       <div class="stats-card">
        <div class="stats-number text-info">
         94.2%
        </div>
        <div class="stats-label">
         Approval Rate
        </div><i class="fa fa-check-circle card-icon text-info"></i>
       </div>
      </div>
     </div><!-- Analytics Overview -->
     <div class="row mt-4 mb-4">
      <div class="col-md-6">
       <div class="recent-activity">
        <h5 class="mb-3">Contributor Performance</h5>
        <div class="row">
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-success mb-1">
            94.2%
           </div><small class="text-muted">Avg Approval Rate</small>
          </div>
         </div>
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-primary mb-1">
            5.4
           </div><small class="text-muted">Avg Content/Week</small>
          </div>
         </div>
        </div>
        <div class="row">
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-warning mb-1">
            2.1 days
           </div><small class="text-muted">Avg Review Time</small>
          </div>
         </div>
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-info mb-1">
            87%
           </div><small class="text-muted">Active Contributors</small>
          </div>
         </div>
        </div>
       </div>
      </div>
      <div class="col-md-6">
       <div class="recent-activity">
        <h5 class="mb-3">Content Categories</h5>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Programming Tutorials</span> <span>45%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-primary" style="width: 45%"></div>
         </div>
        </div>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Design Guides</span> <span>28%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-success" style="width: 28%"></div>
         </div>
        </div>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Data Science</span> <span>18%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-warning" style="width: 18%"></div>
         </div>
        </div>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Other</span> <span>9%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-info" style="width: 9%"></div>
         </div>
        </div>
       </div>
      </div>
     </div><!-- Top Contributors -->
     <div class="row mt-4 mb-4">
      <div class="col-md-12">
       <div class="recent-activity">
        <h5 class="mb-4">Top Contributors This Month</h5>
        <div class="table-responsive">
         <table class="table table-hover">
          <thead>
           <tr>
            <th>Rank</th>
            <th>Contributors</th>
            <th>Submissions</th>
            <th>Approved</th>
            <th>Approval Rate</th>
            <th>Quality Score</th>
           </tr>
          </thead>
          <tbody>
           <tr>
            <td><span class="badge badge-warning">🥇</span></td>
            <td>Sarah Johnson</td>
            <td>23</td>
            <td>22</td>
            <td><span class="text-success">95.7%</span></td>
            <td><span class="badge badge-success">Excellent</span></td>
           </tr>
           <tr>
            <td><span class="badge badge-secondary">🥈</span></td>
            <td>Mike Chen</td>
            <td>19</td>
            <td>17</td>
            <td><span class="text-success">89.5%</span></td>
            <td><span class="badge badge-primary">Good</span></td>
           </tr>
           <tr>
            <td><span class="badge badge-warning">🥉</span></td>
            <td>Alex Rodriguez</td>
            <td>16</td>
            <td>13</td>
            <td><span class="text-warning">81.3%</span></td>
            <td><span class="badge badge-warning">Average</span></td>
           </tr>
          </tbody>
         </table>
        </div>
       </div>
      </div>
     </div>
     <div class="row mt-4">
      <div class="col-md-8">
       <div class="recent-activity">
        <h4 class="mb-4">Recent Contributor Activity</h4>
        <div class="activity-item">
         <div class="activity-icon bg-success text-white"><i class="fa fa-check"></i>
         </div>
         <div><strong>Content approved</strong><br><small class="text-muted">Sarah Johnson's article "Machine Learning Basics" was approved - 1 hour ago</small>
         </div>
        </div>
        <div class="activity-item">
         <div class="activity-icon bg-primary text-white"><i class="fa fa-upload"></i>
         </div>
         <div><strong>New submission</strong><br><small class="text-muted">Mike Chen submitted "Python Data Analysis Tutorial" for review - 3 hours ago</small>
         </div>
        </div>
        <div class="activity-item">
         <div class="activity-icon bg-warning text-white"><i class="fa fa-edit"></i>
         </div>
         <div><strong>Content revision</strong><br><small class="text-muted">Alex Rodriguez updated "JavaScript Best Practices" - 5 hours ago</small>
         </div>
        </div>
        <div class="activity-item">
         <div class="activity-icon bg-info text-white"><i class="fa fa-user-plus"></i>
         </div>
         <div><strong>New contributor</strong><br><small class="text-muted">Emma Wilson joined as a content contributor - 8 hours ago</small>
         </div>
        </div>
       </div>
      </div>
      <div class="col-md-4">
       <div class="recent-activity">
        <h4 class="mb-4">Quick Actions</h4>
        <div class="d-grid gap-2"><button class="btn btn-admin mb-2" onclick="showSection('contributors')"> <i class="fa fa-users mr-2"></i>Manage Contributors </button> <button class="btn btn-admin mb-2" onclick="showSection('activity')"> <i class="fa fa-activity mr-2"></i>Monitor Activities </button> <button class="btn btn-admin mb-2" onclick="showSection('reports')"> <i class="fa fa-file-text mr-2"></i>Generate Report </button>
        </div>
       </div>
      </div>
     </div>
    </div><!-- Contributors Section -->
    <div id="contributors-section" class="content-section" style="display: none;">
     <h1 class="page-title">Contributor Management</h1>
     <div class="recent-activity">
      <div class="d-flex justify-content-between align-items-center mb-4">
       <h4>All Contributors</h4>
      </div>
      <div class="table-responsive">
       <table class="table table-hover">
        <thead>
         <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Contributions</th>
          <th>Approval Rate</th>
          <th>Status</th>
          <th>Actions</th>
         </tr>
        </thead>
        <tbody>
         <tr>
          <td>Sarah Johnson</td>
          <td>sarah.j@example.com</td>
          <td><span class="badge badge-info">47 articles</span></td>
          <td><span class="text-success">96%</span></td>
          <td><span class="badge badge-success">Active</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-warning mr-1"><i class="fa fa-edit"></i></button> <button class="btn btn-sm btn-outline-danger"><i class="fa fa-ban"></i></button></td>
         </tr>
         <tr>
          <td>Mike Chen</td>
          <td>mike.c@example.com</td>
          <td><span class="badge badge-info">23 tutorials</span></td>
          <td><span class="text-success">89%</span></td>
          <td><span class="badge badge-success">Active</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-warning mr-1"><i class="fa fa-edit"></i></button> <button class="btn btn-sm btn-outline-danger"><i class="fa fa-ban"></i></button></td>
         </tr>
         <tr>
          <td>Alex Rodriguez</td>
          <td>alex.r@example.com</td>
          <td><span class="badge badge-info">31 guides</span></td>
          <td><span class="text-warning">78%</span></td>
          <td><span class="badge badge-warning">Under Review</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-warning mr-1"><i class="fa fa-edit"></i></button> <button class="btn btn-sm btn-outline-danger"><i class="fa fa-ban"></i></button></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div>
    </div><!-- Contributor Activities Section -->
    <div id="activity-section" class="content-section" style="display: none;">
     <h1 class="page-title">Monitor Contributor Activities</h1><!-- Filter Controls -->
     <div class="filter-controls">
      <div class="row">
       <div class="col-md-4">
        <div class="form-group mb-0"><label class="small text-muted">Search by Name</label> <input type="text" class="form-control" placeholder="Enter contributor name..." onkeyup="filterContributors()">
        </div>
       </div>
       <div class="col-md-4">
        <div class="form-group mb-0"><label class="small text-muted">Sort By</label> <select class="form-control" onchange="sortContributors()"> <option value="uploads">Upload Count (High to Low)</option> <option value="recent">Latest Activity</option> <option value="name">Name (A-Z)</option> <option value="approval">Approval Rate</option> </select>
        </div>
       </div>
       <div class="col-md-4">
        <div class="form-group mb-0"><label class="small text-muted">Activity Filter</label> <select class="form-control"> <option>All Contributors</option> <option>Active This Week</option> <option>Active This Month</option> <option>Inactive</option> </select>
        </div>
       </div>
      </div>
     </div><!-- Contributors Statistics Table -->
     <div class="recent-activity">
      <h5 class="mb-4">Contributor Statistics &amp; Activities</h5>
      <div class="table-responsive">
       <table class="table table-hover" id="contributorsTable">
        <thead>
         <tr>
          <th>Contributor</th>
          <th>Upload Count</th>
          <th>Latest Upload</th>
          <th>Approval Rate</th>
          <th>Status</th>
          <th>Actions</th>
         </tr>
        </thead>
        <tbody>
         <tr>
          <td>
           <div class="d-flex align-items-center"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Ccircle cx='16' cy='16' r='16' fill='%23e91e63'/%3E%3Ctext x='16' y='21' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'%3ESJ%3C/text%3E%3C/svg%3E" alt="Sarah" class="rounded-circle mr-2" width="32" height="32">
            <div><strong>Sarah Johnson</strong><br><small class="text-muted">sarah.j@example.com</small>
            </div>
           </div></td>
          <td><span class="badge badge-primary badge-lg">47 uploads</span></td>
          <td>
           <div>
            2 hours ago
           </div><small class="text-muted">"Machine Learning Guide"</small></td>
          <td><span class="text-success font-weight-bold">96.2%</span></td>
          <td><span class="badge badge-success">Active</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1" title="View Profile"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-info mr-1" title="View Uploads"><i class="fa fa-list"></i></button> <button class="btn btn-sm btn-outline-warning" title="Send Message"><i class="fa fa-envelope"></i></button></td>
         </tr>
         <tr>
          <td>
           <div class="d-flex align-items-center"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Ccircle cx='16' cy='16' r='16' fill='%232196f3'/%3E%3Ctext x='16' y='21' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'%3EMC%3C/text%3E%3C/svg%3E" alt="Mike" class="rounded-circle mr-2" width="32" height="32">
            <div><strong>Mike Chen</strong><br><small class="text-muted">mike.c@example.com</small>
            </div>
           </div></td>
          <td><span class="badge badge-primary badge-lg">34 uploads</span></td>
          <td>
           <div>
            5 hours ago
           </div><small class="text-muted">"React Hooks Tutorial"</small></td>
          <td><span class="text-success font-weight-bold">89.1%</span></td>
          <td><span class="badge badge-success">Active</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1" title="View Profile"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-info mr-1" title="View Uploads"><i class="fa fa-list"></i></button> <button class="btn btn-sm btn-outline-warning" title="Send Message"><i class="fa fa-envelope"></i></button></td>
         </tr>
         <tr>
          <td>
           <div class="d-flex align-items-center"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Ccircle cx='16' cy='16' r='16' fill='%23ff9800'/%3E%3Ctext x='16' y='21' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'%3EAR%3C/text%3E%3C/svg%3E" alt="Alex" class="rounded-circle mr-2" width="32" height="32">
            <div><strong>Alex Rodriguez</strong><br><small class="text-muted">alex.r@example.com</small>
            </div>
           </div></td>
          <td><span class="badge badge-primary badge-lg">31 uploads</span></td>
          <td>
           <div>
            1 day ago
           </div><small class="text-muted">"JavaScript Best Practices"</small></td>
          <td><span class="text-warning font-weight-bold">78.4%</span></td>
          <td><span class="badge badge-warning">Under Review</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1" title="View Profile"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-info mr-1" title="View Uploads"><i class="fa fa-list"></i></button> <button class="btn btn-sm btn-outline-warning" title="Send Message"><i class="fa fa-envelope"></i></button></td>
         </tr>
         <tr>
          <td>
           <div class="d-flex align-items-center"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Ccircle cx='16' cy='16' r='16' fill='%239c27b0'/%3E%3Ctext x='16' y='21' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'%3EEW%3C/text%3E%3C/svg%3E" alt="Emma" class="rounded-circle mr-2" width="32" height="32">
            <div><strong>Emma Wilson</strong><br><small class="text-muted">emma.w@example.com</small>
            </div>
           </div></td>
          <td><span class="badge badge-primary badge-lg">18 uploads</span></td>
          <td>
           <div>
            3 days ago
           </div><small class="text-muted">"CSS Grid Layout"</small></td>
          <td><span class="text-info font-weight-bold">85.7%</span></td>
          <td><span class="badge badge-info">New</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1" title="View Profile"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-info mr-1" title="View Uploads"><i class="fa fa-list"></i></button> <button class="btn btn-sm btn-outline-warning" title="Send Message"><i class="fa fa-envelope"></i></button></td>
         </tr>
         <tr>
          <td>
           <div class="d-flex align-items-center"><img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='32' height='32' viewBox='0 0 32 32'%3E%3Ccircle cx='16' cy='16' r='16' fill='%234caf50'/%3E%3Ctext x='16' y='21' text-anchor='middle' fill='white' font-family='Arial' font-size='12' font-weight='bold'%3EDK%3C/text%3E%3C/svg%3E" alt="David" class="rounded-circle mr-2" width="32" height="32">
            <div><strong>David Kim</strong><br><small class="text-muted">david.k@example.com</small>
            </div>
           </div></td>
          <td><span class="badge badge-primary badge-lg">12 uploads</span></td>
          <td>
           <div>
            1 week ago
           </div><small class="text-muted">"Python Data Analysis"</small></td>
          <td><span class="text-success font-weight-bold">91.7%</span></td>
          <td><span class="badge badge-secondary">Inactive</span></td>
          <td><button class="btn btn-sm btn-outline-primary mr-1" title="View Profile"><i class="fa fa-eye"></i></button> <button class="btn btn-sm btn-outline-info mr-1" title="View Uploads"><i class="fa fa-list"></i></button> <button class="btn btn-sm btn-outline-warning" title="Send Message"><i class="fa fa-envelope"></i></button></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div>
    </div><!-- Analytics Section -->
    <div id="analytics-section" class="content-section" style="display: none;">
     <h1 class="page-title">Analytics &amp; Insights</h1><!-- Analytics Overview -->
     <div class="row mb-4">
      <div class="col-md-6">
       <div class="recent-activity">
        <h5 class="mb-3">Contributor Performance</h5>
        <div class="row">
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-success mb-1">
            94.2%
           </div><small class="text-muted">Avg Approval Rate</small>
          </div>
         </div>
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-primary mb-1">
            5.4
           </div><small class="text-muted">Avg Content/Week</small>
          </div>
         </div>
        </div>
        <div class="row">
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-warning mb-1">
            2.1 days
           </div><small class="text-muted">Avg Review Time</small>
          </div>
         </div>
         <div class="col-6">
          <div class="text-center p-3">
           <div class="h3 text-info mb-1">
            87%
           </div><small class="text-muted">Active Contributors</small>
          </div>
         </div>
        </div>
       </div>
      </div>
      <div class="col-md-6">
       <div class="recent-activity">
        <h5 class="mb-3">Content Categories</h5>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Programming Tutorials</span> <span>45%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-primary" style="width: 45%"></div>
         </div>
        </div>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Design Guides</span> <span>28%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-success" style="width: 28%"></div>
         </div>
        </div>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Data Science</span> <span>18%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-warning" style="width: 18%"></div>
         </div>
        </div>
        <div class="mb-3">
         <div class="d-flex justify-content-between mb-1"><span>Other</span> <span>9%</span>
         </div>
         <div class="progress" style="height: 8px;">
          <div class="progress-bar bg-info" style="width: 9%"></div>
         </div>
        </div>
       </div>
      </div>
     </div><!-- Top Contributors -->
     <div class="recent-activity">
      <h5 class="mb-4">Top Contributors This Month</h5>
      <div class="table-responsive">
       <table class="table table-hover">
        <thead>
         <tr>
          <th>Rank</th>
          <th>Contributor</th>
          <th>Submissions</th>
          <th>Approved</th>
          <th>Approval Rate</th>
          <th>Quality Score</th>
         </tr>
        </thead>
        <tbody>
         <tr>
          <td><span class="badge badge-warning">🥇</span></td>
          <td>Sarah Johnson</td>
          <td>23</td>
          <td>22</td>
          <td><span class="text-success">95.7%</span></td>
          <td><span class="badge badge-success">Excellent</span></td>
         </tr>
         <tr>
          <td><span class="badge badge-secondary">🥈</span></td>
          <td>Mike Chen</td>
          <td>19</td>
          <td>17</td>
          <td><span class="text-success">89.5%</span></td>
          <td><span class="badge badge-primary">Good</span></td>
         </tr>
         <tr>
          <td><span class="badge badge-warning">🥉</span></td>
          <td>Alex Rodriguez</td>
          <td>16</td>
          <td>13</td>
          <td><span class="text-warning">81.3%</span></td>
          <td><span class="badge badge-warning">Average</span></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div>
    </div><!-- Reports Section -->
    <div id="reports-section" class="content-section" style="display: none;">
     <h1 class="page-title">Generate Analytical Reports</h1><!-- Report Generation -->
     <div class="row mb-4">
      <div class="col-md-8">
       <div class="recent-activity">
        <h5 class="mb-4">Report Generator</h5>
        <form>
         <div class="row">
          <div class="col-md-6">
           <div class="form-group"><label>Report Type</label> <select class="form-control"> <option>Contributor Performance Report</option> <option>Content Analytics Report</option> <option>Activity Summary Report</option> <option>Quality Metrics Report</option> <option>Monthly Overview Report</option> </select>
           </div>
          </div>
          <div class="col-md-3">
           <div class="form-group"><label>Start Date</label> <input type="date" class="form-control" value="2024-11-01">
           </div>
          </div>
          <div class="col-md-3">
           <div class="form-group"><label>End Date</label> <input type="date" class="form-control" value="2024-11-30">
           </div>
          </div>
         </div>
         <div class="row">
          <div class="col-md-6">
           <div class="form-group"><label>Format</label> <select class="form-control"> <option>PDF Report</option> <option>Excel Spreadsheet</option> <option>CSV Data</option> <option>Email Summary</option> </select>
           </div>
          </div>
          <div class="col-md-6">
           <div class="form-group"><label>Include</label>
            <div class="mt-2">
             <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label class="form-check-label">Charts &amp; Graphs</label>
             </div>
             <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label class="form-check-label">Detailed Tables</label>
             </div>
             <div class="form-check"><input class="form-check-input" type="checkbox"> <label class="form-check-label">Raw Data</label>
             </div>
            </div>
           </div>
          </div>
         </div><button type="button" class="btn btn-admin"> <i class="fa fa-download mr-2"></i>Generate Report </button>
        </form>
       </div>
      </div>
      <div class="col-md-4">
       <div class="recent-activity">
        <h5 class="mb-4">Quick Reports</h5>
        <div class="d-grid gap-2"><button class="btn btn-outline-primary mb-2"> <i class="fa fa-users mr-2"></i>Today's Contributors </button> <button class="btn btn-outline-success mb-2"> <i class="fa fa-check-circle mr-2"></i>Weekly Approvals </button> <button class="btn btn-outline-warning mb-2"> <i class="fa fa-clock mr-2"></i>Pending Reviews </button> <button class="btn btn-outline-info mb-2"> <i class="fa fa-chart-line mr-2"></i>Performance Trends </button>
        </div>
       </div>
      </div>
     </div><!-- Recent Reports -->
     <div class="recent-activity">
      <h5 class="mb-4">Recent Reports</h5>
      <div class="table-responsive">
       <table class="table table-hover">
        <thead>
         <tr>
          <th>Report Name</th>
          <th>Type</th>
          <th>Generated</th>
          <th>Size</th>
          <th>Actions</th>
         </tr>
        </thead>
        <tbody>
         <tr>
          <td>Monthly Performance Report - November 2024</td>
          <td><span class="badge badge-primary">Performance</span></td>
          <td>2 hours ago</td>
          <td>2.4 MB</td>
          <td><button class="btn btn-sm btn-outline-primary mr-1"> <i class="fa fa-download"></i> </button> <button class="btn btn-sm btn-outline-secondary mr-1"> <i class="fa fa-eye"></i> </button> <button class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> </button></td>
         </tr>
         <tr>
          <td>Content Analytics - Last 30 Days</td>
          <td><span class="badge badge-success">Analytics</span></td>
          <td>1 day ago</td>
          <td>1.8 MB</td>
          <td><button class="btn btn-sm btn-outline-primary mr-1"> <i class="fa fa-download"></i> </button> <button class="btn btn-sm btn-outline-secondary mr-1"> <i class="fa fa-eye"></i> </button> <button class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> </button></td>
         </tr>
         <tr>
          <td>Weekly Activity Summary</td>
          <td><span class="badge badge-info">Activity</span></td>
          <td>3 days ago</td>
          <td>856 KB</td>
          <td><button class="btn btn-sm btn-outline-primary mr-1"> <i class="fa fa-download"></i> </button> <button class="btn btn-sm btn-outline-secondary mr-1"> <i class="fa fa-eye"></i> </button> <button class="btn btn-sm btn-outline-danger"> <i class="fa fa-trash"></i> </button></td>
         </tr>
        </tbody>
       </table>
      </div>
     </div>
    </div><!-- Settings Section -->
    <div id="settings-section" class="content-section" style="display: none;">
     <h1 class="page-title">System Settings</h1>
     <div class="recent-activity">
      <p>System settings panel coming soon...</p>
     </div>
    </div>
   </div>
  </div><!-- External JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script><!-- Custom JavaScript -->
  <script src="script.js"></script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'99deda4f21511be4',t:'MTc2MzA0MzAyOC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>