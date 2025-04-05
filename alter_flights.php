<!DOCTYPE html>
<html>
<head>
    <title>Manage Flights</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; margin-bottom: 30px; }
        label { display: block; margin-top: 10px; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 15px; color: white; border: none; cursor: pointer; }
        .search-btn { background: #2196F3; }
        .search-btn:hover { background: #0b7dda; }
        .update-btn { background: #4CAF50; }
        .update-btn:hover { background: #45a049; }
        .delete-btn { background: #f44336; }
        .delete-btn:hover { background: #da190b; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Manage Flights</h1>
    
    <?php
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
    
    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['search'])) {
            // Search for flight
            $flight_id = $_POST['flight_id'];
            $flight_number = $_POST['flight_number'];
            
            $sql = "SELECT * FROM flight WHERE flight_id = ? OR flight_number = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $flight_id, $flight_number);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $flight = $result->fetch_assoc();
            } else {
                echo "<p style='color:red;'>Flight not found</p>";
            }
        } elseif (isset($_POST['update'])) {
            // Update flight
            $flight_id = $_POST['flight_id'];
            $flight_number = $_POST['flight_number'];
            $airline = $_POST['airline'];
            $departure_airport_id = $_POST['departure_airport_id'];
            $arrival_airport_id = $_POST['arrival_airport_id'];
            $departure_time = $_POST['departure_time'];
            $arrival_time = $_POST['arrival_time'];
            $available_seats = $_POST['available_seats'];
            $price = $_POST['price'];
            
            $sql = "UPDATE flight SET 
                    flight_number = ?,
                    airline = ?,
                    departure_airport_id = ?,
                    arrival_airport_id = ?,
                    departure_time = ?,
                    arrival_time = ?,
                    available_seats = ?,
                    price = ?
                    WHERE flight_id = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiissidi", 
                $flight_number, $airline, $departure_airport_id, $arrival_airport_id,
                $departure_time, $arrival_time, $available_seats, $price, $flight_id);
            
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Flight updated successfully</p>";
            } else {
                echo "<p style='color:red;'>Error updating flight: " . $conn->error . "</p>";
            }
        } elseif (isset($_POST['delete'])) {
            // Delete flight
            $flight_id = $_POST['flight_id'];
            
            $sql = "DELETE FROM flight WHERE flight_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $flight_id);
            
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Flight deleted successfully</p>";
            } else {
                echo "<p style='color:red;'>Error deleting flight: " . $conn->error . "</p>";
            }
        }
    }
    ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h3>Search Flight</h3>
        <label for="flight_id">Flight ID:</label>
        <input type="number" id="flight_id" name="flight_id">
        
        <label for="flight_number">OR Flight Number:</label>
        <input type="text" id="flight_number" name="flight_number">
        
        <button type="submit" name="search" class="search-btn">Search Flight</button>
    </form>
    
    <?php if (isset($flight)): ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <h3>Edit Flight</h3>
        <input type="hidden" name="flight_id" value="<?php echo $flight['flight_id']; ?>">
        
        <label for="flight_number">Flight Number:</label>
        <input type="text" id="flight_number" name="flight_number" value="<?php echo $flight['flight_number']; ?>" required>
        
        <label for="airline">Airline:</label>
        <input type="text" id="airline" name="airline" value="<?php echo $flight['airline']; ?>" required>
        
        <label for="departure_airport_id">Departure Airport ID:</label>
        <input type="number" id="departure_airport_id" name="departure_airport_id" value="<?php echo $flight['departure_airport_id']; ?>" required>
        
        <label for="arrival_airport_id">Arrival Airport ID:</label>
        <input type="number" id="arrival_airport_id" name="arrival_airport_id" value="<?php echo $flight['arrival_airport_id']; ?>" required>
        
        <label for="departure_time">Departure Time:</label>
        <input type="datetime-local" id="departure_time" name="departure_time" value="<?php echo str_replace(' ', 'T', $flight['departure_time']); ?>" required>
        
        <label for="arrival_time">Arrival Time:</label>
        <input type="datetime-local" id="arrival_time" name="arrival_time" value="<?php echo str_replace(' ', 'T', $flight['arrival_time']); ?>" required>
        
        <label for="available_seats">Available Seats:</label>
        <input type="number" id="available_seats" name="available_seats" value="<?php echo $flight['available_seats']; ?>" required>
        
        <label for="price">Price (₹):</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo $flight['price']; ?>" required>
        
        <button type="submit" name="update" class="update-btn">Update Flight</button>
        <button type="submit" name="delete" class="delete-btn">Delete Flight</button>
    </form>
    <?php endif; ?>
    
    <h2>All Flights</h2>
    <?php
    $sql = "SELECT f.*, a1.name AS departure_airport, a2.name AS arrival_airport 
            FROM flight f
            JOIN airport a1 ON f.departure_airport_id = a1.airport_id
            JOIN airport a2 ON f.arrival_airport_id = a2.airport_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Flight ID</th>
                    <th>Flight Number</th>
                    <th>Airline</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Seats</th>
                    <th>Price</th>
                </tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["flight_id"]."</td>
                    <td>".$row["flight_number"]."</td>
                    <td>".$row["airline"]."</td>
                    <td>".$row["departure_airport"]."</td>
                    <td>".$row["arrival_airport"]."</td>
                    <td>".$row["departure_time"]."</td>
                    <td>".$row["arrival_time"]."</td>
                    <td>".$row["available_seats"]."</td>
                    <td>₹".$row["price"]."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No flights found";
    }
    $conn->close();
    ?>
</body>
</html>