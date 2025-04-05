<!DOCTYPE html>
<html>
<head>
    <title>View All Flights</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Available Flights</h1>
    
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
    
    $sql = "SELECT f.flight_id, f.flight_number, f.airline, 
                   a1.name AS departure_airport, a1.code AS departure_code,
                   a2.name AS arrival_airport, a2.code AS arrival_code,
                   f.departure_time, f.arrival_time, f.available_seats, f.price
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
                    <th>Available Seats</th>
                    <th>Price (₹)</th>
                </tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["flight_id"]."</td>
                    <td>".$row["flight_number"]."</td>
                    <td>".$row["airline"]."</td>
                    <td>".$row["departure_airport"]." (".$row["departure_code"].")</td>
                    <td>".$row["arrival_airport"]." (".$row["arrival_code"].")</td>
                    <td>".$row["departure_time"]."</td>
                    <td>".$row["arrival_time"]."</td>
                    <td>".$row["available_seats"]."</td>
                    <td>".$row["price"]."</td>
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