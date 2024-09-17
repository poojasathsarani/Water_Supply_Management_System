<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Completion Chart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/updatetask.css">
</head>
<body>
<header>
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
        <form>
            <input class="form-control me-2" type="search" placeholder="Search here" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</header>

<h1>Task Completion Chart</h1>

<h2>Auto-filled Data Table</h2>
<input type="text" id="autoFillRequestId" placeholder="Enter Request ID" oninput="autoFillData()">
<table id="autoFillTable" class="table">
    <thead>
        <tr>
            <th>Request ID</th>
            <th>Date Period</th>
            <th>Location</th>
            <th>Issue Description</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text" id="autoFillRequestIdInput" disabled></td>
            <td><input type="text" id="autoFillDatePeriod" disabled></td>
            <td><input type="text" id="autoFillLocation" disabled></td>
            <td><input type="text" id="autoFillIssueDescription" disabled></td>
        </tr>
    </tbody>
</table>

<h2>Task Update Table</h2>
<button onclick="addRow()">Add Row</button>
<input type="text" id="searchTaskId" placeholder="Enter Task ID">
<button onclick="searchRow()">Search</button>
<form id="taskForm">
    <table id="taskTable" class="table">
        <thead>
            <tr>
                <th>Task ID</th>
                <th>Owner</th>
                <th>Priority</th>
                <th>Start</th>
                <th>End</th>
                <th>% Complete</th>
                <th>Status</th>
                <th>Budget</th>
                <th>EST Hours</th>
                <th>Actual Hours</th>
                <th>Notes</th>
                <th>Done</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
        </tbody>
    </table>
    <button type="button" onclick="submitTasks()">Submit</button>
</form>

<script>
    function addRow() {
        var table = document.getElementById("taskTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);

        var today = new Date();
        var formattedDate = today.toISOString().split('T')[0];

        newRow.innerHTML = `
            <td><input type="text" value=""></td>
            <td><input type="text" value=""></td>
            <td>
                <select>
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </td>
            <td><input type="date" value="${formattedDate}"></td>
            <td><input type="date" value=""></td>
            <td><input type="number" value="0" min="0" max="100" step="1"></td>
            <td>
                <select>
                    <option value="Completed">Completed</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Not Started">Not Started</option>
                </select>
            </td>
            <td><input type="number" value=""></td>
            <td><input type="number" value=""></td>
            <td><input type="number" value=""></td>
            <td><input type="text" value=""></td>
            <td><input type="checkbox"></td>
        `;
    }

    function searchRow() {
        var input = document.getElementById('searchTaskId').value.toUpperCase();
        var table = document.getElementById("taskTable");
        var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName("td");
            var taskID = cells[0].getElementsByTagName("input")[0].value.toUpperCase();
            if (taskID.indexOf(input) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    function submitTasks() {
        var table = document.getElementById("taskTable");
        var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
        var data = [];

        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName("td");
            var rowData = {
                technician_Name: cells[1].getElementsByTagName("input")[0].value,
                technician_Name: cells[2].getElementsByTagName("input")[0].value,
                priority: cells[3].getElementsByTagName("select")[0].value,
                startDate: cells[4].getElementsByTagName("input")[0].value,
                endDate: cells[5].getElementsByTagName("input")[0].value,
                completedPercentage: cells[6].getElementsByTagName("input")[0].value,
                status: cells[7].getElementsByTagName("select")[0].value,
                budget: cells[8].getElementsByTagName("input")[0].value,
                estHours: cells[9].getElementsByTagName("input")[0].value,
                actualHours: cells[10].getElementsByTagName("input")[0].value,
                notes: cells[11].getElementsByTagName("input")[0].value,
                done: cells[12].getElementsByTagName("input")[0].checked ? 1 : 0
            };
            data.push(rowData);
        }

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "updatetask.php", true);
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(data));
        xhr.onload = function() {
            if (xhr.status == 200) {
                var responseText = xhr.responseText;
                if (responseText.startsWith("JSON decoding error:")) {
                    alert(responseText);
                } else {
                    alert("Tasks updated successfully!");
                }
            } else {
                console.error("Error response from server: " + xhr.responseText);
                alert("Error updating tasks. Please try again.");
            }
        };
    }
</script>

</body>
</html>
<?php
include('db.php');

// Read the JSON data from the POST request
$data = json_decode(file_get_contents("php://input"), true);

// Check for JSON decoding errors
if (json_last_error() !== JSON_ERROR_NONE) {
    $error_message = json_last_error_msg();
    echo "JSON decoding error: $error_message";
    error_log("JSON decoding error: " . $error_message);
    die(); // Terminate the script
}

// Debug the data (optional)
var_dump($data);

if (!is_array($data)) {
    echo "Invalid data format";
    die(); // Terminate the script
}

// Prepare the SQL statement
foreach ($data as $row) {
    $stmt = $conn->prepare("INSERT INTO updatetask 
                            (taskID, technician_Name, priority, startDate, endDate, completedPercentage, status, budget, estHours, actualHours, notes, done)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ON DUPLICATE KEY UPDATE 
                            taskID=?, technician_Name=?, priority=?, startDate=?, endDate=?, completedPercentage=?, status=?, budget=?, estHours=?, actualHours=?, notes=?, done=?");

    // Bind parameters: s = string, i = integer, d = double
    $stmt->bind_param(
        "issssisdddsiissssisdddsi", 
        $row['taskID'], 
        $row['technician_Name'], 
        $row['priority'], 
        $row['startDate'], 
        $row['endDate'], 
        $row['completedPercentage'], 
        $row['status'], 
        $row['budget'], 
        $row['estHours'], 
        $row['actualHours'], 
        $row['notes'], 
        $row['done'], 
        $row['taskID'], 
        $row['technician_Name'], 
        $row['priority'], 
        $row['startDate'], 
        $row['endDate'], 
        $row['completedPercentage'], 
        $row['status'], 
        $row['budget'], 
        $row['estHours'], 
        $row['actualHours'], 
        $row['notes'], 
        $row['done']
    );

    if (!$stmt->execute()) {
        error_log("SQL Error: " . $stmt->error);
        echo "SQL Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
