<?php
//set the time zone and get the current hour
date_default_timezone_set("Australia/Hobart");

$current_Hour = date("H"); //get the hour
$greeting = '';
$greetingStart = '';

//set message according to the current hour
if ($current_Hour >= 5 && $current_Hour < 12) {
    $greetingStart = "Good Morning!";
    $greeting = "Ready to dive into the ocean's mysteries?";
} elseif ($current_Hour >= 12 && $current_Hour < 17) {
    $greetingStart = "Good Afternoon!";
    $greeting = "The afternoon knows what the morning <br>never suspected!";
} elseif ($current_Hour >= 17 && $current_Hour < 23) {
    $greetingStart = "Good Evening!";
    $greeting = "This is an evening of wonders, indeed!";
} else {
    $greetingStart = "Night!";
    $greeting = "The ocean whispers tales of the deep!";
}

if (isset($_SESSION['username'])) {
    $messageToDisplayToUser = '<p class="user-greeting">' . $greetingStart . '<br>' . 'Welcome Back  ' . $_SESSION['username']
        . ' &#127754 <br><br>' . $greeting . '<br>' . '</p>';
} else {
    $messageToDisplayToUser = ''; //empty if visitor
    $logoutOption = ''; //empty if visitor
}
?>