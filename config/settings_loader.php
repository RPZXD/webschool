<?php
// config/settings_loader.php
// Dynamically fetches site configurations from database and initializes global constants

try {
    $settingModel = new Setting();
    $dbSettings = $settingModel->get_all_settings();
} catch (Exception $e) {
    error_log("Failed to load settings from DB: " . $e->getMessage());
    $dbSettings = [];
}

// Helper function to define constants with a fallback value
function define_setting($name, $key, $fallback, $settings) {
    if (!defined($name)) {
        $val = isset($settings[$key]) ? $settings[$key] : $fallback;
        define($name, $val);
    }
}

// 1. Branding & Name Configurations
define_setting('SCHOOL_NAME', 'school_name', 'โรงเรียนพิชัย', $dbSettings);
define_setting('SCHOOL_NAME_EN', 'school_name_en', 'Phichai School', $dbSettings);
define_setting('SCHOOL_SHORT_NAME', 'school_short_name', 'พช.', $dbSettings);

// 2. Contact Details
define_setting('SCHOOL_ADDRESS_TH', 'school_address_th', 'โรงเรียนพิชัย 123 ถนนพิชัย อำเภอเมือง จังหวัดลำปาง 52000', $dbSettings);
define_setting('SCHOOL_ADDRESS_EN', 'school_address_en', 'Phichai School, 123 Phichai Road, Mueang District, Lampang 52000', $dbSettings);
define_setting('SCHOOL_PHONE', 'school_phone', '054-123456', $dbSettings);
define_setting('SCHOOL_FAX', 'school_fax', '054-654321', $dbSettings);
define_setting('SCHOOL_EMAIL', 'school_email', 'contact@school.ac.th', $dbSettings);

// 3. Social Media Link channels
define_setting('SCHOOL_FACEBOOK', 'school_facebook', 'https://facebook.com/phichaischool', $dbSettings);
define_setting('SCHOOL_YOUTUBE', 'school_youtube', 'https://youtube.com/phichaischool', $dbSettings);
define_setting('SCHOOL_LINE', 'school_line', 'https://line.me/R/ti/p/@phichaischool', $dbSettings);

// 4. Asset references
define_setting('SCHOOL_LOGO', 'school_logo', '', $dbSettings);
define_setting('SCHOOL_FAVICON', 'school_favicon', '', $dbSettings);

// 5. External integrations
define_setting('GOOGLE_MAP_EMBED', 'google_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3780.27453303666!2d99.5050853761053!3d18.286121482759942!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d96fe875e533e7%3A0xc3cb7217db55d7f8!2z4LmC4Lih4Lii4LmA4Lij4Li14Lii4LiZ4Lie4Li04LiK4Lix4Lii!5e0!3m2!1sth!2sth!4v1716480000000!5m2!1sth!2sth', $dbSettings);
define_setting('STUDENT_SCHEDULE_LINK', 'student_schedule_link', 'https://drive.google.com/drive/u/0/folders/15nMNC8bLRSnCmZoRYHemtc-yVLGszw0y', $dbSettings);
define_setting('TEACHER_SCHEDULE_LINK', 'teacher_schedule_link', 'https://drive.google.com/drive/u/0/folders/1nrJR74m7LWrCvOFU9dBhbDN_SgNba6yy', $dbSettings);

// 6. Homepage Statistics & Executive Settings
define_setting('STAT_STUDENTS', 'stat_students', '2,500', $dbSettings);
define_setting('STAT_STUDENTS_SUB', 'stat_students_sub', 'นักเรียนทั้งหมด', $dbSettings);
define_setting('STAT_TEACHERS', 'stat_teachers', '120', $dbSettings);
define_setting('STAT_TEACHERS_SUB', 'stat_teachers_sub', 'ครูและบุคลากร', $dbSettings);
define_setting('STAT_AWARDS', 'stat_awards', '50+', $dbSettings);
define_setting('STAT_AWARDS_SUB', 'stat_awards_sub', 'รางวัลแห่งความสำเร็จ', $dbSettings);
define_setting('STAT_CLASSROOMS', 'stat_classrooms', '45', $dbSettings);
define_setting('STAT_CLASSROOMS_SUB', 'stat_classrooms_sub', 'ห้องเรียนทั้งหมด', $dbSettings);

define_setting('EXEC_NAME', 'exec_name', 'ดร.สมชาย ใจดี', $dbSettings);
define_setting('EXEC_POSITION', 'exec_position', 'ผู้อำนวยการโรงเรียน', $dbSettings);
define_setting('EXEC_MESSAGE', 'exec_message', 'ยินดีต้อนรับสู่เว็บไซต์ของโรงเรียนเรา มุ่งเน้นพัฒนาผู้เรียนให้มีความรู้ คู่คุณธรรม นำเทคโนโลยี', $dbSettings);
define_setting('EXEC_IMAGE', 'exec_image', '', $dbSettings);

// 7. Feedback Page Integration
define_setting('FEEDBACK_FORM_URL', 'feedback_form_url', 'https://docs.google.com/forms/d/e/1FAIpQLSdfj2hYSPIH6DohM5-IFz0gw_tqrAPDNRYeiMpuLqWuvaDGIQ/viewform?embedded=true', $dbSettings);
define_setting('COMPLAINTS_FORM_URL', 'complaints_form_url', 'https://docs.google.com/forms/d/e/1FAIpQLSdXHcrRSeXIou3Ym2De6fP6BVqArEjpSkE6Qay6r8R6RaJLyw/viewform?embedded=true&wmode=transparent', $dbSettings);


define('GENERAL_ASSETS_URL', 'https://general.phichai.ac.th/'); // เปลี่ยนเป็น URL ของระบบ v2