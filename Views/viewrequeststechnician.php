<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Handle Requests</title>
<link rel="stylesheet" type="text/css" href="../css/updateNew.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg">
    <img class="logopic" src="../images/logo.png">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="services.php">Services</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="aboutus.php">About us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contactus.php">Contact us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="faq.php">F&Q</a>
            </li>
        </ul>
    </div>
</nav>
<div class="form-inline">
    <form>
        <input class="form-control me-2" type="search" placeholder="Search here" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
</div>
</header>

    <div id="content">
        <div class="search-bar-container">
            <input class="form-control" id="searchRequestID" type="text" placeholder="Search by Request ID">
            <button class="btn btn-primary" onclick="searchRequest()">Search</button>
            <button class="btn btn-secondary refresh" onclick="refreshRequests()">Refresh</button>
            <button class="btn btn-primary" type="submit">Submit</button>
        </div>

        <div class="tablecontainer">
          <table id="requestsTable">
            <thead>
              <tr>
                <th>Request ID</th>
                <th>Meter Number</th>
                <th>Phone Number</th>
                <th>Maintenance Details</th>
                <th>Verify</th>
              </tr>
            </thead>
            <tbody>
              <!-- Requests will be inserted here by JavaScript -->
            </tbody>
          </table>
        </div>
        
        <!-- Details Box -->

        <div id="detailsBox" class="details-box">
            <h4>Maintenance Details</h4>
            <p><strong>Date Period:</strong> <span id="detailDate"></span></p>
            <p><strong>Location:</strong> <span id="detailLocation"></span></p>
            <p><strong>Issue Description:</strong> <span id="detailDescription"></span></p>
        </div>


    </div>
</div>
<?php
// Include database connection file
include('db.php');

$action = $_GET['action'] ?? '';

if ($action == 'fetchRequests') {
    $requestID = isset($_GET['requestID']) ? $_GET['requestID'] : null;
    if ($requestID) {
        $sql = "SELECT * FROM maintenance_requests WHERE requestID = $requestID";
    } else {
        $sql = "SELECT * FROM maintenance_requests";
    }
    $result = $conn->query($sql);
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    echo json_encode($requests);
} elseif ($action == 'fetchTechnicians') {
    $sql = "SELECT * FROM technician";
    $result = $conn->query($sql);
    $technicians = [];
    while ($row = $result->fetch_assoc()) {
        $technicians[] = $row;
    }
    echo json_encode($technicians);
} elseif ($action == 'fetchRequestDetails') {
    $requestID = isset($_GET['requestID']) ? $_GET['requestID'] : null;
    if ($requestID) {
        $sql = "SELECT datePeriodFrom, datePeriodTo, issue_description, location FROM maintenance_requests WHERE requestID = $requestID";
        $result = $conn->query($sql);
        $details = $result->fetch_assoc();
        echo json_encode($details);
    }
}

$conn->close();
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    fetchRequests();
    fetchTechnicians(); // Fetch technicians for the dropdown
});

function fetchRequests() {
    fetch('fetchData.php?action=fetchRequests')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('#requestsTable tbody');
            tableBody.innerHTML = '';

            data.forEach(request => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${request.requestID}</td>
                    <td>${request.meter_number}</td>
                    <td>${request.phone}</td>
                    <td>${request.location}</td>
                    <td>
                        <button class="btn btn-info view-details-btn" data-request-id="${request.requestID}">Click here to view</button>
                    </td>
                    <td>
                        <select class="form-control technician-dropdown" data-request-id="${request.requestID}">
                            <option value="">Select Technician</option>
                        </select>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            populateTechnicianDropdowns();

            // Add event listeners to view-details buttons
            document.querySelectorAll('.view-details-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    viewDetails(requestId);
                });
            });
        })
        .catch(error => console.error('Error fetching requests:', error));
}

