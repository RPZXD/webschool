<?php
// models/Student.php
// Manages student and teacher rosters in phichaia_student database

class Student {
    private $db;

    public function __construct() {
        $this->db = self::connect();
    }

    /**
     * Establishes a PDO connection to the phichaia_student database
     * supporting environment configurations and XAMPP local fallbacks.
     */
    public static function connect() {
        try {
            return Database::connect('phichaia_student');
        } catch (PDOException $e) {
            error_log("Student Database Connection Error: " . $e->getMessage());
            throw new Exception("Student Database Connection Error: " . $e->getMessage());
        }
    }

    /**
     * Retrieve active class levels and rooms to populate dropdown filters dynamically
     */
    public function getActiveGroups() {
        try {
            $sql = "SELECT DISTINCT Stu_major, Stu_room 
                    FROM student 
                    WHERE Stu_status = '1' 
                      AND Stu_major IS NOT NULL AND Stu_major != ''
                      AND Stu_room IS NOT NULL AND Stu_room != ''
                    ORDER BY CAST(Stu_major AS UNSIGNED) ASC, CAST(Stu_room AS UNSIGNED) ASC";
            
            $stmt = $this->db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Student::getActiveGroups query error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch student roster for specific class level and room
     */
    public function getStudents($class, $room) {
        try {
            $sql = "SELECT Stu_no, Stu_id, Stu_pre, Stu_name, Stu_sur, Stu_picture 
                    FROM student 
                    WHERE Stu_major = :class 
                      AND Stu_room = :room 
                      AND Stu_status = '1'
                    ORDER BY CAST(Stu_no AS UNSIGNED) ASC, Stu_id ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['class' => $class, 'room' => $room]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Student::getStudents query error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch advisors/teachers assigned to the class level and room
     */
    public function getAdvisors($class, $room) {
        try {
            $sql = "SELECT Teach_id, Teach_name, Teach_photo 
                    FROM teacher 
                    WHERE Teach_class = :class 
                      AND Teach_room = :room 
                      AND Teach_status = '1'
                    ORDER BY Teach_name ASC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['class' => $class, 'room' => $room]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Student::getAdvisors query error: " . $e->getMessage());
            return [];
        }
    }
}
