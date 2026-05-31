<?php
// controllers/JournalController.php

class JournalController {
    private $pdo;
    private $pdoUsers;

    public function __construct() {
        try {
            // เชื่อมต่อฐานข้อมูล General และ Student ผ่าน Database class
            $this->pdo = Database::connect('phichaia_general');
            $this->pdoUsers = Database::connect('phichaia_student');
        } catch (Exception $e) {
            error_log("JournalController DB Error: " . $e->getMessage());
            $this->pdo = null;
            $this->pdoUsers = null;
        }
    }

    public function index() {
        $journals = [];
        $stats = ['total' => 0, 'this_month' => 0, 'total_views' => 0, 'this_year' => 0];

        if ($this->pdo) {
            try {
                $stmt = $this->pdo->prepare("SELECT *, COALESCE(view_count, 0) as view_count FROM newsletters ORDER BY news_date DESC, id DESC LIMIT 200");
                $stmt->execute();
                $journals = $stmt->fetchAll();

                $now = new DateTime();
                foreach ($journals as &$item) {
                    $item['teacher_name'] = $this->getTeacherName($item['create_by'] ?? null);
                    
                    // คำนวณ Stats
                    $stats['total']++;
                    $stats['total_views'] += (int)$item['view_count'];
                    $date = new DateTime($item['news_date'] ?? $item['created_at'] ?? 'now');
                    if ($date->format('Y-m') === $now->format('Y-m')) $stats['this_month']++;
                    if ($date->format('Y') === $now->format('Y')) $stats['this_year']++;
                }
                unset($item);
            } catch (PDOException $e) {
                error_log("JournalController::index Error: " . $e->getMessage());
            }
        }

        $title = __('school_journal') . " | " . SCHOOL_NAME;
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/journal.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    public function detail() {
        $id = (int)($_GET['id'] ?? 0);
        if (!$id || !$this->pdo) {
            header('Location: ' . BASE_URL . 'journal');
            exit();
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM newsletters WHERE id = ?");
            $stmt->execute([$id]);
            $journal = $stmt->fetch();

            if (!$journal) {
                header('Location: ' . BASE_URL . 'journal');
                exit();
            }

            // เพิ่มยอดวิว
            $this->pdo->prepare("UPDATE newsletters SET view_count = COALESCE(view_count, 0) + 1 WHERE id = ?")->execute([$id]);

            // จัดการเรื่องรูปภาพ
            $images = [];
            if (!empty($journal['images'])) {
                $decoded = json_decode($journal['images'], true);
                if (is_array($decoded)) {
                    $baseUrl = rtrim(GENERAL_ASSETS_URL, '/');
                    foreach ($decoded as $img) {
                        if (strpos($img, 'http') === 0) {
                            $images[] = $img;
                        } else {
                            // ลบโฟลเดอร์ที่อาจจะติดมาใน DB ออกให้หมด
                            $fileName = str_replace(['uploads/newsletter/', 'uploads/newsletters/'], '', $img);
                            $fileName = ltrim($fileName, '/');
                            $images[] = $baseUrl . '/uploads/newsletter/' . $fileName;
                        }
                    }
                }
            }

            $journal['full_image_urls'] = $images;
            $journal['teacher_name'] = $this->getTeacherName($journal['create_by'] ?? null);

            // ข่าวที่เกี่ยวข้อง
            $relatedStmt = $this->pdo->prepare("SELECT *, COALESCE(view_count, 0) as view_count FROM newsletters WHERE id != ? ORDER BY news_date DESC LIMIT 4");
            $relatedStmt->execute([$id]);
            $relatedJournals = $relatedStmt->fetchAll();
            foreach ($relatedJournals as &$rj) {
                $rj['teacher_name'] = $this->getTeacherName($rj['create_by'] ?? null);
            }
            unset($rj);

        } catch (PDOException $e) {
            error_log("JournalController::detail Error: " . $e->getMessage());
            header('Location: ' . BASE_URL . 'journal');
            exit();
        }

        $title = ($journal['title'] ?? __('school_journal')) . " | " . SCHOOL_NAME;
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/journal_detail.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    private function getTeacherName($teachId) {
        if (empty($teachId) || !$this->pdoUsers) return null;
        try {
            $stmt = $this->pdoUsers->prepare("SELECT Teach_name FROM teacher WHERE Teach_id = ?");
            $stmt->execute([$teachId]);
            return $stmt->fetch()['Teach_name'] ?? null;
        } catch (PDOException $e) { return null; }
    }
}