function searchRequest() {
    const searchRequestID = document.getElementById('searchRequestID').value;
    if (searchRequestID) {
        fetch(`fetchData.php?action=fetchRequests&requestID=${searchRequestID}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#requestsTable tbody');
                tableBody.innerHTML = ''; // Clear current table content
                data.forEach(request => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${request.requestID}</td>
                        <td>${request.meter_number}</td>
                        <td>${request.phone}</td>
                        <td>${request.location}</td>
                        <td>
                            <button class="btn btn-info view-details-btn" data-request-id="${request.requestID}">Click here to view</button>
                        </td>
                        <td>
                            <select class="form-control technician-dropdown" data-request-id="${request.requestID}">
                                <option value="">Select Technician</option>
                            </select>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                populateTechnicianDropdowns();

                // Add event listeners to view-details buttons
                document.querySelectorAll('.view-details-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const requestId = this.getAttribute('data-request-id');
                        viewDetails(requestId);
                    });
                });
            })
            .catch(error => console.error('Error searching requests:', error));
    }
}

function refreshRequests() {
    document.getElementById('searchRequestID').value = '';
    fetchRequests();
}

function fetchTechnicians() {
    fetch('fetchData.php?action=fetchTechnicians')
        .then(response => response.json())
        .then(data => {
            window.technicians = data; // Store technicians for later use
            populateTechnicianDropdowns();
        })
        .catch(error => console.error('Error fetching technicians:', error));
}

function populateTechnicianDropdowns() {
    const dropdowns = document.querySelectorAll('.technician-dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.innerHTML = '<option value="">Select Technician</option>';
        window.technicians.forEach(technician => {
            const option = document.createElement('option');
            option.value = technician.id;
            option.textContent = technician.service_provider;
            dropdown.appendChild(option);
        });
    });
}

function viewDetails(requestId) {
    fetch(`fetchData.php?action=fetchRequestDetails&requestID=${requestId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailDate').textContent = `${data.datePeriodFrom} to ${data.datePeriodTo}` || 'N/A';
            document.getElementById('detailDescription').textContent = data.issue_description || 'N/A';
            document.getElementById('detailLocation').textContent = data.location || 'N/A';

            // Scroll to details box
            document.getElementById('detailsBox').scrollIntoView({ behavior: 'smooth' });
        })
        .catch(error => console.error('Error fetching request details:', error));
}
</script>
</body>
<footer class="text-center text-lg-start text-white" style="background: linear-gradient(108.9deg, rgb(18, 85, 150) 4.9%, rgb(100, 190, 150) 97%);padding:5px;">
    <section class="">
      <div class="container text-center text-md-start mt-5">
        <div class="row mt-3">
          <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold">AQUA LINK</h6>
            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
            <p>The Water Supply Management System aims to revolutionize the traditional manual processes of water administration in rural areas. By leveraging modern technology, this system seeks to streamline water distribution, billing, and maintenance, ensuring a more efficient and reliable supply of water.</p>
          </div>

          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
            <h6 class="text-uppercase fw-bold">Useful links</h6>
            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
            <p><a href="#!" class="text-white">My Account</a></p>
            <p><a href="annualreports.php" class="text-white">Annual Reports</a></p>
            <p><a href="customerservices.php" class="text-white">Customer Services</a></p>
            <p><a href="help.php" class="text-white">Help</a></p>
          </div>

          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
            <h6 class="text-uppercase fw-bold">Contact</h6>
            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
            <p><i class="fas fa-home mr-3"></i>Colombo, Sri Lanka</p>
            <p><i class="fas fa-envelope mr-3"></i> info@aqualink.lk</p>
            <p><i class="fas fa-phone mr-3"></i> + 94 764 730 521</p>
            <p><i class="fas fa-print mr-3"></i> + 94 760 557 356</p>
          </div>
        </div>
      </div>
    </section>
    <div class="text-center p-3" style="position: absolute;width:99%;height:50px;">
      © 2024 Copyright: <a class="text-white" href="">aqualink.lk</a>
    </div>
</footer>

</html>
<?php
// Include database connection file
include('db.php');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'fetchRequests':
        fetchRequests($conn);
        break;

    case 'fetchTechnicians':
        fetchTechnicians($conn);
        break;

    case 'fetchRequestDetails':
        fetchRequestDetails($conn);
        break;

    default:
        echo json_encode(['error' => 'Invalid action']);
}

function fetchRequests($conn) {
    $requestID = isset($_GET['requestID']) ? intval($_GET['requestID']) : null;
    if ($requestID) {
        $sql = "SELECT * FROM maintenance_requests WHERE requestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $requestID);
    } else {
        $sql = "SELECT * FROM maintenance_requests";
        $stmt = $conn->prepare($sql);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $requests = [];
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
    echo json_encode($requests);
    $stmt->close();
}

function fetchTechnicians($conn) {
    $sql = "SELECT id, service_provider FROM technician";
    $result = $conn->query($sql);
    $technicians = [];
    while ($row = $result->fetch_assoc()) {
        $technicians[] = $row;
    }
    echo json_encode($technicians);
}

function fetchRequestDetails($conn) {
    $requestID = isset($_GET['requestID']) ? intval($_GET['requestID']) : null;
    if ($requestID) {
        $sql = "SELECT datePeriodFrom, datePeriodTo, issue_description, location FROM maintenance_requests WHERE requestID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $requestID);
        $stmt->execute();
        $result = $stmt->get_result();
        $details = $result->fetch_assoc();
        echo json_encode($details);
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Request ID not provided']);
    }
}

$conn->close();
?>




