<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handling Maintenance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/handlingmaintenance.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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

<!-- Maintenance Tasks Table -->
<h2>Maintenance Tasks</h2>
<div class="input">
    <input type="text" id="searchMaintenanceRequestId" placeholder="Enter Task ID">
    <button class="btn btn-primary" onclick="searchMaintenanceRow()">Search</button>
    <button class="btn btn-primary" onclick="refresh()">Refresh</button>
</div>
<div class="table-container">
    <table id="maintenanceTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Owner</th>
                <th>Priority</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>% Completed</th>
                <th>Status</th>
                <th>Budget</th>
                <th>EST Hours</th>
                <th>Actual Hours</th>
                <th>Notes</th>
                <th>Done</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- This section will be dynamically populated with updated tasks from technicians -->
        </tbody>
    </table>
</div>

<footer class="text-center text-lg-start text-white" style="background: linear-gradient(108.9deg, rgb(18, 85, 150) 4.9%, rgb(100, 190, 150) 97%);font-family: Arial, sans-serif;">
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

<script>
    $(document).ready(function() {
        function fetchUpdatedTasks() {
            // Make AJAX request to fetch updated tasks
            $.ajax({
                type: "GET",
                url: "fetchMaintenanceTasks.php", // PHP file to fetch maintenance tasks
                dataType: "json",
                success: function(data) {
                    populateTable(data);
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                }
            });
        }

        function populateTable(data) {
            var tableBody = $('#maintenanceTable tbody');
            tableBody.empty();
            data.forEach(function(task) {
                var row = `<tr>
                    <td>${task.taskID}</td>
                    <td>${task.owner}</td>
                    <td>${task.priority}</td>
                    <td>${task.startDate}</td>
                    <td>${task.endDate}</td>
                    <td>${task.completedPercentage}%</td>
                    <td>
                        <select class="form-control task-status" data-task-id="${task.taskID}">
                            <option value="Not Started" ${task.status == 'Not Started' ? 'selected' : ''}>Not Started</option>
                            <option value="In Progress" ${task.status == 'In Progress' ? 'selected' : ''}>In Progress</option>
                            <option value="Completed" ${task.status == 'Completed' ? 'selected' : ''}>Completed</option>
                        </select>
                    </td>
                    <td>${task.budget}</td>
                    <td>${task.estHours}</td>
                    <td>${task.actualHours}</td>
                    <td>${task.notes}</td>
                    <td>
                        <button class="btn btn-success update-btn" onclick="updateTask(${task.taskID})">Update</button>
                    </td>
                </tr>`;
                tableBody.append(row);
            });
        }

        function searchMaintenanceRow() {
            var input = $('#searchMaintenanceRequestId').val().trim();
            if (input) {
                var filteredData = data.filter(function(task) {
                    return task.taskID.toString() === input;
                });
                populateTable(filteredData);
            } else {
                fetchUpdatedTasks();
            }
        }

        function refresh() {
            $('#searchMaintenanceRequestId').val('');
            fetchUpdatedTasks();
        }

        function updateTask(taskID) {
            var status = $(`.task-status[data-task-id='${taskID}']`).val();
            $.ajax({
                type: "POST",
                url: "updateTask.php", // Ensure this is the correct PHP file for updating task status
                data: {
                    taskID: taskID,
                    status: status
                },
                success: function(response) {
                    alert('Update Successful!');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Error updating task status.');
                }
            });
        }

        // Initial fetch of tasks
        fetchUpdatedTasks();

        // Expose functions to global scope
        window.searchMaintenanceRow = searchMaintenanceRow;
        window.refresh = refresh;
        window.updateTask = updateTask;
    });
</script>
</body>
</html>
<?php
include('db.php');

// SQL query to fetch maintenance tasks
$sql = "SELECT * FROM updatetask"; // Adjust table name and columns as needed
$result = $conn->query($sql);

$tasks = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($tasks);

$conn->close();
?>
