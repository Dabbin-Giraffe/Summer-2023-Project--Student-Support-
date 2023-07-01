<?php

include_once "connect.php";
include "student.php";

$user = new Student("lorem@ipsum.com",$conn);

$json_arr = $user->jsonEncoder($user->subjectName);

echo $json_arr;