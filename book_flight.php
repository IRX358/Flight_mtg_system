<!DOCTYPE html>
<html>
<head>
    <title>Book a Flight</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <h1>Book a Flight</h1>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "flight_mtg03";
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Insert passenger
        $stmt = $conn->prepare("INSERT INTO passenger (name, email, phone, passport_number) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['passport']);
        
        if ($stmt->execute()) {
            $passenger_id = $stmt->insert_id;
            
            // Insert booking
            $stmt = $conn->prepare("INSERT INTO booking (passenger_id, flight_id, seat_number) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $passenger_id, $_POST['flight_id'], $_POST['seat_number']);
            
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Booking successful! Passenger ID: $passenger_id, Booking ID: " . $stmt->insert_id . "</p>";
            } else {
                echo "<p style='color:red;'>Error creating booking: " . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color:red;'>Error creating passenger: " . $conn->error . "</p>";
        }
        
        $conn->close();
    }
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h3>Passenger Details</h3>
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>
        
        <label for="passport">Passport Number:</label>
        <input type="text" id="passport" name="passport" required>
        
        <h3>Flight Details</h3>
        <label for="flight_id">Flight ID:</label>
        <input type="number" id="flight_id" name="flight_id" required>
        
        <label for="seat_number">Seat Number:</label>
        <input type="text" id="seat_number" name="seat_number" required>
        
        <button type="submit">Book Flight</button>
    </form>
</body>
</html>