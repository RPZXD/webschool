<?php
// models/TeacherSchedule.php
// Manages teacher schedules and details from phichaia_cktech and phichaia_student databases

class TeacherSchedule {
    private $db;

    public function __construct() {
        // Connect directly to the CKTech database where the subjects/schedules reside
        $this->db = Database::connect('phichaia_cktech');
    }

    /**
     * Fetch all distinct departments from phichaia_student.teacher that have active subjects
     * @return array
     */
    public function getDepartments() {
        try {
            $stmt = $this->db->query("
                SELECT DISTINCT TRIM(t.Teach_major) as dept
                FROM phichaia_student.teacher t
                JOIN phichaia_cktech.tb_subject ts ON t.Teach_id = ts.Teach_id
                WHERE t.Teach_major IS NOT NULL AND t.Teach_major != ''
                ORDER BY dept ASC
            ");
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            error_log("Error in getDepartments: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Retrieve all teachers grouped by their department with resolved names from phichaia_student.teacher
     * @return array
     */
    public function getAllTeachersGroupedByDepartment() {
        try {
            $stmt = $this->db->query("
                SELECT DISTINCT t.Teach_id as id, t.Teach_name as name, TRIM(t.Teach_major) as department
                FROM phichaia_student.teacher t
                JOIN phichaia_cktech.tb_subject ts ON t.Teach_id = ts.Teach_id
                WHERE t.Teach_name IS NOT NULL AND t.Teach_name != '' AND t.Teach_major IS NOT NULL AND t.Teach_major != ''
                ORDER BY department ASC, name ASC
            ");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $grouped = [];
            foreach ($rows as $row) {
                $id = $row['id'];
                $dept = $row['department'];
                $name = $row['name'];

                if (!isset($grouped[$dept])) {
                    $grouped[$dept] = [];
                }
                
                $grouped[$dept][] = [
                    'id' => $id,
                    'name' => $name
                ];
            }

            return $grouped;
        } catch (PDOException $e) {
            error_log("Error in getAllTeachersGroupedByDepartment: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get the weekly class schedule for a specific teacher
     * Filters specifically for phichaia_cktech.tb_subject.table_status = 1
     * @param string $teachId
     * @return array
     */
    public function getTeacherSchedule($teachId) {
        try {
            // Joined with phichaia_cktech.tb_subject to restrict output to table_status = 1
            $sql = "
                SELECT sc.id, sc.day_of_week, sc.period_start, sc.period_end, sc.class_room,
                       s.code, s.name AS subject_name, s.level, s.subject_type
                FROM subject_classes sc
                JOIN subjects s ON sc.subject_id = s.id
                LEFT JOIN phichaia_cktech.tb_subject ts ON s.code = ts.sub_id AND s.created_by = ts.Teach_id
                WHERE s.created_by = :teach_id 
                  AND s.status = 'เปิดสอน'
                  AND (ts.table_status = 1 OR ts.table_status IS NULL)
                ORDER BY FIELD(sc.day_of_week, 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์'), sc.period_start
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':teach_id' => $teachId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getTeacherSchedule for teacher '$teachId': " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get teacher name from teacher ID
     * @param string $teachId
     * @return string
     */
    public function getTeacherName($teachId) {
        try {
            $stmt = $this->db->prepare("
                SELECT Teach_name
                FROM phichaia_student.teacher
                WHERE Teach_id = :tid
                LIMIT 1
            ");
            $stmt->execute([':tid' => $teachId]);
            $name = $stmt->fetchColumn();
            return $name ?: "ครูรหัส " . $teachId;
        } catch (PDOException $e) {
            error_log("Error in getTeacherName for teacher '$teachId': " . $e->getMessage());
            return "ครูรหัส " . $teachId;
        }
    }
}