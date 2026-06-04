<?php
if (!isset($route)) {
    $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
    $parsedUrl = parse_url($requestUri);
    $path = $parsedUrl['path'] ?? '/';
    $basePath = defined('BASE_URL') ? (parse_url(BASE_URL, PHP_URL_PATH) ?? '/') : '/';
    if (substr($basePath, -1) !== '/') {
        $basePath .= '/';
    }
    $route = '/';
    if (strpos($path, $basePath) === 0) {
        $route = '/' . substr($path, strlen($basePath));
    } else {
        $route = $path;
    }
    $route = '/' . trim($route, '/');
    if (strpos($route, '/public/') === 0) {
        $route = '/' . substr($route, 8);
    } elseif ($route === '/public') {
        $route = '/';
    }
    $route = '/' . trim($route, '/');
}

$onlinePortals = [
    [
        'title' => 'ระบบรายงานการสอน',
        'desc' => 'จัดการและรายงานการสอนอย่างมีประสิทธิภาพ',
        'icon' => 'fa-chalkboard-teacher',
        'gradient' => 'from-blue-600 to-indigo-700',
        'url' => 'https://cktech.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'ระบบดูแลช่วยเหลือนักเรียน',
        'desc' => 'ระบบดูแลและพัฒนานักเรียนอย่างครบครัน',
        'icon' => 'fa-shield-alt',
        'gradient' => 'from-emerald-600 to-teal-700',
        'url' => 'https://std.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'ระบบกิจกรรมนักเรียน',
        'desc' => 'จัดการกิจกรรมและพัฒนาทักษะนักเรียน',
        'icon' => 'fa-trophy',
        'gradient' => 'from-orange-500 to-red-600',
        'url' => 'https://eventstd.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'ระบบรับสมัครชุมนุม',
        'desc' => 'สมัครเข้าร่วมชุมนุมและกิจกรรมต่างๆ',
        'icon' => 'fa-users',
        'gradient' => 'from-violet-600 to-purple-700',
        'url' => 'https://club.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'ระบบข้อมูลบุคลากร',
        'desc' => 'จัดการข้อมูลบุคลากรและครูอาจารย์',
        'icon' => 'fa-user-tie',
        'gradient' => 'from-sky-600 to-blue-700',
        'url' => 'https://person.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'ระบบเอกสารคำสั่ง',
        'desc' => 'เข้าถึงเอกสารและคำสั่งต่างๆ ของโรงเรียน',
        'icon' => 'fa-folder-open',
        'gradient' => 'from-amber-500 to-orange-600',
        'url' => 'https://doc.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'งานรับนักเรียน',
        'desc' => 'ข้อมูลการสมัครเรียนและรับนักเรียนใหม่',
        'icon' => 'fa-graduation-cap',
        'gradient' => 'from-green-600 to-emerald-700',
        'url' => 'https://sites.google.com/phichai.ac.th/student68/',
        'badge' => 'hot'
    ],
    [
        'title' => 'งานบริหารทั่วไป',
        'desc' => 'ระบบบริหารจัดการทั่วไปของโรงเรียน',
        'icon' => 'fa-briefcase',
        'gradient' => 'from-rose-600 to-pink-700',
        'url' => 'https://general.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'งานทะเบียน',
        'desc' => 'จัดการระบบทะเบียนและข้อมูลนักเรียน',
        'icon' => 'fa-clipboard-list',
        'gradient' => 'from-cyan-600 to-blue-700',
        'url' => 'https://regis.phichai.ac.th/',
        'badge' => ''
    ],
    [
        'title' => 'ชำระเงินบำรุงการศึกษา',
        'desc' => 'ระบบชำระเงินออนไลน์อย่างสะดวก',
        'icon' => 'fa-credit-card',
        'gradient' => 'from-pink-600 to-rose-700',
        'url' => 'https://schoolbilling.dev31.in.th/SBPHICHAI/Pages/PrintReportPayInForStudent.aspx',
        'badge' => ''
    ],
    [
        'title' => 'คู่มือการจ่ายเงิน',
        'desc' => 'คู่มือและวิธีการชำระเงินบำรุงการศึกษา',
        'icon' => 'fa-book-reader',
        'gradient' => 'from-indigo-600 to-violet-700',
        'url' => 'https://drive.google.com/file/d/12_uFmWt6yWXwH2DC_utnOHAzFojYtjhX/view',
        'badge' => ''
    ],
    [
        'title' => 'ระบบจัดซื้อ-จัดจ้าง',
        'desc' => 'ระบบจัดการพัสดุและการเงิน',
        'icon' => 'fa-shopping-cart',
        'gradient' => 'from-teal-600 to-cyan-700',
        'url' => '#',
        'badge' => 'soon'
    ],
    [
        'title' => 'PA ข้อตกลงการพัฒนางาน',
        'desc' => 'ระบบติดตามและประเมินผลการทำงาน',
        'icon' => 'fa-chart-line',
        'gradient' => 'from-red-600 to-orange-600',
        'url' => 'https://sites.google.com/phichai.ac.th/phichaipa/',
        'badge' => ''
    ],
    [
        'title' => 'BIG DATA Phichai School',
        'desc' => 'ระบบวิเคราะห์ข้อมูลเพื่อการตัดสินใจ',
        'icon' => 'fa-chart-bar',
        'gradient' => 'from-yellow-500 to-amber-600',
        'url' => 'https://phichai.ac.th/phichai/dataph/index.php',
        'badge' => 'new'
    ],
    [
        'title' => 'ห้องเรียนออนไลน์ 2567',
        'desc' => 'แพลตฟอร์มการเรียนการสอนออนไลน์',
        'icon' => 'fa-laptop',
        'gradient' => 'from-fuchsia-600 to-pink-600',
        'url' => 'https://sites.google.com/phichai.ac.th/online/',
        'badge' => ''
    ]
];

