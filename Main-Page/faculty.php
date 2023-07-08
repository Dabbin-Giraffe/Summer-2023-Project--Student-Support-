<?php

class Faculty
{
    public $email;
    private $password;
    public $id;
    public $conn;
    public $firstName;
    public $lastName;
    public $years;
    public $flags;
    public $subjectCount;
    public $subjectCode;
    public $subjectName;
    public $minimumRequired;
    public $maxClasses;

    function __construct($email, $conn)
    {
        $this->email = $email;
        $this->id = strtoupper(explode("@", $email)[0]);
        $this->conn = $conn;

        $stmt = ($this->conn)->prepare("SELECT u.firstName,u.lastName FROM user u WHERE u.email = ? AND u.isStudent = 0");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->bind_result($this->firstName, $this->lastName);
        $stmt->fetch();
        $stmt->close();

        $this->getRoledetails();
        $this->getSubjectdetails();
    }

    private function getRoledetails()
    {
        $flag = 0;
        $year = 0;

        $stmt = ($this->conn)->prepare("SELECT f.flag, m.role FROM faculty f JOIN flag m ON f.flag = m.flag WHERE f.userID = ? GROUP BY f.flag");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $stmt->bind_result($flag, $year);

        while ($stmt->fetch()) {
            $this->flags[] = $flag;
            $this->years[] = $year;
        }
        $stmt->close();
    }

    private function getSubjectdetails()
    {
        $subjectCode = 0;
        $subjectName = 0;
        $minimumRequired = 0;
        $maxClasses = 0;

        for ($i = 0; $i < count($this->flags); $i++) {

            $stmt = ($this->conn)->prepare("SELECT s.subjectCode, s.subjectName,s.maxClasses,s.minRequired FROM subject s JOIN faculty f ON s.subjectCode = f.subjectCode WHERE f.userID = ? AND f.flag = ?");
            $flag = $i + 1;

            $stmt->bind_param("si", $this->id, $flag);
            $stmt->execute();
            $stmt->bind_result($subjectCode, $subjectName, $maxClasses, $minimumRequired);
            while ($stmt->fetch()) {
                $this->subjectCode[$i][] = $subjectCode;
                $this->subjectName[$i][] = $subjectName;
                $this->minimumRequired[$i][] = $minimumRequired;
                $this->maxClasses[$i][] = $maxClasses;
            }
            $stmt->close();

            $this->subjectCount[$i] = count(($this->subjectCode)[$i]);
        }
    }

    //Might need some clarification, There are 4 2d arrays, first indices are their (flags-1) basically which years they teach and secondary
    // indices are the subject indices normal stuff.

    public function getUserdetails()
    {
        $details = [
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "id" => $this->id,
            "subjectCount" => $this->subjectCount,
            "minRequired" => $this->minimumRequired,
            "maxClasses" => $this->maxClasses,
            "subjectCode" => $this->subjectCode,
            "subjectName" => $this->subjectName,
            "years" => $this->years,
            "flags" => $this->flags
        ];
        return $details;
    }
    public function jsonEncoder($arr)
    {
        return json_encode($arr);
    }
}
