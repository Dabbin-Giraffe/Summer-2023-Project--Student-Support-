<?php

include "student.php";

class Faculty extends Student
{
    public $semesterCount;

    function __construct($email, $conn)
    {
        $this->email = $email;
        $this->id = strtoupper(explode("@", $email)[0]);
        $this->conn = $conn;

        $this->getUserdetails();
    }

    private function getDesignation(){
        $stmt = ($this->conn)->prepare();
        $stmt->bind_param();
    }

    private function getYears(){
        
    }

    public function returnUserdetails(){
        $details = [
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "id" => $this->id,
            "semesterCount" => $this->semesterCount
        ];
        return $details;
    }
}
