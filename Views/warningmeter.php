<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Warnings</title>
<link rel="stylesheet" type="text/css" href="../css/warningmeter.css">
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
    <form onsubmit="return false;">
        <input class="form-control me-2" id="meterIdInput" type="search" placeholder="Search by Meter ID" aria-label="Search">
        <button class="btn btn-outline-success" type="button" onclick="searchByMeterId()">Search</button>
    </form>
</div>
</header>

<div class="wrapper">
    <nav id="sidebar">
        <ul class="list-unstyled components">
            <li>
                <a href="updatemeter.php" class="dashboard">Dashboard</a>
            </li>
            <li>
            <a href="warningmeter.php" class="dashboard">Warnings</a>
            </li>
            <li>
            <a href="meterprofile.php" class="dashboard">Profile Management</a>
            </li>
        </ul>
    </nav>

    <div id="content">
        <div class="tablecontainer">
          <table id="requestsTable" class="table table-striped">
            <thead>
              <tr>
                <th>Consumer Name</th>
                <th>Meter ID</th>
                <th>Number of Month</th>
                <th>Unpaid Units</th>
                <th>Total Payment</th>
                <th>Confirmation</th>
              </tr>
            </thead>
            <tbody>
              <!-- Data will be inserted here by JavaScript -->
            </tbody>
          </table>
        </div>
    </div>
</div>

<script>
    function searchByMeterId() {
        const meterId = document.getElementById('meterIdInput').value;
        const tableBody = document.querySelector('#requestsTable tbody');
        tableBody.innerHTML = ''; // Clear previous results

        fetch(`search.php?meterId=${meterId}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.consumer_name}</td>
                            <td>${row.meter_id}</td>
                            <td>
                                <select class="form-control month-dropdown" data-id="${row.id}">
                                    <option value="January" ${row.month === 'January' ? 'selected' : ''}>January</option>
                                    <option value="February" ${row.month === 'February' ? 'selected' : ''}>February</option>
                                     <option value="March" ${row.month === 'March' ? 'selected' : ''}>March</option>
                                      <option value="April" ${row.month === 'April' ? 'selected' : ''}>April</option>
                                       <option value="May" ${row.month === 'May' ? 'selected' : ''}>May</option>
                                        <option value="June" ${row.month === 'June' ? 'selected' : ''}>June</option>
                                         <option value="July" ${row.month === 'July' ? 'selected' : ''}>July</option>
                                          <option value="August" ${row.month === 'August' ? 'selected' : ''}>August</option>
                                           <option value="September" ${row.month === 'September' ? 'selected' : ''}>September</option>
                                            <option value="October" ${row.month === 'October' ? 'selected' : ''}>October</option>
                                            <option value="November" ${row.month === 'November' ? 'selected' : ''}>November</option>
                                    <option value="December" ${row.month === 'December' ? 'selected' : ''}>December</option>
                                </select>
                            </td>
                            <td><input type="number" class="form-control unit-input" value="${row.units}" data-id="${row.id}"></td>
                            <td>${row.total_payment}</td>
                            <td><button class="btn btn-primary" onclick="confirmPayment(${row.id})">Confirm</button></td>
                        `;
                        tableBody.appendChild(tr);
                    });
                } else {
                    tableBody.innerHTML = '<tr><td colspan="6">No results found</td></tr>';
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function confirmPayment(id) {
        fetch('confirm.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Payment confirmed successfully.');
                searchByMeterId(); // Refresh the table
            } else {
                alert('Error confirming payment.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

<footer class="text-center text-lg-start text-white" style="background: linear-gradient(108.9deg, rgb(18, 85, 150) 4.9%, rgb(100, 190, 150) 97%); padding: 5px;">
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
            <p><i class="fas fa-home mr-3"></i>Colombo, Sri Lanka</p

            <?php
// Database connection
$servername = "localhost"; // Replace with your server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "your_database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) ? $conn->real_escape_string($data['id']) : '';

// Prepare and execute the confirm query
$sql = "UPDATE your_table_name SET confirmation = 'Confirmed' WHERE id = '$id'";

$response = [];
if ($conn->query($sql) === TRUE) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $conn->error;
}

echo json_encode($response);

// Close connection
$conn->close();
?>

