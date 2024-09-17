<?php
// Start the session at the very beginning of the script
session_start();  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/profilemanage.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <img class="logopic" src="../images/logo.png" alt="Logo">
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home</a>
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
        <div class="form-inline">
            <form>
                <input class="form-control me-2" type="search" placeholder="Search here" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </nav>
</header>
<div class="container">
    <div class="main">
        <h1>Edit profile</h1>
        <form id="profileForm" method="post" action="profilemanage.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="firstName">Name</label>
                <input type="text" id="firstName" name="firstName" value="">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="">
            </div>
            <div class="form-group">
                <label for="contactNumber">Contact Number</label>
                <input type="text" id="contactNumber" name="contactNumber" value="">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" value="">
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" id="province" name="province" value="">
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" value="">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="">
            </div>
            <div class="form-group">
                <button type="button" class="cancel">Cancel</button>
                <button type="submit" class="save">Save</button>
            </div>
        </form>
    </div>
</div>

<footer class="text-center text-lg-start text-white">
    <section class="">
        <div class="container text-center text-md-start mt-5">
            <div class="row mt-3">
                <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">AQUA LINK</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"/>
                    <p>The Water Supply Management System aims to revolutionize the traditional manual processes of water administration in rural areas. By leveraging modern technology, this system seeks to streamline water distribution, billing, and maintenance, ensuring a more efficient and reliable supply of water.</p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                    <h6 class="text-uppercase fw-bold">Useful links</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"/>
                    <p><a href="#!" class="text-white">My Account</a></p>
                    <p><a href="annualreports.php" class="text-white">Annual Reports</a></p>
                    <p><a href="customerservices.php" class="text-white">Customer Services</a></p>
                    <p><a href="help.php" class="text-white">Help</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="text-uppercase fw-bold">Contact</h6>
                    <hr class="mb-4 mt-0 d-inline-block mx-auto"/>
                    <p><i class="fas fa-home mr-3"></i>Colombo, Sri Lanka</p>
                    <p><i class="fas fa-envelope mr-3"></i> info@aqualink.lk</p>
                    <p><i class="fas fa-phone mr-3"></i> + 94 764 730 521</p>
                    <p><i class="fas fa-print mr-3"></i> + 94 760 557 356</p>
                </div>
            </div>
        </div>
        <div class="text-center p-3">
            © 2024 Copyright: <a class="text-white" href="">aqualink.lk</a>
        </div>
    </section>
</footer>

<!-- jQuery -->
<script>
    $(document).ready(function() {
        // Profile picture upload handling
        function triggerFileUpload() {
            $('#profilePicUpload').click();
        }

        function loadFile(event) {
            var output = document.getElementById('profilePic');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.style.display = 'block';
            $('#profileIcon').hide(); // Hide profile icon after selecting picture
        }

        window.triggerFileUpload = triggerFileUpload;
        window.loadFile = loadFile;

        // AJAX form submission
        $('#profileForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: 'profilemanage.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    alert(response); // Show response from server
                }
            });
        });

        // Cancel button handling
        $('.cancel').on('click', function() {
            window.location.href = '../index.php'; // Redirect to homepage on cancel
        });
    });
</script>
</body>
</html>
<?php
include('db.php');  // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "No user ID in session.";
    exit;
} else {
    $id = $_SESSION['id']; // Get the logged-in user's ID
}

// Proceed only if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the form inputs
    $firstName = filter_var(trim($_POST['firstName']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $contactNumber = filter_var(trim($_POST['contactNumber']), FILTER_SANITIZE_STRING);
    $address = filter_var(trim($_POST['address']), FILTER_SANITIZE_STRING);
    $province = filter_var(trim($_POST['province']), FILTER_SANITIZE_STRING);
    $city = filter_var(trim($_POST['city']), FILTER_SANITIZE_STRING);
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);

    // Input validation (optional)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    if (!preg_match('/^\d{10}$/', $contactNumber)) {
        echo "Invalid contact number. Must be 10 digits.";
        exit;
    }

    // Update the user's profile in the database
    $query = "UPDATE users SET name = ?, email = ?, phone = ?, address = ?, province = ?, city = ?, username = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssi", $firstName, $email, $contactNumber, $address, $province, $city, $username, $id);

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>