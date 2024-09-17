<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/GReport.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg">
    <img class="logopic" src="../images/logo.png">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
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

<div class="wrapper">
    <nav id="sidebar">
        <ul class="list-unstyled components">
            <li>
                <a href="admin.php" class="dashboard">Dashboard</a>
            </li>
            <li>
                <a href="#filterRequestForm" class="scroll-link">View Details</a>
            </li>
            <li>
                <a href="#maintenanceRequestForm" class="scroll-link">Generate Reports</a>
            </li>
            <li>
                <a href="#generateBillForm" class="scroll-link">Generate Bills</a>
            </li>
        </ul>
    </nav>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                </button>
                <h2>Summary</h2>
            </div>
        </nav>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>8,457</h3>
                        <p>users</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>52,160</h3>
                        <p>Sales</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>15,823</h3>
                        <p>Feedback</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h3>36,752</h3>
                        <p>No. of Visits</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h3>Consumption</h3>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h3>Area Chart</h3>
                        <canvas id="areaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h3>Data Of Users</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Username</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John</td>
                                    <td>Doe</td>
                                    <td>@johndoe</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane</td>
                                    <td>Doe</td>
                                    <td>@janedoe</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Sam</td>
                                    <td>Smith</td>
                                    <td>@samsmith</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Generate Bills Section -->
<!-- Generate Bills Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
        <div class="card-body">
    <h3>Generate Bills</h3>
    <table class="table table-bordered" id="billsTable">
        <thead>
            <tr>
                <th>Service Provider</th>
                <th>Account Number</th>
                <th>Consumer Name</th>
                <th>Billing Date</th>
                <th>Current Consumption (units)</th>
                <th>Previous Consumption (units)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Rows will be populated dynamically -->
        </tbody>
    </table>
    <div id="billOutput" style="margin-top:20px;">
        <!-- Generated bills will be displayed here -->
    </div>
    <button type="button" class="btn btn-primary" onclick="generateBill()">Generate Bill</button>
    <button type="button" class="btn btn-secondary" onclick="printBill()">Print Bill</button>
    <button type="button" class="btn btn-success" onclick="sendToDashboard()">Send to Dashboard</button>
</div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<?php
include('db.php');
// Fetch bills from the database
$sql = "SELECT bill_id, service_provider_id, account_number, consumer_name, billing_date, current_consumption, previous_consumption FROM bills";
$result = $conn->query($sql);

$bills = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $bills[] = $row;
    }
}



$conn->close();
?>
<script>
    $(document).ready(function() {
            // Example JSON data (this should be fetched from your backend)
            var data = <?php echo json_encode($bills); ?>;

            var tableBody = $('#billsTable tbody');
            tableBody.empty();
            data.forEach(function(bill) {
                var row = `<tr>
                    <td>Service Provider ${bill.service_provider_id}</td>
                    <td>${bill.account_number}</td>
                    <td>${bill.consumer_name}</td>
                    <td>${bill.billing_date}</td>
                    <td>${bill.current_consumption}</td>
                    <td>${bill.previous_consumption}</td>
                    <td><button class="btn btn-info" onclick="generateBill(${bill.bill_id})">Generate Bill</button></td>
                </tr>`;
                tableBody.append(row);
            });

            window.generateBill = function(billId) {
                var bill = data.find(b => b.bill_id == billId);
                var consumption = bill.current_consumption - bill.previous_consumption;
                var ratePerUnit = 0.20; // Example rate
                var totalAmount = consumption * ratePerUnit;

                // Format the bill details
                var billData = `
                    <div style="border: 1px solid #000; padding: 20px;">
                        <div style="text-align: center;">
                            <img src="../images/logo.png" alt="Company Logo" style="width: 100px;">
                            <h2>Water Supply Management System</h2>
                        </div>
                        <p><strong>Bill ID:</strong> ${bill.consumer_id}-${bill.billing_date}</p>
                        <p><strong>Service Provider:</strong> Service Provider ${bill.service_provider_id}</p>
                        <p><strong>Account Number:</strong> ${bill.account_number}</p>
                        <p><strong>Consumer Name:</strong> ${bill.consumer_name}</p>
                        <p><strong>Billing Date:</strong> ${bill.billing_date}</p>
                        <p><strong>Previous Consumption:</strong> ${bill.previous_consumption} units</p>
                        <p><strong>Current Consumption:</strong> ${bill.current_consumption} units</p>
                        <p><strong>Consumption:</strong> ${consumption} units</p>
                        <p><strong>Total Amount:</strong> $${totalAmount.toFixed(2)}</p>
                        <p>Thank you for your service!</p>
                    </div>
                `;
                $('#billOutput').html(billData);
            };

            window.printBill = function() {
                var printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>Print Bill</title>');
                printWindow.document.write('</head><body >');
                printWindow.document.write($('#billOutput').html());
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.focus();
                printWindow.print();
            };

            window.sendToDashboard = function() {
                var billData = $('#billOutput').html();
                // Implement the logic to send the bill data to the consumer dashboard
                // This could involve making an AJAX request to your server-side script
                alert('Bill has been sent to the consumer dashboard.');
            };
        });
    // Line Chart
    var ctx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                data: [10, 20, 30, 40, 50, 60, 70]
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Value'
                    }
                }
            }
        }
    });

    // Area Chart
    var ctx2 = document.getElementById('areaChart').getContext('2d');
    var areaChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Dataset 1',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                data: [70, 60, 50, 40, 30, 20, 10]
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    display: true,
                    title: {
                        display: true,
                        text: 'Value'
                    }
                }
            }
        }
    });
    
    


</script>

<!-- Footer -->
<footer class="text-center text-lg-start text-white" style="background: linear-gradient(108.9deg, rgb(18, 85, 150) 4.9%, rgb(100, 190, 150) 97%); margin-top:170px;padding:5px;">
    <!-- Section: Links -->
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
                <!-- Grid column -->
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold">AQUA LINK</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
                    <p>
                        The Water Supply Management System aims to revolutionize the traditional manual processes of water administration in rural areas. By leveraging modern technology, this system seeks to streamline 
                        water distribution, billing, and maintenance, ensuring a more efficient and reliable supply of water.
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Useful links</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
                    <p>
                        <a href="#!" class="text-white">My Account</a>
                    </p>
                    <p>
                        <a href="annualreports.php" class="text-white">Annual Reports</a>
                    </p>
                    <p>
                        <a href="customerservices.php" class="text-white">Customer Services</a>
                    </p>
                    <p>
                        <a href="help.php" class="text-white">Help</a>
                    </p>
                </div>
                <!-- Grid column -->

                <!-- Grid column -->
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold">Contact</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px"/>
                    <p><i class="fas fa-home mr-3"></i>Colombo, Sri Lanka</p>
                    <p><i class="fas fa-envelope mr-3"></i> info@aqualink.lk</p>
                    <p><i class="fas fa-phone mr-3"></i> + 94 764 730 521</p>
                    <p><i class="fas fa-print mr-3"></i> + 94 760 557 356</p>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->
        </div>
    </section>
    <!-- Section: Links -->

    <!-- Copyright -->
    <div class="text-center p-3" style="position: absolute;width:99%;height:50px;">
        © 2024 Copyright:
        <a class="text-white" href="">aqualink.lk</a>
    </div>
    <!-- Copyright -->
</footer>
</body>
</html>
