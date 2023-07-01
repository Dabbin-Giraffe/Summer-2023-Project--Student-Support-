<?php

class Faculty{
    private $email;
    private $password;

    public $name;
    public $subject;

    public function verify($email,$password,$conn){
        $stmt = $conn->prepare("SELECT * from FACULTY WHERE email=?");
        $stmt->bind_param("s",)
    }
}