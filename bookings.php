<?php

declare(strict_types=1);
require "availability.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yrgopelago</title>
    <link rel="stylesheet" href="booking.css">
</head>

<body>
    <h1>Availability Calendars for January 2024, red marks occupied</h1>

    <?php

    // create calendars that check avaliablity
    function getAvailabilityCalendar($roomid)
    {

        $month = 1;  // January
        $year = 2024;

        $firstDay = mktime(0, 0, 0, $month, 1, $year);
        $daysInMonth = date('t', $firstDay);
        $dayOfWeek = date('N', $firstDay);


        echo '<table border="1">
            <thead>
                <tr>
                    <th>Mon</th>
                    <th>Tue</th>
                    <th>Wed</th>
                    <th>Thu</th>
                    <th>Fri</th>
                    <th>Sat</th>
                    <th>Sun</th>
                </tr>
            </thead>
            <tbody>';


        $day = 1;
        $week = 1;

        // Loop through each day of the month
        while ($day <= $daysInMonth) {
            echo '<tr>';

            // Loop through each day of the week
            for ($i = 1; $i <= 7; $i++) {
                // Check if the current day is in the month
                if (($day <= $daysInMonth) && ($week == 1 && $i >= $dayOfWeek || $week > 1)) {

                    // 
                    $date = date('Y-m-d', strtotime("2024-01-$day"));
                    if (roomIsOccupied($roomid, $date)) {
                        $css_class = 'occupied';
                    } else {
                        $css_class = '';
                    }

                    echo '<td class="' . $css_class . '">' . $day;
                    echo '</td>';

                    $day++;
                } else {
                    echo '<td></td>';
                }
            }

            echo '</tr>';
            $week++;
        }

        echo '</tbody></table>';
    }

    function roomIsOccupied($roomid, $date)
    {
        $dataBase = new PDO('sqlite:Yrgopelagooriginal.sqlite');
        $statementCalendar = $dataBase->prepare("SELECT COUNT (*) FROM occupancy 
        WHERE room_id=:room_id
        AND check_in_date <= :date
        AND :date <= check_out_date");

        $statementCalendar->bindParam(':room_id', $roomid, PDO::PARAM_INT);
        $statementCalendar->bindParam(':date', $date);
        $statementCalendar->execute();
        $count = $statementCalendar->fetchColumn();
        return ($count > 0);
    }

    ?>
    <div class="calendars">

        <div class="calendar-individual">
            <h3>Budget Brew Haven (2$ / night)</h3>
            <?php getAvailabilityCalendar(1);  ?>
        </div>

        <div class="calendar-individual">
            <h3>Standard Steep Suite (4$ / night)</h3>
            <?php getAvailabilityCalendar(2);  ?>
        </div>

        <div class="calendar-individual">
            <h3>Luxury Infusion Palace (6$ / night)</h3>
            <?php getAvailabilityCalendar(3);  ?>
        </div>


    </div>

    <div class="booking_form">
        <h2>Book a room by submitting the form</h2>
        <form method="post">
            <label for="name">First Name</label>
            <input type="text" name="name" required>
            <br />
            <label for="check-in">Check-in Date:</label>
            <input type="date" name="check_in_date" required min="2024-01-01" max="2024-01-31" required />
            <br />
            <label for="check-out">Check-out Date:</label>
            <input type="date" name="check_out_date" required min="2024-01-01" max="2024-01-31" required />
            <br />
            <label for="room-type">Room Type:</label>
            <select name="room_type" required>
                <option value="Standard">Budget Brew Haven</option>
                <option value="Luxury">Standard Steep Suite</option>
                <option value="Awesome">Luxury Infusion Palace</option>
            </select>
            <br />
            <label for="transfer-code">Transfer code: </label>
            <input type="text" name="transfer-code" required />
            <br />
            <button type="submit">Submit Booking</button>
        </form>
    </div>
</body>