$basicInfoMenu = [
    'general' => [
        'title_key' => 'cat_general_admin',
        'icon' => 'fa-school',
        'items' => [
            ['title_key' => 'info_general', 'url' => BASE_URL . 'info', 'target' => ''],
            ['title_key' => 'info_board', 'url' => BASE_URL . 'schoolboard', 'target' => ''],
            ['title_key' => 'info_charter', 'url' => BASE_URL . 'tammanoon', 'target' => ''],
            ['title_key' => 'info_campus', 'url' => BASE_URL . 'campus', 'target' => '']
        ]
    ],
    'academics' => [
        'title_key' => 'cat_academic_schedule',
        'icon' => 'fa-calendar-days',
        'items' => [
            ['title_key' => 'info_schedule_student', 'url' => BASE_URL . 'student-schedule', 'target' => ''],
            ['title_key' => 'info_schedule_teacher', 'url' => BASE_URL . 'teacher-schedule', 'target' => ''],
            ['title_key' => 'info_student_list', 'url' => BASE_URL . 'student-list', 'target' => ''],
            ['title_key' => 'info_school_staff', 'url' => BASE_URL . 'school-staff', 'target' => ''],
            ['title_key' => 'info_attendance_stats', 'url' => BASE_URL . 'attendance-stats', 'target' => '']
        ]
    ],
    'rules' => [
        'title_key' => 'cat_rules_handbook',
        'icon' => 'fa-book-bookmark',
        'items' => [
            ['title_key' => 'info_handbook_student', 'url' => BASE_URL . 'student-handbook', 'target' => ''],
            ['title_key' => 'info_support_handbook', 'url' => BASE_URL . 'student-support-handbook', 'target' => ''],
            ['title_key' => 'info_discipline_rules', 'url' => BASE_URL . 'discipline-rules', 'target' => ''],
            ['title_key' => 'info_dress_rules', 'url' => BASE_URL . 'dress-rules', 'target' => '']
        ]
    ],
    'transparency' => [
        'title_key' => 'cat_transparency_participation',
        'icon' => 'fa-shield-halved',
        'items' => [
            ['title_key' => 'info_feedback', 'url' => BASE_URL . 'feedback', 'target' => ''],
            ['title_key' => 'info_complaints', 'url' => BASE_URL . 'complaints', 'target' => ''],
            ['title_key' => 'info_qna', 'url' => BASE_URL . 'ita?search=O8', 'target' => ''],
            ['title_key' => 'info_no_gift', 'url' => BASE_URL . 'no-gift', 'target' => ''],
            ['title_key' => 'info_dos_donts', 'url' => BASE_URL . 'dos-donts', 'target' => '']
        ]
    ]
];

