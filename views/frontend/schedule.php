<!-- views/frontend/schedule.php -->
<!-- Public Class Schedule View (Unified student/teacher view) -->

<!-- Hero Header Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1506784983877-45594efa4cbe?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider font-english">
            <?php echo __('cat_academic_schedule'); ?>
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white"><?php echo $scheduleType === 'student' ? __('info_schedule_student') : __('info_schedule_teacher'); ?></h1>
        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            <?php echo $scheduleType === 'student' ? 'ตารางเรียนปีการศึกษาล่าสุดของโรงเรียน สำหรับนักเรียนระดับชั้นมัธยมศึกษาปีที่ 1 - 6' : 'ตารางสอนและภาระงานของคณะครูอาจารย์โรงเรียนประจำปีการศึกษาล่าสุด'; ?>
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
    <?php if (empty($scheduleUrl) && $scheduleType === 'student'): ?>
        <!-- Fallback Warning: When no student schedule URL is set -->
        <div class="max-w-2xl mx-auto bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-950/5 dark:border-white/10 rounded-3xl p-8 text-center space-y-6 shadow-2xl animate-fade-in-up">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
            </div>
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">ยังไม่มีการอัปโหลดข้อมูลตารางเรียน</h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                    ขณะนี้อยู่ในระหว่างการจัดทำและอัปเดตข้อมูลตารางเรียน หากมีข้อสงสัยหรือต้องการข้อมูลเพิ่มเติม กรุณาติดต่อฝ่ายวิชาการ
                </p>
            </div>
            <div class="pt-4 flex flex-col sm:flex-row justify-center gap-3">
                <a href="<?php echo BASE_URL; ?>" class="inline-flex items-center justify-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fa-solid fa-home mr-2"></i>กลับไปยังหน้าหลัก
                </a>
            </div>
        </div>
    <?php else: ?>

        <div class="space-y-8 animate-fade-in-up">
            
            <!-- TEACHER VIEW: Filters & Interactive Mode Toggle -->
            <?php if ($scheduleType === 'teacher'): ?>
                <div class="bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-900/5 dark:border-white/10 rounded-3xl p-6 shadow-xl">
                    <form id="filter-form" action="" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                        <input type="hidden" name="view_mode" id="view-mode-input" value="<?php echo htmlspecialchars($viewMode); ?>">
                        
                        <!-- Department Filter -->
                        <div class="space-y-2">
                            <label for="dept-select" class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                <i class="fa-solid fa-network-wired mr-1.5 text-indigo-500"></i>กลุ่มสาระการเรียนรู้
                            </label>
                            <select id="dept-select" name="dept" onchange="onDeptChange()" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl text-xs font-semibold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                                <option value="">-- เลือกทุกกลุ่มสาระ --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo htmlspecialchars($dept); ?>" <?php echo $selectedDept === $dept ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($dept); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Teacher Filter (with Search Autocomplete) -->
                        <div class="space-y-2 relative" id="teacher-autocomplete-container">
                            <label for="teacher-search-input" class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">
                                <i class="fa-solid fa-chalkboard-user mr-1.5 text-indigo-500"></i>ครูผู้สอน
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                                </span>
                                <input type="text" id="teacher-search-input" placeholder="พิมพ์เพื่อค้นหาครู..." autocomplete="off"
                                       class="w-full pl-10 pr-10 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-2xl text-xs font-semibold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                                <button type="button" id="clear-search-btn" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hidden">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </button>
                            </div>
                            <!-- Hidden select for compatibility with form submit -->
                            <select id="teacher-select" name="teacher_id" class="hidden">
                                <option value="">-- เลือกครูผู้สอน --</option>
                            </select>
                            
                            <!-- Search Autocomplete Dropdown List -->
                            <div id="teacher-search-dropdown" class="hidden absolute left-0 right-0 mt-1 max-h-64 overflow-y-auto bg-white dark:bg-slate-950 border border-slate-200 dark:border-white/10 rounded-2xl shadow-2xl z-[100] divide-y divide-slate-100 dark:divide-white/5 scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800">
                            </div>
                        </div>

                        <!-- Mode Switcher Toggle Button Group -->
                        <div class="flex flex-col space-y-2 md:items-end">
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider md:mr-4">รูปแบบการแสดงผล</span>
                            <div class="flex items-center bg-slate-100 dark:bg-slate-900/50 p-1.5 rounded-2xl w-full md:w-fit border border-slate-200 dark:border-white/5 shadow-inner">
                                <button type="button" onclick="setViewMode('interactive')" class="flex-grow md:flex-grow-0 px-4 py-2 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 font-bold <?php echo $viewMode === 'interactive' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200'; ?>">
                                    <i class="fa-solid fa-calendar-days text-xs"></i>
                                    <span>ตารางเรียนออนไลน์</span>
                                </button>
                                <button type="button" onclick="setViewMode('pdf')" class="flex-grow md:flex-grow-0 px-4 py-2 rounded-xl text-xs transition-all flex items-center justify-center gap-1.5 font-bold <?php echo $viewMode === 'pdf' ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200'; ?>">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                    <span>ไฟล์เอกสาร PDF / โฟลเดอร์</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- MAIN VIEW CONTAINER -->
            <?php if ($scheduleType === 'teacher' && $viewMode === 'interactive'): ?>
                
                <?php if (empty($selectedTeacherId)): ?>
                    <!-- Onboarding Guide: When no teacher is selected yet -->
                    <div class="max-w-2xl mx-auto bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-950/5 dark:border-white/10 rounded-3xl p-10 text-center space-y-6 shadow-2xl">
                        <div class="w-24 h-24 mx-auto rounded-3xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <i class="fa-solid fa-calendar-days text-4xl animate-pulse"></i>
                        </div>
                        <div class="space-y-2">
                            <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">กรุณาเลือกรายชื่อครูผู้สอน</h2>
                            <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                                เพื่อดูรายละเอียดตารางสอน คาบเรียน รายวิชา และห้องเรียนของอาจารย์แต่ละท่านแบบออนไลน์
                            </p>
                        </div>
                        <div class="pt-4 flex flex-col sm:flex-row justify-center gap-3">
                            <button type="button" onclick="setViewMode('pdf')" class="inline-flex items-center justify-center px-5 py-3 bg-slate-200/50 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-300 dark:border-white/10 transition-all duration-300">
                                <i class="fa-solid fa-folder-open mr-2 text-amber-500"></i>หรือดูในโฟลเดอร์ PDF ทั้งหมด
                            </button>
                        </div>
                    </div>
                <?php else: ?>
                    <style>
                        /* Aurora Effect Background */
                        .timetable-wrapper {
                            position: relative;
                            isolation: isolate;
                        }
                        .timetable-wrapper::before {
                            content: '';
                            position: absolute;
                            inset: -20px;
                            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(59, 130, 246, 0.08));
                            filter: blur(40px);
                            z-index: -1;
                            border-radius: 999px;
                            animation: timetableGlow 10s ease-in-out infinite;
                        }
                        @keyframes timetableGlow {
                            0%, 100% { opacity: 0.4; transform: scale(1); }
                            50% { opacity: 0.6; transform: scale(1.03); }
                        }

                        /* Timetable Cell Styles */
                        .timetable-cell {
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        }
                        .timetable-cell:not(.empty):hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08);
                            z-index: 10;
                        }

                        /* Subject Card Styles */
                        .subject-card {
                            padding: 0.5rem;
                            border-radius: 0.75rem;
                            border: 1px solid rgba(255, 255, 255, 0.5);
                            backdrop-filter: blur(4px);
                        }

                        /* Mobile Day Strip */
                        @media (max-width: 768px) {
                            .mobile-day-selector::-webkit-scrollbar {
                                display: none;
                            }
                            .mobile-day-selector {
                                -ms-overflow-style: none;
                                scrollbar-width: none;
                                overflow-x: auto;
                                -webkit-overflow-scrolling: touch;
                            }
                        }
                        
                        /* Animation for Switching Days on Mobile */
                        .mobile-day-content.active {
                            animation: fadeInSlide 0.4s ease-out forwards;
                        }
                        @keyframes fadeInSlide {
                            from { opacity: 0; transform: translateY(10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                    </style>

                    <!-- Dynamic Timetable Grid Wrapper -->
                    <div class="timetable-wrapper bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-900/5 dark:border-white/10 rounded-3xl overflow-hidden shadow-2xl p-6 sm:p-8 space-y-6">
                        <!-- Timetable Header with Metadata and Actions -->
                        <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 pb-6 border-b border-slate-200 dark:border-white/5">
                            <div class="space-y-1.5">
                                <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    <i class="fa-solid fa-id-card-clip text-indigo-550 text-indigo-500"></i>
                                    <span>ตารางสอนประจำสัปดาห์: <?php echo htmlspecialchars($selectedTeacherName); ?></span>
                                </h2>
                                <div class="flex flex-wrap items-center gap-2 text-xs">
                                    
                                    <?php if (!empty($selectedDept)): ?>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 rounded-full font-bold shadow-sm ring-1 ring-emerald-100 dark:ring-emerald-800/30">
                                        <i class="fa-solid fa-network-wired text-emerald-500"></i> <?php echo htmlspecialchars($selectedDept); ?>
                                    </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            

                        </div>

                        <?php
                        $subjectTypeColors = [
                            'พื้นฐาน' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-500/20',
                            'เพิ่มเติม' => 'bg-sky-500/10 text-sky-700 dark:text-sky-400 border-sky-500/20',
                            'กิจกรรมพัฒนาผู้เรียน' => 'bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-500/20',
                            'อื่นๆ' => 'bg-slate-500/10 text-slate-700 dark:text-slate-400 border-slate-500/20'
                        ];
                        $periodTimes = [
                            1 => '08:30–09:25', 2 => '09:25–10:20', 3 => '10:20–11:15',
                            4 => '11:15–12:10', 5 => '12:10–13:05', 6 => '13:05–14:00',
                            7 => '14:00–14:55', 8 => '14:55–15:50'
                        ];
                        ?>

                        <!-- Desktop View (Horizontal Table) -->
                        <div class="hidden md:block overflow-x-auto rounded-2xl border border-slate-200 dark:border-white/10 shadow-lg bg-white dark:bg-slate-950/20">
                            <table class="w-full text-left border-collapse min-w-[950px]" id="timetableMainTable">
                                <thead>
                                    <tr class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                                        <th class="p-5 text-center font-bold border-b border-white/10 w-28 bg-white/10 dark:bg-black/20">
                                            <i class="fa-solid fa-calendar-days mb-1 block opacity-85 text-sm text-yellow-400"></i> วัน \ คาบ
                                        </th>
                                        <?php foreach ($periods as $p): ?>
                                        <th class="p-4 text-center border-b border-white/10 min-w-[130px] border-r border-white/5 last:border-r-0">
                                            <div class="text-[11px] font-black uppercase tracking-wider text-slate-100 opacity-90">คาบที่ <?= $p ?></div>
                                            <div class="text-[9px] font-semibold mt-1 inline-flex items-center gap-1 bg-white/10 px-2 py-0.5 rounded-full text-slate-100">
                                                <i class="fa-regular fa-clock text-[8px]"></i> <?= $periodTimes[$p] ?>
                                            </div>
                                        </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <?php 
                                    $dayEmojis = ['จันทร์'=>'🌞','อังคาร'=>'🔥','พุธ'=>'🌳','พฤหัสบดี'=>'⚡','ศุกร์'=>'💧'];
                                    $dayColors = [
                                        'จันทร์' => 'bg-yellow-500/10 text-yellow-700 dark:text-yellow-400 border-l-yellow-500',
                                        'อังคาร' => 'bg-pink-500/10 text-pink-700 dark:text-pink-400 border-l-pink-500',
                                        'พุธ' => 'bg-green-500/10 text-green-700 dark:text-green-400 border-l-green-500',
                                        'พฤหัสบดี' => 'bg-orange-500/10 text-orange-700 dark:text-orange-400 border-l-orange-500',
                                        'ศุกร์' => 'bg-sky-500/10 text-sky-700 dark:text-sky-400 border-l-sky-500'
                                    ];
                                    foreach ($days as $day): ?>
                                    <tr class="hover:bg-slate-500/5 dark:hover:bg-slate-800/30 transition-colors">
                                        <td class="p-4 text-center font-bold border-r border-slate-200 dark:border-slate-800 <?= $dayColors[$day] ?? '' ?> border-l-8 bg-slate-50/10 dark:bg-slate-900/10">
                                            <div class="text-[10px] uppercase tracking-wider font-extrabold opacity-60 mb-0.5"><?= $day ?></div>
                                            <div class="text-xl"><?= $dayEmojis[$day] ?? '' ?></div>
                                        </td>
                                        <?php 
                                        foreach ($periods as $p):
                                            $cell = $scheduleGrid[$day][$p] ?? null;
                                            if ($cell === 'occupied') {
                                                continue;
                                            }
                                            $span = $cell ? min(9 - $p, $cell['span']) : 1;
                                        ?>
                                        <td class="p-2 min-h-[100px] border-r border-slate-200 dark:border-slate-800 last:border-r-0" <?php if ($span > 1) echo 'colspan="' . $span . '"'; ?>>
                                            <?php if ($cell): 
                                                $class = $cell['class'];
                                                $type = $class['subject_type'] ?? 'อื่นๆ';
                                                $colorClass = $subjectTypeColors[$type] ?? $subjectTypeColors['อื่นๆ'];
                                                $levelText = isset($class['level']) ? 'ม.' . intval($class['level']) : '';
                                                $classRoom = trim($class['class_room'] ?? '');
                                                $levelRoom = ($levelText ?? '') . ($classRoom ? '/' . preg_replace('/^ห้อง\s*/u', '', $classRoom) : '');
                                            ?>
                                                <div class="timetable-cell subject-card <?= $colorClass ?> shadow-sm hover:scale-[1.02] active:scale-95 cursor-pointer relative overflow-hidden group select-none">
                                                    <div class="font-extrabold text-[10px] leading-tight mb-0.5"><?= htmlspecialchars($class['code']) ?></div>
                                                    <div class="text-[10px] font-bold text-slate-900/80 dark:text-white/80 line-clamp-2 min-h-[2.4em]" title="<?= htmlspecialchars($class['subject_name']) ?>">
                                                        <?= htmlspecialchars($class['subject_name']) ?>
                                                    </div>
                                                    <?php if (!empty($classRoom)): ?>
                                                    <div class="text-[9px] mt-1.5 font-bold opacity-80 flex items-center gap-1 text-slate-655 text-slate-650 dark:text-slate-350">
                                                        <i class="fa-solid fa-door-open text-[8px] text-indigo-500"></i> 
                                                        <span><?= htmlspecialchars($levelRoom) ?></span>
                                                    </div>
                                                    <?php endif; ?>
                                                    <!-- Subtle decoration icon -->
                                                    <i class="fa-solid fa-graduation-cap absolute -right-1 -bottom-1 opacity-5 text-lg group-hover:opacity-10 transition-opacity"></i>
                                                </div>
                                            <?php else: ?>
                                                <div class="flex items-center justify-center h-full text-slate-200 dark:text-slate-850 py-6">
                                                    <i class="fa-solid fa-ellipsis"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile View (Daily Vertical Flip Cards) -->
                        <div class="md:hidden space-y-4">
                            <!-- Modern Day Tabs Selector -->
                            <div class="mobile-day-selector p-1.5 bg-slate-100/80 dark:bg-slate-900/60 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-white/5 shadow-inner mb-6 sticky top-[72px] z-20">
                                <div class="flex gap-2">
                                    <?php foreach ($days as $index => $day): ?>
                                    <button type="button" onclick="switchMobileDay('<?= $day ?>')" id="tab-<?= $day ?>"
                                        class="flex-shrink-0 flex flex-col items-center justify-center w-14 h-14 rounded-xl font-bold text-xs transition-all shadow-sm active:scale-90 border border-slate-200/50 dark:border-white/5
                                        <?= $index === 0 ? 'bg-indigo-600 text-white ring-4 ring-indigo-600/20 font-extrabold' : 'bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400' ?>">
                                        <span class="text-base opacity-95"><?= substr($dayEmojis[$day], 0, 4) ?></span>
                                        <span class="mt-0.5 text-[10px]"><?= mb_substr($day, 0, 1) ?></span>
                                    </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Mobile Cards List -->
                            <div id="mobileCardsContainer">
                                <?php foreach ($days as $dayIndex => $day): ?>
                                <div data-day="<?= $day ?>" class="mobile-day-content <?= $dayIndex === 0 ? 'active' : 'hidden' ?> space-y-4">
                                    <div class="flex items-center justify-between px-2">
                                        <h2 class="text-base font-black text-slate-800 dark:text-white flex items-center gap-2">
                                            <span class="p-1.5 bg-white dark:bg-slate-900 rounded-xl shadow border border-slate-200 dark:border-white/5"><?= $dayEmojis[$day] ?></span>
                                            วัน<?= $day ?>
                                        </h2>
                                        <?php 
                                        $dayTotalCount = 0;
                                        foreach ($periods as $p) {
                                            $cell = $scheduleGrid[$day][$p] ?? null;
                                            if ($cell && $cell !== 'occupied') {
                                                $dayTotalCount++;
                                            }
                                        }
                                        ?>
                                        <div class="px-2.5 py-1 bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-full text-[10px] font-black">
                                             <?= $dayTotalCount ?> วิชาเรียน
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-3">
                                        <?php 
                                        $hasAnyEntry = false;
                                        foreach ($periods as $p):
                                            $cell = $scheduleGrid[$day][$p] ?? null;
                                            if ($cell && $cell !== 'occupied'):
                                                $hasAnyEntry = true;
                                                $class = $cell['class'];
                                                $type = $class['subject_type'] ?? 'อื่นๆ';
                                                $colorClass = $subjectTypeColors[$type] ?? $subjectTypeColors['อื่นๆ'];
                                                $levelText = isset($class['level']) ? 'ม.' . intval($class['level']) : '';
                                                $classRoom = trim($class['class_room'] ?? '');
                                                $levelRoom = ($levelText ?? '') . ($classRoom ? '/' . preg_replace('/^ห้อง\s*/u', '', $classRoom) : '');
                                        ?>
                                        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl shadow border border-slate-150 dark:border-slate-850 border-l-8 <?= $colorClass ?> relative overflow-hidden active:scale-[0.98] transition-all cursor-pointer">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="px-2 py-0.5 bg-black/5 dark:bg-white/5 rounded-lg text-[9px] font-bold text-slate-500 uppercase flex items-center gap-1">
                                                            <i class="fa-regular fa-clock text-[8px]"></i> <?= $periodTimes[$p] ?>
                                                        </span>
                                                        <span class="text-[9px] font-extrabold text-indigo-650 dark:text-indigo-400 font-bold">คาบ <?= $p ?> (<?= $cell['span'] ?> คาบ)</span>
                                                    </div>
                                                    <h3 class="font-extrabold text-sm text-slate-900 dark:text-white leading-tight mb-0.5">
                                                        <?= htmlspecialchars($class['code']) ?>
                                                    </h3>
                                                    <p class="text-xs text-slate-650 dark:text-slate-400 font-bold leading-snug">
                                                        <?= htmlspecialchars($class['subject_name']) ?>
                                                    </p>
                                                    
                                                    <div class="flex items-center gap-4 mt-3 pt-3 border-t border-slate-100 dark:border-slate-800/50">
                                                        <?php if (!empty($classRoom)): ?>
                                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                                                            <i class="fa-solid fa-door-open text-indigo-500 text-[9px]"></i>
                                                            <span><?= htmlspecialchars($levelRoom) ?></span>
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-slate-500">
                                                            <i class="fa-solid fa-layer-group text-indigo-500 text-[9px]"></i>
                                                            <span><?= htmlspecialchars($type) ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="absolute right-[-10px] bottom-[-10px] opacity-[0.03] transform rotate-[15deg] pointer-events-none">
                                                <i class="fa-solid fa-graduation-cap text-6xl"></i>
                                            </div>
                                        </div>
                                        <?php endif; endforeach; ?>
                                        
                                        <?php if (!$hasAnyEntry): ?>
                                        <div class="flex flex-col items-center justify-center py-10 text-center bg-white/50 dark:bg-slate-900/40 rounded-2xl border-dashed border-2 border-slate-200 dark:border-slate-800 opacity-80">
                                            <div class="text-4xl mb-3 grayscale">🍦</div>
                                            <h3 class="text-sm font-bold text-slate-400 dark:text-slate-500 mb-0.5 italic">ไม่มีคาบสอนวันนี้</h3>
                                            <p class="text-[8px] text-slate-400 dark:text-slate-650 uppercase font-black tracking-wider leading-loose">Relax & Re-charge Yourself!</p>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                
                <!-- Google Drive PDF Embed View -->
                <?php 
                    $isFolder = (strpos($scheduleUrl, 'folders') !== false || strpos($embedUrl, 'embeddedfolderview') !== false);
                ?>
                <div class="bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-900/5 dark:border-white/10 rounded-3xl overflow-hidden shadow-2xl p-6 sm:p-8 space-y-6 transition-all duration-300">
                    
                    <!-- Quick Toolbar -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200 dark:border-white/5">
                        <div class="space-y-1">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <i class="<?php echo $isFolder ? 'fa-solid fa-folder-open text-amber-500' : 'fa-regular fa-file-pdf text-red-500'; ?> text-xl"></i>
                                <span><?php echo $isFolder ? ($scheduleType === 'student' ? 'โฟลเดอร์เอกสารตารางเรียนนักเรียน' : 'โฟลเดอร์เอกสารตารางสอนครู') : ($scheduleType === 'student' ? 'เอกสารตารางเรียนนักเรียนอย่างเป็นทางการ' : 'เอกสารตารางสอนครูอย่างเป็นทางการ'); ?></span>
                            </h2>
                            <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400">
                                <?php echo $isFolder ? 'เลือกดูและดาวน์โหลดไฟล์ตารางเวลาจากรายการด้านล่าง' : 'ไฟล์รูปแบบ PDF สามารถขยาย ซูม หรือพิมพ์ตารางได้ตามปกติ'; ?>
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <?php if ($isFolder): ?>
                                <a href="<?php echo htmlspecialchars($scheduleUrl); ?>" target="_blank" rel="noopener" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                                    <i class="fa-solid fa-folder-open mr-2"></i>เปิดโฟลเดอร์ในแท็บใหม่
                                </a>
                            <?php else: ?>
                                <a href="<?php echo htmlspecialchars($scheduleUrl); ?>" target="_blank" rel="noopener" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                                    <i class="fa-solid fa-external-link-alt mr-2"></i>เปิดในแท็บใหม่
                                </a>
                                <a href="<?php echo htmlspecialchars($scheduleUrl); ?>" target="_blank" rel="noopener" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-lg hover:shadow-rose-500/20 transition-all duration-300 transform hover:-translate-y-0.5">
                                    <i class="fa-solid fa-download mr-2"></i>ดาวน์โหลด PDF
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- PDF Viewer Embed Frame -->
                    <div class="relative w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-white/10 bg-slate-900 shadow-inner animate-pulse" style="height: 75vh;" id="pdf-container">
                        <iframe src="<?php echo htmlspecialchars($embedUrl); ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay" loading="lazy" title="<?php echo htmlspecialchars($scheduleType === 'student' ? 'ตารางเรียนนักเรียน' : 'ตารางสอนครู'); ?>" onload="document.getElementById('pdf-container').classList.remove('animate-pulse')"></iframe>
                    </div>

                    <!-- Supporting Information / Instruction Tips -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-indigo-500/5 border border-indigo-500/10">
                            <div class="p-2 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 shrink-0">
                                <i class="fa-solid fa-mobile-screen"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">การดูผ่านโทรศัพท์มือถือ</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                    เพื่อความสะดวกและรวดเร็ว แนะนำให้กดปุ่ม "เปิดในแท็บใหม่" (หรือ "ดาวน์โหลด PDF" สำหรับไฟล์) เพื่อเปิดดูผ่านแอปพลิเคชัน Google Drive ในเครื่อง
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/10">
                            <div class="p-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 shrink-0">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">ขยายเพื่อความคมชัด</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                    ท่านสามารถใช้การจีบนิ้วเพื่อซูมเข้าหรือออก หรือเลื่อนปุ่มควบคุมในกรอบแสดงเอกสารด้านบนเพื่อปรับขนาดเอกสารได้ตามต้องการ
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-amber-500/5 border border-amber-500/10">
                            <div class="p-2 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 shrink-0">
                                <i class="fa-solid fa-circle-question"></i>
                            </div>
                            <div class="space-y-1">
                                <h4 class="text-xs font-bold text-slate-900 dark:text-white">พบข้อผิดพลาดของตาราง?</h4>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed">
                                    หากข้อมูลชั้นเรียน รายวิชา หรืออาจารย์ผู้สอนสะกดไม่ถูกต้อง กรุณาติดต่อห้องกลุ่มงานวิชาการเพื่อรายงานและดำเนินการแก้ไขตาราง
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            <?php endif; ?>

        </div>
    <?php endif; ?>
</section>

<!-- TEACHER DYNAMIC FILTER JAVASCRIPT & EXPORTS -->
<?php if ($scheduleType === 'teacher'): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    // Embedded JSON data for client-side dropdown filtering
    const teachersGrouped = <?php echo json_encode($teachersGrouped, JSON_UNESCAPED_UNICODE); ?>;
    const selectedTeacherId = <?php echo json_encode($selectedTeacherId); ?>;
    const selectedDept = <?php echo json_encode($selectedDept); ?>;

    let activeTeachers = [];
    let focusedIndex = -1;

    /**
     * Re-populates the active teachers array and the hidden select dropdown
     */
    function onDeptChange() {
        const deptSelect = document.getElementById('dept-select');
        const teacherSelect = document.getElementById('teacher-select');
        const searchInput = document.getElementById('teacher-search-input');
        const clearBtn = document.getElementById('clear-search-btn');
        const dept = deptSelect.value;

        // Clear existing option list
        teacherSelect.innerHTML = '<option value="">-- เลือกครูผู้สอน --</option>';
        activeTeachers = [];

        if (dept && teachersGrouped[dept]) {
            // Populate active teachers from chosen department
            activeTeachers = [...teachersGrouped[dept]];
        } else if (!dept) {
            // Populate all unique teachers
            const allTeachers = [];
            Object.keys(teachersGrouped).forEach(d => {
                teachersGrouped[d].forEach(t => {
                    if (!allTeachers.some(at => at.id === t.id)) {
                        allTeachers.push(t);
                    }
                });
            });
            // Sort alphabetically by Thai collator
            allTeachers.sort((a, b) => a.name.localeCompare(b.name, 'th'));
            activeTeachers = allTeachers;
        }

        // Populate hidden select box for fallback/compatibility
        activeTeachers.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.id;
            opt.textContent = t.name;
            if (t.id === selectedTeacherId) {
                opt.selected = true;
            }
            teacherSelect.appendChild(opt);
        });

        // Set search input display value based on selection
        const selectedTeacher = activeTeachers.find(t => t.id === selectedTeacherId);
        if (selectedTeacher) {
            searchInput.value = selectedTeacher.name;
            teacherSelect.value = selectedTeacher.id;
            clearBtn.classList.remove('hidden');
        } else {
            // If the selected teacher is not in this department, clear selection
            if (selectedTeacherId && deptSelect.value) {
                searchInput.value = '';
                teacherSelect.value = '';
                clearBtn.classList.add('hidden');
            } else if (!selectedTeacherId) {
                searchInput.value = '';
                teacherSelect.value = '';
                clearBtn.classList.add('hidden');
            }
        }
    }

    /**
     * Renders autocomplete dropdown options based on the filter query
     */
    function renderDropdownOptions(filterText = '') {
        const dropdown = document.getElementById('teacher-search-dropdown');
        const teacherSelect = document.getElementById('teacher-select');
        const query = filterText.trim().toLowerCase();
        
        dropdown.innerHTML = '';
        focusedIndex = -1;

        // Filter active teachers list by name or ID
        const filtered = activeTeachers.filter(t => 
            t.name.toLowerCase().includes(query) || 
            t.id.includes(query)
        );

        if (filtered.length === 0) {
            const noResult = document.createElement('div');
            noResult.className = 'px-4 py-3 text-xs text-slate-400 dark:text-slate-500 font-bold text-center italic bg-slate-50/50 dark:bg-slate-900/10';
            noResult.textContent = 'ไม่พบข้อมูลครูผู้สอน';
            dropdown.appendChild(noResult);
            return;
        }

        filtered.forEach((t, index) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.dataset.id = t.id;
            btn.dataset.index = index;
            
            // Highlight query text in results
            let displayName = t.name;
            if (query) {
                const escapedQuery = query.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                const regex = new RegExp(`(${escapedQuery})`, 'gi');
                displayName = t.name.replace(regex, '<mark class="bg-yellow-255 dark:bg-yellow-800/60 text-slate-950 dark:text-white rounded-sm px-0.5">$1</mark>');
            }

            const isSelected = t.id === teacherSelect.value;
            btn.className = `w-full text-left px-4 py-3 text-xs font-bold transition-all duration-150 cursor-pointer block focus:outline-none ${
                isSelected 
                ? 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-l-4 border-indigo-500' 
                : 'text-slate-700 dark:text-slate-200 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-600 dark:hover:text-white'
            }`;
            
            btn.innerHTML = `<div class="flex items-center justify-between pointer-events-none">
                <span>${displayName}</span>
            </div>`;

            btn.addEventListener('click', () => {
                selectTeacher(t.id, t.name);
            });

            dropdown.appendChild(btn);
        });
    }

    /**
     * Handles selecting a teacher from the autocomplete dropdown
     */
    function selectTeacher(id, name) {
        const searchInput = document.getElementById('teacher-search-input');
        const teacherSelect = document.getElementById('teacher-select');
        const dropdown = document.getElementById('teacher-search-dropdown');
        const clearBtn = document.getElementById('clear-search-btn');

        searchInput.value = name;
        teacherSelect.value = id;
        clearBtn.classList.remove('hidden');
        dropdown.classList.add('hidden');

        // Submit the form
        document.getElementById('filter-form').submit();
    }

    /**
     * Switch view mode between interactive and PDF
     * @param {string} mode
     */
    function setViewMode(mode) {
        document.getElementById('view-mode-input').value = mode;
        document.getElementById('filter-form').submit();
    }

    /**
     * Switch Mobile View Day
     */
    function switchMobileDay(day) {
        // 1. Update Buttons Styling
        document.querySelectorAll('[id^="tab-"]').forEach(btn => {
            btn.classList.remove('bg-indigo-600', 'text-white', 'ring-4', 'ring-indigo-600/20', 'font-extrabold');
            btn.classList.add('bg-white', 'dark:bg-slate-800', 'text-slate-500', 'dark:text-slate-400');
        });
        
        const activeBtn = document.getElementById('tab-' + day);
        if (activeBtn) {
            activeBtn.classList.remove('bg-white', 'dark:bg-slate-800', 'text-slate-500', 'dark:text-slate-400');
            activeBtn.classList.add('bg-indigo-600', 'text-white', 'ring-4', 'ring-indigo-600/20', 'font-extrabold');
        }
        
        // 2. Switch Content with Fade Animation
        const allContents = document.querySelectorAll('.mobile-day-content');
        allContents.forEach(content => {
            content.classList.remove('active');
            content.classList.add('hidden');
        });
        
        const activeContent = document.querySelector(`[data-day="${day}"]`);
        if (activeContent) {
            activeContent.classList.remove('hidden');
            void activeContent.offsetWidth; // Force a reflow
            activeContent.classList.add('active');
        }
        
        // 3. Smooth scroll target tab into center
        if (activeBtn) {
            activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        }
    }

    // Initialize all logic on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        // Setup Search Input Elements
        const searchInput = document.getElementById('teacher-search-input');
        const dropdown = document.getElementById('teacher-search-dropdown');
        const clearBtn = document.getElementById('clear-search-btn');
        const teacherSelect = document.getElementById('teacher-select');
        const filterForm = document.getElementById('filter-form');

        // Populate dropdowns and initialize starting values
        onDeptChange();

        if (searchInput) {
            // Show options on focus
            searchInput.addEventListener('focus', () => {
                dropdown.classList.remove('hidden');
                renderDropdownOptions(searchInput.value);
            });

            // Filter options on typing
            searchInput.addEventListener('input', () => {
                dropdown.classList.remove('hidden');
                renderDropdownOptions(searchInput.value);
                if (searchInput.value) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            });

            // Keyboard navigation on search input
            searchInput.addEventListener('keydown', (e) => {
                const items = dropdown.querySelectorAll('button[data-id]');
                if (!items.length) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    focusedIndex = (focusedIndex + 1) % items.length;
                    items[focusedIndex].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    focusedIndex = (focusedIndex - 1 + items.length) % items.length;
                    items[focusedIndex].focus();
                } else if (e.key === 'Escape') {
                    dropdown.classList.add('hidden');
                    searchInput.focus();
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (focusedIndex >= 0 && items[focusedIndex]) {
                        items[focusedIndex].click();
                    } else if (items.length === 1) {
                        items[0].click();
                    }
                }
            });

            // Keyboard navigation inside dropdown container
            dropdown.addEventListener('keydown', (e) => {
                const items = dropdown.querySelectorAll('button[data-id]');
                if (!items.length) return;

                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    focusedIndex = (focusedIndex + 1) % items.length;
                    items[focusedIndex].focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    focusedIndex = (focusedIndex - 1 + items.length) % items.length;
                    if (focusedIndex < 0) {
                        focusedIndex = -1;
                        searchInput.focus();
                    } else {
                        items[focusedIndex].focus();
                    }
                } else if (e.key === 'Escape') {
                    dropdown.classList.add('hidden');
                    searchInput.focus();
                }
            });

            // Clear search button behavior
            clearBtn?.addEventListener('click', () => {
                searchInput.value = '';
                teacherSelect.value = '';
                clearBtn.classList.add('hidden');
                dropdown.classList.add('hidden');
                // Submit form to reset filter
                filterForm.submit();
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            const container = document.getElementById('teacher-autocomplete-container');
            if (container && !container.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Excel Export
        document.getElementById('btnExportExcel')?.addEventListener('click', () => {
            const table = document.getElementById('timetableMainTable');
            if (!table) return;
            const wb = XLSX.utils.table_to_book(table, { 
                sheet: "Timetable_Data",
                raw: false,
                display: true
            });
            XLSX.writeFile(wb, `Timetable_Report_<?php echo htmlspecialchars($selectedTeacherId); ?>_${new Date().toISOString().split('T')[0]}.xlsx`);
        });

        // PDF Export
        document.getElementById('btnExportPDF')?.addEventListener('click', () => {
            const element = document.querySelector('.timetable-wrapper');
            if (!element) return;
            const opt = {
                margin:       [10, 10, 10, 10],
                filename:     `Weekly_Timetable_<?php echo urlencode($selectedTeacherName); ?>.pdf`,
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { 
                    scale: 3, 
                    useCORS: true, 
                    letterRendering: true,
                    backgroundColor: '#ffffff'
                },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' },
                pagebreak:    { mode: 'avoid-all' }
            };
            
            Swal.fire({
                title: '🎨 กำลังเตรียมไฟล์ PDF...',
                text: 'รอกระบวนการสักครู่ครับ',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            html2pdf().set(opt).from(element).save().then(() => {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'ดาวน์โหลดสำเร็จ',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        });

        // CSV Export
        document.getElementById('btnExportCSV')?.addEventListener('click', () => {
            const rows = [];
            const table = document.getElementById('timetableMainTable');
            if(!table) return;
            
            const headers = ["วัน", "คาบ", "รหัสวิชา", "ชื่อวิชา", "ระดับ/ห้อง"];
            rows.push(headers);

            const tbodyRows = table.querySelectorAll('tbody tr');
            tbodyRows.forEach((tr) => {
                const day = tr.querySelector('td:first-child div:first-child')?.innerText || '';
                const cells = tr.querySelectorAll('td:not(:first-child)');
                cells.forEach((cell, pIndex) => {
                    const chips = cell.querySelectorAll('.subject-card');
                    chips.forEach(chip => {
                        const code = chip.querySelector('.font-extrabold')?.innerText || '';
                        const name = chip.querySelector('.text-\\[10px\\].font-bold')?.innerText || '';
                        const room = chip.querySelector('.text-\\[9px\\]')?.innerText || '';
                        rows.push([day, pIndex + 1, code, name, room]);
                    });
                });
            });

            const csvContent = "\uFEFF" + rows.map(e => e.map(cell => `"${cell.replace(/"/g, '""')}"`).join(",")).join("\n");
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.setAttribute("href", url);
            link.setAttribute("download", `Timetable_<?php echo htmlspecialchars($selectedTeacherId); ?>_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Copy to Clipboard on Click
        document.querySelectorAll('.timetable-cell, .mobile-day-content .cursor-pointer').forEach(card => {
            card.addEventListener('click', () => {
                const code = card.querySelector('h3, .font-extrabold')?.innerText || '';
                const name = card.querySelector('p, .text-\\[10px\\].font-bold, .text-\\[10px\\].font-medium')?.innerText || '';
                const textToCopy = `${code} ${name}`.trim();
                
                if (textToCopy) {
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: `คัดลอก: ${textToCopy}`,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    });
                }
            });
        });
    });
</script>
<?php endif; ?>
