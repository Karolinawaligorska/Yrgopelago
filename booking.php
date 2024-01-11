<?php

declare(strict_types=1);

//set up database connection
$dataBase = new PDO('sqlite:Yrgopelagooriginal.sqlite');

// Variabels for check in/out dates
$checkIn = $_POST['check_in_date'];
$checkOut = $_POST['check_out_date'];

//Booking details that will become json response
$bookingDetails = [
    "Island" => "Tea cup island",
    "Hotel" => "Roibos Cozy Cottage",
    "Arrival Date" => $checkIn,
    "Departure Date" => $checkOut,
    "Stars" => 1
];

//json encode booking details 
$bookingDetailsJson = json_encode($bookingDetails);

//room types 
$roomType = $_POST['room_type'];

//room ids
$roomTypeIds = [

    "Standard" => 1,
    "Luxury" => 2,
    "Awesome" => 3
];

$roomId = $roomTypeIds[$roomType];

//base URL for yrgopelago bank
$baseUrl = "https://www.yrgopelag.se/centralbank";


if (isset($checkIn) && isset($checkOut)) {
    // check for avaliabilty
    $statementAvailabilty = $dataBase->prepare("SELECT COUNT(*) FROM occupancy 
    WHERE room_id =:room_id

    /* check occupancy*/
    AND NOT (check_out_date <= :check_in_date OR check_in_date >= :check_out_date)
    ");

    // bind params
    $statementAvailabilty->bindParam(':room_id', $roomId, PDO::PARAM_INT);
    $statementAvailabilty->bindParam(':check_in_date', $checkIn, PDO::PARAM_STR);
    $statementAvailabilty->bindParam(':check_out_date', $checkOut, PDO::PARAM_STR);

    $statementAvailabilty->execute();
    $occupied = $statementAvailabilty->fetchColumn();

    if ($occupied > 0) {
        echo "Unforuntaly the hotel is booked during these dates";
    } else {
        $statementBooking = $dataBase->prepare("INSERT INTO occupancy(room_id, check_in_date, check_out_date)VALUES (:room_id, :check_in_date, :check_out_date)");
        //bind params
        $statementBooking->bindParam(':room_id', $roomId, PDO::PARAM_INT);
        $statementBooking->bindParam(':check_in_date', $checkIn, PDO::PARAM_STR);
        $statementBooking->bindParam(':check_out_date', $checkOut, PDO::PARAM_STR);
        $statementBooking->execute();

        //calculate total cost for visit
        $bookedDays = strtotime($checkOut) - strtotime($checkIn);
        //change time seconds to days/24 hours, add one day for the checkout day as well
        $bookedDays = $bookedDays / (60 * 60 * 24) + 1;
        $totalCost = ($bookedDays * $roomId);
        /* echo "Sucessfull booking! The total cost for your stay is $totalCost !";*/

        //check if transfercode is valid 
        //create own endpoint for checking transfercode
        $transfercodeEndpoint = "/transferCode";
        $transfercodeURL = $baseUrl .  $transfercodeEndpoint;

        $transferCode = $_POST['transfer-code'];

        //inputs
        $transferInputs = [
            'transferCode' => $transferCode,
            'totalcost' => $totalCost,
        ];

        // initialize curl
        $ch = curl_init($transfercodeURL);

        // Set options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $transferInputs);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $transferData = curl_exec($ch);
        // check for errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);


        //deposit

        $depositURL = $baseUrl . '/deposit';

        // Inputs
        $depositInputs = [
            'user' => 'Karolina',
            'transferCode' => $transferCode
        ];

        // Initialize curl
        $ch = curl_init($depositURL);

        // Set options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $depositInputs);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $depositData = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }


        curl_close($ch);


        // Decode json response
        $responseArray = json_decode($data, true);
    }
}


/*
clear database
$statementClear = $dataBase->prepare("DELETE FROM occupancy");
$statementClear->execute();
*/