$internalGroups = [
    'admin' => [
        'title' => 'กลุ่มบริหาร',
        'icon' => 'fa-building-columns',
        'items' => [
            ['title' => 'กลุ่มบริหารงานบุคคล', 'url' => 'https://sites.google.com/phichai.ac.th/phichaipersonal', 'icon' => 'fa-users-gear'],
            ['title' => 'กลุ่มบริหารวิชาการ', 'url' => 'https://sites.google.com/unc.ac.th/phichai-school-academic/%E0%B8%AB%E0%B8%99%E0%B8%B2%E0%B9%81%E0%B8%A3%E0%B8%81', 'icon' => 'fa-book-open-reader'],
            ['title' => 'กลุ่มบริหารกิจการนักเรียน', 'url' => 'https://sites.google.com/phichai.ac.th/std-af/', 'icon' => 'fa-children'],
            ['title' => 'กลุ่มบริหารงบประมาณและแผนงาน', 'url' => 'https://sites.google.com/phichai.ac.th/budget/home', 'icon' => 'fa-coins'],
            ['title' => 'กลุ่มบริหารทั่วไป', 'url' => 'https://sites.google.com/phichai.ac.th/gadphichai/home', 'icon' => 'fa-briefcase'],
        ]
    ],
    'subjects' => [
        'title' => 'กลุ่มสาระการเรียนรู้',
        'icon' => 'fa-chalkboard',
        'items' => [
            ['title' => 'กลุ่มสาระฯภาษาไทย', 'url' => '#', 'icon' => 'fa-language'],
            ['title' => 'กลุ่มสาระฯภาษาต่างประเทศ', 'url' => '#', 'icon' => 'fa-earth-americas'],
            ['title' => 'กลุ่มสาระฯคณิตศาสตร์', 'url' => '#', 'icon' => 'fa-calculator'],
            ['title' => 'กลุ่มสาระฯวิทยาศาสตร์และเทคโนโลยี', 'url' => '#', 'icon' => 'fa-flask'],
            ['title' => 'กลุ่มสาระฯสังคมศึกษาฯ', 'url' => '#', 'icon' => 'fa-landmark'],
            ['title' => 'กลุ่มสาระฯศิลปะ', 'url' => '#', 'icon' => 'fa-palette'],
            ['title' => 'กลุ่มสาระฯสุขศึกษาและพลศึกษา', 'url' => '#', 'icon' => 'fa-heart-pulse'],
            ['title' => 'กลุ่มสาระฯการงานอาชีพ', 'url' => '#', 'icon' => 'fa-screwdriver-wrench'],
        ]
    ],
    'special' => [
        'title' => 'กลุ่มงานพิเศษ',
        'icon' => 'fa-star',
        'items' => [
            ['title' => 'กิจกรรมพัฒนาผู้เรียน', 'url' => '#', 'icon' => 'fa-puzzle-piece'],
            ['title' => 'ห้องเรียนพิเศษ', 'url' => '#', 'icon' => 'fa-microscope'],
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="<?php echo getActiveLang(); ?>" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="เว็บไซต์และระบบเผยแพร่ข้อมูลการประเมินคุณธรรมและความโปร่งใส (ITA) ออนไลน์ ของ <?php echo SCHOOL_NAME; ?>">
    <title><?php echo $title ?? SCHOOL_NAME; ?></title>
    
    <!-- Suppress Tailwind Play CDN production warning in console -->
    <script>
        (function() {
            const originalWarn = console.warn;
            console.warn = function(...args) {
                if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com should not be used in production')) {
                    return;
                }
                originalWarn.apply(console, args);
            };
        })();
    </script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Sarabun', 'sans-serif'],
                        english: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        darkblue: {
                            900: '#0b0f19',
                            950: '#05070d',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">

    <!-- Dynamic Favicon Integration -->
    <?php if (!empty(SCHOOL_FAVICON)): ?>
        <link rel="shortcut icon" href="<?php echo UPLOAD_URL . SCHOOL_FAVICON; ?>" type="image/x-icon">
    <?php endif; ?>

    <!-- Immediate Theme & Font-Size Init Script to prevent screen flashing -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('school_theme') || 'dark';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            
            const savedFontSize = localStorage.getItem('school_font_size') || 'normal';
            const fontSizes = { small: '13px', normal: '16px', large: '19px' };
            document.documentElement.style.fontSize = fontSizes[savedFontSize] || '16px';
        })();
    </script>
</head>
<body class="bg-gradient-mesh min-h-screen text-slate-800 dark:text-slate-100 flex flex-col font-sans transition-colors duration-300">
    <?php
    $currentUri = $_SERVER['REQUEST_URI'];
    $isHomeActive = ($currentUri === '/' || strpos($currentUri, 'index') !== false || $currentUri === '/main_web/public/' || $currentUri === '/main_web/public/index.php');
    $isNewsActive = (strpos($currentUri, '/news') !== false);
    $isAboutActive = (strpos($currentUri, '/about') !== false);
    $isItaActive = (strpos($currentUri, '/ita') !== false);
    $isContactActive = (strpos($currentUri, '/contact') !== false);
    ?>

    <!-- 1. Non-sticky Accessibility Toolbar (Top Bar) -->
    <div class="bg-white/95 dark:bg-slate-950/95 border-b border-slate-200 dark:border-white/5 text-slate-600 dark:text-slate-300 py-2.5 px-4 sm:px-6 lg:px-8 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <!-- Left Side: Welcome Info -->
            <div class="text-[10px] sm:text-xs font-semibold text-slate-400 dark:text-slate-500 hidden sm:block">
                ยินดีต้อนรับสู่เว็บไซต์ทางการของโรงเรียนพิชัย
            </div>

            <!-- Right Side: Accessibility, Theme & Language Toggles -->
            <div class="flex items-center gap-4 justify-between w-full sm:w-auto ml-auto">
                <!-- Font Resizing Controls -->
                <div class="flex items-center gap-1.5">
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-semibold tracking-wider mr-1">A A A</span>
                    <button id="fs-btn-small" onclick="setFontSize('small')" class="font-size-btn px-2.5 py-0.5 rounded bg-slate-200 dark:bg-white/5 hover:bg-slate-300 dark:hover:bg-white/10 text-[10px] font-bold transition-all" title="ลดขนาดตัวอักษร (Zoom Out)">
                        ก-
                    </button>
                    <button id="fs-btn-normal" onclick="setFontSize('normal')" class="font-size-btn px-2.5 py-0.5 rounded bg-indigo-600 text-white text-[10px] font-bold transition-all" title="ขนาดตัวอักษรปกติ (Normal Size)">
                        ก
                    </button>
                    <button id="fs-btn-large" onclick="setFontSize('large')" class="font-size-btn px-2.5 py-0.5 rounded bg-slate-200 dark:bg-white/5 hover:bg-slate-300 dark:hover:bg-white/10 text-[10px] font-bold transition-all" title="เพิ่มขนาดตัวอักษร (Zoom In)">
                        ก+
                    </button>
                </div>
                
                <div class="flex items-center gap-4">
                    <!-- Theme Toggle Button -->
                    <button onclick="toggleDarkMode()" class="hover:text-indigo-600 dark:hover:text-white transition-colors flex items-center gap-1.5" title="สลับโหมด สีสว่าง/สีมืด">
                        <i id="theme-icon" class="fa-solid fa-moon"></i>
                        <span class="text-[10px] hidden sm:inline font-bold">สลับโหมด / Theme</span>
                    </button>
                    
                    <span class="text-slate-300 dark:text-white/10">|</span>
                    
                    <!-- Language Selection -->
                    <div class="flex items-center gap-1">
                        <?php $activeLang = getActiveLang(); ?>
                        <a href="?lang=th" class="px-2 py-0.5 rounded transition-all text-[10px] font-black <?php echo $activeLang === 'th' ? 'bg-indigo-600 text-white' : 'hover:text-slate-800 dark:hover:text-white'; ?>">TH</a>
                        <span class="text-slate-300 dark:text-slate-600 text-[10px]">|</span>
                        <a href="?lang=en" class="px-2 py-0.5 rounded transition-all text-[10px] font-black <?php echo $activeLang === 'en' ? 'bg-indigo-600 text-white' : 'hover:text-slate-800 dark:hover:text-white'; ?>">EN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Sticky Main Header Container (Logo, Brand Name, Search & Action Button) -->
    <header class="sticky top-0 z-50 glass-nav shadow-lg border-b border-slate-200/50 dark:border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand Name (Left) -->
                <div class="flex items-center gap-3">
                    <a href="<?php echo BASE_URL; ?>" class="flex items-center gap-3 group">
                        <?php if (!empty(SCHOOL_LOGO)): ?>
                            <img src="<?php echo UPLOAD_URL . SCHOOL_LOGO; ?>" alt="School Logo" class="w-12 h-12 rounded-2xl object-cover shadow-lg border border-slate-200 dark:border-white/10 group-hover:scale-105 transition-transform duration-300">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg border border-indigo-400/20 group-hover:scale-105 transition-transform duration-300">
                                <span class="text-white font-english font-black text-xl tracking-wider"><?php echo SCHOOL_SHORT_NAME; ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex flex-col">
                            <span class="text-md sm:text-lg font-bold text-slate-900 dark:text-white tracking-wide group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors leading-tight"><?php echo SCHOOL_NAME; ?></span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 font-english leading-none mt-0.5"><?php echo SCHOOL_NAME_EN; ?></span>
                        </div>
                    </a>
                </div>

                <!-- Desktop Search Input (Center) -->
                <div class="hidden lg:flex flex-col items-center justify-center flex-grow max-w-md mx-8 space-y-1">
                    <form action="<?php echo BASE_URL; ?>search" method="GET" class="w-full relative">
                        <div class="relative">
                            <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="ค้นหาข่าวสารหรือประกาศ..." class="w-full pl-10 pr-16 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50/80 dark:bg-slate-800/80 text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all shadow-inner">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white px-3.5 py-1.5 rounded-lg text-[10px] font-bold transition-all cursor-pointer">
                                ค้นหา
                            </button>
                        </div>
                        
                        <!-- Quick Search tags -->
                        <div class="flex items-center gap-2 px-1 text-[10px]">
                            <span class="text-slate-400 dark:text-slate-500 font-medium">ค้นหาด่วน:</span>
                            <a href="<?php echo BASE_URL; ?>search?search=จัดซื้อจัดจ้าง" class="text-indigo-600 dark:text-indigo-400 hover:underline">#จัดซื้อจัดจ้าง</a>
                            <span class="text-slate-300 dark:text-slate-700">|</span>
                            <a href="<?php echo BASE_URL; ?>news?filter=activity" class="text-indigo-600 dark:text-indigo-400 hover:underline">#ข่าวกิจกรรม</a>
                            <span class="text-slate-300 dark:text-slate-700">|</span>
                            <a href="<?php echo BASE_URL; ?>news?filter=announcement" class="text-indigo-600 dark:text-indigo-400 hover:underline">#ประชาสัมพันธ์</a>
                            <span class="text-slate-300 dark:text-slate-700">|</span>
                            <a href="<?php echo BASE_URL; ?>news?filter=award" class="text-indigo-600 dark:text-indigo-400 hover:underline">#ผลงานเด่น</a>
                        </div>
                    </form>
                </div>

                <!-- Admin Action Button - Desktop (Right) -->
                <div class="hidden md:flex items-center gap-3">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-600 dark:text-slate-400 bg-slate-200/50 dark:bg-white/5 border border-slate-900/5 dark:border-white/10 px-3 py-2 rounded-xl">
                                <i class="fa-solid fa-user-circle text-indigo-500 dark:text-indigo-400 mr-1.5"></i><?php echo htmlspecialchars($_SESSION['fullname']); ?>
                            </span>
                            <a href="<?php echo BASE_URL; ?>admin" class="px-4 py-2.5 bg-indigo-600/10 dark:bg-indigo-600/20 border border-indigo-500/30 text-indigo-600 dark:text-indigo-300 hover:bg-indigo-600 hover:text-white rounded-xl text-xs font-semibold shadow-lg transition-all duration-300">
                                <i class="fa-solid fa-gauge mr-1.5"></i><?php echo __('admin_dashboard'); ?>
                            </a>
                            <a href="<?php echo BASE_URL; ?>logout" class="px-3.5 py-2.5 hover:bg-red-500/10 text-red-600 dark:text-red-400 hover:text-red-500 border border-transparent hover:border-red-500/20 rounded-xl text-xs transition-all duration-300">
                                <i class="fa-solid fa-sign-out-alt"></i>
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>login" class="px-4.5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl text-xs font-semibold shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-lock mr-1.5"></i><?php echo __('admin_panel'); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Hamburger Button -->
                <div class="md:hidden flex items-center gap-3">
                    <button id="mobile-menu-button" class="p-2.5 rounded-xl text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 focus:outline-none transition-all duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" id="menu-icon"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Drawer Menu -->
    <div id="mobile-menu" class="hidden fixed inset-0 z-50 flex justify-end">
            <!-- Backdrop Overlay -->
            <div id="mobile-menu-backdrop" class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-out z-10"></div>
            <!-- Content Panel -->
            <div class="drawer-panel relative z-20 w-full max-w-[300px] sm:max-w-[320px] bg-slate-50 dark:bg-slate-900 border-l border-slate-200 dark:border-white/10 shadow-2xl h-full flex flex-col transform translate-x-full transition-transform duration-300 ease-out">
                <!-- Drawer Header -->
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-white/5 bg-white dark:bg-slate-950/50">
                    <div class="flex items-center gap-2">
                        <?php if (!empty(SCHOOL_LOGO)): ?>
                            <img src="<?php echo UPLOAD_URL . SCHOOL_LOGO; ?>" alt="School Logo" class="w-8 h-8 rounded-lg object-cover border border-slate-200 dark:border-white/10" onerror="this.style.display='none'">
                        <?php else: ?>
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center">
                                <span class="text-white font-english font-black text-xs"><?php echo SCHOOL_SHORT_NAME; ?></span>
                            </div>
                        <?php endif; ?>
                        <span class="text-xs font-bold text-slate-800 dark:text-white uppercase tracking-wider">เมนูหลัก / Menu</span>
                    </div>
                    <button id="mobile-menu-close" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                        <i class="fa-solid fa-times text-sm"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="flex-grow overflow-y-auto p-4 space-y-4">
                    <!-- Mobile Search Input -->
                    <div class="bg-white dark:bg-slate-950/30 p-3 rounded-2xl border border-slate-200 dark:border-white/5">
                        <form action="<?php echo BASE_URL; ?>search" method="GET" class="relative">
                            <input type="text" name="search" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="ค้นหาข่าวสารหรือประกาศ..." class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500"><i class="fa-solid fa-magnifying-glass text-xs"></i></span>
                        </form>
                        <div class="flex flex-wrap gap-1.5 mt-2 px-1 text-[8px]">
                            <span class="text-slate-400">ค้นหาด่วน:</span>
                            <a href="<?php echo BASE_URL; ?>search?search=จัดซื้อจัดจ้าง" class="text-indigo-600 dark:text-indigo-400 underline">#จัดซื้อจัดจ้าง</a>
                            <a href="<?php echo BASE_URL; ?>news?filter=activity" class="text-indigo-600 dark:text-indigo-400 underline">#ข่าวกิจกรรม</a>
                        </div>
                    </div>

                    <!-- Menu List -->
                    <div class="space-y-1.5">
                        <!-- Home Link -->
                        <a href="<?php echo BASE_URL; ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 <?php echo $isHomeActive ? 'text-indigo-600 dark:text-indigo-400 bg-slate-200/50 dark:bg-white/5 border border-slate-900/5 dark:border-white/5' : ''; ?>">
                            <i class="fa-solid fa-home text-sm w-4 text-center shrink-0"></i>
                            <span><?php echo __('home'); ?></span>
                        </a>

                        <!-- About School Accordion -->
                        <div class="space-y-0.5">
                            <button onclick="toggleMobileAccordion('acc-about')" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 rounded-xl transition-all">
                                <span class="flex items-center gap-3">
                                    <i class="fa-solid fa-graduation-cap text-sm w-4 text-center shrink-0"></i>
                                    <span><?php echo __('about_school'); ?></span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" id="acc-about-icon"></i>
                            </button>
                            <div id="acc-about" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden">
                                <div class="min-h-0 pl-8 pr-2 mt-0.5 space-y-1 border-l border-slate-200 dark:border-white/5 ml-6 pb-1">
                                <a href="<?php echo BASE_URL; ?>about?tab=history" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('history'); ?></a>
                                <a href="<?php echo BASE_URL; ?>about?tab=vision_mission" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('vision_mission'); ?></a>
                                <a href="<?php echo BASE_URL; ?>about?tab=symbol" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('symbol'); ?></a>
                                <a href="<?php echo BASE_URL; ?>about?tab=colors" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('colors'); ?></a>
                                <a href="<?php echo BASE_URL; ?>about?tab=song" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('song'); ?></a>
                                <a href="<?php echo BASE_URL; ?>about?tab=executives" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('executives'); ?></a>
                                <a href="<?php echo BASE_URL; ?>about?tab=structure" class="block px-3 py-2 rounded-xl text-[11px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __('structure'); ?></a>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Info Accordion -->
                        <div class="space-y-0.5">
                            <button onclick="toggleMobileAccordion('acc-basic')" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 rounded-xl transition-all">
                                <span class="flex items-center gap-3">
                                    <i class="fa-solid fa-circle-info text-sm w-4 text-center shrink-0"></i>
                                    <span><?php echo __('basic_info'); ?></span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" id="acc-basic-icon"></i>
                            </button>
                            <div id="acc-basic" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden">
                                <div class="min-h-0 pl-4 mt-0.5 space-y-3 border-l border-slate-200 dark:border-white/5 ml-6 pb-2">
                                <?php foreach ($basicInfoMenu as $cat): ?>
                                    <div class="space-y-1">
                                        <p class="text-[9px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide flex items-center gap-1.5 px-3">
                                            <i class="fa-solid <?php echo $cat['icon']; ?>"></i>
                                            <span><?php echo __($cat['title_key']); ?></span>
                                        </p>
                                        <div class="pl-3 border-l border-slate-200 dark:border-white/5 ml-4 space-y-0.5">
                                            <?php foreach ($cat['items'] as $item): ?>
                                                <a href="<?php echo htmlspecialchars($item['url']); ?>" <?php echo !empty($item['target']) ? 'target="'.$item['target'].'" rel="noopener"' : ''; ?> class="block py-1.5 px-2 text-[10px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400"><?php echo __($item['title_key']); ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- News Link -->
                        <a href="<?php echo BASE_URL; ?>news" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 <?php echo $isNewsActive ? 'text-indigo-600 dark:text-indigo-400 bg-slate-200/50 dark:bg-white/5 border border-slate-900/5 dark:border-white/5' : ''; ?>">
                            <i class="fa-solid fa-bullhorn text-sm w-4 text-center shrink-0"></i>
                            <span>ข่าวสารและประกาศ</span>
                        </a>

                        <!-- Journal Link -->
                        <a href="<?php echo BASE_URL; ?>journal" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 <?php echo (strpos($route, '/journal') === 0) ? 'text-indigo-600 dark:text-indigo-400 bg-slate-200/50 dark:bg-white/5 border border-slate-900/5 dark:border-white/5' : ''; ?>">
                            <i class="fa-solid fa-book-open text-sm w-4 text-center shrink-0"></i>
                            <span><?php echo __('school_journal'); ?></span>
                        </a>

                        <!-- Internal Department Groups Accordion -->
                        <div class="space-y-0.5">
                            <button onclick="toggleMobileAccordion('acc-internal')" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 rounded-xl transition-all">
                                <span class="flex items-center gap-3">
                                    <i class="fa-solid fa-building-columns text-sm w-4 text-center shrink-0"></i>
                                    <span>เว็บไซต์กลุ่มงานภายใน</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" id="acc-internal-icon"></i>
                            </button>
                            <div id="acc-internal" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden">
                                <div class="min-h-0 pl-4 mt-0.5 space-y-3 border-l border-slate-200 dark:border-white/5 ml-6 pb-2">
                                <?php foreach ($internalGroups as $gKey => $group): ?>
                                    <div class="space-y-1">
                                        <p class="text-[9px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wide flex items-center gap-1.5 px-3">
                                            <i class="fa-solid <?php echo $group['icon']; ?>"></i>
                                            <span><?php echo $group['title']; ?></span>
                                        </p>
                                        <div class="pl-3 border-l border-slate-200 dark:border-white/5 ml-4 space-y-0.5">
                                            <?php foreach ($group['items'] as $item): 
                                                $target = ($item['url'] !== '#') ? 'target="_blank" rel="noopener"' : '';
                                            ?>
                                                <a href="<?php echo htmlspecialchars($item['url']); ?>" <?php echo $target; ?> class="block py-1.5 px-2 text-[10px] text-slate-500 dark:text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                    <i class="fa-solid <?php echo $item['icon']; ?> w-3.5 text-center mr-1 text-[8px]"></i><?php echo $item['title']; ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Quality Assurance Link -->
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5">
                            <i class="fa-solid fa-award text-sm w-4 text-center shrink-0"></i>
                            <span>งานประกันคุณภาพการศึกษา</span>
                        </a>

                        <!-- Document Download Link -->
                        <a href="#" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5">
                            <i class="fa-solid fa-file-arrow-down text-sm w-4 text-center shrink-0"></i>
                            <span>ดาวน์โหลดเอกสารราชการ</span>
                        </a>

                        <!-- ITA Link -->
                        <a href="<?php echo BASE_URL; ?>ita" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 <?php echo $isItaActive ? 'text-indigo-600 dark:text-indigo-400 bg-slate-200/50 dark:bg-white/5 border border-slate-900/5 dark:border-white/5' : ''; ?>">
                            <i class="fa-solid fa-square-poll-horizontal text-sm w-4 text-center shrink-0"></i>
                            <span>ข้อมูล ITA Online</span>
                        </a>

                        <!-- Contact Link -->
                        <a href="<?php echo BASE_URL; ?>contact" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 <?php echo $isContactActive ? 'text-indigo-600 dark:text-indigo-400 bg-slate-200/50 dark:bg-white/5 border border-slate-900/5 dark:border-white/5' : ''; ?>">
                            <i class="fa-solid fa-phone text-sm w-4 text-center shrink-0"></i>
                            <span>ติดต่อเรา</span>
                        </a>

                        <!-- Online Portals Accordion -->
                        <div class="space-y-0.5">
                            <button onclick="toggleMobileAccordion('acc-portals')" class="w-full flex items-center justify-between px-4 py-2.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-200/50 dark:hover:bg-white/5 rounded-xl transition-all">
                                <span class="flex items-center gap-3">
                                    <i class="fa-solid fa-server text-sm w-4 text-center shrink-0"></i>
                                    <span>ระบบสารสนเทศ</span>
                                </span>
                                <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-300" id="acc-portals-icon"></i>
                            </button>
                            <div id="acc-portals" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden">
                                <div class="min-h-0 pl-2 pr-2 mt-1 border-l border-slate-200 dark:border-white/5 ml-6 pb-2">
                                <div class="grid grid-cols-2 gap-1">
                                    <?php foreach ($onlinePortals as $portal): 
                                        $url = $portal['url'];
                                        $target = ($url !== '#') ? 'target="_blank"' : '';
                                    ?>
                                        <a href="<?php echo htmlspecialchars($url); ?>" <?php echo $target; ?> class="flex items-center gap-1.5 p-2 rounded-xl text-[9px] text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 font-semibold">
                                            <i class="fa-solid <?php echo htmlspecialchars($portal['icon']); ?> text-indigo-500 shrink-0"></i>
                                            <span class="truncate"><?php echo htmlspecialchars($portal['title']); ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Action Section (Drawer Footer) -->
                <div class="p-4 pb-[calc(1rem+env(safe-area-inset-bottom))] border-t border-slate-200 dark:border-white/5 bg-white dark:bg-slate-950/30 relative z-30">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="space-y-2">
                            <p class="text-[10px] text-indigo-500 dark:text-indigo-400 font-bold mb-1 px-1">
                                <i class="fa-solid fa-user-circle mr-1"></i><?php echo htmlspecialchars($_SESSION['fullname']); ?>
                            </p>
                            <div class="grid grid-cols-2 gap-2">
                                <a href="<?php echo BASE_URL; ?>admin" class="flex items-center justify-center py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-[10px] font-bold transition-all shadow-md">
                                    <i class="fa-solid fa-gauge mr-1.5"></i>แผงควบคุม
                                </a>
                                <a href="<?php echo BASE_URL; ?>logout" class="flex items-center justify-center py-2.5 bg-red-600/10 hover:bg-red-600/20 text-red-600 dark:text-red-400 rounded-xl text-[10px] font-bold border border-red-500/20 transition-all">
                                    <i class="fa-solid fa-sign-out-alt mr-1.5"></i>ออกจากระบบ
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>login" class="w-full flex items-center justify-center py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl text-xs font-semibold shadow-lg transition-all">
                            <i class="fa-solid fa-lock mr-1.5"></i><?php echo __('admin_panel'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <!-- 3. Non-sticky Main Menu Bar (Below header, above news ticker) -->
    <div class="hidden md:block bg-[#f8fafc] dark:bg-slate-900 border-b-[3px] border-amber-500 py-2.5 px-4 sm:px-6 lg:px-8 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-center">
            <nav class="flex items-center gap-1.5 text-slate-700 dark:text-slate-200">
                <a href="<?php echo BASE_URL; ?>" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out <?php echo $isHomeActive ? 'bg-indigo-600 text-white border border-indigo-500 shadow-md shadow-indigo-500/20 -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg'; ?>">
                    <?php echo __('home'); ?>
                </a>

                <!-- About School Dropdown Menu -->
                <div class="relative group/dropdown">
                    <button class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out flex items-center gap-1.5 <?php echo $isAboutActive ? 'bg-indigo-600 text-white border border-indigo-500 shadow-md shadow-indigo-500/20 -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg'; ?>">
                        <span><?php echo __('about_school'); ?></span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 opacity-70 transition-transform duration-300 group-hover/dropdown:rotate-180"></i>
                    </button>
                    <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-64 rounded-2xl glass-modal shadow-2xl p-2 border border-slate-900/5 dark:border-white/10 opacity-0 invisible translate-y-3 group-hover/dropdown:opacity-100 group-hover/dropdown:visible group-hover/dropdown:translate-y-0 transition-all duration-300 z-50">
                        <a href="<?php echo BASE_URL; ?>about?tab=history" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('history'); ?>
                        </a>
                        <a href="<?php echo BASE_URL; ?>about?tab=vision_mission" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('vision_mission'); ?>
                        </a>
                        <a href="<?php echo BASE_URL; ?>about?tab=symbol" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('symbol'); ?>
                        </a>
                        <a href="<?php echo BASE_URL; ?>about?tab=colors" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('colors'); ?>
                        </a>
                        <a href="<?php echo BASE_URL; ?>about?tab=song" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('song'); ?>
                        </a>
                        <a href="<?php echo BASE_URL; ?>about?tab=executives" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('executives'); ?>
                        </a>
                        <a href="<?php echo BASE_URL; ?>about?tab=structure" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-xs text-slate-600 dark:text-slate-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-600/30 transition-all duration-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                            <?php echo __('structure'); ?>
                        </a>
                    </div>
                </div>

                <!-- Basic Info Dropdown Menu (Mega Menu) -->
                <div class="relative group/dropdown">
                    <button class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out flex items-center gap-1.5 text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg">
                        <span><?php echo __('basic_info'); ?></span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 opacity-70 transition-transform duration-300 group-hover/dropdown:rotate-180"></i>
                    </button>
                    <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-[840px] rounded-2xl glass-modal shadow-2xl p-4 border border-slate-900/5 dark:border-white/10 opacity-0 invisible translate-y-3 group-hover/dropdown:opacity-100 group-hover/dropdown:visible group-hover/dropdown:translate-y-0 transition-all duration-300 z-50 grid grid-cols-4 gap-4">
                        <?php foreach ($basicInfoMenu as $catKey => $cat): ?>
                            <div class="space-y-3 text-left">
                                <h4 class="text-[10px] sm:text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider flex items-center gap-1.5 pb-1.5 border-b border-slate-200/50 dark:border-white/10">
                                    <i class="fa-solid <?php echo $cat['icon']; ?>"></i>
                                    <span><?php echo __($cat['title_key']); ?></span>
                                </h4>
                                <div class="space-y-1">
                                    <?php foreach ($cat['items'] as $item): ?>
                                        <a href="<?php echo htmlspecialchars($item['url']); ?>" <?php echo !empty($item['target']) ? 'target="'.$item['target'].'" rel="noopener"' : ''; ?> class="flex items-center gap-2 px-2 py-1.5 rounded-xl text-[10px] text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50/50 dark:hover:bg-white/5 transition-all duration-200 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400 dark:bg-slate-600 shrink-0"></span>
                                            <span class="truncate"><?php echo __($item['title_key']); ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="<?php echo BASE_URL; ?>news" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out <?php echo $isNewsActive ? 'bg-indigo-600 text-white border border-indigo-500 shadow-md shadow-indigo-500/20 -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg'; ?>">
                    ข่าวสารและประกาศ
                </a>
                <a href="<?php echo BASE_URL; ?>journal" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out <?php echo (strpos($route, '/journal') === 0) ? 'bg-indigo-600 text-white border border-indigo-500 shadow-md shadow-indigo-500/20 -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg'; ?>">
                    <?php echo __('school_journal'); ?>
                </a>

                <!-- Internal Department Groups Mega Menu Dropdown -->
                <div class="relative group/dropdown">
                    <button class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out flex items-center gap-1.5 text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg">
                        <span>เว็บไซต์กลุ่มงาน</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 opacity-70 transition-transform duration-300 group-hover/dropdown:rotate-180"></i>
                    </button>
                    <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-[780px] rounded-2xl glass-modal shadow-2xl p-5 border border-slate-900/5 dark:border-white/10 opacity-0 invisible translate-y-3 group-hover/dropdown:opacity-100 group-hover/dropdown:visible group-hover/dropdown:translate-y-0 transition-all duration-300 z-50 grid grid-cols-3 gap-5">
                        <?php foreach ($internalGroups as $groupKey => $group): ?>
                            <div class="space-y-3 text-left">
                                <h4 class="text-[10px] sm:text-[11px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider flex items-center gap-1.5 pb-1.5 border-b border-slate-200/50 dark:border-white/10">
                                    <i class="fa-solid <?php echo $group['icon']; ?>"></i>
                                    <span><?php echo $group['title']; ?></span>
                                </h4>
                                <div class="space-y-0.5">
                                    <?php foreach ($group['items'] as $item): 
                                        $target = ($item['url'] !== '#') ? 'target="_blank" rel="noopener"' : '';
                                    ?>
                                        <a href="<?php echo htmlspecialchars($item['url']); ?>" <?php echo $target; ?> class="flex items-center gap-2 px-2 py-1.5 rounded-xl text-[10px] text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-indigo-50/50 dark:hover:bg-white/5 transition-all duration-200 font-semibold">
                                            <i class="fa-solid <?php echo $item['icon']; ?> w-4 text-center text-slate-400 dark:text-slate-500 shrink-0 text-[9px]"></i>
                                            <span class="truncate"><?php echo $item['title']; ?></span>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <a href="#" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg">
                    งานประกันคุณภาพฯ
                </a>

                <a href="#" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg">
                    ดาวน์โหลดเอกสาร
                </a>
                
                <a href="<?php echo BASE_URL; ?>ita" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out <?php echo $isItaActive ? 'bg-indigo-600 text-white border border-indigo-500 shadow-md shadow-indigo-500/20 -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg'; ?>">
                    ข้อมูล ITA Online
                </a>
                
                <a href="<?php echo BASE_URL; ?>contact" class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out <?php echo $isContactActive ? 'bg-indigo-600 text-white border border-indigo-500 shadow-md shadow-indigo-500/20 -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg'; ?>">
                    ติดต่อเรา
                </a>
                
                <!-- Portal Dropdown Menu -->
                <div class="relative group/dropdown">
                    <button class="px-4.5 py-2 rounded-xl text-xs font-bold transition-all duration-300 ease-out flex items-center gap-1.5 text-slate-600 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white border border-transparent hover:border-slate-200 dark:hover:border-white/10 hover:-translate-y-0.5 hover:scale-[1.03] hover:shadow-lg">
                        <span>ระบบสารสนเทศ</span>
                        <i class="fa-solid fa-chevron-down text-[10px] ml-0.5 opacity-70 transition-transform duration-300 group-hover/dropdown:rotate-180"></i>
                    </button>
                    <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-[640px] rounded-2xl glass-modal shadow-2xl p-4 border border-slate-900/5 dark:border-white/10 opacity-0 invisible translate-y-3 group-hover/dropdown:opacity-100 group-hover/dropdown:visible group-hover/dropdown:translate-y-0 transition-all duration-300 z-50 grid grid-cols-3 gap-3">
                        <?php foreach ($onlinePortals as $portal): 
                            $url = $portal['url'];
                            $target = ($url !== '#') ? 'target="_blank" rel="noopener"' : '';
                            $badge = trim($portal['badge'] ?? '');
                        ?>
                            <a href="<?php echo htmlspecialchars($url); ?>" <?php echo $target; ?> class="flex items-start gap-2.5 p-2 rounded-xl hover:bg-indigo-600/10 dark:hover:bg-indigo-600/30 transition-all duration-200 group">
                                <i class="fa-solid <?php echo htmlspecialchars($portal['icon']); ?> mt-0.5 shrink-0 text-indigo-600 dark:text-indigo-400 text-sm group-hover:scale-110 transition-transform"></i>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-tight truncate flex items-center gap-1">
                                        <?php echo htmlspecialchars($portal['title']); ?>
                                        <?php if ($badge === 'hot'): ?>
                                            <span class="bg-rose-500 text-white text-[7px] font-black px-1 rounded-sm uppercase tracking-wider animate-pulse">HOT</span>
                                        <?php elseif ($badge === 'new'): ?>
                                            <span class="bg-emerald-500 text-white text-[7px] font-black px-1 rounded-sm uppercase tracking-wider">NEW</span>
                                        <?php elseif ($badge === 'soon'): ?>
                                            <span class="bg-amber-500 text-slate-900 text-[7px] font-black px-1 rounded-sm uppercase tracking-wider">SOON</span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="text-[9px] text-slate-400 dark:text-slate-500 leading-normal line-clamp-1"><?php echo htmlspecialchars($portal['desc']); ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>



    <?php 
    global $activeTickers;
    if (!empty($activeTickers)): 
    ?>
        <!-- Scrolling Urgent News Ticker (Amber Theme with Play/Pause Control) -->
        <div class="bg-amber-500 text-slate-900 py-2.5 px-4 font-semibold overflow-hidden border-b border-amber-600/10 shadow-md">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                <span class="bg-indigo-950 text-white px-4.5 py-1.5 rounded-full font-bold text-xs shrink-0 flex items-center gap-1.5 shadow-md">
                    <i class="fa-solid fa-bullhorn text-[11px] animate-bounce"></i>ข่าวด่วน
                </span>
                <div class="relative overflow-hidden flex-grow h-6 flex items-center">
                    <marquee scrollamount="5" class="w-full text-slate-900 font-bold text-xs" id="ticker-marquee" onmouseover="this.stop()" onmouseout="this.start()">
                        <?php 
                        $messages = [];
                        foreach ($activeTickers as $t) {
                            $msg = htmlspecialchars($t['message']);
                            if (!empty($t['link_url'])) {
                                $messages[] = "<a href='{$t['link_url']}' target='_blank' class='hover:underline hover:text-red-800 transition-colors'>{$msg}</a>";
                            } else {
                                $messages[] = "<span>{$msg}</span>";
                            }
                        }
                        echo implode("&nbsp;&nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;&nbsp;", $messages);
                        ?>
                    </marquee>
                </div>
                <button id="ticker-toggle-btn" onclick="toggleTickerMarquee()" class="w-7 h-7 rounded-full bg-indigo-950 text-white flex items-center justify-center shadow-md hover:bg-slate-900 transition-colors shrink-0 cursor-pointer" title="หยุด/เล่นข่าววิ่ง">
                    <i id="ticker-toggle-icon" class="fa-solid fa-pause text-[10px]"></i>
                </button>
            </div>
        </div>

        <script>
            function toggleTickerMarquee() {
                const marquee = document.getElementById('ticker-marquee');
                const icon = document.getElementById('ticker-toggle-icon');
                if (!marquee || !icon) return;
                
                if (marquee.isStopped) {
                    marquee.start();
                    marquee.isStopped = false;
                    icon.className = 'fa-solid fa-pause text-[10px]';
                } else {
                    marquee.stop();
                    marquee.isStopped = true;
                    icon.className = 'fa-solid fa-play text-[10px]';
                }
            }
        </script>
    <?php endif; ?>

    <!-- Accessibility Handler JavaScript -->
    <script>
        const htmlDoc = document.documentElement;

        // Font Resizing Handler
        const scaleSizes = {
            small: '13px',
            normal: '16px',
            large: '19px'
        };

        function setFontSize(size) {
            if (!scaleSizes[size]) return;
            
            // Set root HTML element font size
            htmlDoc.style.fontSize = scaleSizes[size];
            localStorage.setItem('school_font_size', size);
            
            // Update active state class names on toolbar buttons
            document.querySelectorAll('.font-size-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white');
                btn.classList.add('bg-slate-200', 'dark:bg-white/5', 'text-slate-500', 'dark:text-slate-400');
            });
            
            const targetBtn = document.getElementById(`fs-btn-${size}`);
            if (targetBtn) {
                targetBtn.classList.remove('bg-slate-200', 'dark:bg-white/5', 'text-slate-500', 'dark:text-slate-400');
                targetBtn.classList.add('bg-indigo-600', 'text-white');
            }
        }

        // Dark/Light Theme Switcher Handler
        function toggleDarkMode() {
            const isDarkModeActive = htmlDoc.classList.toggle('dark');
            const targetTheme = isDarkModeActive ? 'dark' : 'light';
            localStorage.setItem('school_theme', targetTheme);
            updateThemeUI(targetTheme);
        }

        function updateThemeUI(theme) {
            const themeIconEl = document.getElementById('theme-icon');
            if (!themeIconEl) return;
            
            if (theme === 'dark') {
                themeIconEl.className = 'fa-solid fa-sun text-yellow-400';
            } else {
                themeIconEl.className = 'fa-solid fa-moon text-slate-400 dark:text-slate-300';
            }
        }

        // Mobile Accordion Toggle
        function toggleMobileAccordion(id) {
            const el = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            if (el) {
                const isOpen = el.classList.contains('grid-rows-[1fr]');
                if (isOpen) {
                    el.classList.remove('grid-rows-[1fr]');
                    el.classList.add('grid-rows-[0fr]');
                    if (icon) icon.classList.remove('rotate-180');
                } else {
                    el.classList.remove('grid-rows-[0fr]');
                    el.classList.add('grid-rows-[1fr]');
                    if (icon) icon.classList.add('rotate-180');
                }
            }
        }

        // Initialize UI settings highlights on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            const currentFS = localStorage.getItem('school_font_size') || 'normal';
            setFontSize(currentFS);
            
            const currentTheme = localStorage.getItem('school_theme') || 'dark';
            updateThemeUI(currentTheme);
        });
    </script>

    <main class="flex-grow">
    <!-- Main content starts here -->
