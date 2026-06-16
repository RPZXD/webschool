<!-- views/admin/settings.php -->
<!-- Administrative Website Settings Control Panel View -->

<!DOCTYPE html>
<html lang="th" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    
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
                        <span class="text-sm font-bold text-slate-900 dark:text-white tracking-wide leading-tight">ระบบตั้งค่าเว็บไซต์</span>
                        <span class="text-[9px] text-slate-500 dark:text-slate-400 font-english mt-0.5"><?php echo SCHOOL_NAME_EN; ?></span>
                    </div>
                </a>

                <!-- Desktop Navigation Portal links -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="<?php echo BASE_URL; ?>admin" class="px-4 py-2 bg-indigo-600/10 hover:bg-indigo-600/20 border border-indigo-500/20 rounded-xl text-xs font-semibold text-indigo-600 dark:text-indigo-300 transition-all duration-300">
                        <i class="fa-solid fa-gauge mr-1.5"></i>กลับสู่หน้าแดชบอร์ด
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
                
                <a href="<?php echo BASE_URL; ?>admin?tab=news" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-regular fa-newspaper text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>จัดการข่าวสารและกิจกรรม</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=ita" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-chart-bar text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>ประเมิน ITA Online</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=hero" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-regular fa-images text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>รูปสไลด์หน้าแรก (Hero)</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=ticker" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-bullhorn text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>ข่าวด่วนตัววิ่ง (Ticker)</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=about" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-info-circle text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>แนะนำโรงเรียน (About)</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=stats" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-database text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>สถิติและข้อมูลทั่วไป</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=schedules" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-calendar-days text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>จัดการตารางเรียน/สอน</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=documents" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-folder-open text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>จัดการไฟล์คู่มือและระเบียบ</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=feedback" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-comments text-sm shrink-0 w-5 text-center text-indigo-400"></i>
                    <span>จัดการลิงก์รับฟังความคิดเห็น</span>
                </a>
                
                <a href="<?php echo BASE_URL; ?>admin?tab=complaints" class="flex items-center gap-3 px-4 py-3 text-xs font-bold rounded-2xl text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                    <i class="fa-solid fa-circle-exclamation text-sm shrink-0 w-5 text-center text-indigo-400"></i>
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
                    <a href="<?php echo BASE_URL; ?>admin" class="flex items-center justify-center py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold rounded-xl transition-all shadow-md"><i class="fa-solid fa-gauge mr-1"></i>แดชบอร์ด</a>
                    <a href="<?php echo BASE_URL; ?>" target="_blank" class="flex items-center justify-center py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-[10px] font-bold rounded-xl border border-white/10 transition-all"><i class="fa-solid fa-globe mr-1"></i>เว็บหลัก</a>
                </div>
                <a href="<?php echo BASE_URL; ?>logout" class="w-full flex items-center justify-center py-2 bg-red-600/10 hover:bg-red-600/20 border border-red-500/20 text-red-400 text-[10px] font-bold rounded-xl transition-all" onclick="confirmLogout(event)"><i class="fa-solid fa-sign-out-alt mr-1"></i>ออกจากระบบ</a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full space-y-8 animate-fade-in-up">
        
        <!-- Headers Section -->
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">จัดการการตั้งค่าพื้นฐานของเว็บไซต์ (Site Settings)</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">คุณสามารถแก้ไข ข้อมูลติดต่อ ลิงก์โซเชียล โลโก้ และแผนที่ของโรงเรียน เพื่ออัปเดตข้อมูลที่จะแสดงบนหน้าหลักและฟุตเตอร์ได้ทันที</p>
        </div>

        <!-- Alerts Display (Success/Error) -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="p-4 bg-emerald-500/10 dark:bg-emerald-900/30 border border-emerald-500/20 dark:border-emerald-500/30 rounded-2xl text-emerald-600 dark:text-emerald-300 text-xs flex items-center gap-2.5 shadow-xl">
                <i class="fa-solid fa-circle-check text-base"></i>
                <span class="font-semibold"><?php echo $_SESSION['success']; ?></span>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="p-4 bg-red-500/10 dark:bg-red-900/30 border border-red-500/20 dark:border-red-500/30 rounded-2xl text-red-600 dark:text-red-300 text-xs flex items-center gap-2.5 shadow-xl">
                <i class="fa-solid fa-circle-exclamation text-base"></i>
                <span class="font-semibold"><?php echo $_SESSION['error']; ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Mobile Dropdown Selector Menu -->
        <div class="lg:hidden w-full bg-slate-100/80 dark:bg-slate-900/60 border border-slate-200/50 dark:border-white/10 p-4 rounded-2xl flex items-center justify-between gap-3 shadow-lg backdrop-blur-md mb-6 transition-all duration-300">
            <span class="text-xs font-bold text-slate-700 dark:text-slate-300"><i class="fa-solid fa-cog mr-2 text-indigo-500 animate-pulse"></i>เลือกประเภทตั้งค่า</span>
            <select onchange="switchSettingTab(this.value)" id="mobile-tab-select" class="glass-input rounded-xl px-3 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 font-semibold cursor-pointer">
                <option value="general">ℹ️ ข้อมูลทั่วไป</option>
                <option value="contact">📞 ข้อมูลติดต่อ</option>
                <option value="social">🔗 โซเชียลมีเดีย</option>
                <option value="assets">🖼️ โลโก้ & Favicon</option>
                <option value="exec_stats">👤 สารจากผู้บริหาร & สถิติ</option>
            </select>
        </div>

        <!-- Form and Tab Layout -->
        <form action="<?php echo BASE_URL; ?>admin/settings/update" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Desktop Left Sidebar -->
            <div class="hidden lg:block lg:col-span-3 space-y-4 sticky top-28 transition-all duration-300">
                <div class="glass-card p-4 rounded-3xl shadow-xl border border-slate-900/5 dark:border-white/10 space-y-1 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl">
                    <p class="px-3 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">การตั้งค่าระบบ</p>
                    
                    <button type="button" onclick="switchSettingTab('general')" id="tab-btn-general" class="setting-tab-btn w-full flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 border border-transparent text-left">
                        <i class="fa-solid fa-circle-info text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                        <span>ข้อมูลทั่วไป</span>
                    </button>
                    
                    <button type="button" onclick="switchSettingTab('contact')" id="tab-btn-contact" class="setting-tab-btn w-full flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 border border-transparent text-left">
                        <i class="fa-solid fa-address-book text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                        <span>ข้อมูลติดต่อ</span>
                    </button>

                    <button type="button" onclick="switchSettingTab('social')" id="tab-btn-social" class="setting-tab-btn w-full flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 border border-transparent text-left">
                        <i class="fa-solid fa-share-nodes text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                        <span>โซเชียลมีเดีย</span>
                    </button>

                    <button type="button" onclick="switchSettingTab('assets')" id="tab-btn-assets" class="setting-tab-btn w-full flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 border border-transparent text-left">
                        <i class="fa-solid fa-image text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                        <span>โลโก้ & Favicon</span>
                    </button>

                    <button type="button" onclick="switchSettingTab('exec_stats')" id="tab-btn-exec_stats" class="setting-tab-btn w-full flex items-center gap-3 px-4 py-3.5 text-xs font-bold rounded-2xl transition-all duration-300 border border-transparent text-left">
                        <i class="fa-solid fa-user-tie text-sm shrink-0 w-5 text-center text-indigo-500 dark:text-indigo-400"></i>
                        <span>สารจากผู้บริหาร & สถิติ</span>
                    </button>
                </div>
            </div>

            <!-- Content Column -->
            <div class="lg:col-span-9 space-y-6 w-full">
                <!-- Content Card -->
                <div class="glass-card p-8 rounded-3xl shadow-2xl relative overflow-hidden">

                <!-- Tab 1: General Info -->
                <div id="setting-panel-general" class="setting-panel-pane space-y-6 hidden">
                    <h3 class="text-md font-bold text-slate-900 dark:text-white pb-3 border-b border-slate-200 dark:border-white/5"><i class="fa-solid fa-circle-info text-indigo-500 mr-1.5"></i>ตั้งค่าข้อมูลทั่วไปของสถานศึกษา</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label for="school_name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่อโรงเรียน (ภาษาไทย)</label>
                            <input type="text" id="school_name" name="school_name" value="<?php echo htmlspecialchars($settings['school_name'] ?? ''); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label for="school_name_en" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่อโรงเรียน (ภาษาอังกฤษ)</label>
                            <input type="text" id="school_name_en" name="school_name_en" value="<?php echo htmlspecialchars($settings['school_name_en'] ?? ''); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="school_short_name" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่อย่อโรงเรียน (ภาษาไทย เช่น พช.)</label>
                            <input type="text" id="school_short_name" name="school_short_name" value="<?php echo htmlspecialchars($settings['school_short_name'] ?? ''); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="student_schedule_link" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ ตารางเรียนนักเรียน (Google Drive PDF)</label>
                            <input type="url" id="student_schedule_link" name="student_schedule_link" value="<?php echo htmlspecialchars($settings['student_schedule_link'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">วางลิงก์แชร์ไฟล์ PDF ตารางเรียนจาก Google Drive (ตรวจสอบสิทธิ์การเข้าถึงให้เป็น "ทุกคนที่มีลิงก์มีสิทธิ์อ่าน" ด้วย)</p>
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="teacher_schedule_link" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ ตารางสอนครู (Google Drive PDF)</label>
                            <input type="url" id="teacher_schedule_link" name="teacher_schedule_link" value="<?php echo htmlspecialchars($settings['teacher_schedule_link'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://drive.google.com/file/d/.../view?usp=sharing">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">วางลิงก์แชร์ไฟล์ PDF ตารางสอนจาก Google Drive (ตรวจสอบสิทธิ์การเข้าถึงให้เป็น "ทุกคนที่มีลิงก์มีสิทธิ์อ่าน" ด้วย)</p>
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="feedback_form_url" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ช่องทางรับฟังความคิดเห็น (Google Form)</label>
                            <input type="url" id="feedback_form_url" name="feedback_form_url" value="<?php echo htmlspecialchars($settings['feedback_form_url'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://docs.google.com/forms/d/e/.../viewform?embedded=true">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">วางลิงก์ Google Form สำหรับรับฟังความคิดเห็น (แนะนำลิงก์รูปแบบ ?embedded=true เพื่อให้ฝังในบราวเซอร์ได้อย่างพอดี)</p>
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label for="complaints_form_url" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ช่องทางรับเรื่องร้องเรียน (Google Form)</label>
                            <input type="url" id="complaints_form_url" name="complaints_form_url" value="<?php echo htmlspecialchars($settings['complaints_form_url'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://docs.google.com/forms/d/e/.../viewform?embedded=true">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">วางลิงก์ Google Form สำหรับรับเรื่องร้องเรียน (แนะนำลิงก์รูปแบบ ?embedded=true เพื่อให้ฝังในบราวเซอร์ได้อย่างพอดี)</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Contact Info -->
                <div id="setting-panel-contact" class="setting-panel-pane space-y-6 hidden">
                    <h3 class="text-md font-bold text-slate-900 dark:text-white pb-3 border-b border-slate-200 dark:border-white/5"><i class="fa-solid fa-address-book text-indigo-500 mr-1.5"></i>ตั้งค่าข้อมูลติดต่อและลิงก์แผนที่</h3>
                    
                    <div class="space-y-6">
                        <div class="space-y-1.5">
                            <label for="school_address_th" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ที่อยู่โรงเรียน (ภาษาไทย)</label>
                            <textarea id="school_address_th" name="school_address_th" rows="2" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"><?php echo htmlspecialchars($settings['school_address_th'] ?? ''); ?></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label for="school_address_en" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ที่อยู่โรงเรียน (ภาษาอังกฤษ)</label>
                            <textarea id="school_address_en" name="school_address_en" rows="2" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"><?php echo htmlspecialchars($settings['school_address_en'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="space-y-1.5">
                                <label for="school_phone" class="text-xs font-semibold text-slate-700 dark:text-slate-300">เบอร์โทรศัพท์ติดต่อ</label>
                                <input type="text" id="school_phone" name="school_phone" value="<?php echo htmlspecialchars($settings['school_phone'] ?? ''); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label for="school_fax" class="text-xs font-semibold text-slate-700 dark:text-slate-300">เบอร์โทรสาร (แฟกซ์)</label>
                                <input type="text" id="school_fax" name="school_fax" value="<?php echo htmlspecialchars($settings['school_fax'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label for="school_email" class="text-xs font-semibold text-slate-700 dark:text-slate-300">อีเมลโรงเรียน</label>
                                <input type="email" id="school_email" name="school_email" value="<?php echo htmlspecialchars($settings['school_email'] ?? ''); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label for="google_map_embed" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ลิงก์ Google Map Embed (สำหรับแผนที่หน้าติดต่อเรา)</label>
                            <input type="url" id="google_map_embed" name="google_map_embed" value="<?php echo htmlspecialchars($settings['google_map_embed'] ?? ''); ?>" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all" placeholder="https://www.google.com/maps/embed?...">
                            <p class="text-[10px] text-slate-400 dark:text-slate-500">นำลิงก์มาจากตัวเลือกแชร์แผนที่ -> ฝังแผนที่ (Embed Map) คัดลอกเฉพาะลิงก์ที่อยู่ในแท็ก `src` ของ iframe มากรอก</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Social Links -->
                <div id="setting-panel-social" class="setting-panel-pane space-y-6 hidden">
                    <h3 class="text-md font-bold text-slate-900 dark:text-white pb-3 border-b border-slate-200 dark:border-white/5"><i class="fa-solid fa-share-nodes text-indigo-500 mr-1.5"></i>ตั้งค่าลิงก์เชื่อมโยงโซเชียลมีเดีย</h3>
                    
                    <div class="space-y-5">
                        <div class="space-y-1.5">
                            <label for="school_facebook" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><i class="fab fa-facebook text-indigo-500 mr-1 text-sm"></i> Facebook Page URL</label>
                            <input type="url" id="school_facebook" name="school_facebook" value="<?php echo htmlspecialchars($settings['school_facebook'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label for="school_youtube" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><i class="fab fa-youtube text-red-500 mr-1 text-sm"></i> YouTube Channel URL</label>
                            <input type="url" id="school_youtube" name="school_youtube" value="<?php echo htmlspecialchars($settings['school_youtube'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label for="school_line" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><i class="fab fa-line text-green-500 mr-1 text-sm"></i> Line Official Account URL</label>
                            <input type="url" id="school_line" name="school_line" value="<?php echo htmlspecialchars($settings['school_line'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Tab 4: Assets Upload -->
                <div id="setting-panel-assets" class="setting-panel-pane space-y-6 hidden">
                    <h3 class="text-md font-bold text-slate-900 dark:text-white pb-3 border-b border-slate-200 dark:border-white/5"><i class="fa-solid fa-image text-indigo-500 mr-1.5"></i>ตั้งค่ารูปโลโก้โรงเรียนและ Favicon ไอคอนแท็บ</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- School Logo Upload -->
                        <div class="space-y-4">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 block">โลโก้สถาบัน (School Logo)</label>
                            <div class="relative p-6 border-2 border-dashed border-slate-300 dark:border-white/20 hover:border-indigo-500 dark:hover:border-indigo-400 rounded-2xl flex flex-col items-center justify-center text-center space-y-3 bg-slate-50/50 dark:bg-slate-950/20 hover:bg-slate-100/50 dark:hover:bg-slate-900/30 transition-all duration-300 cursor-pointer">
                                <input type="file" name="school_logo" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this, 'school_logo_preview')">
                                <div class="flex flex-col items-center justify-center space-y-2.5 z-0" id="school_logo_preview_container">
                                    <?php if (!empty($settings['school_logo'])): ?>
                                        <img id="school_logo_preview" src="<?php echo UPLOAD_URL . $settings['school_logo']; ?>" alt="Logo Preview" class="w-20 h-20 object-cover rounded-xl border border-slate-200 dark:border-white/10 shadow-lg">
                                    <?php else: ?>
                                        <span id="school_logo_preview_placeholder" class="w-20 h-20 rounded-xl bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-600 text-3xl"><i class="fa-solid fa-image"></i></span>
                                        <img id="school_logo_preview" class="w-20 h-20 object-cover rounded-xl border border-slate-200 dark:border-white/10 shadow-lg hidden">
                                    <?php endif; ?>
                                    <span class="px-3 py-1.5 rounded-xl bg-indigo-600/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold hover:bg-indigo-600/20 transition-all"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>อัปโหลดโลโก้ใหม่</span>
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับไฟล์ภาพ .png, .jpg, .webp ขนาดไม่เกิน 5MB (แนะนำเป็นภาพพื้นหลังโปร่งใสแบบสี่เหลี่ยมจัตุรัส)</p>
                        </div>

                        <!-- Favicon Upload -->
                        <div class="space-y-4">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 block">ไอคอนหน้าต่างเบราว์เซอร์ (Favicon)</label>
                            <div class="relative p-6 border-2 border-dashed border-slate-300 dark:border-white/20 hover:border-indigo-500 dark:hover:border-indigo-400 rounded-2xl flex flex-col items-center justify-center text-center space-y-3 bg-slate-50/50 dark:bg-slate-950/20 hover:bg-slate-100/50 dark:hover:bg-slate-900/30 transition-all duration-300 cursor-pointer">
                                <input type="file" name="school_favicon" accept="image/x-icon, image/png, image/jpeg, image/gif" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this, 'school_favicon_preview')">
                                <div class="flex flex-col items-center justify-center space-y-2.5 z-0" id="school_favicon_preview_container">
                                    <?php if (!empty($settings['school_favicon'])): ?>
                                        <img id="school_favicon_preview" src="<?php echo UPLOAD_URL . $settings['school_favicon']; ?>" alt="Favicon Preview" class="w-10 h-10 object-cover rounded-md border border-slate-200 dark:border-white/10 shadow-md">
                                    <?php else: ?>
                                        <span id="school_favicon_preview_placeholder" class="w-10 h-10 rounded-md bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-600 text-xl"><i class="fa-solid fa-shapes"></i></span>
                                        <img id="school_favicon_preview" class="w-10 h-10 object-cover rounded-md border border-slate-200 dark:border-white/10 shadow-md hidden">
                                    <?php endif; ?>
                                    <span class="px-3 py-1.5 rounded-xl bg-indigo-600/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold hover:bg-indigo-600/20 transition-all"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>อัปโหลดไอคอนใหม่</span>
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับไฟล์ .ico, .png, .jpg ขนาดไม่เกิน 2MB (ขนาดมาตรฐานควรเป็น 16x16 หรือ 32x32 พิกเซล)</p>
                        </div>
                    </div>
                </div>

                <!-- Tab 5: Executive Message & Stats -->
                <div id="setting-panel-exec_stats" class="setting-panel-pane space-y-6 hidden">
                    <h3 class="text-md font-bold text-slate-900 dark:text-white pb-3 border-b border-slate-200 dark:border-white/5"><i class="fa-solid fa-user-tie text-indigo-500 mr-1.5"></i>ตั้งค่าสารจากผู้บริหาร & สถิติสถานศึกษา</h3>
                    
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่อผู้บริหาร (ผู้อำนวยการ)</label>
                                <input type="text" name="exec_name" value="<?php echo htmlspecialchars($settings['exec_name'] ?? ''); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">ตำแหน่งผู้บริหาร</label>
                                <input type="text" name="exec_position" value="<?php echo htmlspecialchars($settings['exec_position'] ?? 'ผู้อำนวยการโรงเรียน'); ?>" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300">สารจากผู้บริหาร (ข้อความต้อนรับ / วิสัยทัศน์)</label>
                            <textarea name="exec_message" rows="4" class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all"><?php echo htmlspecialchars($settings['exec_message'] ?? ''); ?></textarea>
                        </div>

                        <div class="space-y-4">
                            <label class="text-xs font-semibold text-slate-700 dark:text-slate-300 block">รูปภาพผู้บริหาร (Executive Photo)</label>
                            <div class="relative p-6 border-2 border-dashed border-slate-300 dark:border-white/20 hover:border-indigo-500 dark:hover:border-indigo-400 rounded-2xl flex flex-col items-center justify-center text-center space-y-3 bg-slate-50/50 dark:bg-slate-950/20 hover:bg-slate-100/50 dark:hover:bg-slate-900/30 transition-all duration-300 cursor-pointer">
                                <input type="file" name="exec_image" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this, 'exec_image_preview')">
                                <div class="flex flex-col items-center justify-center space-y-2.5 z-0" id="exec_image_preview_container">
                                    <?php if (!empty($settings['exec_image'])): ?>
                                        <img id="exec_image_preview" src="<?php echo UPLOAD_URL . $settings['exec_image']; ?>" alt="Executive Preview" class="w-32 h-40 object-cover rounded-xl border border-slate-200 dark:border-white/10 shadow-lg animate-fade-in">
                                    <?php else: ?>
                                        <span id="exec_image_preview_placeholder" class="w-32 h-40 rounded-xl bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-600 text-3xl"><i class="fa-solid fa-user"></i></span>
                                        <img id="exec_image_preview" class="w-32 h-40 object-cover rounded-xl border border-slate-200 dark:border-white/10 shadow-lg animate-fade-in hidden">
                                    <?php endif; ?>
                                    <span class="px-3 py-1.5 rounded-xl bg-indigo-600/10 text-indigo-600 dark:text-indigo-400 text-[10px] font-bold hover:bg-indigo-600/20 transition-all"><i class="fa-solid fa-cloud-arrow-up mr-1"></i>อัปโหลดรูปผู้บริหารใหม่</span>
                                </div>
                            </div>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">รองรับไฟล์ภาพ .png, .jpg, .webp ขนาดไม่เกิน 5MB (แนะนำรูปแนวตั้ง หรือรูปครึ่งตัวของผู้บริหาร)</p>
                        </div>

                        <hr class="border-slate-200 dark:border-white/5 my-4">

                        <h4 class="text-sm font-bold text-slate-950 dark:text-white"><i class="fa-solid fa-chart-simple text-indigo-500 mr-1.5"></i>ข้อมูลสถิติสถานศึกษา (สี่สถิติบนแถบสีน้ำเงินหน้าหลัก)</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Stat 1: Students -->
                            <div class="p-4 bg-slate-100/50 dark:bg-slate-950/20 border border-slate-200 dark:border-white/5 rounded-2xl space-y-3">
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1.5"><i class="fa-solid fa-user-graduate"></i> สถิติจำนวนนักเรียน</span>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">ตัวเลขหลัก (เช่น 2,500)</label>
                                    <input type="text" name="stat_students" value="<?php echo htmlspecialchars($settings['stat_students'] ?? ''); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">คำอธิบายเพิ่มเติม (เช่น นักเรียนทั้งหมด)</label>
                                    <input type="text" name="stat_students_sub" value="<?php echo htmlspecialchars($settings['stat_students_sub'] ?? 'นักเรียนทั้งหมด'); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Stat 2: Teachers -->
                            <div class="p-4 bg-slate-100/50 dark:bg-slate-950/20 border border-slate-200 dark:border-white/5 rounded-2xl space-y-3">
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1.5"><i class="fa-solid fa-chalkboard-user"></i> สถิติจำนวนครูและบุคลากร</span>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">ตัวเลขหลัก (เช่น 120)</label>
                                    <input type="text" name="stat_teachers" value="<?php echo htmlspecialchars($settings['stat_teachers'] ?? ''); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">คำอธิบายเพิ่มเติม (เช่น ครูและบุคลากรทางการศึกษา)</label>
                                    <input type="text" name="stat_teachers_sub" value="<?php echo htmlspecialchars($settings['stat_teachers_sub'] ?? 'ครูและบุคลากรทางการศึกษา'); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Stat 3: Awards -->
                            <div class="p-4 bg-slate-100/50 dark:bg-slate-950/20 border border-slate-200 dark:border-white/5 rounded-2xl space-y-3">
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1.5"><i class="fa-solid fa-trophy"></i> รางวัลและผลงานเด่น</span>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">ตัวเลขหลัก (เช่น 50+)</label>
                                    <input type="text" name="stat_awards" value="<?php echo htmlspecialchars($settings['stat_awards'] ?? ''); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">คำอธิบายเพิ่มเติม (เช่น รางวัลและความสำเร็จ)</label>
                                    <input type="text" name="stat_awards_sub" value="<?php echo htmlspecialchars($settings['stat_awards_sub'] ?? 'รางวัลและความสำเร็จ'); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>

                            <!-- Stat 4: Admissions -->
                            <div class="p-4 bg-slate-100/50 dark:bg-slate-950/20 border border-slate-200 dark:border-white/5 rounded-2xl space-y-3">
                                <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 flex items-center gap-1.5"><i class="fa-solid fa-percent"></i> อัตราการศึกษาต่อ</span>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">ตัวเลขหลัก (เช่น 100%)</label>
                                    <input type="text" name="stat_admission" value="<?php echo htmlspecialchars($settings['stat_admission'] ?? ''); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-semibold text-slate-600 dark:text-slate-400">คำอธิบายเพิ่มเติม (เช่น เข้าศึกษาต่อในระดับอุดมศึกษา)</label>
                                    <input type="text" name="stat_admission_sub" value="<?php echo htmlspecialchars($settings['stat_admission_sub'] ?? 'เข้าศึกษาต่อในระดับอุดมศึกษา'); ?>" class="w-full glass-input rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

                <!-- Submit Button Row -->
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="<?php echo BASE_URL; ?>admin" onclick="confirmCancel(event)" class="inline-flex items-center justify-center px-5 py-3 hover:bg-slate-100 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl transition-all whitespace-nowrap">ยกเลิกการแก้ไข</a>
                    <button type="submit" class="px-7 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-xl hover:shadow-indigo-500/20 transition-all flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fa-solid fa-save text-sm"></i> บันทึกการตั้งค่าทั้งหมด
                    </button>
                </div>
            </div>
            
        </form>
    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-100/50 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 border-t border-slate-200 dark:border-white/5 mt-auto py-6 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-slate-500 text-xs">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SCHOOL_NAME_EN; ?>. Admin Portal System.</p>
        </div>
    </footer>

    <!-- Interactive script switching logic -->
    <script>
        // Track unsaved changes
        let formChanged = false;
        const formEl = document.querySelector('form');
        if (formEl) {
            formEl.addEventListener('input', () => formChanged = true);
            formEl.addEventListener('change', () => formChanged = true);
        }

        function switchSettingTab(panelId) {
            // Hide all panels
            document.querySelectorAll('.setting-panel-pane').forEach(pane => {
                pane.classList.add('hidden');
            });

            // Reset all tab button styles
            document.querySelectorAll('.setting-tab-btn').forEach(btn => {
                btn.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/20', 'transform', '-translate-y-0.5', 'scale-[1.02]');
                btn.classList.add('text-slate-650', 'dark:text-slate-400', 'hover:text-slate-950', 'dark:hover:text-white', 'hover:bg-slate-200/50', 'dark:hover:bg-white/5');
                const icon = btn.querySelector('i');
                if (icon) {
                    icon.classList.remove('!text-white');
                }
            });

            // Show selected panel
            const activePanel = document.getElementById(`setting-panel-${panelId}`);
            if (activePanel) {
                activePanel.classList.remove('hidden');
            }

            // Style active tab button
            const activeBtn = document.getElementById(`tab-btn-${panelId}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-650', 'dark:text-slate-400', 'hover:text-slate-950', 'dark:hover:text-white', 'hover:bg-slate-200/50', 'dark:hover:bg-white/5');
                activeBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'shadow-indigo-500/20', 'transform', '-translate-y-0.5', 'scale-[1.02]');
                const icon = activeBtn.querySelector('i');
                if (icon) {
                    icon.classList.add('!text-white');
                }
            }

            // Update mobile select element if it exists
            const mobileSelect = document.getElementById('mobile-tab-select');
            if (mobileSelect) {
                mobileSelect.value = panelId;
            }

            // Save active tab inside temporary state
            localStorage.setItem('active_setting_tab', panelId);
        }

        // Live image uploads preview
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    const placeholder = document.getElementById(previewId + '_placeholder');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(input.files[0]);
                formChanged = true;
            }
        }

        // SweetAlert2 Theme Options
        function getSwalThemeOptions() {
            const isDark = document.documentElement.classList.contains('dark');
            return {
                background: isDark ? '#1e293b' : '#ffffff', // slate-800 or white
                color: isDark ? '#f8fafc' : '#1e293b', // slate-50 or slate-800
                confirmButtonColor: '#4f46e5', // indigo-600
                cancelButtonColor: '#64748b' // slate-500
            };
        }

        // Confirm Cancel / Discard Changes
        function confirmCancel(event) {
            if (formChanged) {
                event.preventDefault();
                const url = event.currentTarget.getAttribute('href');
                const themeOpts = getSwalThemeOptions();
                Swal.fire({
                    title: 'ละทิ้งการเปลี่ยนแปลง?',
                    text: 'คุณมีรายละเอียดการตั้งค่าที่ยังไม่ได้กดบันทึก ต้องการย้อนกลับโดยละทิ้งการแก้ไขหรือไม่?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'ใช่, ละทิ้งการแก้ไข',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonColor: '#ef4444', // red-500
                    ...themeOpts
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }
        }

        // Confirm Logout
        function confirmLogout(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');
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

        // Initialize active tab and UI theme highlights on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            const activeTab = localStorage.getItem('active_setting_tab') || 'general';
            switchSettingTab(activeTab);

            const currentTheme = localStorage.getItem('school_theme') || 'dark';
            updateThemeUI(currentTheme);
        });
    </script>
</body>
</html>
