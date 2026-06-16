<?php
// controllers/HeroController.php
// Manages Hero Carousel slide CRUD (Create, Read, Update, Delete, Toggle Status)

class HeroController {
    private $heroModel;

    public function __construct() {
        $this->heroModel = new Hero();
    }

    /**
     * Creates a new hero slide
     */
    public function create() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $displayOrder = (int)($_POST['display_order'] ?? 0);
            $status = trim($_POST['status'] ?? 'active');

            if ($status !== 'active' && $status !== 'inactive') {
                $status = 'active';
            }

            // Handle file upload for hero image
            $imageUrl = null;
            if (isset($_FILES['slide_image']) && $_FILES['slide_image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->handleImageUpload($_FILES['slide_image']);
                if ($imageUrl === false) {
                    $_SESSION['error'] = 'การอัปโหลดรูปภาพล้มเหลว (กรุณาใช้ไฟล์รูปภาพสกุล .jpg, .png, .webp ขนาดไม่เกิน 5MB)';
                    header('Location: ' . BASE_URL . 'admin?tab=hero');
                    exit();
                }
            } else {
                $_SESSION['error'] = 'กรุณาเลือกไฟล์รูปภาพสำหรับสไลด์';
                header('Location: ' . BASE_URL . 'admin?tab=hero');
                exit();
            }

            $success = $this->heroModel->create([
                'title' => $title,
                'image_url' => $imageUrl,
                'display_order' => $displayOrder,
                'status' => $status
            ]);

            if ($success) {
                $_SESSION['success'] = 'เพิ่มรูปภาพสไลด์ใหม่สำเร็จเรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูลรูปภาพสไลด์';
            }
        }
        header('Location: ' . BASE_URL . 'admin?tab=hero');
        exit();
    }

    /**
     * Updates an existing hero slide
     */
    public function edit() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)($_POST['id'] ?? 0);
            $title = trim($_POST['title'] ?? '');
            $displayOrder = (int)($_POST['display_order'] ?? 0);
            $status = trim($_POST['status'] ?? 'active');

            if ($status !== 'active' && $status !== 'inactive') {
                $status = 'active';
            }

            $slide = $this->heroModel->getById($id);
            if (!$slide) {
                $_SESSION['error'] = 'ไม่พบข้อมูลสไลด์ที่ต้องการแก้ไข';
                header('Location: ' . BASE_URL . 'admin?tab=hero');
                exit();
            }

            $data = [
                'title' => $title,
                'display_order' => $displayOrder,
                'status' => $status
            ];

            // If a new slide image is uploaded, process it
            if (isset($_FILES['slide_image']) && $_FILES['slide_image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->handleImageUpload($_FILES['slide_image']);
                if ($imageUrl !== false) {
                    $data['image_url'] = $imageUrl;
                    // Delete old file if exists and is local
                    if (!empty($slide['image_url']) && strpos($slide['image_url'], UPLOAD_URL) === 0) {
                        $oldPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $slide['image_url']);
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }
                } else {
                    $_SESSION['error'] = 'การอัปโหลดรูปภาพล้มเหลว (กรุณาใช้ไฟล์รูปภาพที่ถูกต้อง)';
                    header('Location: ' . BASE_URL . 'admin?tab=hero');
                    exit();
                }
            }

            $success = $this->heroModel->update($id, $data);
            if ($success) {
                $_SESSION['success'] = 'แก้ไขรูปภาพสไลด์สำเร็จเรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการปรับปรุงข้อมูลรูปภาพสไลด์';
            }
        }
        header('Location: ' . BASE_URL . 'admin?tab=hero');
        exit();
    }

    /**
     * Deletes a hero slide
     */
    public function delete() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $id = (int)($_GET['id'] ?? 0);
        $slide = $this->heroModel->getById($id);

        if ($slide) {
            // Delete physical image from system disk if it's local
            if (!empty($slide['image_url']) && strpos($slide['image_url'], UPLOAD_URL) === 0) {
                $oldPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $slide['image_url']);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $success = $this->heroModel->delete($id);
            if ($success) {
                $_SESSION['success'] = 'ลบรูปภาพสไลด์เสร็จเรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการลบรูปภาพสไลด์';
            }
        } else {
            $_SESSION['error'] = 'ไม่พบข้อมูลรูปภาพสไลด์ที่ต้องการลบ';
        }
        header('Location: ' . BASE_URL . 'admin?tab=hero');
        exit();
    }

    /**
     * Quick status toggle for display/hide status
     */
    public function toggleStatus() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        $id = (int)($_GET['id'] ?? 0);
        $slide = $this->heroModel->getById($id);

        if ($slide) {
            $newStatus = ($slide['status'] === 'active') ? 'inactive' : 'active';
            $success = $this->heroModel->update($id, [
                'title' => $slide['title'],
                'display_order' => $slide['display_order'],
                'status' => $newStatus
            ]);

            if ($success) {
                $_SESSION['success'] = 'เปลี่ยนสถานะการแสดงผลสำเร็จ';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการสลับสถานะ';
            }
        } else {
            $_SESSION['error'] = 'ไม่พบข้อมูลสไลด์';
        }
        header('Location: ' . BASE_URL . 'admin?tab=hero');
        exit();
    }

    /**
     * Core Helper: Handles sanitisation and upload of hero images
     * @param array $file $_FILES element
     * @return string|false relative/absolute public URL of uploaded file
     */
    private function handleImageUpload($file) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension'] ?? '');

        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        // Limit size to 5MB
        if ($file['size'] > 5 * 1024 * 1024) {
            return false;
        }

        // Ensure directories exist
        if (!file_exists(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }

        // Generate secure random filename
        $newFilename = 'hero_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destination = UPLOAD_DIR . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return UPLOAD_URL . $newFilename;
        }

        return false;
    }

    /**
     * Reorders hero slides via AJAX
     */
    public function reorder() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $order = $input['order'] ?? [];

            if (is_array($order) && !empty($order)) {
                $db = Database::connect();
                try {
                    $db->beginTransaction();
                    $stmt = $db->prepare("UPDATE hero_slides SET display_order = :display_order WHERE id = :id");
                    foreach ($order as $index => $id) {
                        $stmt->execute([
                            'display_order' => $index + 1,
                            'id' => (int)$id
                        ]);
                    }
                    $db->commit();
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true]);
                    exit();
                } catch (Exception $e) {
                    $db->rollBack();
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                    exit();
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit();
    }
}
