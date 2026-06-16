<?php
$activeTab = $_GET['tab'] ?? 'news';
?>
<!-- views/admin/dashboard.php -->
<!-- Administrative Control Panel View -->

<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบหลังบ้านแอดมิน | <?php echo SCHOOL_NAME; ?></title>
    
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
    <!-- Tailwind CSS, Bootstrap 5.3, FontAwesome & SweetAlert2 -->
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
                        indigo: {
                            50: '#fff5f5',
                            100: '#ffe3e3',
                            200: '#ffc9c9',
                            300: '#ffa8a8',
                            400: '#ff8787',
                            500: '#ff6b6b',
                            600: '#be123c', // Refined Crimson (Primary Red)
                            700: '#9f1239',
                            800: '#881337',
                            900: '#4c0519',
                            950: '#3f0412',
                        },
                        purple: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b', // Refined Gold (Accent Yellow)
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            950: '#451a03',
                        },
                        violet: {
                            50: '#fffbeb',
                            100: '#fef3c7',
                            200: '#fde68a',
                            300: '#fcd34d',
                            400: '#fbbf24',
                            500: '#f59e0b', // Map violet to Gold for gradient consistency
                            600: '#d97706',
                            700: '#b45309',
                            800: '#92400e',
                            900: '#78350f',
                            950: '#451a03',
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/style.css">

    <!-- Dynamic Favicon Integration -->
    <?php if (!empty(SCHOOL_FAVICON)): ?>
        <link rel="shortcut icon" href="<?php echo UPLOAD_URL . SCHOOL_FAVICON; ?>" type="image/x-icon">
    <?php endif; ?>

    <!-- Immediate Theme Init Script to prevent screen flashing -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('school_theme') || 'dark';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body class="bg-gradient-mesh min-h-screen text-slate-800 dark:text-slate-100 font-sans flex flex-col transition-colors duration-300">
    <!-- Admin Top Navbar -->
    <nav class="sticky top-0 z-50 glass-nav shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Branding -->
                <a href="<?php echo BASE_URL; ?>admin" class="flex items-center gap-3 hover:opacity-90 transition-opacity">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center border border-indigo-400/20 shadow-md">
                        <span class="text-white font-english font-black text-sm"><?php echo SCHOOL_SHORT_NAME; ?></span>
                    </div>
                    <div class="flex flex-col text-left">
                        <span class="text-sm font-bold text-slate-900 dark:text-white tracking-wide leading-tight">ระบบหลังบ้านแอดมิน</span>
                        <span class="text-[9px] text-slate-550 dark:text-slate-400 font-english mt-0.5"><?php echo SCHOOL_NAME_EN; ?></span>
                    </div>
                </a>

                <!-- Desktop Navigation Portal links -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="<?php echo BASE_URL; ?>admin/settings" class="px-4 py-2 bg-indigo-600/10 hover:bg-indigo-600/20 border border-indigo-500/20 rounded-xl text-xs font-semibold text-indigo-600 dark:text-indigo-300 transition-all duration-300">
                        <i class="fa-solid fa-cog mr-1.5"></i>ตั้งค่าระบบ
                    </a>
                    <a href="<?php echo BASE_URL; ?>" target="_blank" class="px-4 py-2 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 hover:border-slate-400 dark:hover:border-white/20 rounded-xl text-xs font-semibold text-slate-700 dark:text-white transition-all duration-300">
                        <i class="fa-solid fa-globe mr-1.5"></i>ดูหน้าเว็บหลัก
                    </a>
                    
                    <!-- Dark/Light Theme Switcher Button -->
                    <button onclick="toggleDarkMode()" class="p-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl text-xs font-semibold text-slate-700 dark:text-white transition-all duration-300 flex items-center justify-center" title="สลับโหมด สีสว่าง/สีมืด">
                        <i id="theme-icon" class="fa-solid fa-moon"></i>
                    </button>
                    
                    <span class="text-xs text-slate-400 dark:text-slate-600 font-english">|</span>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-700 dark:text-slate-300 font-semibold bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 px-3 py-1.5 rounded-xl">
                            <i class="fa-solid fa-user text-indigo-500 dark:text-indigo-400 mr-1.5"></i><?php echo htmlspecialchars($_SESSION['fullname']); ?>
                        </span>
                        <a href="<?php echo BASE_URL; ?>logout" class="px-4 py-2 bg-red-600/10 dark:bg-red-600/20 border border-red-500/20 dark:border-red-500/30 text-red-600 dark:text-red-300 hover:bg-red-600/20 dark:hover:bg-red-600/30 rounded-xl text-xs font-semibold transition-all duration-300" onclick="confirmLogout(event)">
                            <i class="fa-solid fa-sign-out-alt mr-1.5"></i>ออกจากระบบ
                        </a>
                    </div>
                </div>

                <!-- Mobile Header Actions -->
                <div class="flex md:hidden items-center gap-2">
                    <!-- Dark/Light Theme Switcher Button -->
                    <button onclick="toggleDarkMode()" class="p-2.5 hover:bg-slate-200 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl text-xs font-semibold text-slate-700 dark:text-white transition-all duration-200 flex items-center justify-center" title="สลับโหมด สีสว่าง/สีมืด">
                        <i id="theme-icon-mobile" class="fa-solid fa-moon"></i>
                    </button>
                    
                    <!-- Mobile Hamburger Button to open Offcanvas -->
                    <button class="p-2.5 bg-slate-200/50 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 border border-slate-300 dark:border-white/10 rounded-xl text-slate-700 dark:text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas" aria-controls="adminSidebarOffcanvas">
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Offcanvas Sidebar Drawer (Bootstrap 5.3) -->
    <div class="offcanvas offcanvas-start bg-slate-900 dark:bg-darkblue-950 text-white" tabindex="-1" id="adminSidebarOffcanvas" aria-labelledby="adminSidebarOffcanvasLabel" style="width: 280px; border-right: 1px solid rgba(255,255,255,0.08);">
        <div class="offcanvas-header border-b border-white/5 bg-slate-950/50 py-4 px-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center">
                    <span class="text-white font-english font-black text-xs"><?php echo SCHOOL_SHORT_NAME; ?></span>
                </div>
                <span class="text-xs font-bold text-white uppercase tracking-wider font-english">Admin Portal</span>
            </div>
            <button type="button" class="btn-close btn-close-white text-white text-sm" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-3 space-y-4">
            <div class="space-y-1.5">
                <p class="px-3 text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">เมนูจัดการข้อมูล</p>
                
                <a href="?tab=news" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'news' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-regular fa-newspaper text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'news' ? '!text-white' : ''; ?>"></i>
                    <span>จัดการข่าวสารและกิจกรรม</span>
                </a>
                
                <a href="?tab=ita" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'ita' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-chart-bar text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'ita' ? '!text-white' : ''; ?>"></i>
                    <span>ประเมิน ITA Online</span>
                </a>
                
                <a href="?tab=hero" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'hero' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-regular fa-images text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'hero' ? '!text-white' : ''; ?>"></i>
                    <span>รูปสไลด์หน้าแรก (Hero)</span>
                </a>
                
                <a href="?tab=ticker" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'ticker' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-bullhorn text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'ticker' ? '!text-white' : ''; ?>"></i>
                    <span>ข่าวด่วนตัววิ่ง (Ticker)</span>
                </a>
                
                <a href="?tab=about" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'about' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-info-circle text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'about' ? '!text-white' : ''; ?>"></i>
                    <span>แนะนำโรงเรียน (About)</span>
                </a>
                
                <a href="?tab=stats" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'stats' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-database text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'stats' ? '!text-white' : ''; ?>"></i>
                    <span>สถิติและข้อมูลทั่วไป</span>
                </a>
                
                <a href="?tab=schedules" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'schedules' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-calendar-days text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'schedules' ? '!text-white' : ''; ?>"></i>
                    <span>จัดการตารางเรียน/สอน</span>
                </a>
                
                <a href="?tab=documents" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'documents' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-folder-open text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'documents' ? '!text-white' : ''; ?>"></i>
                    <span>จัดการไฟล์คู่มือและระเบียบ</span>
                </a>
                
                <a href="?tab=feedback" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'feedback' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-comments text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'feedback' ? '!text-white' : ''; ?>"></i>
                    <span>จัดการลิงก์รับฟังความคิดเห็น</span>
                </a>
                
                <a href="?tab=complaints" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl transition-all <?php echo $activeTab === 'complaints' ? 'bg-indigo-600 text-white shadow-lg' : 'text-slate-300 hover:bg-white/5 hover:text-white'; ?>">
                    <i class="fa-solid fa-circle-exclamation text-sm shrink-0 w-5 text-center text-indigo-400 <?php echo $activeTab === 'complaints' ? '!text-white' : ''; ?>"></i>
                    <span>จัดการลิงก์รับเรื่องร้องเรียน</span>
                </a>
            </div>

            <hr class="border-white/5 my-3">

            <div class="space-y-2.5 p-3 bg-slate-950/40 rounded-2xl border border-white/5 text-left">
                <div class="flex items-center gap-2 px-1 text-slate-400">
                    <i class="fa-solid fa-user-circle text-indigo-400 text-md"></i>
                    <span class="text-xs truncate font-semibold"><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-1.5">
                    <a href="<?php echo BASE_URL; ?>admin/settings" class="flex items-center justify-center py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold rounded-xl transition-all shadow-md"><i class="fa-solid fa-cog mr-1"></i>ตั้งค่าระบบ</a>
                    <a href="<?php echo BASE_URL; ?>" target="_blank" class="flex items-center justify-center py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-[10px] font-bold rounded-xl border border-white/10 transition-all"><i class="fa-solid fa-globe mr-1"></i>เว็บหลัก</a>
                </div>
                <a href="<?php echo BASE_URL; ?>logout" class="w-full flex items-center justify-center py-2 bg-red-600/10 hover:bg-red-600/20 border border-red-500/20 text-red-400 text-[10px] font-bold rounded-xl transition-all" onclick="confirmLogout(event)"><i class="fa-solid fa-sign-out-alt mr-1"></i>ออกจากระบบ</a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full space-y-8">
        
        <!-- Alerts Display (Success/Error) -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="p-4 bg-emerald-500/10 dark:bg-emerald-900/30 border border-emerald-500/20 dark:border-emerald-500/30 rounded-2xl text-emerald-600 dark:text-emerald-300 text-xs flex items-center gap-2.5 shadow-xl animate-fade-in-up">
                <i class="fa-solid fa-circle-check text-base"></i>
                <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="p-4 bg-red-500/10 dark:bg-red-900/30 border border-red-500/20 dark:border-red-500/30 rounded-2xl text-red-600 dark:text-red-300 text-xs flex items-center gap-2.5 shadow-xl animate-fade-in-up">
                <i class="fa-solid fa-circle-exclamation text-base"></i>
                <span class="font-semibold"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Welcome Banner & Summary Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Summary 1: Welcome -->
            <div class="col-span-1 md:col-span-2 glass-card p-6 rounded-3xl flex flex-col justify-between shadow-lg">
                <div class="space-y-1">
                    <span class="text-[10px] text-indigo-600 dark:text-indigo-400 font-bold uppercase tracking-wider">Control Center</span>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white">สวัสดี, ครู <?php echo htmlspecialchars($_SESSION['fullname']); ?></h1>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed max-w-sm">ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูลหลังบ้าน คุณสามารถโพสต์ข่าวสารอัปเดต และดำเนินการอัปโหลดไฟล์/แก้ไขลิงก์ตัวชี้วัด ITA ได้จากที่นี่</p>
                </div>
                
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <div class="mt-4 pt-2">
                    <a href="<?php echo BASE_URL; ?>admin/settings" class="inline-flex items-center gap-1.5 px-4.5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-indigo-500/20 transition-all duration-200">
                        <i class="fa-solid fa-cog"></i> ตั้งค่าเว็บไซต์พื้นฐาน (Site Settings)
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Summary 2: News Metrics -->
            <div class="glass-card p-6 rounded-3xl flex flex-col justify-between shadow-lg">
                <span class="text-slate-500 dark:text-slate-400 text-[10px] uppercase font-bold tracking-wider">News Count</span>
                <div class="mt-4">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white font-english"><?php echo count($allNews); ?> <span class="text-xs text-slate-500 dark:text-slate-400 font-normal font-sans">โพสต์</span></h2>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">จำนวนข้อมูลข่าวสารและกิจกรรมทั้งหมด</p>
                </div>
            </div>

            <!-- Summary 3: ITA Completion Metrics -->
            <div class="glass-card p-6 rounded-3xl flex flex-col justify-between shadow-lg">
                <span class="text-slate-500 dark:text-slate-400 text-[10px] uppercase font-bold tracking-wider">ITA Progress</span>
                <div class="mt-4">
                    <?php 
                    $completed = $itaMetrics['completed'] ?? 0;
                    $total = $itaMetrics['total'] ?? 43;
                    $percent = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                    ?>
                    <h2 class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 font-english"><?php echo $percent; ?>%</h2>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">เผยแพร่แล้ว <?php echo $completed; ?> จาก <?php echo $total; ?> ตัวชี้วัด</p>
                </div>
            </div>
        </div>

        <!-- Tab Navigation & Content Layout Grid -->
        
        <!-- Mobile Dropdown Selector Menu -->
        <div class="lg:hidden w-full bg-slate-100/80 dark:bg-slate-900/60 border border-slate-200/50 dark:border-white/10 p-4 rounded-2xl flex items-center justify-between gap-3 shadow-lg backdrop-blur-md mb-6 transition-all duration-300">
            <span class="text-xs font-bold text-slate-700 dark:text-slate-300"><i class="fa-solid fa-list-check mr-2 text-indigo-500 animate-pulse"></i>เมนูเลือกจัดการข้อมูล</span>
            <select onchange="window.location.href=this.value" class="glass-input rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 font-semibold cursor-pointer">
                <option value="?tab=news" <?php echo $activeTab === 'news' ? 'selected' : ''; ?>>📰 จัดการข่าวสารและกิจกรรม</option>
                <option value="?tab=ita" <?php echo $activeTab === 'ita' ? 'selected' : ''; ?>>📊 ระบบประเมิน ITA Online</option>
                <option value="?tab=hero" <?php echo $activeTab === 'hero' ? 'selected' : ''; ?>>🖼️ จัดการรูปสไลด์แนะนำ</option>
                <option value="?tab=ticker" <?php echo $activeTab === 'ticker' ? 'selected' : ''; ?>>📢 จัดการข้อความวิ่งด่วน</option>
                <option value="?tab=about" <?php echo $activeTab === 'about' ? 'selected' : ''; ?>>ℹ️ จัดการข้อมูลแนะนำโรงเรียน</option>
                <option value="?tab=stats" <?php echo $activeTab === 'stats' ? 'selected' : ''; ?>>📈 จัดการข้อมูลและสถิติพื้นฐาน</option>
                <option value="?tab=schedules" <?php echo $activeTab === 'schedules' ? 'selected' : ''; ?>>📅 จัดการลิงก์ตารางเรียน/สอน</option>
                <option value="?tab=documents" <?php echo $activeTab === 'documents' ? 'selected' : ''; ?>>📂 จัดการไฟล์คู่มือและระเบียบ</option>
                <option value="?tab=feedback" <?php echo $activeTab === 'feedback' ? 'selected' : ''; ?>>💬 จัดการลิงก์รับฟังความคิดเห็น</option>
                <option value="?tab=complaints" <?php echo $activeTab === 'complaints' ? 'selected' : ''; ?>>⚠️ จัดการลิงก์รับเรื่องร้องเรียน</option>
            </select>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Desktop Left Sidebar -->
            <div class="hidden lg:block lg:col-span-3 space-y-4 sticky top-28 transition-all duration-300">
                <div class="glass-card p-4 rounded-3xl shadow-xl border border-slate-900/5 dark:border-white/10 space-y-1 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl">
                    <p class="px-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">แผงควบคุมหลัก</p>
                    
                    <a href="?tab=news" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'news' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-regular fa-newspaper text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'news' ? '!text-white' : ''; ?>"></i>
                        <span>จัดการข่าวสารและกิจกรรม</span>
                    </a>
                    
                    <a href="?tab=ita" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'ita' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-chart-bar text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'ita' ? '!text-white' : ''; ?>"></i>
                        <span>ประเมิน ITA Online</span>
                    </a>

                    <a href="?tab=hero" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'hero' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-regular fa-images text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'hero' ? '!text-white' : ''; ?>"></i>
                        <span>รูปสไลด์หน้าแรก (Hero)</span>
                    </a>

                    <a href="?tab=ticker" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'ticker' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-bullhorn text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'ticker' ? '!text-white' : ''; ?>"></i>
                        <span>ข่าวด่วนตัววิ่ง (Ticker)</span>
                    </a>

                    <a href="?tab=about" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'about' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-info-circle text-sm shrink-0 w-5 text-center text-indigo-550 text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'about' ? '!text-white' : ''; ?>"></i>
                        <span>แนะนำโรงเรียน (About)</span>
                    </a>

                    <a href="?tab=stats" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'stats' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-database text-sm shrink-0 w-5 text-center text-indigo-550 text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'stats' ? '!text-white' : ''; ?>"></i>
                        <span>สถิติและข้อมูลทั่วไป</span>
                    </a>

                    <a href="?tab=schedules" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'schedules' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-950 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-calendar-days text-sm shrink-0 w-5 text-center text-indigo-550 text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'schedules' ? '!text-white' : ''; ?>"></i>
                        <span>จัดการตารางเรียน/สอน</span>
                    </a>

                    <a href="?tab=documents" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'documents' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-955 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-folder-open text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'documents' ? '!text-white' : ''; ?>"></i>
                        <span>จัดการไฟล์คู่มือและระเบียบ</span>
                    </a>

                    <a href="?tab=feedback" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'feedback' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-955 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-comments text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'feedback' ? '!text-white' : ''; ?>"></i>
                        <span>จัดการลิงก์รับฟังความคิดเห็น</span>
                    </a>

                    <a href="?tab=complaints" class="flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 <?php echo $activeTab === 'complaints' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 transform -translate-y-0.5 scale-[1.02]' : 'text-slate-600 dark:text-slate-400 hover:text-slate-955 dark:hover:text-white hover:bg-slate-200/50 dark:hover:bg-white/5 border border-transparent hover:border-slate-200 dark:hover:border-white/5'; ?>">
                        <i class="fa-solid fa-circle-exclamation text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400 <?php echo $activeTab === 'complaints' ? '!text-white' : ''; ?>"></i>
                        <span>จัดการลิงก์รับเรื่องร้องเรียน</span>
                    </a>
                </div>
            </div>

            <!-- Content Area Column -->
            <div class="lg:col-span-9 space-y-6 w-full">

        <!-- Tab 1 Panel: News Management -->
        <?php if ($activeTab === 'news'): ?>
            <div class="space-y-6">
                <!-- Action Header -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">ตารางข้อมูลข่าวสารและกิจกรรม</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">คุณสามารถ ค้นหา เพิ่ม แก้ไข หรือลบข้อมูลการประชาสัมพันธ์ของโรงเรียนได้</p>
                    </div>
                    <button onclick="openCreateNewsModal()" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                        <i class="fa-solid fa-plus mr-1.5"></i> เพิ่มข่าวสารประชาสัมพันธ์
                    </button>
                </div>

                <!-- News Grid / Table List -->
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[11px] font-semibold text-slate-600 dark:text-slate-300 tracking-wider">
                                    <th class="py-4 px-6 text-center w-24">รูปภาพ</th>
                                    <th class="py-4 px-6">หัวข้อข่าว</th>
                                    <th class="py-4 px-6 text-center w-36">ประเภทข่าว</th>
                                    <th class="py-4 px-6 text-center w-40">วันที่บันทึก</th>
                                    <th class="py-4 px-6 text-center w-36">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs text-slate-600 dark:text-slate-300">
                                <?php if (empty($allNews)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-16">
                                            <i class="fa-regular fa-folder-open text-3xl text-slate-400 mb-3"></i>
                                            <p class="text-slate-500 dark:text-slate-400">ยังไม่มีรายการข่าวสารที่สร้างไว้ในระบบ</p>
                                        </td>
                                    </tr>
                                <?php else: 
                                    foreach ($allNews as $news): 
                                        $catLabel = 'ทั่วไป';
                                        $catColor = 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
                                        if ($news['category'] === 'announcement') {
                                            $catLabel = 'ประกาศ';
                                            $catColor = 'bg-red-500/10 text-red-600 dark:text-red-400 border-red-500/20';
                                        } elseif ($news['category'] === 'activity') {
                                            $catLabel = 'กิจกรรม';
                                            $catColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
                                        }
                                ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <!-- Image Thumbnail -->
                                        <td class="py-3 px-6 text-center">
                                            <div class="w-12 h-12 rounded-lg bg-slate-200 dark:bg-slate-950 border border-slate-300 dark:border-white/10 overflow-hidden mx-auto flex items-center justify-center shadow-inner">
                                                <?php if (!empty($news['image_url'])): ?>
                                                    <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="thumbnail" class="w-full h-full object-cover">
                                                <?php else: ?>
                                                    <i class="fa-regular fa-image text-slate-400 dark:text-slate-600"></i>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!-- Title -->
                                        <td class="py-3 px-6 font-semibold text-slate-800 dark:text-white max-w-sm truncate">
                                            <?php echo htmlspecialchars($news['title']); ?>
                                        </td>
                                        <!-- Category -->
                                        <td class="py-3 px-6 text-center">
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold border <?php echo $catColor; ?>">
                                                <?php echo $catLabel; ?>
                                            </span>
                                        </td>
                                        <!-- Created At -->
                                        <td class="py-3 px-6 text-center text-slate-500 dark:text-slate-400 font-english">
                                            <?php echo date('d/m/Y H:i', strtotime($news['created_at'])); ?>
                                        </td>
                                        <!-- Actions -->
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="openEditNewsModal(<?php echo htmlspecialchars(json_encode($news)); ?>)" class="p-2 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200" title="แก้ไข">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <a href="<?php echo BASE_URL; ?>admin/news/delete?id=<?php echo $news['id']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบข่าวสารประชาสัมพันธ์นี้ใช่หรือไม่? ข้อมูลทั้งหมดรวมถึงรูปภาพจะถูกลบออกจากระบบอย่างถาวร')" class="p-2 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl hover:text-red-700 dark:hover:text-red-300 transition-all duration-200" title="ลบ">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                    endforeach; 
                                endif; 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- News Mobile Card List -->
                    <div class="block md:hidden space-y-4 p-4 bg-slate-50/50 dark:bg-slate-950/20 rounded-b-3xl">
                        <?php if (empty($allNews)): ?>
                            <div class="text-center py-12">
                                <i class="fa-regular fa-folder-open text-3xl text-slate-400 mb-2"></i>
                                <p class="text-slate-500 dark:text-slate-400 text-xs">ยังไม่มีรายการข่าวสารที่สร้างไว้ในระบบ</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($allNews as $news): 
                                $catLabel = 'ทั่วไป';
                                $catColor = 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
                                if ($news['category'] === 'announcement') {
                                    $catLabel = 'ประกาศ';
                                    $catColor = 'bg-red-500/10 text-red-600 dark:text-red-400 border-red-500/20';
                                } elseif ($news['category'] === 'activity') {
                                    $catLabel = 'กิจกรรม';
                                    $catColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
                                }
                            ?>
                                <div class="p-4 bg-white/60 dark:bg-slate-900/60 border border-slate-200 dark:border-white/10 rounded-2xl space-y-3 shadow-sm hover:border-indigo-500/30 transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-14 h-14 rounded-xl bg-slate-200 dark:bg-slate-950 border border-slate-300 dark:border-white/10 overflow-hidden flex-shrink-0 flex items-center justify-center shadow-inner">
                                            <?php if (!empty($news['image_url'])): ?>
                                                <img src="<?php echo htmlspecialchars($news['image_url']); ?>" alt="thumbnail" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <i class="fa-regular fa-image text-slate-400 dark:text-slate-600 text-lg"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <div class="flex items-center justify-between">
                                                <span class="px-2 py-0.5 rounded text-[9px] font-semibold border <?php echo $catColor; ?>">
                                                    <?php echo $catLabel; ?>
                                                </span>
                                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-english">
                                                    <?php echo date('d/m/Y H:i', strtotime($news['created_at'])); ?>
                                                </span>
                                            </div>
                                            <h4 class="font-bold text-slate-800 dark:text-white text-xs truncate mt-2" title="<?php echo htmlspecialchars($news['title']); ?>">
                                                <?php echo htmlspecialchars($news['title']); ?>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-white/5">
                                        <button onclick="openEditNewsModal(<?php echo htmlspecialchars(json_encode($news)); ?>)" class="px-3 py-1.5 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="แก้ไข">
                                            <i class="fa-solid fa-edit text-xs"></i> แก้ไข
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>admin/news/delete?id=<?php echo $news['id']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบข่าวสารประชาสัมพันธ์นี้ใช่หรือไม่? ข้อมูลทั้งหมดรวมถึงรูปภาพจะถูกลบออกจากระบบอย่างถาวร')" class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="ลบ">
                                            <i class="fa-solid fa-trash text-xs"></i> ลบ
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 2 Panel: ITA Management -->
        <?php if ($activeTab === 'ita'): ?>
            <div class="space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">ระบบจัดการตัวชี้วัดความโปร่งใส ITA (O1 - O43)</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">ระบุคำอธิบาย รายละเอียดลิงก์ภายนอก หรืออัปโหลดไฟล์เอกสารประกอบตามตัวชี้วัด OIT แต่ละข้อ</p>
                </div>

                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[11px] font-semibold text-slate-600 dark:text-slate-300 tracking-wider">
                                    <th class="py-4 px-6 text-center w-24">รหัส OIT</th>
                                    <th class="py-4 px-6">ชื่อตัวชี้วัด / หัวข้อประเมิน</th>
                                    <th class="py-4 px-6">ข้อมูลที่เผยแพร่</th>
                                    <th class="py-4 px-6 text-center w-24">สถานะ</th>
                                    <th class="py-4 px-6 text-center w-24">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs text-slate-600 dark:text-slate-300">
                                <?php foreach ($itaItems as $item): ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <!-- Code -->
                                        <td class="py-3.5 px-6 text-center font-english font-bold text-indigo-600 dark:text-indigo-400">
                                            <span class="bg-indigo-500/10 px-2.5 py-1.5 rounded-lg border border-indigo-500/20">
                                                <?php echo htmlspecialchars($item['code']); ?>
                                            </span>
                                        </td>
                                        <!-- Name -->
                                        <td class="py-3.5 px-6 font-semibold text-slate-800 dark:text-white max-w-sm truncate">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </td>
                                        <!-- Published Info status -->
                                        <td class="py-3.5 px-6 space-y-1">
                                            <?php if (!empty($item['file_path'])): ?>
                                                <div class="flex items-center gap-1.5 text-[11px] text-red-500 dark:text-red-400">
                                                    <i class="fa-regular fa-file-pdf shrink-0"></i>
                                                    <span class="truncate max-w-[200px]"><?php echo basename($item['file_path']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($item['link_url'])): ?>
                                                <div class="flex items-center gap-1.5 text-[11px] text-indigo-600 dark:text-indigo-400">
                                                    <i class="fa-solid fa-link shrink-0"></i>
                                                    <span class="truncate max-w-[200px]"><?php echo htmlspecialchars($item['link_url']); ?></span>
                                                </div>
                                            <?php endif; ?>

                                            <?php if (empty($item['file_path']) && empty($item['link_url'])): ?>
                                                <span class="text-slate-400 dark:text-slate-500 italic text-[10px]">ยังไม่ได้อัปโหลดข้อมูล</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Status Badge -->
                                        <td class="py-3.5 px-6 text-center">
                                            <?php if ($item['status'] === 'published'): ?>
                                                <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-[10px] font-semibold">เผยแพร่</span>
                                            <?php else: ?>
                                                <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 text-[10px] font-semibold">ฉบับร่าง</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Action -->
                                        <td class="py-3.5 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="openEditItaModal(<?php echo htmlspecialchars(json_encode($item)); ?>)" class="p-2 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200" title="แก้ไข">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <a href="<?php echo BASE_URL; ?>admin/ita/delete?code=<?php echo $item['code']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบไฟล์แนบและลิงก์เชื่อมโยงทั้งหมดของตัวชี้วัด <?php echo $item['code']; ?> ใช่หรือไม่?')" class="p-2 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl hover:text-red-700 dark:hover:text-red-300 transition-all duration-200" title="ลบข้อมูล">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ITA Mobile Card List -->
                    <div class="block md:hidden space-y-4 p-4 bg-slate-50/50 dark:bg-slate-950/20 rounded-b-3xl">
                        <?php foreach ($itaItems as $item): ?>
                            <div class="p-4 bg-white/60 dark:bg-slate-900/60 border border-slate-200 dark:border-white/10 rounded-2xl space-y-3 shadow-sm hover:border-indigo-500/30 transition-all duration-300">
                                <div class="flex items-start justify-between gap-2.5">
                                    <span class="bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-black px-2.5 py-1 border border-indigo-500/20 rounded-lg font-english shrink-0">
                                        <?php echo htmlspecialchars($item['code']); ?>
                                    </span>
                                    <div class="flex-grow min-w-0">
                                        <h4 class="font-bold text-slate-800 dark:text-white text-xs leading-normal">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </h4>
                                        <div class="mt-2 space-y-1">
                                            <?php if (!empty($item['file_path'])): ?>
                                                <div class="flex items-center gap-1 text-[10px] text-red-500 dark:text-red-400">
                                                    <i class="fa-regular fa-file-pdf shrink-0"></i>
                                                    <span class="truncate max-w-[180px]"><?php echo basename($item['file_path']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($item['link_url'])): ?>
                                                <div class="flex items-center gap-1 text-[10px] text-indigo-600 dark:text-indigo-400">
                                                    <i class="fa-solid fa-link shrink-0"></i>
                                                    <span class="truncate max-w-[180px]"><?php echo htmlspecialchars($item['link_url']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (empty($item['file_path']) && empty($item['link_url'])): ?>
                                                <span class="text-slate-400 dark:text-slate-500 italic text-[10px]">ยังไม่ได้อัปโหลดข้อมูล</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <?php if ($item['status'] === 'published'): ?>
                                            <span class="px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-[9px] font-semibold">เผยแพร่</span>
                                        <?php else: ?>
                                            <span class="px-2 py-0.5 rounded bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 text-[9px] font-semibold">ฉบับร่าง</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-white/5">
                                    <button onclick="openEditItaModal(<?php echo htmlspecialchars(json_encode($item)); ?>)" class="px-3 py-1.5 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="แก้ไข">
                                        <i class="fa-solid fa-edit text-xs"></i> แก้ไข
                                    </button>
                                    <a href="<?php echo BASE_URL; ?>admin/ita/delete?code=<?php echo $item['code']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบไฟล์แนบและลิงก์เชื่อมโยงทั้งหมดของตัวชี้วัด <?php echo $item['code']; ?> ใช่หรือไม่?')" class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="ลบข้อมูล">
                                        <i class="fa-solid fa-trash text-xs"></i> ลบ
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 3 Panel: Hero Carousel Management -->
        <?php if ($activeTab === 'hero'): ?>
            <div class="space-y-6">
                <!-- Action Header -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">ตารางข้อมูลสไลด์หน้าแรก (Hero Carousel)</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">คุณสามารถ เพิ่ม ลบ แก้ไข หรือเปิด/ปิดการแสดงผลรูปภาพสไลด์แนะนำของโรงเรียนได้จากตารางนี้</p>
                    </div>
                    <button onclick="openCreateHeroModal()" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                        <i class="fa-solid fa-plus mr-1.5"></i> เพิ่มรูปภาพสไลด์
                    </button>
                </div>

                <!-- Hero Grid / Table List -->
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[11px] font-semibold text-slate-600 dark:text-slate-300 tracking-wider">
                                    <th class="py-4 px-6 text-center w-24">รูปภาพ</th>
                                    <th class="py-4 px-6">ชื่ออ้างอิงสไลด์</th>
                                    <th class="py-4 px-6 text-center w-32">ลำดับการแสดงผล</th>
                                    <th class="py-4 px-6 text-center w-36">สถานะการแสดงผล</th>
                                    <th class="py-4 px-6 text-center w-36">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs text-slate-600 dark:text-slate-300">
                                <?php if (empty($allHeroes)): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-16">
                                            <i class="fa-regular fa-images text-3xl text-slate-400 mb-3"></i>
                                            <p class="text-slate-500 dark:text-slate-400">ยังไม่มีข้อมูลรูปภาพสไลด์ในระบบ</p>
                                        </td>
                                    </tr>
                                <?php else: 
                                    foreach ($allHeroes as $hero): 
                                ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <!-- Slide Image Thumbnail -->
                                        <td class="py-3 px-6 text-center">
                                            <div class="w-20 h-10 rounded-lg bg-slate-200 dark:bg-slate-950 border border-slate-300 dark:border-white/10 overflow-hidden mx-auto flex items-center justify-center shadow-inner">
                                                <img src="<?php echo htmlspecialchars($hero['image_url']); ?>" alt="slide thumbnail" class="w-full h-full object-cover">
                                            </div>
                                        </td>
                                        <!-- Slide Title -->
                                        <td class="py-3 px-6 font-semibold text-slate-800 dark:text-white max-w-sm truncate">
                                            <?php echo !empty($hero['title']) ? htmlspecialchars($hero['title']) : '<span class="text-slate-400 italic">ไม่ระบุชื่อสไลด์</span>'; ?>
                                        </td>
                                        <!-- Display Order -->
                                        <td class="py-3 px-6 text-center font-english font-semibold">
                                            <?php echo (int)$hero['display_order']; ?>
                                        </td>
                                        <!-- Display Status Badge / Toggle Link -->
                                        <td class="py-3 px-6 text-center">
                                            <a href="<?php echo BASE_URL; ?>admin/hero/toggle?id=<?php echo $hero['id']; ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-semibold border transition-all duration-300 <?php echo $hero['status'] === 'active' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-500 dark:text-slate-400 border-slate-500/20 hover:bg-slate-500/20'; ?>" title="คลิกเพื่อเปิด/ปิดการแสดงผลสไลด์">
                                                <span class="flex h-1.5 w-1.5 relative">
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 <?php echo $hero['status'] === 'active' ? 'bg-emerald-500' : 'bg-slate-400'; ?>"></span>
                                                </span>
                                                <?php echo $hero['status'] === 'active' ? 'แสดงผล (Active)' : 'ซ่อนไว้ (Inactive)'; ?>
                                            </a>
                                        </td>
                                        <!-- Actions -->
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="openEditHeroModal(<?php echo htmlspecialchars(json_encode($hero)); ?>)" class="p-2 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200" title="แก้ไข">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <a href="<?php echo BASE_URL; ?>admin/hero/delete?id=<?php echo $hero['id']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบรูปภาพสไลด์แนะนำนี้ใช่หรือไม่? ไฟล์รูปภาพจะถูกลบออกจากเซิร์ฟเวอร์ด้วย')" class="p-2 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl hover:text-red-700 dark:hover:text-red-300 transition-all duration-200" title="ลบ">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                    endforeach; 
                                    endif; 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Hero Mobile Card List -->
                    <div class="block md:hidden space-y-4 p-4 bg-slate-50/50 dark:bg-slate-950/20 rounded-b-3xl">
                        <?php if (empty($allHeroes)): ?>
                            <div class="text-center py-12">
                                <i class="fa-regular fa-images text-3xl text-slate-400 mb-2"></i>
                                <p class="text-slate-500 dark:text-slate-400 text-xs">ยังไม่มีข้อมูลรูปภาพสไลด์ในระบบ</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($allHeroes as $hero): ?>
                                <div class="p-4 bg-white/60 dark:bg-slate-900/60 border border-slate-200 dark:border-white/10 rounded-2xl space-y-3 shadow-sm hover:border-indigo-500/30 transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-24 h-12 rounded-lg bg-slate-200 dark:bg-slate-950 border border-slate-300 dark:border-white/10 overflow-hidden flex-shrink-0 flex items-center justify-center shadow-inner">
                                            <img src="<?php echo htmlspecialchars($hero['image_url']); ?>" alt="slide thumbnail" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <h4 class="font-bold text-slate-800 dark:text-white text-xs truncate">
                                                <?php echo !empty($hero['title']) ? htmlspecialchars($hero['title']) : '<span class="text-slate-400 italic">ไม่ระบุชื่อสไลด์</span>'; ?>
                                            </h4>
                                            <div class="flex items-center justify-between mt-2">
                                                <span class="text-[10px] text-slate-500 dark:text-slate-450 font-semibold font-english">
                                                    ลำดับ: <?php echo (int)$hero['display_order']; ?>
                                                </span>
                                                <a href="<?php echo BASE_URL; ?>admin/hero/toggle?id=<?php echo $hero['id']; ?>" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[9px] font-bold border transition-all duration-300 <?php echo $hero['status'] === 'active' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20' : 'bg-slate-500/10 text-slate-500 dark:text-slate-400 border-slate-500/20'; ?>">
                                                    <?php echo $hero['status'] === 'active' ? 'แสดงผล' : 'ซ่อน'; ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-white/5">
                                        <button onclick="openEditHeroModal(<?php echo htmlspecialchars(json_encode($hero)); ?>)" class="px-3 py-1.5 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="แก้ไข">
                                            <i class="fa-solid fa-edit text-xs"></i> แก้ไข
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>admin/hero/delete?id=<?php echo $hero['id']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบรูปภาพสไลด์แนะนำนี้ใช่หรือไม่? ไฟล์รูปภาพจะถูกลบออกจากเซิร์ฟเวอร์ด้วย')" class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="ลบ">
                                            <i class="fa-solid fa-trash text-xs"></i> ลบ
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 4 Panel: Urgent News Ticker Management -->
        <?php if ($activeTab === 'ticker'): ?>
            <div class="space-y-6 animate-fade-in-up">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">ข่าวด่วนวิ่งใต้แถบเมนู (Scrolling Ticker)</h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs">คุณสามารถ เพิ่ม ลบ แก้ไข ข้อมูลที่เป็นข้อความวิ่งข่าวด่วนแสดงใต้เมนูเพื่อแจ้งเตือนเรื่องสำคัญ</p>
                    </div>
                    <button onclick="openCreateTickerModal()" class="px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                        <i class="fa-solid fa-plus mr-1.5"></i> เพิ่มข่าวด่วนวิ่ง
                    </button>
                </div>

                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[11px] font-semibold text-slate-600 dark:text-slate-300 tracking-wider">
                                    <th class="py-4 px-6">ข้อความข่าววิ่ง</th>
                                    <th class="py-4 px-6">ลิงก์คลิกไปหน้าอื่น (ถ้ามี)</th>
                                    <th class="py-4 px-6 text-center w-36">สถานะการแสดงผล</th>
                                    <th class="py-4 px-6 text-center w-36">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs text-slate-600 dark:text-slate-300">
                                <?php if (empty($allTickers)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-16">
                                            <i class="fa-solid fa-bullhorn text-3xl text-slate-400 mb-3"></i>
                                            <p class="text-slate-500 dark:text-slate-400">ยังไม่มีข้อมูลข้อความข่าวด่วนในระบบ</p>
                                        </td>
                                    </tr>
                                <?php else: 
                                    foreach ($allTickers as $ticker): 
                                ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <td class="py-3 px-6 font-semibold text-slate-800 dark:text-white max-w-md truncate">
                                            <?php echo htmlspecialchars($ticker['message']); ?>
                                        </td>
                                        <td class="py-3 px-6 text-slate-500 dark:text-slate-400 truncate max-w-xs">
                                            <?php echo !empty($ticker['link_url']) ? '<a href="'.htmlspecialchars($ticker['link_url']).'" target="_blank" class="text-indigo-500 hover:underline">'.htmlspecialchars($ticker['link_url']).'</a>' : '<span class="text-slate-400 italic">ไม่มีลิงก์</span>'; ?>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <a href="<?php echo BASE_URL; ?>admin/ticker/toggle?id=<?php echo $ticker['id']; ?>" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-[10px] font-semibold border transition-all duration-300 <?php echo (int)$ticker['is_active'] === 1 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20 hover:bg-emerald-500/20' : 'bg-slate-500/10 text-slate-500 dark:text-slate-400 border-slate-500/20 hover:bg-slate-500/20'; ?>" title="คลิกเพื่อสลับแสดง/ซ่อน">
                                                <span class="flex h-1.5 w-1.5 relative">
                                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 <?php echo (int)$ticker['is_active'] === 1 ? 'bg-emerald-500' : 'bg-slate-400'; ?>"></span>
                                                </span>
                                                <?php echo (int)$ticker['is_active'] === 1 ? 'แสดงผล (Active)' : 'ซ่อนไว้ (Inactive)'; ?>
                                            </a>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="openEditTickerModal(<?php echo htmlspecialchars(json_encode($ticker)); ?>)" class="p-2 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200" title="แก้ไข">
                                                    <i class="fa-solid fa-edit"></i>
                                                </button>
                                                <a href="<?php echo BASE_URL; ?>admin/ticker/delete?id=<?php echo $ticker['id']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบข้อความวิ่งแจ้งเตือนข่าวด่วนนี้ใช่หรือไม่?')" class="p-2 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl hover:text-red-700 dark:hover:text-red-300 transition-all duration-200" title="ลบ">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php 
                                    endforeach; 
                                    endif; 
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Ticker Mobile Card List -->
                    <div class="block md:hidden space-y-4 p-4 bg-slate-50/50 dark:bg-slate-950/20 rounded-b-3xl">
                        <?php if (empty($allTickers)): ?>
                            <div class="text-center py-12">
                                <i class="fa-solid fa-bullhorn text-3xl text-slate-400 mb-2"></i>
                                <p class="text-slate-500 dark:text-slate-400 text-xs">ยังไม่มีข้อมูลข้อความข่าวด่วนในระบบ</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($allTickers as $ticker): ?>
                                <div class="p-4 bg-white/60 dark:bg-slate-900/60 border border-slate-200 dark:border-white/10 rounded-2xl space-y-3 shadow-sm hover:border-indigo-500/30 transition-all duration-300">
                                    <div class="space-y-1.5">
                                        <h4 class="font-bold text-slate-800 dark:text-white text-xs leading-normal">
                                            <?php echo htmlspecialchars($ticker['message']); ?>
                                        </h4>
                                        <?php if (!empty($ticker['link_url'])): ?>
                                            <p class="text-[10px] text-indigo-500 truncate mt-1">
                                                <i class="fa-solid fa-link mr-1"></i>
                                                <a href="<?php echo htmlspecialchars($ticker['link_url']); ?>" target="_blank" class="hover:underline"><?php echo htmlspecialchars($ticker['link_url']); ?></a>
                                            </p>
                                        <?php endif; ?>
                                        <div class="flex items-center justify-between pt-1.5">
                                            <span class="text-[9px] text-slate-400">สถานะการแสดงผล:</span>
                                            <a href="<?php echo BASE_URL; ?>admin/ticker/toggle?id=<?php echo $ticker['id']; ?>" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl text-[9px] font-bold border transition-all duration-300 <?php echo (int)$ticker['is_active'] === 1 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20' : 'bg-slate-500/10 text-slate-500 dark:text-slate-400 border-slate-500/20'; ?>">
                                                <?php echo (int)$ticker['is_active'] === 1 ? 'แสดงผล' : 'ซ่อน'; ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2 pt-2 border-t border-slate-100 dark:border-white/5">
                                        <button onclick="openEditTickerModal(<?php echo htmlspecialchars(json_encode($ticker)); ?>)" class="px-3 py-1.5 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="แก้ไข">
                                            <i class="fa-solid fa-edit text-xs"></i> แก้ไข
                                        </button>
                                        <a href="<?php echo BASE_URL; ?>admin/ticker/delete?id=<?php echo $ticker['id']; ?>" onclick="confirmDelete(event, 'คุณต้องการลบข้อความวิ่งแจ้งเตือนข่าวด่วนนี้ใช่หรือไม่?')" class="px-3 py-1.5 bg-red-600/10 hover:bg-red-600/30 text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center gap-1" title="ลบ">
                                            <i class="fa-solid fa-trash text-xs"></i> ลบ
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 5 Panel: About School Management -->
        <?php if ($activeTab === 'about'): ?>
            <div class="space-y-6">
                <!-- Action Header -->
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">ระบบจัดการข้อมูลแนะนำโรงเรียน (About School)</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">แก้ไขข้อมูลประวัติความเป็นมา วิสัยทัศน์/พันธกิจ เพลงประจำโรงเรียน และโครงสร้างที่แสดงบนหน้าหลักและเมนูแนะนำโรงเรียน</p>
                </div>

                <!-- About Info Table List -->
                <div class="glass-card rounded-3xl overflow-hidden shadow-xl">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[11px] font-semibold text-slate-600 dark:text-slate-300 tracking-wider">
                                    <th class="py-4 px-6 w-1/4">หัวข้อข้อมูลแนะนำ</th>
                                    <th class="py-4 px-6">ตัวอย่างเนื้อหา (Preview)</th>
                                    <th class="py-4 px-6 text-center w-40">แก้ไขล่าสุด</th>
                                    <th class="py-4 px-6 text-center w-40">การจัดการ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sectionNames = [
                                    'history' => 'ประวัติความเป็นมา (History)',
                                    'vision_mission' => 'วิสัยทัศน์และพันธกิจ (Vision & Mission)',
                                    'symbol' => 'ตราสัญลักษณ์โรงเรียน (School Symbol)',
                                    'colors' => 'สีประจำโรงเรียน (School Colors)',
                                    'song' => 'เพลงประจำโรงเรียน (School Song)',
                                    'structure' => 'โครงสร้างองค์กร (School Structure)'
                                ];

                                if (!empty($aboutSections)):
                                    foreach ($aboutSections as $section):
                                        $key = $section['section_key'];
                                        $title = $sectionNames[$key] ?? $key;
                                ?>
                                    <!-- Store original values safely in hidden textareas to prevent JS injection/quoting issues -->
                                    <textarea id="about-content-th-<?php echo htmlspecialchars($key); ?>" class="hidden"><?php echo htmlspecialchars($section['content_th']); ?></textarea>
                                    <textarea id="about-content-en-<?php echo htmlspecialchars($key); ?>" class="hidden"><?php echo htmlspecialchars($section['content_en']); ?></textarea>

                                    <tr class="border-b border-slate-200 dark:border-white/10 hover:bg-slate-100/50 dark:hover:bg-white/5 transition-colors">
                                        <td class="py-4 px-6 font-semibold text-xs text-slate-900 dark:text-white">
                                            <?php echo htmlspecialchars($title); ?>
                                            <div class="text-[9px] text-slate-400 dark:text-slate-500 font-mono mt-0.5"><?php echo htmlspecialchars($key); ?></div>
                                        </td>
                                        <td class="py-4 px-6 text-xs text-slate-600 dark:text-slate-300">
                                            <div class="line-clamp-2 max-w-xl">
                                                <span class="text-indigo-600 dark:text-indigo-400 font-semibold mr-1">TH:</span><?php echo htmlspecialchars(mb_strimwidth(strip_tags($section['content_th']), 0, 120, '...')); ?>
                                            </div>
                                            <div class="line-clamp-2 max-w-xl mt-1 text-slate-400">
                                                <span class="text-indigo-400/80 font-semibold mr-1">EN:</span><?php echo htmlspecialchars(mb_strimwidth(strip_tags($section['content_en']), 0, 120, '...')); ?>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-center text-xs font-mono text-slate-500 dark:text-slate-400">
                                            <?php echo date('d/m/Y H:i', strtotime($section['updated_at'])); ?>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <button onclick="openEditAboutModal(<?php echo htmlspecialchars(json_encode([
                                                'key' => $key,
                                                'title' => $title
                                            ])); ?>)" class="px-3 py-2 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl hover:text-indigo-700 dark:hover:text-indigo-300 transition-all duration-200" title="แก้ไขข้อมูล">
                                                <i class="fa-solid fa-edit mr-1"></i> แก้ไข
                                            </button>
                                        </td>
                                    </tr>
                                <?php 
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-xs text-slate-400 dark:text-slate-500">
                                            ไม่พบข้อมูลในตาราง school_info
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- About Mobile Card List -->
                    <div class="block md:hidden space-y-4 p-4 bg-slate-50/50 dark:bg-slate-950/20 rounded-b-3xl">
                        <?php if (!empty($aboutSections)): ?>
                            <?php foreach ($aboutSections as $section):
                                $key = $section['section_key'];
                                $title = $sectionNames[$key] ?? $key;
                            ?>
                                <div class="p-4 bg-white/60 dark:bg-slate-900/60 border border-slate-200 dark:border-white/10 rounded-2xl space-y-3 shadow-sm hover:border-indigo-500/30 transition-all duration-300">
                                    <div>
                                        <h4 class="font-bold text-slate-800 dark:text-white text-xs leading-normal">
                                            <?php echo htmlspecialchars($title); ?>
                                        </h4>
                                        <span class="text-[9px] text-slate-400 font-mono"><?php echo htmlspecialchars($key); ?></span>
                                    </div>
                                    <div class="space-y-1.5 text-[11px] text-slate-600 dark:text-slate-300">
                                        <div>
                                            <span class="text-indigo-600 dark:text-indigo-400 font-bold mr-1">TH:</span>
                                            <span class="line-clamp-2"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($section['content_th']), 0, 100, '...')); ?></span>
                                        </div>
                                        <div class="text-slate-400">
                                            <span class="text-indigo-400/80 font-bold mr-1">EN:</span>
                                            <span class="line-clamp-2"><?php echo htmlspecialchars(mb_strimwidth(strip_tags($section['content_en']), 0, 100, '...')); ?></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-1 text-[10px] text-slate-400 font-mono">
                                        <span>แก้ไขล่าสุด:</span>
                                        <span><?php echo date('d/m/Y H:i', strtotime($section['updated_at'])); ?></span>
                                    </div>
                                    <div class="flex justify-end pt-2 border-t border-slate-100 dark:border-white/5">
                                        <button onclick="openEditAboutModal(<?php echo htmlspecialchars(json_encode(['key' => $key, 'title' => $title])); ?>)" class="w-full py-2 bg-indigo-600/10 hover:bg-indigo-600/30 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-xl text-[10px] font-bold transition-all flex items-center justify-center gap-1" title="แก้ไขข้อมูล">
                                            <i class="fa-solid fa-edit text-xs"></i> แก้ไขข้อมูลแนะนำ
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 6 Panel: School Statistics Configuration -->
        <?php if ($activeTab === 'stats'): 
            $infoModel = new Info();
            $generalStats = $infoModel->getGeneralStats();
            
            // Extract stats with fallback defaults
            $founded_date_th = $generalStats['founded_date_th']['stat_value'] ?? '1 มิถุนายน พ.ศ. 2482';
            $founded_date_en = $generalStats['founded_date_en']['stat_value'] ?? 'June 1, 1939';
            $education_levels_th = $generalStats['education_levels_th']['stat_value'] ?? 'มัธยมศึกษาปีที่ 1 - 6';
            $education_levels_en = $generalStats['education_levels_en']['stat_value'] ?? 'Mathayom 1 - 6';
            $address_th = $generalStats['address_th']['stat_value'] ?? '';
            $address_en = $generalStats['address_en']['stat_value'] ?? '';
            $phone = $generalStats['phone']['stat_value'] ?? '';
            $email = $generalStats['email']['stat_value'] ?? '';
            $coordinator_th = $generalStats['coordinator_th']['stat_value'] ?? '';
            $coordinator_en = $generalStats['coordinator_en']['stat_value'] ?? '';
        ?>
            <div class="space-y-6 animate-fade-in-up">
                <!-- Action Header -->
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">จัดการข้อมูลและสถิติพื้นฐานโรงเรียน</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">แก้ไขข้อมูลพื้นฐานทั่วไป และข้อมูลติดต่อผู้ประสานงานสำหรับแสดงผลบนแผงหน้าจอข้อมูลสารสนเทศ (School Information Dashboard)</p>
                </div>

                <div class="glass-card rounded-3xl p-6 md:p-8 shadow-xl max-w-4xl">
                    <form action="<?php echo BASE_URL; ?>admin/statistics/update" method="POST" class="space-y-6">
                        <!-- Group 1: General Info -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 border-b border-slate-100 dark:border-white/5 pb-2">
                                <i class="fa-solid fa-circle-info mr-1.5"></i>ข้อมูลทั่วไปสถานศึกษา
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">วันก่อตั้งโรงเรียน (ภาษาไทย)</label>
                                    <input type="text" name="founded_date_th" value="<?php echo htmlspecialchars($founded_date_th); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">วันก่อตั้งโรงเรียน (ภาษาอังกฤษ)</label>
                                    <input type="text" name="founded_date_en" value="<?php echo htmlspecialchars($founded_date_en); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ระดับชั้นที่เปิดสอน (ภาษาไทย)</label>
                                    <input type="text" name="education_levels_th" value="<?php echo htmlspecialchars($education_levels_th); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ระดับชั้นที่เปิดสอน (ภาษาอังกฤษ)</label>
                                    <input type="text" name="education_levels_en" value="<?php echo htmlspecialchars($education_levels_en); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ที่ตั้งสถานศึกษา (ภาษาไทย)</label>
                                    <textarea name="address_th" required rows="2" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"><?php echo htmlspecialchars($address_th); ?></textarea>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ที่ตั้งสถานศึกษา (ภาษาอังกฤษ)</label>
                                    <textarea name="address_en" required rows="2" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"><?php echo htmlspecialchars($address_en); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Group 2: Contact Info -->
                        <div class="space-y-4 pt-4">
                            <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 border-b border-slate-100 dark:border-white/5 pb-2">
                                <i class="fa-solid fa-address-book mr-1.5"></i>ข้อมูลติดต่อและประสานงาน
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เบอร์โทรศัพท์ติดต่อ</label>
                                    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">อีเมลติดต่อ</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ผู้ประสานงาน (ภาษาไทย)</label>
                                    <input type="text" name="coordinator_th" value="<?php echo htmlspecialchars($coordinator_th); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ผู้ประสานงาน (ภาษาอังกฤษ)</label>
                                    <input type="text" name="coordinator_en" value="<?php echo htmlspecialchars($coordinator_en); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-slate-100 dark:border-white/5">
                            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-save"></i> บันทึกข้อมูลสถิติ
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 7 Panel: Manage Schedules (Google Drive Links) -->
        <?php if ($activeTab === 'schedules'): 
            $settingModel = new Setting();
            $settings = $settingModel->get_all_settings();
            
            $studentLink = $settings['student_schedule_link'] ?? '';
            $teacherLink = $settings['teacher_schedule_link'] ?? '';
        ?>
            <div class="space-y-6 animate-fade-in-up">
                <!-- Action Header -->
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">จัดการลิงก์ตารางเรียนและตารางสอน</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">ระบุลิงก์แชร์โฟลเดอร์หรือไฟล์ Google Drive PDF สำหรับตารางเรียนนักเรียนและตารางสอนครู</p>
                </div>

                <div class="glass-card rounded-3xl p-6 md:p-8 shadow-xl max-w-4xl">
                    <form action="<?php echo BASE_URL; ?>admin/settings/schedules" method="POST" class="space-y-6">
                        <div class="space-y-6">
                            <!-- Student Link -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-graduation-cap text-indigo-500 text-sm"></i>
                                    <span>ลิงก์ ตารางเรียนนักเรียน (Google Drive PDF หรือ โฟลเดอร์)</span>
                                </label>
                                <input type="url" name="student_schedule_link" value="<?php echo htmlspecialchars($studentLink); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://drive.google.com/file/d/... หรือ https://drive.google.com/drive/folders/...">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-normal">
                                    วางลิงก์แชร์ไฟล์ PDF หรือลิงก์โฟลเดอร์รวบรวมตารางเรียนจาก Google Drive (โปรดตั้งค่าการแชร์ให้เป็น "ทุกคนที่มีลิงก์มีสิทธิ์อ่าน" ด้วยเพื่อให้บุคคลภายนอกเปิดดูได้)</p>
                            </div>

                            <hr class="border-slate-100 dark:border-white/5 my-2">

                            <!-- Teacher Link -->
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-chalkboard-teacher text-indigo-500 text-sm"></i>
                                    <span>ลิงก์ ตารางสอนครู (Google Drive PDF หรือ โฟลเดอร์)</span>
                                </label>
                                <input type="url" name="teacher_schedule_link" value="<?php echo htmlspecialchars($teacherLink); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://drive.google.com/file/d/... หรือ https://drive.google.com/drive/folders/...">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-normal">
                                    วางลิงก์แชร์ไฟล์ PDF หรือลิงก์โฟลเดอร์รวบรวมตารางสอนคณะครูจาก Google Drive (โปรดตั้งค่าการแชร์ให้เป็น "ทุกคนที่มีลิงก์มีสิทธิ์อ่าน" ด้วย)</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-slate-100 dark:border-white/5">
                            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-save"></i> บันทึกข้อมูลตาราง
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 8 Panel: Manage PDF Documents -->
        <?php if ($activeTab === 'documents'): 
            $documentsList = [
                'handbook' => [
                    'label' => 'คู่มือนักเรียนและผู้ปกครอง',
                    'filename' => 'คู่มือนักเรียนและผู้ปกครอง.pdf',
                    'route' => 'student-handbook',
                    'desc' => 'แสดงบนหน้า "คู่มือนักเรียน" ในส่วนเมนูคู่มือและระเบียบปฏิบัติ'
                ],
                'support_handbook' => [
                    'label' => 'คู่มือระบบดูแลช่วยเหลือนักเรียน',
                    'filename' => 'คู่มือระบบดูแลช่วยเหลือนักเรียน.pdf',
                    'route' => 'student-support-handbook',
                    'desc' => 'แสดงบนหน้า "คู่มือระบบดูแลช่วยเหลือนักเรียน" ในส่วนเมนูคู่มือและระเบียบปฏิบัติ'
                ],
                'discipline' => [
                    'label' => 'ระเบียบวินัยและความประพฤติ',
                    'filename' => 'ระเบียบโรงเรียนพิชัย 2568.pdf',
                    'route' => 'discipline-rules',
                    'desc' => 'แสดงบนหน้า "ระเบียบวินัยและความประพฤติ" ในส่วนเมนูคู่มือและระเบียบปฏิบัติ'
                ],
                'dress' => [
                    'label' => 'ระเบียบเครื่องแต่งกายและทรงผม',
                    'filename' => 'ประกาศโรงเรียนพิชัย-ว่าด้วยทรงผม2566_230509_113401.pdf',
                    'route' => 'dress-rules',
                    'desc' => 'แสดงบนหน้า "ระเบียบเครื่องแต่งกายและทรงผม" ในส่วนเมนูคู่มือและระเบียบปฏิบัติ'
                ],
                'campus' => [
                    'label' => 'สหวิทยาเขตพระยาพิชัยดาบหัก',
                    'filename' => 'ประกาศแต่งตั้งคณะกรรมการสหวิทยาเขตพระยาพิชัยดาบหัก.pdf',
                    'route' => 'campus',
                    'desc' => 'แสดงบนหน้า "สหวิทยาเขตพระยาพิชัยดาบหัก" ในส่วนเมนูข้อมูลทั่วไปและบริหาร'
                ],
                'no_gift_policy' => [
                    'label' => 'แนวปฏิบัติ Do\'s & Don\'ts และนโยบาย No Gift Policy',
                    'filename' => 'แนวปฏิบัติ DO\'S & Don\'ts.pdf',
                    'route' => 'no-gift',
                    'desc' => 'แสดงบนหน้า "นโยบาย No Gift Policy" และ "แนวปฏิบัติ Do\'s & Don\'ts" ในส่วนเมนูความโปร่งใส'
                ],
                'no_gift_announcement' => [
                    'label' => 'ประกาศเจตนารมณ์ นโยบาย No Gift Policy',
                    'filename' => 'ประกาศเจตนารมณ์ นโยบาย No Gift Polioy จากการปฏิบัติหน้าที่.pdf',
                    'route' => 'no-gift',
                    'desc' => 'แสดงบนหน้า "นโยบาย No Gift Policy" ในส่วนเมนูความโปร่งใส'
                ]
            ];
        ?>
            <div class="space-y-6 animate-fade-in-up">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">ระบบจัดการและอัปเดตไฟล์คู่มือ/ระเบียบปฏิบัติโรงเรียน (PDF)</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">คุณสามารถอัปโหลดไฟล์ PDF ใหม่เพื่อแก้ไข/เขียนทับไฟล์เก่าได้โดยตรง ระบบจะจัดการให้อัตโนมัติและลิงก์ของเว็บไซต์หลักจะอัปเดตทันที</p>
                </div>

                <div class="glass-card rounded-3xl overflow-hidden shadow-xl border border-slate-900/5 dark:border-white/10 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl">
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[11px] font-semibold text-slate-600 dark:text-slate-300 tracking-wider">
                                    <th class="py-4 px-6 w-1/3">หน้าและรายการเอกสาร</th>
                                    <th class="py-4 px-6 w-1/4">ชื่อไฟล์ปัจจุบัน / ขนาด</th>
                                    <th class="py-4 px-6 text-center w-32">แก้ไขล่าสุด</th>
                                    <th class="py-4 px-6 text-center w-64">อัปโหลดอัปเดตไฟล์ใหม่ (.pdf)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs text-slate-600 dark:text-slate-300">
                                <?php foreach ($documentsList as $key => $doc): 
                                    $filePath = UPLOAD_DIR . $doc['filename'];
                                    $fileExists = file_exists($filePath);
                                    $fileSize = $fileExists ? round(filesize($filePath) / (1024 * 1024), 2) . ' MB' : '-';
                                    $fileTime = $fileExists ? date('d/m/Y H:i', filemtime($filePath)) : 'ไม่มีไฟล์';
                                ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <!-- Document Info -->
                                        <td class="py-5 px-6">
                                            <h4 class="font-bold text-slate-800 dark:text-white"><?php echo htmlspecialchars($doc['label']); ?></h4>
                                            <p class="text-[10px] text-slate-450 dark:text-slate-500 mt-1"><?php echo htmlspecialchars($doc['desc']); ?></p>
                                            <a href="<?php echo BASE_URL . $doc['route']; ?>" target="_blank" class="inline-flex items-center gap-1 text-[9px] text-indigo-500 hover:underline mt-1.5 font-bold">
                                                <i class="fa-solid fa-external-link text-[8px]"></i> ดูหน้านี้บนเว็บหลัก
                                            </a>
                                        </td>
                                        <!-- Filename / Size -->
                                        <td class="py-5 px-6 space-y-1">
                                            <?php if ($fileExists): ?>
                                                <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-350">
                                                    <i class="fa-regular fa-file-pdf text-red-500 text-sm"></i>
                                                    <span class="font-mono text-[10px] truncate max-w-[200px]" title="<?php echo htmlspecialchars($doc['filename']); ?>"><?php echo htmlspecialchars($doc['filename']); ?></span>
                                                </div>
                                                <div class="text-[10px] text-slate-400 dark:text-slate-500">
                                                    ขนาด: <span class="font-bold font-english"><?php echo $fileSize; ?></span>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-rose-500 font-bold italic">ไม่พบไฟล์ในระบบ</span>
                                            <?php endif; ?>
                                        </td>
                                        <!-- Last Modified -->
                                        <td class="py-5 px-6 text-center text-slate-500 dark:text-slate-400 font-mono">
                                            <?php echo $fileTime; ?>
                                        </td>
                                        <!-- Upload Form -->
                                        <td class="py-5 px-6">
                                            <form action="<?php echo BASE_URL; ?>admin/documents/upload" method="POST" enctype="multipart/form-data" class="flex items-center gap-2">
                                                <input type="hidden" name="document_key" value="<?php echo htmlspecialchars($key); ?>">
                                                <div class="relative flex-grow">
                                                    <input type="file" name="pdf_file" accept=".pdf" required class="block w-full text-[10px] text-slate-500 dark:text-slate-450 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[10px] file:font-semibold file:bg-indigo-500/10 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-500/20 cursor-pointer">
                                                </div>
                                                <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-bold text-[10px] shadow-sm hover:shadow active:scale-95 transition-all flex items-center gap-1 shrink-0">
                                                    <i class="fa-solid fa-cloud-arrow-up"></i> อัปโหลด
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Documents Mobile Card List -->
                    <div class="block md:hidden space-y-4 p-4 bg-slate-50/50 dark:bg-slate-950/20 rounded-b-3xl">
                        <?php foreach ($documentsList as $key => $doc): 
                            $filePath = UPLOAD_DIR . $doc['filename'];
                            $fileExists = file_exists($filePath);
                            $fileSize = $fileExists ? round(filesize($filePath) / (1024 * 1024), 2) . ' MB' : '-';
                            $fileTime = $fileExists ? date('d/m/Y H:i', filemtime($filePath)) : 'ไม่มีไฟล์';
                        ?>
                            <div class="p-4 bg-white/60 dark:bg-slate-900/60 border border-slate-200 dark:border-white/10 rounded-2xl space-y-3 shadow-sm hover:border-indigo-500/30 transition-all duration-300">
                                <div>
                                    <h4 class="font-bold text-slate-800 dark:text-white text-xs leading-normal">
                                        <?php echo htmlspecialchars($doc['label']); ?>
                                    </h4>
                                    <p class="text-[9px] text-slate-450 dark:text-slate-500 mt-1"><?php echo htmlspecialchars($doc['desc']); ?></p>
                                    <a href="<?php echo BASE_URL . $doc['route']; ?>" target="_blank" class="inline-flex items-center gap-1 text-[9px] text-indigo-500 hover:underline mt-1 font-bold">
                                        <i class="fa-solid fa-external-link text-[8px]"></i> ดูหน้าเว็บหลัก
                                    </a>
                                </div>
                                <div class="p-3 bg-slate-50 dark:bg-slate-950/50 rounded-xl space-y-1">
                                    <span class="text-[9px] text-slate-450 block">ไฟล์ปัจจุบัน:</span>
                                    <?php if ($fileExists): ?>
                                        <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-350 text-[10px]">
                                            <i class="fa-regular fa-file-pdf text-red-500 text-sm"></i>
                                            <span class="font-mono truncate max-w-[180px]"><?php echo htmlspecialchars($doc['filename']); ?></span>
                                        </div>
                                        <div class="text-[9px] text-slate-400 dark:text-slate-500">
                                            ขนาด: <span class="font-bold font-english"><?php echo $fileSize; ?></span> | ล่าสุด: <span class="font-mono"><?php echo $fileTime; ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-rose-500 font-bold italic text-[10px]">ไม่พบไฟล์ในระบบ</span>
                                    <?php endif; ?>
                                </div>
                                <form action="<?php echo BASE_URL; ?>admin/documents/upload" method="POST" enctype="multipart/form-data" class="space-y-2 pt-2 border-t border-slate-100 dark:border-white/5">
                                    <input type="hidden" name="document_key" value="<?php echo htmlspecialchars($key); ?>">
                                    <div class="space-y-1">
                                        <label class="text-[9px] text-slate-400 font-semibold">อัปโหลดอัปเดตไฟล์ใหม่ (.pdf):</label>
                                        <input type="file" name="pdf_file" accept=".pdf" required class="block w-full text-[9px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[9px] file:font-semibold file:bg-indigo-500/10 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-500/20 cursor-pointer">
                                    </div>
                                    <button type="submit" class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-[10px] shadow-sm hover:shadow active:scale-95 transition-all flex items-center justify-center gap-1">
                                        <i class="fa-solid fa-cloud-arrow-up"></i> อัปโหลดไฟล์ใหม่
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 9 Panel: Manage Feedback Link -->
        <?php if ($activeTab === 'feedback'): 
            $settingModel = new Setting();
            $settings = $settingModel->get_all_settings();
            $feedbackLink = $settings['feedback_form_url'] ?? 'https://docs.google.com/forms/d/e/1FAIpQLSdfj2hYSPIH6DohM5-IFz0gw_tqrAPDNRYeiMpuLqWuvaDGIQ/viewform?embedded=true';
        ?>
            <div class="space-y-6 animate-fade-in-up">
                <!-- Action Header -->
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">จัดการลิงก์ช่องทางรับฟังความคิดเห็น</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">ระบุลิงก์ Google Form หรือลิงก์ช่องทางอื่นสำหรับการรับฟังความคิดเห็นของบุคคลภายนอกและบุคลากร</p>
                </div>

                <div class="glass-card rounded-3xl p-6 md:p-8 shadow-xl max-w-4xl border border-slate-900/5 dark:border-white/10 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl">
                    <form action="<?php echo BASE_URL; ?>admin/settings/feedback" method="POST" class="space-y-6">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-comments text-indigo-500 text-sm"></i>
                                    <span>ลิงก์ Google Form สำหรับรับฟังความคิดเห็น</span>
                                </label>
                                <input type="url" name="feedback_form_url" value="<?php echo htmlspecialchars($feedbackLink); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://docs.google.com/forms/d/e/.../viewform?embedded=true">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-normal">
                                    วางลิงก์ Google Form ของคุณ (แนะนำให้ใช้ลิงก์เวอร์ชันที่มี `?embedded=true` ท้ายลิงก์เพื่อให้แสดงผลในกรอบเว็บไซด์ได้อย่างสวยงาม)</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-slate-100 dark:border-white/5">
                            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-save"></i> บันทึกข้อมูลลิงก์
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 10 Panel: Manage Complaints Link -->
        <?php if ($activeTab === 'complaints'): 
            $settingModel = new Setting();
            $settings = $settingModel->get_all_settings();
            $complaintsLink = $settings['complaints_form_url'] ?? 'https://docs.google.com/forms/d/e/1FAIpQLSdXHcrRSeXIou3Ym2De6fP6BVqArEjpSkE6Qay6r8R6RaJLyw/viewform?embedded=true&wmode=transparent';
        ?>
            <div class="space-y-6 animate-fade-in-up">
                <!-- Action Header -->
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">จัดการลิงก์ช่องทางรับเรื่องร้องเรียน</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">ระบุลิงก์ Google Form หรือลิงก์ช่องทางอื่นสำหรับการแจ้งเบาะแส/เรื่องร้องเรียนทุจริตและประพฤติมิชอบ</p>
                </div>

                <div class="glass-card rounded-3xl p-6 md:p-8 shadow-xl max-w-4xl border border-slate-900/5 dark:border-white/10 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl">
                    <form action="<?php echo BASE_URL; ?>admin/settings/complaints" method="POST" class="space-y-6">
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-exclamation text-red-500 text-sm"></i>
                                    <span>ลิงก์ Google Form สำหรับรับเรื่องร้องเรียน</span>
                                </label>
                                <input type="url" name="complaints_form_url" value="<?php echo htmlspecialchars($complaintsLink); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://docs.google.com/forms/d/e/.../viewform?embedded=true">
                                <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-normal">
                                    วางลิงก์ Google Form ของคุณ (แนะนำให้ใช้ลิงก์เวอร์ชันที่มี `?embedded=true` ท้ายลิงก์เพื่อให้แสดงผลในกรอบเว็บไซด์ได้อย่างสวยงาม)</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-slate-100 dark:border-white/5">
                            <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-save"></i> บันทึกข้อมูลลิงก์
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
            </div> <!-- End of lg:col-span-9 -->
        </div> <!-- End of grid layout -->
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-100/50 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 border-t border-slate-200 dark:border-white/5 mt-auto py-6 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-500 text-xs">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SCHOOL_NAME_EN; ?>. Admin Portal System.</p>
        </div>
    </footer>

    <!-- MODAL: Create Ticker -->
    <div id="create-ticker-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-md font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-plus text-indigo-500 dark:text-indigo-400 mr-1.5"></i>เพิ่มข้อความข่าวด่วนใหม่</h3>
                <button onclick="closeCreateTickerModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/ticker/create" method="POST" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ข้อความข่าววิ่ง (จำเป็น)</label>
                    <textarea name="message" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="เช่น ขอเชิญชวนร่วมงานวันสถาปนาโรงเรียนประจำปี 2569 ณ หอประชุมใหญ่..."></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ภายนอก URL (ไม่บังคับ)</label>
                    <input type="url" name="link_url" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://example.com/details">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">สถานะการแสดงผล</label>
                    <select name="is_active" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="1">แสดงผล (Active)</option>
                        <option value="0">ซ่อนไว้ (Inactive)</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeCreateTickerModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Ticker -->
    <div id="edit-ticker-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-md font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-edit text-indigo-500 dark:text-indigo-400 mr-1.5"></i>แก้ไขข้อมูลข่าวด่วน</h3>
                <button onclick="closeEditTickerModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/ticker/edit" method="POST" class="space-y-4">
                <input type="hidden" name="id" id="edit-ticker-id">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ข้อความข่าววิ่ง (จำเป็น)</label>
                    <textarea name="message" id="edit-ticker-message" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ภายนอก URL (ไม่บังคับ)</label>
                    <input type="url" name="link_url" id="edit-ticker-link" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">สถานะการแสดงผล</label>
                    <select name="is_active" id="edit-ticker-is-active" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="1">แสดงผล (Active)</option>
                        <option value="0">ซ่อนไว้ (Inactive)</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeEditTickerModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Create News -->
    <div id="create-news-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-md font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-plus text-indigo-500 dark:text-indigo-400 mr-1.5"></i>เพิ่มข่าวสารประชาสัมพันธ์ใหม่</h3>
                <button onclick="closeCreateNewsModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/news/create" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">หัวข้อข่าวสาร</label>
                    <input type="text" name="title" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ประเภทข่าวสาร</label>
                    <select name="category" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="general">ทั่วไป / ประชาสัมพันธ์</option>
                        <option value="activity">ภาพข่าวกิจกรรม</option>
                        <option value="announcement">ประกาศจัดซื้อจัดจ้าง</option>
                        <option value="award">ผลงานและรางวัล (Award)</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 hidden" id="create-news-procurement-fields">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เลขที่เอกสาร (เช่น 12/2569)</label>
                        <input type="text" name="doc_number" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="เช่น 12/2569">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">งบประมาณ (บาท)</label>
                        <input type="number" name="budget" step="0.01" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="เช่น 50000">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เนื้อหาข่าวประชาสัมพันธ์</label>
                    <textarea name="content" rows="5" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">รูปภาพหน้าปกข่าว (ไม่บังคับ)</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับสกุลไฟล์ .jpg, .png, .webp ขนาดสูงสุดไม่เกิน 5MB</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ไฟล์เอกสารแนบ PDF (ไม่บังคับ)</label>
                    <input type="file" name="attachment_pdf" accept="application/pdf" class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับสกุลไฟล์ .pdf ขนาดสูงสุดไม่เกิน 15MB</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">วันที่/เวลาเผยแพร่ข่าวสาร (วันลงข่าว)</label>
                    <input type="datetime-local" name="created_at" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">ไม่บังคับ หากไม่ระบุระบบจะใช้วันที่และเวลาปัจจุบัน</p>
                </div>
                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeCreateNewsModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit News -->
    <div id="edit-news-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-md font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-edit text-indigo-500 dark:text-indigo-400 mr-1.5"></i>แก้ไขข้อมูลข่าวประชาสัมพันธ์</h3>
                <button onclick="closeEditNewsModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/news/edit" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="id" id="edit-news-id">
                
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">หัวข้อข่าวสาร</label>
                    <input type="text" name="title" id="edit-news-title" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ประเภทข่าวสาร</label>
                    <select name="category" id="edit-news-category" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="general">ทั่วไป / ประชาสัมพันธ์</option>
                        <option value="activity">ภาพข่าวกิจกรรม</option>
                        <option value="announcement">ประกาศจัดซื้อจัดจ้าง</option>
                        <option value="award">ผลงานและรางวัล (Award)</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 hidden" id="edit-news-procurement-fields">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เลขที่เอกสาร (เช่น 12/2569)</label>
                        <input type="text" name="doc_number" id="edit-news-doc-number" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="เช่น 12/2569">
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">งบประมาณ (บาท)</label>
                        <input type="number" name="budget" id="edit-news-budget" step="0.01" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="เช่น 50000">
                    </div>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เนื้อหาข่าวประชาสัมพันธ์</label>
                    <textarea name="content" id="edit-news-content" rows="5" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"></textarea>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เปลี่ยนรูปภาพหน้าปกข่าว (ไม่บังคับ)</label>
                    <input type="file" name="cover_image" accept="image/*" class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">เลือกไฟล์ใหม่หากต้องการเปลี่ยนรูปหน้าปกเดิม ขนาดสูงสุด 5MB</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เปลี่ยนไฟล์เอกสารแนบ PDF (ไม่บังคับ)</label>
                    <input type="file" name="attachment_pdf" accept="application/pdf" class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">เลือกไฟล์ใหม่หากต้องการเปลี่ยนไฟล์เอกสารแนบเดิม ขนาดสูงสุด 15MB</p>
                </div>
                <div class="flex items-center gap-2 py-1 hidden" id="edit-news-clear-pdf-container">
                    <input type="checkbox" name="clear_pdf" value="1" id="edit-news-clear-pdf" class="w-4 h-4 rounded border-slate-300 dark:border-white/10 text-indigo-600 focus:ring-indigo-500">
                    <label for="edit-news-clear-pdf" class="text-xs text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors cursor-pointer" id="edit-news-current-pdf-label">ลบไฟล์เอกสารเดิมออกจากระบบ</label>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">วันที่/เวลาเผยแพร่ข่าวสาร (วันลงข่าว)</label>
                    <input type="datetime-local" name="created_at" id="edit-news-created-at" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeEditNewsModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit ITA Item -->
    <div id="edit-ita-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <span class="bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold px-2 py-1 border border-indigo-400/20 rounded-md uppercase tracking-wider font-english mr-1.5" id="edit-ita-code-badge">O1</span>
                    <h3 class="text-md font-bold text-slate-900 dark:text-white inline-block">อัปเดตข้อมูลตัวชี้วัด ITA</h3>
                </div>
                <button onclick="closeEditItaModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            
            <form action="<?php echo BASE_URL; ?>admin/ita/update" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="code" id="edit-ita-code">

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่อตัวชี้วัด (สามารถปรับแต่งได้)</label>
                    <input type="text" name="name" id="edit-ita-name" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ URL ข้อมูลภายนอก (ถ้ามี)</label>
                    <input type="url" name="link_url" id="edit-ita-link" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://example.com/some-page">
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">อัปโหลดไฟล์เอกสาร (PDF, Word, Excel, Zip)</label>
                    <input type="file" name="ita_file" class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับไฟล์ขนาดสูงสุดไม่เกิน 15MB</p>
                </div>

                <!-- Delete physical file toggle if exists -->
                <div class="flex items-center gap-2 py-2 hidden" id="clear-file-container">
                    <input type="checkbox" name="clear_file" value="1" id="clear-file-checkbox" class="w-4 h-4 rounded border-slate-300 dark:border-white/10 text-indigo-600 focus:ring-indigo-500">
                    <label for="clear-file-checkbox" class="text-xs text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors cursor-pointer">ต้องการลบไฟล์เอกสารเดิมออกจากระบบ (ใช้เฉพาะการเชื่อมโยงด้วยลิงก์ URL เท่านั้น)</label>
                </div>

                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">สถานะการเผยแพร่</label>
                    <select name="status" id="edit-ita-status" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="published">เผยแพร่สาธารณะ (Published)</option>
                        <option value="draft">ฉบับร่างครูแอดมิน (Draft)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeEditItaModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกตัวชี้วัด</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Create Hero Slide -->
    <div id="create-hero-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-md font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-plus text-indigo-500 dark:text-indigo-400 mr-1.5"></i>เพิ่มรูปภาพสไลด์ใหม่</h3>
                <button onclick="closeCreateHeroModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/hero/create" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่ออ้างอิงสไลด์ (ไม่บังคับ)</label>
                    <input type="text" name="title" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="เช่น สไลด์แนะนำวิชาการ">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">รูปภาพสไลด์ (จำเป็น)</label>
                    <input type="file" name="slide_image" accept="image/*" required class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับสกุลไฟล์ .jpg, .png, .webp ขนาดสูงสุดไม่เกิน 5MB</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลำดับการแสดงผล (ตัวเลข)</label>
                    <input type="number" name="display_order" value="1" min="1" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">สถานะการแสดงผล</label>
                    <select name="status" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="active">แสดงผล (Active)</option>
                        <option value="inactive">ซ่อนไว้ (Inactive)</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeCreateHeroModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Hero Slide -->
    <div id="edit-hero-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-lg rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-md font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-edit text-indigo-500 dark:text-indigo-400 mr-1.5"></i>แก้ไขข้อมูลสไลด์แนะนำ</h3>
                <button onclick="closeEditHeroModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            <form action="<?php echo BASE_URL; ?>admin/hero/edit" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="id" id="edit-hero-id">
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่ออ้างอิงสไลด์ (ไม่บังคับ)</label>
                    <input type="text" name="title" id="edit-hero-title" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เปลี่ยนรูปภาพสไลด์ (ไม่บังคับ)</label>
                    <input type="file" name="slide_image" accept="image/*" class="w-full glass-input rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">เลือกไฟล์ใหม่หากต้องการเปลี่ยนรูปสไลด์เดิม ขนาดสูงสุด 5MB</p>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลำดับการแสดงผล (ตัวเลข)</label>
                    <input type="number" name="display_order" id="edit-hero-order" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">สถานะการแสดงผล</label>
                    <select name="status" id="edit-hero-status" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        <option value="active">แสดงผล (Active)</option>
                        <option value="inactive">ซ่อนไว้ (Inactive)</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2.5 pt-4">
                    <button type="button" onclick="closeEditHeroModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit About Section -->
    <div id="edit-about-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="w-full max-w-5xl rounded-3xl shadow-2xl glass-modal p-6 scale-95 transition-transform duration-300">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <span class="bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold px-2 py-1 border border-indigo-400/20 rounded-md uppercase tracking-wider font-english mr-1.5">ABOUT</span>
                    <h3 class="text-md font-bold text-slate-900 dark:text-white inline-block">แก้ไขข้อมูลแนะนำโรงเรียน: <span id="edit-about-title-display" class="text-indigo-600 dark:text-indigo-400"></span></h3>
                </div>
                <button onclick="closeEditAboutModal()" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-500 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            
            <form action="<?php echo BASE_URL; ?>admin/about/update" method="POST" class="space-y-4">
                <input type="hidden" name="section_key" id="edit-about-key">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เนื้อหาภาษาไทย (รองรับ HTML)</label>
                        <textarea name="content_th" id="edit-about-content-th" rows="14" required class="w-full glass-input rounded-xl px-4 py-3 text-xs font-mono focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"></textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">เนื้อหาภาษาอังกฤษ (รองรับ HTML)</label>
                        <textarea name="content_en" id="edit-about-content-en" rows="14" required class="w-full glass-input rounded-xl px-4 py-3 text-xs font-mono focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"></textarea>
                    </div>
                </div>

                <div class="p-3 bg-amber-500/10 border border-amber-500/20 rounded-xl text-amber-600 dark:text-amber-300 text-[10px] leading-relaxed flex gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-xs mt-0.5"></i>
                    <span><strong>คำแนะนำ:</strong> ข้อมูลแนะนำนี้เก็บโครงสร้างการแสดงผลด้วยรหัส HTML (เช่น <code>&lt;div class="space-y-6"&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;h3&gt;</code>) เพื่อรักษาดีไซน์ต้นฉบับ โปรดระมัดระวังในการเปลี่ยนแปลงรหัสเหล่านี้</span>
                </div>

                <div class="flex justify-end gap-2.5 pt-2">
                    <button type="button" onclick="closeEditAboutModal()" class="px-4 py-2.5 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-semibold rounded-xl transition-all">ยกเลิก</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all">บันทึกข้อมูลแนะนำโรงเรียน</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modals Script Logic -->
    <script>
        function openModalHelper(id) {
            const modal = document.getElementById(id);
            const modalInner = modal.querySelector('.scale-95');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                modalInner.classList.remove('scale-95');
                modalInner.classList.add('scale-100');
            }, 50);
        }

        function closeModalHelper(id) {
            const modal = document.getElementById(id);
            const modalInner = modal.querySelector('.scale-100');
            if (modalInner) {
                modalInner.classList.remove('scale-100');
                modalInner.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 150);
        }

        // Create News Modal
        function openCreateNewsModal() {
            // Reset fields
            document.querySelector('#create-news-modal select[name="category"]').value = 'general';
            toggleProcurementFields('create', 'general');
            openModalHelper('create-news-modal');
        }
        function closeCreateNewsModal() {
            closeModalHelper('create-news-modal');
        }

        // Edit News Modal
        function openEditNewsModal(news) {
            document.getElementById('edit-news-id').value = news.id;
            document.getElementById('edit-news-title').value = news.title;
            document.getElementById('edit-news-category').value = news.category;
            document.getElementById('edit-news-content').value = news.content;
            
            // Format custom created_at date for datetime-local (YYYY-MM-DDTHH:MM)
            if (news.created_at) {
                const formattedDate = news.created_at.replace(' ', 'T').substring(0, 16);
                document.getElementById('edit-news-created-at').value = formattedDate;
            } else {
                document.getElementById('edit-news-created-at').value = '';
            }

            // Populate procurement fields
            document.getElementById('edit-news-doc-number').value = news.doc_number || '';
            document.getElementById('edit-news-budget').value = news.budget || '';
            toggleProcurementFields('edit', news.category);

            // PDF clear selection logic
            const clearPdfContainer = document.getElementById('edit-news-clear-pdf-container');
            const clearPdfCheckbox = document.getElementById('edit-news-clear-pdf');
            const currentPdfLabel = document.getElementById('edit-news-current-pdf-label');
            
            clearPdfCheckbox.checked = false;
            if (news.attachment_pdf && news.attachment_pdf.trim() !== '') {
                clearPdfContainer.classList.remove('hidden');
                const filename = news.attachment_pdf.split('/').pop();
                currentPdfLabel.innerHTML = `ลบไฟล์เอกสารแนบเดิม (${filename}) ออกจากระบบ`;
            } else {
                clearPdfContainer.classList.add('hidden');
            }

            openModalHelper('edit-news-modal');
        }
        function closeEditNewsModal() {
            closeModalHelper('edit-news-modal');
        }

        // Edit ITA Modal
        function openEditItaModal(item) {
            document.getElementById('edit-ita-code').value = item.code;
            document.getElementById('edit-ita-code-badge').innerText = item.code;
            document.getElementById('edit-ita-name').value = item.name;
            document.getElementById('edit-ita-link').value = item.link_url || '';
            document.getElementById('edit-ita-status').value = item.status;

            const clearContainer = document.getElementById('clear-file-container');
            const clearCheckbox = document.getElementById('clear-file-checkbox');
            clearCheckbox.checked = false;
            
            if (item.file_path && item.file_path.trim() !== '') {
                clearContainer.classList.remove('hidden');
            } else {
                clearContainer.classList.add('hidden');
            }

            openModalHelper('edit-ita-modal');
        }
        function closeEditItaModal() {
            closeModalHelper('edit-ita-modal');
        }

        // Create Hero Modal
        function openCreateHeroModal() {
            openModalHelper('create-hero-modal');
        }
        function closeCreateHeroModal() {
            closeModalHelper('create-hero-modal');
        }

        // Edit Hero Modal
        function openEditHeroModal(hero) {
            document.getElementById('edit-hero-id').value = hero.id;
            document.getElementById('edit-hero-title').value = hero.title || '';
            document.getElementById('edit-hero-order').value = hero.display_order;
            document.getElementById('edit-hero-status').value = hero.status;
            openModalHelper('edit-hero-modal');
        }
        function closeEditHeroModal() {
            closeModalHelper('edit-hero-modal');
        }

        // Ticker Modal Functions
        function openCreateTickerModal() {
            openModalHelper('create-ticker-modal');
        }
        function closeCreateTickerModal() {
            closeModalHelper('create-ticker-modal');
        }
        function openEditTickerModal(ticker) {
            document.getElementById('edit-ticker-id').value = ticker.id;
            document.getElementById('edit-ticker-message').value = ticker.message;
            document.getElementById('edit-ticker-link').value = ticker.link_url || '';
            document.getElementById('edit-ticker-is-active').value = ticker.is_active;
            openModalHelper('edit-ticker-modal');
        }
        function closeEditTickerModal() {
            closeModalHelper('edit-ticker-modal');
        }

        // About Modal Functions
        function openEditAboutModal(data) {
            const key = data.key;
            const title = data.title;
            
            document.getElementById('edit-about-key').value = key;
            document.getElementById('edit-about-title-display').innerText = title;
            
            const contentTh = document.getElementById('about-content-th-' + key).value;
            const contentEn = document.getElementById('about-content-en-' + key).value;
            
            document.getElementById('edit-about-content-th').value = contentTh;
            document.getElementById('edit-about-content-en').value = contentEn;
            
            openModalHelper('edit-about-modal');
        }
        function closeEditAboutModal() {
            closeModalHelper('edit-about-modal');
        }

        function toggleProcurementFields(prefix, category) {
            const container = document.getElementById(`${prefix}-news-procurement-fields`);
            if (container) {
                if (category === 'announcement') {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
        }

        // SweetAlert2 Theme Helper
        function getSwalThemeOptions() {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                background: isDark ? '#1e293b' : '#ffffff', // slate-800 or white
                color: isDark ? '#f8fafc' : '#1e293b', // slate-50 or slate-800
                confirmButtonColor: '#4f46e5', // indigo-600
                cancelButtonColor: '#64748b' // slate-500
            };
        }

        // SweetAlert2 Confirmation Dialogs
        function confirmDelete(event, message) {
            event.preventDefault();
            const target = event.currentTarget;
            const url = target.getAttribute('href');
            const themeOpts = getSwalThemeOptions();
            Swal.fire({
                title: 'ยืนยันการลบข้อมูล?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ต้องการลบ!',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#ef4444', // red-500
                ...themeOpts
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        function confirmLogout(event) {
            event.preventDefault();
            const target = event.currentTarget;
            const url = target.getAttribute('href');
            const themeOpts = getSwalThemeOptions();
            Swal.fire({
                title: 'ออกจากระบบ?',
                text: 'คุณต้องการออกจากระบบบริหารจัดการใช่หรือไม่?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ใช่, ออกจากระบบ',
                cancelButtonText: 'ยกเลิก',
                ...themeOpts
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        // Dark/Light Theme Switcher Handler
        const htmlDoc = document.documentElement;

        function toggleDarkMode() {
            const isDarkModeActive = htmlDoc.classList.toggle('dark');
            const targetTheme = isDarkModeActive ? 'dark' : 'light';
            localStorage.setItem('school_theme', targetTheme);
            updateThemeUI(targetTheme);
        }

        function updateThemeUI(theme) {
            const themeIconEl = document.getElementById('theme-icon');
            const themeIconMobileEl = document.getElementById('theme-icon-mobile');
            
            if (theme === 'dark') {
                if (themeIconEl) themeIconEl.className = 'fa-solid fa-sun text-yellow-400';
                if (themeIconMobileEl) themeIconMobileEl.className = 'fa-solid fa-sun text-yellow-400';
            } else {
                if (themeIconEl) themeIconEl.className = 'fa-solid fa-moon text-slate-600 dark:text-slate-350';
                if (themeIconMobileEl) themeIconMobileEl.className = 'fa-solid fa-moon text-slate-600 dark:text-slate-350';
            }
        }

        // Initialize UI settings highlights on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            const currentTheme = localStorage.getItem('school_theme') || 'dark';
            updateThemeUI(currentTheme);

            const createCategorySelect = document.querySelector('#create-news-modal select[name="category"]');
            if (createCategorySelect) {
                createCategorySelect.addEventListener('change', function(e) {
                    toggleProcurementFields('create', e.target.value);
                });
            }

            const editCategorySelect = document.getElementById('edit-news-category');
            if (editCategorySelect) {
                editCategorySelect.addEventListener('change', function(e) {
                    toggleProcurementFields('edit', e.target.value);
                });
            }
        });
    </script>
</body>
</html>
