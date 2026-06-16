<?php
// controllers/NewsController.php
// Manages frontend index view data loading and admin news CRUD (Create, Read, Update, Delete)

class NewsController {
    private $newsModel;
    private $itaModel;

    public function __construct() {
        $this->newsModel = new News();
        $this->itaModel = new Ita();
    }

    /**
     * Frontend Homepage: Displays slider, news feed, and portals
     */
    public function index() {
        // Fetch news for frontend showcase
        $announcements = $this->newsModel->getAll('announcement', 4);
        $activities = $this->newsModel->getAll('activity', 4);
        $generalNews = $this->newsModel->getAll('general', 4);
        
        // Fetch latest certificates from phichaia_cktech database
        $awards = [];
        try {
            $pdoCktech = Database::connect('phichaia_cktech');
            if ($pdoCktech) {
                $stmt = $pdoCktech->prepare("SELECT id, student_name, student_class, student_room, award_name, award_detail, award_date, certificate_image, created_at FROM certificates ORDER BY award_date DESC, id DESC LIMIT 4");
                $stmt->execute();
                $certs = $stmt->fetchAll();

                $cktechCertBaseUrl = 'https://cktech.phichai.ac.th/uploads/certificates/';

                foreach ($certs as $c) {
                    $imageUrl = null;
                    if (!empty($c['certificate_image'])) {
                        $imageUrl = $cktechCertBaseUrl . ltrim($c['certificate_image'], '/');
                    }
                    
                    // Construct a clean display content
                    $classText = !empty($c['student_class']) ? " ชั้น ม.{$c['student_class']}" : "";
                    $roomText = (!empty($c['student_room']) && !empty($c['student_class'])) ? "/{$c['student_room']}" : "";
                    $studentInfo = !empty($c['student_name']) ? "ผู้รับรางวัล: {$c['student_name']}{$classText}{$roomText}" : "";
                    
                    $detailText = $c['award_detail'] ?? '';
                    $fullContent = $studentInfo ? $studentInfo . "\n" . $detailText : $detailText;

                    $awards[] = [
                        'id' => $c['id'],
                        'title' => !empty($c['award_name']) ? $c['award_name'] : 'รางวัลเกียรติยศ',
                        'content' => $fullContent,
                        'image_url' => $imageUrl,
                        'created_at' => $c['award_date'] ?? $c['created_at'] ?? date('Y-m-d')
                    ];
                }
            }
        } catch (Exception $e) {
            error_log("NewsController index fetch certificates error: " . $e->getMessage());
            $awards = [];
        }
        
        // Fetch active ITA indicator metrics for progress bar
        $itaMetrics = $this->itaModel->getMetrics();

        // Fetch active Hero slides
        $heroModel = new Hero();
        $slides = $heroModel->getAll(true);

        // Fetch latest journals for Activity Gallery
        $journalsForGallery = [];
        try {
            $pdoGeneral = Database::connect('phichaia_general');
            if ($pdoGeneral) {
                // Fetch the latest 50 newsletters to find items with images
                $stmt = $pdoGeneral->prepare("SELECT id, title, images, news_date, created_at FROM newsletters ORDER BY news_date DESC, id DESC LIMIT 50");
                $stmt->execute();
                $allJournals = $stmt->fetchAll();
                
                foreach ($allJournals as $j) {
                    if (!empty($j['images'])) {
                        $imagesArray = json_decode($j['images'], true);
                        if (is_array($imagesArray) && !empty($imagesArray)) {
                            // Resolve the first image path
                            $firstImage = $imagesArray[0];
                            $imageUrl = null;
                            if (strpos($firstImage, 'http') === 0) {
                                $imageUrl = $firstImage;
                            } else {
                                $fileName = str_replace(['uploads/newsletter/', 'uploads/newsletters/'], '', $firstImage);
                                $fileName = ltrim($fileName, '/');
                                $imageUrl = rtrim(GENERAL_ASSETS_URL, '/') . '/uploads/newsletter/' . $fileName;
                            }
                            
                            $journalsForGallery[] = [
                                'id' => $j['id'],
                                'title' => $j['title'],
                                'image_url' => $imageUrl
                            ];
                            
                            if (count($journalsForGallery) >= 8) {
                                break;
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            error_log("NewsController index fetch journals error: " . $e->getMessage());
        }

        // Render main landing page
        $title = SCHOOL_NAME . " | หน้าแรก";
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/index.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Frontend News Archive List: Displays filterable news posts
     */
    public function archive() {
        // Fetch all news items
        $announcements = $this->newsModel->getAll('announcement');
        $activities = $this->newsModel->getAll('activity');
        $generalNews = $this->newsModel->getAll('general');
        $awards = $this->newsModel->getAll('award');

        $title = "ข่าวสารและประกาศ | " . SCHOOL_NAME;
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/news.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Frontend News Detail View: Read a specific news article
     */
    public function detail() {
        $id = (int)($_GET['id'] ?? 0);
        $newsItem = $this->newsModel->getById($id);

        if (!$newsItem) {
            handle404("ไม่พบข่าวสารที่คุณต้องการอ่าน");
            exit();
        }

        // Fetch related news (excluding the current one)
        $relatedNews = [];
        $allCategoryNews = $this->newsModel->getAll($newsItem['category'], 4);
        foreach ($allCategoryNews as $item) {
            if ((int)$item['id'] !== $id && count($relatedNews) < 3) {
                $relatedNews[] = $item;
            }
        }

        $title = $newsItem['title'] . " | " . SCHOOL_NAME;
        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/news_detail.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Creates a new news posting
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
            $content = trim($_POST['content'] ?? '');
            $category = trim($_POST['category'] ?? 'general');
            $docNumber = trim($_POST['doc_number'] ?? '');
            $budget = trim($_POST['budget'] ?? '');
            
            // Format custom created_at date
            $createdAt = null;
            if (!empty($_POST['created_at'])) {
                $createdAt = date('Y-m-d H:i:s', strtotime($_POST['created_at']));
            } else {
                $createdAt = date('Y-m-d H:i:s');
            }
            
            // Validate basic inputs
            if (empty($title) || empty($content)) {
                $_SESSION['error'] = 'กรุณากรอกหัวข้อและเนื้อหาข่าวสาร';
                header('Location: ' . BASE_URL . 'admin?tab=news');
                exit();
            }

            // Handle file upload for news cover image
            $imageUrl = null;
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->handleImageUpload($_FILES['cover_image']);
                if ($imageUrl === false) {
                    $_SESSION['error'] = 'การอัปโหลดรูปภาพล้มเหลว (กรุณาใช้ไฟล์รูปภาพสกุล .jpg, .png, .webp ขนาดไม่เกิน 5MB)';
                    header('Location: ' . BASE_URL . 'admin?tab=news');
                    exit();
                }
            }

            // Handle file upload for PDF document attachment
            $pdfUrl = null;
            if (isset($_FILES['attachment_pdf']) && $_FILES['attachment_pdf']['error'] === UPLOAD_ERR_OK) {
                $pdfUrl = $this->handlePdfUpload($_FILES['attachment_pdf']);
                if ($pdfUrl === false) {
                    $_SESSION['error'] = 'การอัปโหลดไฟล์เอกสารแนบล้มเหลว (กรุณาใช้ไฟล์เอกสารสกุล .pdf ขนาดไม่เกิน 15MB)';
                    header('Location: ' . BASE_URL . 'admin?tab=news');
                    exit();
                }
            }

            $success = $this->newsModel->create([
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'image_url' => $imageUrl,
                'attachment_pdf' => $pdfUrl,
                'doc_number' => !empty($docNumber) ? $docNumber : null,
                'budget' => !empty($budget) ? $budget : null,
                'created_by' => $_SESSION['user_id'],
                'created_at' => $createdAt
            ]);

            if ($success) {
                $_SESSION['success'] = 'เพิ่มข่าวสารสำเร็จเรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูลข่าวสาร';
            }
        }
        header('Location: ' . BASE_URL . 'admin?tab=news');
        exit();
    }

    /**
     * Updates an existing news posting
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
            $content = trim($_POST['content'] ?? '');
            $category = trim($_POST['category'] ?? 'general');

            $newsItem = $this->newsModel->getById($id);
            if (!$newsItem) {
                $_SESSION['error'] = 'ไม่พบข้อมูลข่าวสารที่ต้องการแก้ไข';
                header('Location: ' . BASE_URL . 'admin?tab=news');
                exit();
            }

            if (empty($title) || empty($content)) {
                $_SESSION['error'] = 'กรุณากรอกหัวข้อและเนื้อหาข่าวสาร';
                header('Location: ' . BASE_URL . 'admin?tab=news');
                exit();
            }

            $data = [
                'title' => $title,
                'content' => $content,
                'category' => $category,
                'doc_number' => !empty($_POST['doc_number']) ? trim($_POST['doc_number']) : null,
                'budget' => !empty($_POST['budget']) ? trim($_POST['budget']) : null
            ];

            // Handle custom created_at date edit
            if (!empty($_POST['created_at'])) {
                $data['created_at'] = date('Y-m-d H:i:s', strtotime($_POST['created_at']));
            }

            // If a new cover image is uploaded, process it
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->handleImageUpload($_FILES['cover_image']);
                if ($imageUrl !== false) {
                    $data['image_url'] = $imageUrl;
                    // Delete old file if exists
                    if (!empty($newsItem['image_url'])) {
                        $oldPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $newsItem['image_url']);
                        if (file_exists($oldPath)) {
                            @unlink($oldPath);
                        }
                    }
                } else {
                    $_SESSION['error'] = 'การอัปโหลดรูปภาพล้มเหลว (กรุณาใช้ไฟล์รูปภาพที่ถูกต้อง)';
                    header('Location: ' . BASE_URL . 'admin?tab=news');
                    exit();
                }
            }

            // Handle clearing existing PDF if checkbox clear_pdf is ticked
            if (isset($_POST['clear_pdf']) && $_POST['clear_pdf'] == '1') {
                $data['attachment_pdf'] = null;
                if (!empty($newsItem['attachment_pdf'])) {
                    $oldPdfPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $newsItem['attachment_pdf']);
                    if (file_exists($oldPdfPath)) {
                        @unlink($oldPdfPath);
                    }
                }
            }

            // Handle uploading a new PDF attachment
            if (isset($_FILES['attachment_pdf']) && $_FILES['attachment_pdf']['error'] === UPLOAD_ERR_OK) {
                $pdfUrl = $this->handlePdfUpload($_FILES['attachment_pdf']);
                if ($pdfUrl !== false) {
                    $data['attachment_pdf'] = $pdfUrl;
                    // Delete old pdf if exists
                    if (!empty($newsItem['attachment_pdf'])) {
                        $oldPdfPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $newsItem['attachment_pdf']);
                        if (file_exists($oldPdfPath)) {
                            @unlink($oldPdfPath);
                        }
                    }
                } else {
                    $_SESSION['error'] = 'การอัปโหลดไฟล์เอกสารแนบล้มเหลว (กรุณาใช้ไฟล์เอกสารสกุล .pdf)';
                    header('Location: ' . BASE_URL . 'admin?tab=news');
                    exit();
                }
            }

            $success = $this->newsModel->update($id, $data);
            if ($success) {
                $_SESSION['success'] = 'แก้ไขข่าวสารสำเร็จเรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการปรับปรุงข้อมูลข่าวสาร';
            }
        }
        header('Location: ' . BASE_URL . 'admin?tab=news');
        exit();
    }

    /**
     * Deletes a news posting
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
        $newsItem = $this->newsModel->getById($id);
        
        if ($newsItem) {
            // Delete physical image from system disk
            if (!empty($newsItem['image_url'])) {
                $oldPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $newsItem['image_url']);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Delete physical PDF attachment from system disk
            if (!empty($newsItem['attachment_pdf'])) {
                $oldPdfPath = str_replace(UPLOAD_URL, UPLOAD_DIR, $newsItem['attachment_pdf']);
                if (file_exists($oldPdfPath)) {
                    @unlink($oldPdfPath);
                }
            }

            $success = $this->newsModel->delete($id);
            if ($success) {
                $_SESSION['success'] = 'ลบข่าวสารเสร็จเรียบร้อยแล้ว';
            } else {
                $_SESSION['error'] = 'เกิดข้อผิดพลาดในการลบข่าวสาร';
            }
        } else {
            $_SESSION['error'] = 'ไม่พบข้อมูลข่าวสารที่ต้องการลบ';
        }
        header('Location: ' . BASE_URL . 'admin?tab=news');
        exit();
    }

    /**
     * Core Helper: Handles sanitisation and upload of cover images
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
        $newFilename = 'news_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destination = UPLOAD_DIR . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return UPLOAD_URL . $newFilename;
        }

        return false;
    }

    /**
     * Core Helper: Handles sanitisation and upload of PDF documents
     * @param array $file $_FILES element
     * @return string|false relative/absolute public URL of uploaded file
     */
    private function handlePdfUpload($file) {
        $allowedExtensions = ['pdf'];
        $fileInfo = pathinfo($file['name']);
        $extension = strtolower($fileInfo['extension'] ?? '');

        if (!in_array($extension, $allowedExtensions)) {
            return false;
        }

        // Limit size to 15MB
        if ($file['size'] > 15 * 1024 * 1024) {
            return false;
        }

        // Ensure directories exist
        if (!file_exists(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }

        // Generate secure random filename
        $newFilename = 'news_attachment_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destination = UPLOAD_DIR . $newFilename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return UPLOAD_URL . $newFilename;
        }

        return false;
    }
}
