<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Flight Management System</title>
    <style>
        /* All the same styles as index.php */
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Header Styles */
        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        /* Navigation Styles */
        nav {
            background-color: var(--dark-color);
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
        }
        
        .nav-menu li {
            position: relative;
        }
        
        .nav-menu li a {
            color: white;
            text-decoration: none;
            padding: 1rem;
            display: block;
            transition: background-color 0.3s;
        }
        
        .nav-menu li a:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .dropdown {
            position: relative;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: var(--dark-color);
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        /* Main Content Styles */
        main {
            padding: 2rem 0;
            min-height: 70vh;
        }
        
        .admin-panel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }
        
        .admin-card {
            background-color: white;
            padding: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .admin-card:hover {
            transform: translateY(-5px);
        }
        
        .admin-card h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .admin-card p {
            color: #666;
            margin-bottom: 1.5rem;
        }
        
        .admin-card a {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .admin-card a:hover {
            background-color: var(--secondary-color);
        }
        
        /* Footer Styles */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 2rem 0;
            margin-top: 2rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        
        .footer-section h3 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        
        .footer-section p, .footer-section a {
            color: #bbb;
            margin-bottom: 0.5rem;
            display: block;
            text-decoration: none;
        }
        
        .footer-section a:hover {
            color: white;
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid #444;
            color: #bbb;
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">Flight Management System</div>
        </div>
    </header>
    
    <nav>
        <div class="container">
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="view_flights.php">View Flights</a></li>
                <li><a href="book_flight.php">Book Flight</a></li>
                <li><a href="process_payment.php">Process Payment</a></li>
                <li class="dropdown">
                    <a href="admin_panel.php">Admin Panel</a>
                    <div class="dropdown-content">
                        <a href="view_bookings.php">View Bookings</a>
                        <a href="alter_flights.php">Alter Flights</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <main class="container">
        <h1 style="margin-bottom: 2rem; color: var(--dark-color);">Admin Panel</h1>
        
        <div class="admin-panel">
            <div class="admin-card">
                <h2>View Bookings</h2>
                <p>View all flight bookings with passenger details, flight information, and payment status.</p>
                <a href="view_bookings.php">Access Bookings</a>
            </div>
            
            <div class="admin-card">
                <h2>Alter Flights</h2>
                <p>Manage flight details including adding, updating, or removing flights from the system.</p>
                <a href="alter_flights.php">Manage Flights</a>
            </div>
        </div>
    </main>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>About Us</h3>
                    <p>Flight Management System - An comprehensive website with a Database made using mysqli in myphpadmin and has data retrival , inserting and updation using php scripts.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Team Member 1 :</h3>
                    <p>IRFAN BASHA . L</p>
                    <a href="index.php">20231CSD0088</a>
                    <a href="index.php">CLASS - 4CSD02</a>
                </div>
                
                <div class="footer-section">
                    <h3>Team Member 2 :</h3>
                    <p>SANIA M MEHEK</p>
                    <a href="index.php">20231CSD0090</a>
                    <a href="index.php">CLASS - 4CSD02</a>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; CSE3156 [DBMS] - Flight Management System </p>
            </div>
        </div>
    </footer>
</body>
</html>