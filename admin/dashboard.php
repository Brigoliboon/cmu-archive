<?php
// File: admin/dashboard.php
// Include session management
require_once '../public/include/session.php';

// Require admin
requireAdmin();

// Get statistics
$documentCounts = countDocumentsByType($conn);
$userCount = countUsers($conn);
$flaggedCount = countFlaggedDocuments($conn);
$documentStats = getDocumentStatistics($conn);

include 'include/header.php';
include 'include/admin-sidebar.php';
?>

<!-- Main Panel -->
<div class="main-panel">
  <div class="content-wrapper">
    <!-- Welcome Message -->
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Administrator Dashboard</h3>
            <h6 class="font-weight-normal mb-0">Manage your document archive directory</h6>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="row">
      <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-tale">
          <div class="card-body">
            <p class="mb-4">Total Documents</p>
            <p class="fs-30 mb-2"><?php echo $documentCounts['total']; ?></p>
            <p>Across all users</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-dark-blue">
          <div class="card-body">
            <p class="mb-4">Total Users</p>
            <p class="fs-30 mb-2"><?php echo $userCount; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-light-blue">
          <div class="card-body">
            <p class="mb-4">Flagged Documents</p>
            <p class="fs-30 mb-2"><?php echo $flaggedCount; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3 grid-margin stretch-card">
        <div class="card card-light-danger">
          <div class="card-body">
            <p class="mb-4">Document Types</p>
            <div class="d-flex justify-content-between">
              <p>PDF: <span class="font-weight-bold"><?php echo $documentCounts['pdf']; ?></span></p>
              <p>PNG: <span class="font-weight-bold"><?php echo $documentCounts['png']; ?></span></p>
              <p>JPG: <span class="font-weight-bold"><?php echo $documentCounts['jpg']; ?></span></p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Document Categories -->
    <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Document Categories</p>
            <canvas id="documentCategoriesChart" height="300"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Access Level Distribution</p>
            <canvas id="accessLevelChart" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
    
    <!-- File Upload Trends -->
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">File Upload Trends</p>
            <canvas id="fileUploadTrendsChart" height="250"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
// Document Categories chart
var categoryCtx = document.getElementById('documentCategoriesChart').getContext('2d');
var categoryData = {
    labels: [
        <?php 
        if (!empty($documentStats['by_category'])) {
            foreach ($documentStats['by_category'] as $category => $count) {
                echo "'" . addslashes($category) . "', ";
            }
        } else {
            echo "'No Data'";
        }
        ?>
    ],
    datasets: [{
        data: [
            <?php 
            if (!empty($documentStats['by_category'])) {
                foreach ($documentStats['by_category'] as $count) {
                    echo $count . ", ";
                }
            } else {
                echo "1";
            }
            ?>
        ],
        backgroundColor: ['#4B49AC', '#248AFD', '#57B657', '#FFC100', '#FF4747', '#6610f2', '#e83e8c', '#fd7e14']
    }]
};

var categoryChart = new Chart(categoryCtx, {
    type: 'doughnut',
    data: categoryData,
    options: {
        responsive: true,
        legend: {
            position: 'bottom'
        }
    }
});

// Access Level Distribution chart
var accessLevelCtx = document.getElementById('accessLevelChart').getContext('2d');
var accessLevelData = {
    labels: [
        <?php 
        if (!empty($documentStats['by_access_level'])) {
            foreach ($documentStats['by_access_level'] as $level => $count) {
                echo "'" . addslashes($level) . "', ";
            }
        } else {
            echo "'No Data'";
        }
        ?>
    ],
    datasets: [{
        label: 'Documents',
        data: [
            <?php 
            if (!empty($documentStats['by_access_level'])) {
                foreach ($documentStats['by_access_level'] as $count) {
                    echo $count . ", ";
                }
            } else {
                echo "0";
            }
            ?>
        ],
        backgroundColor: '#4B49AC'
    }]
};

var accessLevelChart = new Chart(accessLevelCtx, {
    type: 'bar',
    data: accessLevelData,
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

// File Upload Trends chart
var trendsCtx = document.getElementById('fileUploadTrendsChart').getContext('2d');
var trendsData = {
    labels: [
        <?php 
        if (!empty($documentStats['by_month'])) {
            foreach ($documentStats['by_month'] as $month => $counts) {
                echo "'" . $month . "', ";
            }
        } else {
            echo "'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'";
        }
        ?>
    ],
    datasets: [{
        label: 'PDF',
        data: [
            <?php 
            if (!empty($documentStats['by_month'])) {
                foreach ($documentStats['by_month'] as $counts) {
                    echo $counts['pdf'] . ", ";
                }
            } else {
                echo "0, 0, 0, 0, 0, 0";
            }
            ?>
        ],
        borderColor: '#4B49AC',
        backgroundColor: 'rgba(75, 73, 172, 0.1)',
        borderWidth: 2,
        fill: true
    },
    {
        label: 'Images (PNG & JPG)',
        data: [
            <?php 
            if (!empty($documentStats['by_month'])) {
                foreach ($documentStats['by_month'] as $counts) {
                    echo $counts['image'] . ", ";
                }
            } else {
                echo "0, 0, 0, 0, 0, 0";
            }
            ?>
        ],
        borderColor: '#FFC100',
        backgroundColor: 'rgba(255, 193, 0, 0.1)',
        borderWidth: 2,
        fill: true
    }]
};

var trendsChart = new Chart(trendsCtx, {
    type: 'line',
    data: trendsData,
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<?php
include 'include/footer.php';
?>