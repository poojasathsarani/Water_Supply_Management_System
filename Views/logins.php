<?php 
session_start();
?>
<html>
<head>
    <style></style>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="../css/logincss.css">
</head>
<body>
    <video autoplay muted loop id="background-video">
        <source src="../images/background.mp4" type="video/mp4">
    </video>

    <div class="white-box">
        <div class="button-box">
            <div id="btns"></div>
            <button name='admins' class="toogle" id="adminbutton" type="button" onclick="admin()">ADMIN LOGIN</button>
            <button name='userss' class="toogle" id="userbutton" type="button" onclick="user()">USER LOGIN</button>
        </div>

        <!-- Admin login -->
        <form id="admins" action="" method="POST" class="input-group">
            <h2>Admin</h2>
            <div class="x">
                <label for="email">Username</label><br>
                <input id="email" value="" name="txtname">
            </div>
            <br><br>
            <div class="y">
                <label for="ids">Password</label><br>
                <input id="ids" value="" name="userpassword" type="password" placeholder="Enter Your Password">
            </div>
            <div>
                <button name='admin_login' class="btn" id="placelogin" type="submit">Log In</button>
            </div>
        </form>

        <!-- User login -->
        <form id="users" action="" method="POST" class="input-group">
            <h2>User</h2>
            <div class="x">
                <label for="user">Username</label><br>
                <input id="user" value="" name="users" type="text">
            </div>
            <br><br>
            <div class="y">
                <label for="pwd">Password</label><br>
                <input id="pwd" value="" name="userspassword" type="password" placeholder="Enter Your Password">
            </div>
            <div>
                <button name='user_login' class="btn" id="userlogin" type="submit">Log In</button>
            </div>
        </form>

        <script>
            var adminz = document.getElementById("admins");
            var userz = document.getElementById("users");
            var z = document.getElementById("btns");

            function admin() {
                adminz.style.left = "-400px";
                adminz.style.top = "-100px";
                userz.style.left = "30px";
                z.style.left = "0px";
            }

            function user() {
                adminz.style.left = "-900px";
                adminz.style.top = "-400px";
                userz.style.left = "-400px";
                z.style.left = "140px";
            }
        </script>

        <?php
        include('db.php'); // Include the database connection file

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Check if the admin login form was submitted
            if (isset($_POST['admin_login'])) {   
                // Get the username and password from the form input
                $uname = isset($_POST['txtname']) ? mysqli_real_escape_string($conn, $_POST['txtname']) : '';
                $password = isset($_POST['userpassword']) ? mysqli_real_escape_string($conn, $_POST['userpassword']) : '';

                // Create an SQL query to check if there is an admin user with the provided username and password
                $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$uname' and password='$password'");
                
                if (!$query) {
                    die('Query failed: ' . mysqli_error($conn));
                }

                // Get the number of rows returned by the query
                $row = mysqli_num_rows($query);

                // If one row is returned, it means the login credentials are correct
                if($row == 1) {
                    // Start a session and set a session variable 'admin'
                    $_SESSION['admin'] = 'admin';
                    
                    // Display an alert and redirect to the admin page
                    echo '
                    <script>
                        alert("Logged in successfully.");
                        window.location="admin.php";
                    </script>';
                } else {
                    // If no rows are returned, display an alert and redirect back to the login page
                    echo '
                    <script>
                        alert("Access denied.");
                        window.location="logins.php";
                    </script>';
                }
            }

            // Check if the user login form was submitted
            if (isset($_POST['user_login'])) {
                // Retrieve and sanitize user inputs
                $username = isset($_POST['users']) ? mysqli_real_escape_string($conn, $_POST['users']) : '';
                $password = isset($_POST['userspassword']) ? mysqli_real_escape_string($conn, $_POST['userspassword']) : '';

                // Check if both fields are filled
                if (empty($username) || empty($password)) {
                    echo '<script>
                        alert("Please fill in both fields.");
                        window.location="logins.php";
                        </script>';
                    exit();
                }

                // Fetch the user from the database
                $query = "SELECT id, username, password, role FROM users WHERE username='$username'";
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    die('Query failed: ' . mysqli_error($conn));
                }


                //

    $query = "SELECT id FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id);
        $stmt->fetch();
        
        // Store the user ID in the session
        $_SESSION['id'] = $id;

        // Redirect to the profile page or dashboard
        header("Location: profilemanage.php");
        exit;}
                // Check if user exists
                if (mysqli_num_rows($result) == 1) {
                    $user = mysqli_fetch_assoc($result);

                    // Verify the password
                    if (password_verify($password, $user['password'])) {
                        // Set session variables
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $_SESSION['role'] = $user['role'];

                        // Redirect based on user role
                        switch ($user['role']) {
                            case 'consumer':
                                header('Location: consumer.php');
                                break;
                            case 'meterreader':
                                header('Location: meterreader.php');
                                break;
                            case 'technician':
                                header('Location: technician.php');
                                break;
                            case 'serviceprovider':
                                header('Location: serviceprovider.php');
                                break;
                            default:
                                echo '<script>
                                    alert("Unknown role.");
                                    window.location="logins.php";
                                    </script>';
                                break;
                        }
                        exit();
                    } else {
                        echo '<script>
                            alert("Invalid password.");
                            window.location="logins.php";
                            </script>';
                    }
                } else {
                    echo '<script>
                        alert("Invalid username.");
                        window.location="logins.php";
                        </script>';
                }
            }
        }
        ?>
    </div>
</body>
</html>
