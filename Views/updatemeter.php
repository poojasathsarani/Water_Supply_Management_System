<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Meter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/updateNew.css">
</head>
<body>
    <header class="header">
        <nav class="navbar navbar-expand-lg">
            <img class="logopic" src="../images/logo.png">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="aboutus.php">About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="contactus.php">Contact us</a></li>
                    <li class="nav-item"><a class="nav-link" href="faq.php">F&Q</a></li>
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
                <li><a href="meterreader.php" class="dashboard">Dashboard</a></li>
                <li><a href="warningmeter.php" class="dashboard">Warning</a></li>
                <li><a href="meterprofile.php" class="dashboard">Profile Management</a></li>
            </ul>
        </nav>

        <div class="tablecontainer">
            <h2>Bill Data Update Table</h2>
            <button id="addRowButton" class="btn btn-primary">Add Row</button>
            <input type="text" id="searchBillId" placeholder="Enter Account Number" class="form-control">
            <button id="searchButton" class="btn btn-primary">Search</button>
            <form id="billForm">
                <table id="billTable" class="table">
                    <thead>
                        <tr>
                            <th>Service Provider ID</th>
                            <th>Account Number</th>
                            <th>Consumer Name</th>
                            <th>Billing Date</th>
                            <th>Current Consumption</th>
                            <th>Previous Consumption</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Rows will be added dynamically here -->
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log("JavaScript Loaded");

        // Add a row to the table
        function addBillRow() {
            const table = document.getElementById("billTable").getElementsByTagName('tbody')[0];
            const newRow = table.insertRow(table.rows.length);

            // Create today's date
            const today = new Date().toISOString().split('T')[0];

            // Adding cells to the new row
            newRow.innerHTML = `
                <td><input type="number" name="service_provider_id"></td>
                <td><input type="text" name="account_number"></td>
                <td><input type="text" name="consumer_name"></td>
                <td><input type="date" name="billing_date" value="${today}"></td>
                <td><input type="number" name="current_consumption"></td>
                <td><input type="number" name="previous_consumption"></td>
                <td>
                    <button type="button" onclick="submitBillRow(this)">Submit</button>
                    <button type="button" onclick="editBillRow(this)">Edit</button>
                    <button type="button" onclick="deleteBillRow(this)">Delete</button>
                </td>
            `;
            console.log("New row added");
        }

        // Delete a row from the table
        function deleteBillRow(button) {
            const row = button.closest('tr');
            const id = row.dataset.id;

            if (id && confirm('Are you sure you want to delete this record?')) {
                fetch('updatemeter.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify([{ id: parseInt(id), action: 'delete' }]), // Send the ID to delete
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert(result.message);
                        row.remove();
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    alert('Error: ' + error.message);
                });
            }
        }

        // Submit data (insert or update)
        function submitBillRow(button) {
            const row = button.closest('tr');
            const id = row.dataset.id;
            const bill = {
                id: id ? parseInt(id) : null,
                service_provider_id: row.cells[0].querySelector('input').value,
                account_number: row.cells[1].querySelector('input').value,
                consumer_name: row.cells[2].querySelector('input').value,
                billing_date: row.cells[3].querySelector('input').value,
                current_consumption: row.cells[4].querySelector('input').value,
                previous_consumption: row.cells[5].querySelector('input').value,
                action: id ? 'update' : 'insert'
            };

            console.log("Submitting bill row", bill);

            fetch('updatemeter.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify([bill]), // Wrap in an array for consistency
            })
            .then(response => response.json())
            .then(result => {
                console.log("Result from server", result);
                if (result.status === 'success') {
                    alert('Success: ' + result.message);
                    if (!id) {
                        row.dataset.id = result.newId; // Update the row with the new ID
                    }
                } else {
                    alert('Error: ' + result.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }

        // Edit a row (enable inputs)
        function editBillRow(button) {
            const row = button.closest('tr');
            const inputs = row.querySelectorAll('input');
            inputs.forEach(input => input.disabled = !input.disabled);
            console.log("Row editing enabled");
        }

        // Add event listeners to buttons
        document.getElementById("addRowButton").addEventListener('click', addBillRow);
    });
    </script>
</body>
<!-- Footer -->
<footer class="text-center text-lg-start text-white" style="background: linear-gradient(108.9deg, rgb(18, 85, 150) 4.9%, rgb(100, 190, 150) 97%);">
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
            <div class="text-center p-3" style="height: 50px;">
                © 2024 Copyright: <a class="text-white" href="">aqualink.lk</a>
            </div>
        </div>
    </section>
</footer>
</html>
<?php
// PHP code for handling form submissions
include('db.php');

// Disable error display for production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Enable error logging to a file
ini_set("log_errors", 1);
ini_set("error_log", "/path/to/php-error.log"); // Ensure this path is writable by the web server

header('Content-Type: application/json');

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    echo json_encode(['status' => 'success', 'received' => $data]);
    if (!empty($data)) {
        $conn->begin_transaction();
        try {
            foreach ($data as $bill) {
                if (isset($bill['action'])) {
                    if ($bill['action'] == 'delete') {
                        // Delete record
                        $stmt = $conn->prepare("DELETE FROM bills WHERE bill_id = ?");
                        $stmt->bind_param("i", $bill['id']);
                    } elseif ($bill['action'] == 'update') {
                        // Update existing record
                        $stmt = $conn->prepare("UPDATE bills SET service_provider_id = ?, account_number = ?, consumer_name = ?, billing_date = ?, current_consumption = ?, previous_consumption = ? WHERE bill_id = ?");
                        $stmt->bind_param("isssiii", $bill['service_provider_id'], $bill['account_number'], $bill['consumer_name'], $bill['billing_date'], $bill['current_consumption'], $bill['previous_consumption'], $bill['id']);
                    } elseif ($bill['action'] == 'insert') {
                        // Insert new record
                        $stmt = $conn->prepare("INSERT INTO bills (service_provider_id, account_number, consumer_name, billing_date, current_consumption, previous_consumption) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("isssii", $bill['service_provider_id'], $bill['account_number'], $bill['consumer_name'], $bill['billing_date'], $bill['current_consumption'], $bill['previous_consumption']);
                    }

                    if ($stmt->execute()) {
                        if ($bill['action'] == 'insert') {
                            $bill['id'] = $stmt->insert_id; // Get the new ID
                        }
                        $response[] = ['status' => 'success', 'message' => 'Record successfully processed', 'newId' => $bill['id'] ?? null];
                    } else {
                        throw new Exception($stmt->error);
                    }
                    $stmt->close();
                }
            }
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Transaction failed: ' . $e->getMessage()]);
            exit;
        }

        echo json_encode(['status' => 'success', 'message' => 'All records processed successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No data received']);
    }
    exit;
}else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

?>