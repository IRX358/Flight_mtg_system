<!DOCTYPE html>
<html>
<head>
    <title>Process Payment</title>
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
    <h1>Process Payment</h1>
    
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
        
        // Get booking amount
        $booking_id = $_POST['booking_id'];
        $sql = "SELECT f.price FROM booking b JOIN flight f ON b.flight_id = f.flight_id WHERE b.booking_id = $booking_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $amount = $row['price'];
            
            // Insert payment
            $stmt = $conn->prepare("INSERT INTO payment (booking_id, amount, payment_method, payment_status) VALUES (?, ?, ?, 'Success')");
            $stmt->bind_param("ids", $_POST['booking_id'], $amount, $_POST['payment_method']);
            
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Payment processed successfully! Payment ID: " . $stmt->insert_id . "</p>";
                
                // Update booking status
                $conn->query("UPDATE booking SET status = 'Confirmed' WHERE booking_id = $booking_id");
            } else {
                echo "<p style='color:red;'>Error processing payment: " . $conn->error . "</p>";
            }
        } else {
            echo "<p style='color:red;'>Booking not found</p>";
        }
        
        $conn->close();
    }
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="booking_id">Booking ID:</label>
        <input type="number" id="booking_id" name="booking_id" required>
        
        <label for="payment_method">Payment Method:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="">Select Payment Method</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Debit Card">Debit Card</option>
            <option value="PayPal">PayPal</option>
            <option value="Bank Transfer">Bank Transfer</option>
        </select>
        
        <button type="submit">Process Payment</button>
    </form>
</body>
</html>