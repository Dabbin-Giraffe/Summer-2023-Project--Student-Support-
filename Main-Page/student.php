<?php
// include_once "D:\Summer Project - Student Support\Main-Page\connect.php";


class Student
{
    public $email;
    public $id;
    public $semesterCount;
    public $semester;
    public $firstName;
    public $lastName;
    public $flag;
    public $year;
    public $subjectCode;
    public $subjectName;
    public $minimumRequired;
    public $maxClasses;

    private $conn;


    function __construct($email, $conn)
    {
        $this->email = $email;
        $this->id = strtoupper(explode("@", $email)[0]);
        $this->conn = $conn;

        $this->getStudentdetails();
        $this->getSemesterdetails();
        $this->getSubjectdetails();
    }
    private function getStudentdetails()
    {
        $stmt = ($this->conn)->prepare("SELECT u.firstName,u.lastName,u.flag,f.role FROM user u JOIN flag f ON u.flag = f.flag WHERE u.email = ?");
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->bind_result($this->firstName, $this->lastName, $this->flag, $this->year);
        $stmt->fetch();
    }
    // Sets number of unique semesters present for specified flag
    private function getSemesterdetails()
    {
        $stmt = ($this->conn)->prepare("SELECT COUNT(DISTINCT semester) AS semester_count FROM subject WHERE flag = ?");
        $stmt->bind_param("i", $this->flag);
        $stmt->execute();
        $stmt->bind_result($this->semesterCount);
        $stmt->fetch();
        $stmt->close();
    }
    private function getSubjectdetails()
    {
        // gets the subjects and subject codes along with minimum required attendence and maximum classes planned for specified semester, uses global flag
        for ($i = 1; $i <= $this->semesterCount; $i++) {
            $stmt = ($this->conn)->prepare("SELECT subjectCode,subjectName,minRequired,maxClasses FROM subject WHERE FLAG = ? AND SEMESTER = ?");
            $stmt->bind_param("ii", $this->flag, $i);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $this->subjectCode[$i - 1][] = $row['subjectCode'];
                $this->subjectName[$i - 1][] = $row['subjectName'];
                $this->minimumRequired[$i - 1][] = $row['minRequired'];
                $this->maxClasses[$i - 1][] = $row['maxClasses'];
            }
            $stmt->close();
        }
    }
    public function jsonEncoder($arr)
    {
        return json_encode($arr);
    }
}
