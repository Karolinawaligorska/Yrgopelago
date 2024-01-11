<?php
require "booking.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yrgopelago</title>
</head>

<body>
    <form method="post">
        <label for="check-in">Check-in Date:</label>
        <input type="date" name="check_in_date" required min="2024-01-01" max="2024-01-31" />
        <br />
        <label for="check-out">Check-out Date:</label>
        <input type="date" name="check_out_date" required min="2024-01-01" max="2024-01-31" />
        <br />
        <label for="room-type">Room Type:</label>
        <select name="room_type" required>
            <option value="Standard">Standard</option>
            <option value="Luxury">Luxury</option>
            <option value="Awesome">Awesome</option>
        </select>
        <br />
        <label for="transfer-code">Transfer code: </label>
        <input type="text" name="transfer-code" />
        <br />
        <button type="submit">Submit Booking</button>
    </form>
</body>

</html>

<?php
