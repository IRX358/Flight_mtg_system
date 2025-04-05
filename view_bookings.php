<!DOCTYPE html>
<html>
<head>
    <title>View All Bookings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>All Bookings</h1>
    
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
    
    $sql = "SELECT b.booking_id, p.name AS passenger_name, p.email, p.phone,
                   f.flight_number, f.airline, 
                   a1.name AS departure_airport, a2.name AS arrival_airport,
                   f.departure_time, b.seat_number, b.status,
                   py.amount, py.payment_method, py.payment_status
            FROM booking b
            JOIN passenger p ON b.passenger_id = p.passenger_id
            JOIN flight f ON b.flight_id = f.flight_id
            JOIN airport a1 ON f.departure_airport_id = a1.airport_id
            JOIN airport a2 ON f.arrival_airport_id = a2.airport_id
            LEFT JOIN payment py ON b.booking_id = py.booking_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Booking ID</th>
                    <th>Passenger</th>
                    <th>Contact</th>
                    <th>Flight</th>
                    <th>Route</th>
                    <th>Departure</th>
                    <th>Seat</th>
                    <th>Status</th>
                    <th>Payment</th>
                </tr>";
        
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row["booking_id"]."</td>
                    <td>".$row["passenger_name"]."<br>".$row["email"]."<br>".$row["phone"]."</td>
                    <td>".$row["email"]."<br>".$row["phone"]."</td>
                    <td>".$row["airline"]." ".$row["flight_number"]."</td>
                    <td>".$row["departure_airport"]." to ".$row["arrival_airport"]."</td>
                    <td>".$row["departure_time"]."</td>
                    <td>".$row["seat_number"]."</td>
                    <td>".$row["status"]."</td>
                    <td>".($row["amount"] ? "₹".$row["amount"]." (".$row["payment_method"]." - ".$row["payment_status"].")" : "Pending")."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No bookings found";
    }
    $conn->close();
    ?>
</body>
</html>