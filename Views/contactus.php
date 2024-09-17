
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../css/contactus.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
        <!-- Header -->
        <header>
        <div class="logo">
            <img src="../images/logo.png" alt="Aqua Link Logo">
        </div>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQ</a></li>
            </ul>
        </nav>
        <div class="header-right">
            <div class="search-bar">
                <input type="text" placeholder="Search here">
                <button>Search</button>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h1>Contact us</h1>
            <form action="#">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="">

                <label for="email">Email address</label>
                <input type="email" id="email" name="email" placeholder="">

                <label for="message">Your message</label>
                <textarea id="message" name="message" placeholder="Enter your question or message"></textarea>

                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
    <!-- <div class="footer-icons">
        <img src="mail-icon.png" alt="Email Icon">
        <img src="location-icon.png" alt="Location Icon">
        <img src="phone-icon.png" alt="Phone Icon">
    </div> -->
     <!-- Footer -->
     <footer>
        <div class="footer-section">
            <h2>AQUA LINK</h2>
            <p>The Water Supply Management System aims to revolutionize the traditional manual processes of water administration in rural areas. By leveraging modern technology, this system seeks to streamline water distribution, billing, and maintenance, ensuring a more efficient and reliable supply of water.</p>
        </div>
        <div class="footer-section">
            <h2>USEFUL LINKS</h2>
            <ul>
                <li><a href="#">My Account</a></li>
                <li><a href="#">Annual Reports</a></li>
                <li><a href="#">Customer Services</a></li>
                <li><a href="#">Help</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h2>CONTACT</h2>
            <p>Colombo, Sri Lanka</p>
            <p>info@aqualink.lk</p>
            <p>+94 764 730 521</p>
            <p>+94 760 557 356</p>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Copyright: aqualink.lk</p>
        </div>
    </footer>
</body>
</html>
