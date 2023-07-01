<?php

const SERVER_NAME = "localhost";
const USER = "root";
const PASSWORD = "";
const DATABASE = "studentsupport";

$conn = new mysqli(SERVER_NAME, USER, PASSWORD, DATABASE);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
    // echo "suc";
}
