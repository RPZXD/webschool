<?php
// controllers/ScheduleController.php
// Manages public access and view loading for class schedules

class ScheduleController {
    /**
     * Renders public Student Class Schedule page
     */
    public function student() {
        $scheduleType = 'student';
        $scheduleUrl = defined('STUDENT_SCHEDULE_LINK') ? STUDENT_SCHEDULE_LINK : '';
        $embedUrl = $this->getGoogleDriveEmbedUrl($scheduleUrl);
        $title = __('info_schedule_student') . " | " . SCHOOL_NAME;

        // Render views
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/schedule.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Renders public Teacher Class Schedule page
     */
    public function teacher() {
        $scheduleType = 'teacher';
        $scheduleUrl = defined('TEACHER_SCHEDULE_LINK') ? TEACHER_SCHEDULE_LINK : '';
        $embedUrl = $this->getGoogleDriveEmbedUrl($scheduleUrl);
        $title = __('info_schedule_teacher') . " | " . SCHOOL_NAME;

        // Instantiate TeacherSchedule model
        $scheduleModel = new TeacherSchedule();
        $departments = $scheduleModel->getDepartments();
        $teachersGrouped = $scheduleModel->getAllTeachersGroupedByDepartment();

        // Get filter inputs
        $selectedTeacherId = isset($_GET['teacher_id']) ? trim($_GET['teacher_id']) : '';
        $selectedDept = isset($_GET['dept']) ? trim($_GET['dept']) : '';
        $viewMode = isset($_GET['view_mode']) ? trim($_GET['view_mode']) : 'interactive';

        $selectedTeacherName = '';
        $scheduleGrid = [];
        $rawSchedule = [];

        $days = ['จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์'];
        $periods = [1, 2, 3, 4, 5, 6, 7, 8];

        if (!empty($selectedTeacherId)) {
            $selectedTeacherName = $scheduleModel->getTeacherName($selectedTeacherId);
            $rawSchedule = $scheduleModel->getTeacherSchedule($selectedTeacherId);

            // Initialize empty weekly schedule grid
            foreach ($days as $day) {
                foreach ($periods as $p) {
                    $scheduleGrid[$day][$p] = null;
                }
            }

            // Populate the weekly schedule grid
            foreach ($rawSchedule as $class) {
                $day = trim($class['day_of_week']);
                $pStart = intval($class['period_start']);
                $pEnd = intval($class['period_end']);

                if (!in_array($day, $days)) {
                    continue;
                }

                // Standardize periods within 1 to 8 range
                $pStart = max(1, min(8, $pStart));
                $pEnd = max(1, min(8, $pEnd));

                $span = $pEnd - $pStart + 1;
                if ($span < 1) $span = 1;

                if (isset($scheduleGrid[$day]) && array_key_exists($pStart, $scheduleGrid[$day])) {
                    // If slot is occupied by a simpler record, or empty, set it
                    if ($scheduleGrid[$day][$pStart] === null || $scheduleGrid[$day][$pStart] === 'occupied') {
                        $scheduleGrid[$day][$pStart] = [
                            'class' => $class,
                            'span' => $span
                        ];

                        // Mark subsequent spanned cells as occupied
                        for ($i = $pStart + 1; $i <= $pEnd; $i++) {
                            if (isset($scheduleGrid[$day]) && array_key_exists($i, $scheduleGrid[$day])) {
                                $scheduleGrid[$day][$i] = 'occupied';
                            }
                        }
                    }
                }
            }
        }

        // Render views
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/schedule.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Parse standard sharing links and turn them into iframe preview links
     */
    private function getGoogleDriveEmbedUrl($url) {
        $url = trim($url);
        
        // Match Google Drive folder pattern
        if (preg_match('/\/folders\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return "https://drive.google.com/embeddedfolderview?id=" . $matches[1] . "#grid";
        }
        
        // Match pattern: drive.google.com/file/d/(ID)/...
        if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return "https://drive.google.com/file/d/" . $matches[1] . "/preview";
        }
        // Match pattern: drive.google.com/open?id=(ID)
        if (preg_match('/id=([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return "https://drive.google.com/file/d/" . $matches[1] . "/preview";
        }
        return $url;
    }
}
