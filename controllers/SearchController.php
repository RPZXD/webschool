<?php
// controllers/SearchController.php
// Executes cross-entity keyword matching across News, ITA OIT items, Staff members, and Static pages

class SearchController {
    /**
     * Executes the keyword search and renders the results panel
     */
    public function index() {
        $query = isset($_GET['search']) ? trim($_GET['search']) : '';
        
        $results = [
            'news' => [],
            'ita' => [],
            'staff' => [],
            'journal' => [],
            'pages' => []
        ];
        
        $totalResults = 0;

        if ($query !== '') {
            $qLike = '%' . $query . '%';

            // 1. Search News and Announcements
            try {
                $db = Database::connect();
                $stmt = $db->prepare("SELECT id, title, content, category, created_at, image_url 
                                      FROM news 
                                      WHERE title LIKE :q1 OR content LIKE :q2 
                                      ORDER BY created_at DESC");
                $stmt->execute(['q1' => $qLike, 'q2' => $qLike]);
                $results['news'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalResults += count($results['news']);
            } catch (Exception $e) {
                error_log("Search news query error: " . $e->getMessage());
            }

            // 2. Search ITA (OIT) Indicators
            try {
                $db = Database::connect();
                $stmt = $db->prepare("SELECT code, name, file_path, link_url 
                                      FROM ita_items 
                                      WHERE status = 'published' AND (code LIKE :q1 OR name LIKE :q2)
                                      ORDER BY CAST(SUBSTRING(code, 2) AS UNSIGNED) ASC");
                $stmt->execute(['q1' => $qLike, 'q2' => $qLike]);
                $results['ita'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalResults += count($results['ita']);
            } catch (Exception $e) {
                error_log("Search ITA query error: " . $e->getMessage());
            }

            // 3. Search School Staff (Teachers)
            try {
                $studentDb = Student::connect();
                $stmt = $studentDb->prepare("SELECT Teach_id, Teach_name, Teach_major, Teach_Position2, Teach_Academic, Teach_photo 
                                             FROM teacher 
                                             WHERE Teach_status = '1' AND (Teach_name LIKE :q1 OR Teach_major LIKE :q2 OR Teach_Position2 LIKE :q3)
                                             ORDER BY Teach_name ASC");
                $stmt->execute(['q1' => $qLike, 'q2' => $qLike, 'q3' => $qLike]);
                $results['staff'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalResults += count($results['staff']);
            } catch (Exception $e) {
                error_log("Search staff query error: " . $e->getMessage());
            }

            // 4. Search Journal/Newsletter from generalv2 (phichaia_general)
            try {
                $journalDb = Database::connect('phichaia_general');
                $stmt = $journalDb->prepare("SELECT id, title, detail, news_date, images, COALESCE(view_count, 0) as view_count 
                                             FROM newsletters 
                                             WHERE title LIKE :q1 OR detail LIKE :q2 
                                             ORDER BY news_date DESC 
                                             LIMIT 20");
                $stmt->execute(['q1' => $qLike, 'q2' => $qLike]);
                $results['journal'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $totalResults += count($results['journal']);
            } catch (Exception $e) {
                error_log("Search journal query error: " . $e->getMessage());
            }

            // 5. Search Static/Manual Pages and Links
            $staticPages = [
                [
                    'title' => 'คู่มือนักเรียน',
                    'desc' => 'คู่มือนักเรียนและผู้ปกครอง กฎระเบียบ ข้อบังคับ ข้อพึงปฏิบัติ',
                    'url' => BASE_URL . 'student-handbook',
                    'category' => 'ระเบียบ & คู่มือ'
                ],
                [
                    'title' => 'คู่มือระบบดูแลช่วยเหลือนักเรียน',
                    'desc' => 'คู่มือแนวทางการช่วยเหลือ ดูแล ป้องกัน และพัฒนานักเรียน',
                    'url' => BASE_URL . 'student-support-handbook',
                    'category' => 'ระเบียบ & คู่มือ'
                ],
                [
                    'title' => 'ระเบียบวินัยและความประพฤติ',
                    'desc' => 'ข้อบังคับระเบียบวินัยนักเรียน ความประพฤติ และบทลงโทษ',
                    'url' => BASE_URL . 'discipline-rules',
                    'category' => 'ระเบียบ & คู่มือ'
                ],
                [
                    'title' => 'ระเบียบเครื่องแต่งกายและทรงผม',
                    'desc' => 'ประกาศโรงเรียนพิชัยเกี่ยวกับเครื่องแต่งกาย ทรงผมนักเรียนชายและหญิง',
                    'url' => BASE_URL . 'dress-rules',
                    'category' => 'ระเบียบ & คู่มือ'
                ],
                [
                    'title' => 'สหวิทยาเขตพระยาพิชัยดาบหัก',
                    'desc' => 'ประกาศแต่งตั้งคณะกรรมการและข้อมูลของสหวิทยาเขตพระยาพิชัยดาบหัก',
                    'url' => BASE_URL . 'campus',
                    'category' => 'ข้อมูลทั่วไป'
                ],
                [
                    'title' => 'นโยบาย No Gift Policy',
                    'desc' => 'ประกาศเจตนารมณ์นโยบายงดรับ งดให้ของขวัญ หรือผลประโยชน์อื่นใดจากการปฏิบัติหน้าที่',
                    'url' => BASE_URL . 'no-gift',
                    'category' => 'ความโปร่งใส'
                ],
                [
                    'title' => "แนวปฏิบัติ Do's and Don'ts",
                    'desc' => 'แนวทางพฤติกรรมและการปฏิบัติตามหลักจริยธรรมของบุคลากร',
                    'url' => BASE_URL . 'dos-donts',
                    'category' => 'ความโปร่งใส'
                ],
                [
                    'title' => 'ช่องทางรับฟังความคิดเห็น',
                    'desc' => 'ร่วมเสนอความคิดเห็น ข้อเสนอแนะ หรือคำปรึกษาออนไลน์ผ่าน Google Form',
                    'url' => BASE_URL . 'feedback',
                    'category' => 'ความโปร่งใส'
                ],
                [
                    'title' => 'ช่องทางรับเรื่องร้องเรียนทุจริต',
                    'desc' => 'ช่องทางการร้องเรียน แจ้งเบาะแส การประพฤติมิชอบ การทุจริตของบุคลากร',
                    'url' => BASE_URL . 'complaints',
                    'category' => 'ความโปร่งใส'
                ],
                [
                    'title' => 'ทำเนียบผู้บริหาร',
                    'desc' => 'ทำเนียบผู้อำนวยการโรงเรียนพิชัยและคณะผู้บริหารตั้งแต่อดีตถึงปัจจุบัน',
                    'url' => BASE_URL . 'about?tab=executives',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'ประวัติโรงเรียน',
                    'desc' => 'ประวัติความเป็นมา ข้อมูลการก่อตั้ง และการพัฒนาของโรงเรียนพิชัย',
                    'url' => BASE_URL . 'about?tab=history',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'วิสัยทัศน์และพันธกิจ',
                    'desc' => 'วิสัยทัศน์ พันธกิจ เป้าประสงค์ และปรัชญาของโรงเรียนพิชัย',
                    'url' => BASE_URL . 'about?tab=vision_mission',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'ตราสัญลักษณ์',
                    'desc' => 'ตราสัญลักษณ์ประจำโรงเรียนพิชัย ข้อมูลอ้างอิง และรูปภาพสัญลักษณ์',
                    'url' => BASE_URL . 'about?tab=symbol',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'สีประจำโรงเรียน',
                    'desc' => 'สีประจำโรงเรียนพิชัย และความหมายของสีประจำสถานศึกษา',
                    'url' => BASE_URL . 'about?tab=colors',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'เพลงประจำโรงเรียน',
                    'desc' => 'เนื้อร้อง ฟังเพลง และประวัติเพลงประจำโรงเรียนพิชัย',
                    'url' => BASE_URL . 'about?tab=song',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'โครงสร้างการบริหารงาน',
                    'desc' => 'โครงสร้างองค์กร และแผนผังฝ่ายบริหารจัดการของโรงเรียนพิชัย',
                    'url' => BASE_URL . 'about?tab=structure',
                    'category' => 'แนะนำโรงเรียน'
                ],
                [
                    'title' => 'ข้อมูลสารสนเทศทั่วไป',
                    'desc' => 'สถิติจำนวนนักเรียน ครู และข้อมูลสารสนเทศเบื้องต้นประจำปีการศึกษา',
                    'url' => BASE_URL . 'info',
                    'category' => 'ข้อมูลทั่วไป'
                ],
                [
                    'title' => 'คณะกรรมการสถานศึกษา',
                    'desc' => 'ทำเนียบและรายชื่อคณะกรรมการสถานศึกษาขั้นพื้นฐานโรงเรียนพิชัย',
                    'url' => BASE_URL . 'schoolboard',
                    'category' => 'ข้อมูลทั่วไป'
                ],
                [
                    'title' => 'ธรรมนูญโรงเรียน',
                    'desc' => 'เอกสารธรรมนูญโรงเรียนพิชัย และแผนพัฒนาคุณภาพการศึกษา',
                    'url' => BASE_URL . 'tammanoon',
                    'category' => 'ข้อมูลทั่วไป'
                ],
                [
                    'title' => 'ตารางเรียนนักเรียน',
                    'desc' => 'ลิงก์ระบบดาวน์โหลดตารางเรียนรายห้องเรียนและรายชั้นเรียน',
                    'url' => BASE_URL . 'student-schedule',
                    'category' => 'วิชาการ & ตารางเวลา'
                ],
                [
                    'title' => 'ตารางสอนครู',
                    'desc' => 'ลิงก์ระบบดาวน์โหลดตารางสอนของครูอาจารย์รายบุคคล',
                    'url' => BASE_URL . 'teacher-schedule',
                    'category' => 'วิชาการ & ตารางเวลา'
                ],
                [
                    'title' => 'รายชื่อนักเรียน',
                    'desc' => 'ระบบค้นหารายชื่อนักเรียนแยกตามระดับชั้น ม.ต้น ม.ปลาย และห้องเรียน',
                    'url' => BASE_URL . 'student-list',
                    'category' => 'วิชาการ & ตารางเวลา'
                ],
                [
                    'title' => 'สถิติการมาเรียนประจำวัน',
                    'desc' => 'ข้อมูลการเช็กชื่อมาสาย ขาดเรียน ลาป่วย ลากิจ ประจำวันของนักเรียน',
                    'url' => BASE_URL . 'attendance-stats',
                    'category' => 'วิชาการ & ตารางเวลา'
                ],
                [
                    'title' => 'ติดต่อเรา',
                    'desc' => 'ที่อยู่ เบอร์โทรศัพท์ แผนที่ Google Maps อีเมล และช่องทางการติดต่อโรงเรียน',
                    'url' => BASE_URL . 'contact',
                    'category' => 'ข้อมูลทั่วไป'
                ],
                [
                    'title' => 'วารสารโรงเรียน',
                    'desc' => 'ข่าวประชาสัมพันธ์ วารสาร กิจกรรม และความเคลื่อนไหวล่าสุดจากระบบบริหารงานทั่วไป',
                    'url' => BASE_URL . 'journal',
                    'category' => 'ข่าวสาร'
                ]
            ];

            foreach ($staticPages as $page) {
                $qLower = mb_strtolower($query);
                $titleMatch = mb_strpos(mb_strtolower($page['title']), $qLower) !== false;
                $descMatch = mb_strpos(mb_strtolower($page['desc']), $qLower) !== false;
                $catMatch = mb_strpos(mb_strtolower($page['category']), $qLower) !== false;
                
                if ($titleMatch || $descMatch || $catMatch) {
                    $results['pages'][] = $page;
                    $totalResults++;
                }
            }
        }

        $title = "ผลการค้นหาสำหรับ: \"" . htmlspecialchars($query) . "\" | " . SCHOOL_NAME;

        require ROOT_PATH . 'views/layouts/header.php';
        require ROOT_PATH . 'views/frontend/search.php';
        require ROOT_PATH . 'views/layouts/footer.php';
    }
}
