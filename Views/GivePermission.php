<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Permissions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/GP.css">
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

<div class="wrapper">
    <nav id="sidebar">
        <ul class="list-unstyled components">
           <li>
                <a href="admin.php" class="dashboard">Dashboard</a>
            </li>
            <li>
                <a href="#givePermission" class="scroll-link">Give Permission</a>
            </li>
            <li>
                <a href="#userRoleManagement" class="scroll-link">User Role Management</a>
            </li>
        </ul>
    </nav>
    <div class="content">

        <div id="userRoleManagement" class="container mt-4">
            <div class="row">
                <!-- User Role Management -->
                <div class="col-md-4">
                    <h3>User Role Management</h3>
                    <div id="roleList" class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active" data-role="serviceProvider">Service Provider</a>
                        <a href="#" class="list-group-item list-group-item-action" data-role="technician">Technician</a>
                        <a href="#" class="list-group-item list-group-item-action" data-role="consumer">Consumer</a>
                        <a href="#" class="list-group-item list-group-item-action" data-role="meterReader">Meter Reader</a>
                    </div>
                    <button class="btn btn-primary mt-3">Add Role</button>
                    <button class="btn btn-secondary mt-3">Edit Role</button>
                    <button class="btn btn-danger mt-3">Delete Role</button>
                </div>

                <!-- Assign Permissions to Roles -->
                <div class="col-md-8">
                    <h3 id="roleTitle">Service Provider Permissions</h3>
                    <form id="permissionForm">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="viewReports" checked>
                            <label class="form-check-label" for="viewReports">View Reports</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="manageRequests" checked>
                            <label class="form-check-label" for="manageRequests">Manage Requests</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editProfile">
                            <label class="form-check-label" for="editProfile">Edit Profile</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sendNotifications">
                            <label class="form-check-label" for="sendNotifications">Send Notifications</label>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Save Changes</button>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <!-- Assign Roles to Users -->
                <div class="col-md-12">
                    <h3>Assign Roles to Users</h3>
                    <div id="userList" class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" data-user="user1">User_ID</a>
                    </div>
                    <select class="form-control mt-3" id="roleAssignmentDropdown">
                        <option value="serviceProvider">Service Provider</option>
                        <option value="technician">Technician</option>
                        <option value="consumer">Consumer</option>
                        <option value="meterReader">Meter Reader</option>
                    </select>
                    <button class="btn btn-primary mt-3">Assign Role</button>
                </div>
            </div>

            <!-- Notification Area -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div id="notificationArea">
                        <!-- Success and Error Messages will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Smooth scrolling for sidebar links
        $('.scroll-link').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            }, 500);
        });

        $('#roleList .list-group-item').click(function() {
            $('#roleList .list-group-item').removeClass('active');
            $(this).addClass('active');
            const role = $(this).data('role');
            $('#roleTitle').text(role.charAt(0).toUpperCase() + role.slice(1) + ' Permissions');
            // Load permissions for the selected role
        });

        $('#permissionForm').submit(function(event) {
            event.preventDefault();
            // Save permissions logic
            $('#notificationArea').html('<div class="alert alert-success">Permissions saved successfully!</div>');
        });

        $('#userList .list-group-item').click(function() {
            $('#userList .list-group-item').removeClass('active');
            $(this).addClass('active');
        });

        $('#roleAssignmentDropdown').change(function() {
            const selectedRole = $(this).val();
            // Update role assignment logic
        });

        $('.btn-primary.mt-3').click(function() {
            // Assign role to user logic
            $('#notificationArea').html('<div class="alert alert-success">Role assigned successfully!</div>');
        });
    });
</script>

</body>
</html>
