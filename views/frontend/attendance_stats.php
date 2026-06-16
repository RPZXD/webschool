<!-- views/frontend/attendance_stats.php -->
<!-- Public Daily Attendance Statistics View -->

<?php
function thaiDateShort($date) {
    $months = [
        1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
        5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
        9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
    ];
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $m)) {
        $year = (int)$m[1];
        $month = (int)$m[2];
        $day = (int)$m[3];
        if ($year < 2500) $year += 543;
        return $day . ' ' . $months[$month] . ' ' . $year;
    }
    return $date;
}

$status_labels = [
    '1' => ['label' => 'มาเรียน', 'emoji' => '✅', 'gradient' => 'from-emerald-400 to-green-500', 'bg' => 'bg-emerald-500/10 dark:bg-emerald-500/20', 'text' => 'text-emerald-600 dark:text-emerald-400', 'ring' => 'ring-emerald-500/20'],
    '2' => ['label' => 'ขาดเรียน', 'emoji' => '❌', 'gradient' => 'from-rose-400 to-red-500', 'bg' => 'bg-rose-500/10 dark:bg-rose-500/20', 'text' => 'text-rose-600 dark:text-rose-400', 'ring' => 'ring-rose-500/20'],
    '3' => ['label' => 'มาสาย', 'emoji' => '🕒', 'gradient' => 'from-amber-400 to-orange-500', 'bg' => 'bg-amber-500/10 dark:bg-amber-500/20', 'text' => 'text-amber-600 dark:text-amber-400', 'ring' => 'ring-amber-500/20'],
    '4' => ['label' => 'ลาป่วย', 'emoji' => '🤒', 'gradient' => 'from-sky-400 to-blue-500', 'bg' => 'bg-sky-500/10 dark:bg-sky-500/20', 'text' => 'text-sky-600 dark:text-sky-400', 'ring' => 'ring-sky-500/20'],
    '5' => ['label' => 'ลากิจ', 'emoji' => '📝', 'gradient' => 'from-violet-400 to-purple-500', 'bg' => 'bg-violet-500/10 dark:bg-violet-500/20', 'text' => 'text-violet-600 dark:text-violet-400', 'ring' => 'ring-violet-500/20'],
    '6' => ['label' => 'กิจกรรม', 'emoji' => '🎉', 'gradient' => 'from-pink-400 to-rose-500', 'bg' => 'bg-pink-500/10 dark:bg-pink-500/20', 'text' => 'text-pink-600 dark:text-pink-400', 'ring' => 'ring-pink-500/20'],
];

// Load assets directly inside the view since they are scoped to the dashboard
?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }
    .dark .glass-card {
        background: rgba(30, 41, 59, 0.4);
    }
    .stat-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-6px);
    }
    .glow-emerald { box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.3); }
    .glow-blue { box-shadow: 0 15px 30px -10px rgba(59, 130, 246, 0.3); }
    .glow-purple { box-shadow: 0 15px 30px -10px rgba(139, 92, 246, 0.3); }
    .pulse-ring {
        animation: pulse-ring 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-ring {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.1; transform: scale(1.3); }
    }
    .floating-icon {
        animation: float 4s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-6px); }
    }
    .shimmer {
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.25), transparent);
        background-size: 200% 100%;
        animation: shimmer 2.5s infinite;
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Custom DataTables styling to fit dark mode and premium look */
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 1.5rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.25rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 0.75rem !important;
        border: 1px solid rgba(226, 232, 240, 0.2) !important;
        background: rgba(255, 255, 255, 0.5) !important;
        color: #475569 !important;
        font-weight: 700 !important;
        padding: 0.4rem 0.9rem !important;
        transition: all 0.2s;
        font-size: 0.825rem;
        cursor: pointer;
    }
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: rgba(15, 23, 42, 0.5) !important;
        color: #cbd5e1 !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: rgb(79, 70, 229) !important;
        color: white !important;
        border-color: rgb(79, 70, 229) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: rgb(79, 70, 229) !important;
        color: white !important;
        border-color: rgb(79, 70, 229) !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled, 
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.35;
        cursor: not-allowed;
        background: transparent !important;
        color: #94a3b8 !important;
        border-color: rgba(226, 232, 240, 0.1) !important;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
    /* Hide native datatable search */
    .dataTables_filter {
        display: none;
    }
</style>

<!-- Hero Header Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-emerald-600/5 dark:bg-emerald-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <!-- Left: Title -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl blur-lg opacity-40 pulse-ring"></div>
                    <div class="relative bg-gradient-to-br from-indigo-500 to-purple-600 text-white p-4 rounded-2xl shadow-xl">
                        <i class="fas fa-chart-line text-2xl floating-icon"></i>
                    </div>
                </div>
                <div>
                    <span class="px-3 py-1 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider">
                        <?php echo __('info_attendance_stats'); ?>
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-1.5 tracking-tight leading-tight">
                        ภาพรวมสถิติการเข้าเรียนประจำวัน
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 font-semibold text-xs sm:text-sm flex items-center gap-2 mt-1.5">
                        <i class="far fa-calendar-alt text-indigo-500"></i>
                        <span>ประจำวันที่ <?php echo htmlspecialchars(thaiDateShort($date)); ?></span>
                    </p>
                </div>
            </div>
            
            <!-- Right: Date Picker Form -->
            <form method="get" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <div class="flex items-center gap-3 bg-white dark:bg-slate-900 px-4 py-3 rounded-2xl border border-slate-200/60 dark:border-slate-800 shadow-sm">
                    <i class="far fa-calendar-alt text-indigo-500 text-lg"></i>
                    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($date); ?>" 
                           class="bg-transparent border-none focus:ring-0 text-slate-700 dark:text-slate-200 font-bold text-sm w-full sm:w-auto p-0">
                </div>
                <button type="submit" class="relative overflow-hidden bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-md hover:shadow-lg transition-all duration-300 active:scale-95 group">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        <i class="fas fa-search text-xs"></i>
                        <span>แสดงข้อมูล</span>
                    </span>
                    <div class="absolute inset-0 shimmer"></div>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
        <!-- Card: วันนี้ -->
        <div class="stat-card bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 rounded-3xl p-5 sm:p-6 text-white relative overflow-hidden glow-emerald">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute right-4 top-4 w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-day text-lg"></i>
            </div>
            <div class="relative">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">วันนี้ (เข้าเรียน)</p>
                <p class="text-3xl sm:text-4xl font-black mb-1"><?php echo number_format($stats['today']['present']); ?> <span class="text-xs font-normal">คน</span></p>
                <p class="text-[10px] font-semibold opacity-85 mb-3 leading-tight">
                    สาย <?php echo $stats['today']['late']; ?> คน • ขาด <?php echo $stats['today']['absent']; ?> คน
                </p>
                <div class="pt-3 border-t border-white/20 flex items-center gap-2">
                    <span class="text-xl font-black">
                        <?php echo ($stats['today']['total'] > 0) ? round(($stats['today']['present'] / $stats['today']['total']) * 100, 1) : 0; ?>%
                    </span>
                    <span class="text-[9px] uppercase font-bold opacity-75">อัตราเข้าเรียน</span>
                </div>
            </div>
        </div>

        <!-- Card: สัปดาห์นี้ -->
        <div class="stat-card bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-3xl p-5 sm:p-6 text-white relative overflow-hidden glow-blue">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute right-4 top-4 w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-week text-lg"></i>
            </div>
            <div class="relative">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">สัปดาห์นี้ (เข้าเรียน)</p>
                <p class="text-3xl sm:text-4xl font-black mb-1"><?php echo number_format($stats['week']['present']); ?> <span class="text-xs font-normal">คน</span></p>
                <p class="text-[10px] font-semibold opacity-85 mb-3 leading-tight">
                    สาย <?php echo $stats['week']['late']; ?> คน • ขาด <?php echo $stats['week']['absent']; ?> คน
                </p>
                <div class="pt-3 border-t border-white/20 flex items-center gap-2">
                    <span class="text-xl font-black">
                        <?php echo ($stats['week']['total'] > 0) ? round(($stats['week']['present'] / $stats['week']['total']) * 100, 1) : 0; ?>%
                    </span>
                    <span class="text-[9px] uppercase font-bold opacity-75">อัตราเข้าเรียน</span>
                </div>
            </div>
        </div>

        <!-- Card: เดือนนี้ -->
        <div class="stat-card bg-gradient-to-br from-violet-500 via-purple-600 to-fuchsia-600 rounded-3xl p-5 sm:p-6 text-white relative overflow-hidden glow-purple">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute right-4 top-4 w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-line text-lg"></i>
            </div>
            <div class="relative">
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-2">เดือนนี้ (เข้าเรียน)</p>
                <p class="text-3xl sm:text-4xl font-black mb-1"><?php echo number_format($stats['month']['present']); ?> <span class="text-xs font-normal">คน</span></p>
                <p class="text-[10px] font-semibold opacity-85 mb-3 leading-tight">
                    สาย <?php echo $stats['month']['late']; ?> คน • ขาด <?php echo $stats['month']['absent']; ?> คน
                </p>
                <div class="pt-3 border-t border-white/20 flex items-center gap-2">
                    <span class="text-xl font-black">
                        <?php echo ($stats['month']['total'] > 0) ? round(($stats['month']['present'] / $stats['month']['total']) * 100, 1) : 0; ?>%
                    </span>
                    <span class="text-[9px] uppercase font-bold opacity-75">อัตราเข้าเรียน</span>
                </div>
            </div>
        </div>

        <!-- Card: เป้าหมาย -->
        <?php $avg = ($stats['today']['total'] > 0) ? round(($stats['today']['present'] / $stats['today']['total']) * 100, 1) : 0; ?>
        <div class="stat-card glass-card rounded-3xl p-5 sm:p-6 border border-slate-200/60 dark:border-slate-800 shadow-sm relative overflow-hidden bg-white/80 dark:bg-slate-900/50">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-orange-500/10 rounded-full blur-2xl"></div>
            <div class="absolute right-4 top-4 w-10 h-10 bg-gradient-to-br from-orange-400 to-rose-500 rounded-xl flex items-center justify-center text-white">
                <i class="fas fa-bullseye text-lg"></i>
            </div>
            <div class="relative">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">อัตราเฉลี่ยวันนี้</p>
                <p class="text-3xl sm:text-4xl font-black mb-1 text-slate-850 dark:text-white"><?php echo $avg; ?>%</p>
                <p class="text-[10px] font-semibold text-slate-500 dark:text-slate-450 mb-3">เป้าหมายมาตรฐาน: 95.0%</p>
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-450 to-pink-500 h-full rounded-full transition-all duration-1000 relative" style="width: <?php echo min($avg, 100); ?>%">
                            <div class="absolute inset-0 shimmer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Count Cards (Active enrollment) -->
    <div class="grid grid-cols-3 gap-4 sm:gap-6 mb-8">
        <div class="glass-card rounded-3xl p-6 border border-slate-200/60 dark:border-slate-800 shadow-sm text-center bg-white/80 dark:bg-slate-900/50 transition-all duration-300 hover:scale-[1.02]">
            <div class="w-12 h-12 mx-auto bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center mb-3 shadow-md shadow-blue-500/10">
                <i class="fas fa-user-graduate text-white text-lg"></i>
            </div>
            <p class="text-xl sm:text-3xl font-black text-slate-800 dark:text-white mb-1"><?php echo number_format($studentCounts['total']); ?></p>
            <p class="text-[10px] sm:text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">นักเรียนปัจจุบันทั้งหมด</p>
        </div>
        <div class="glass-card rounded-3xl p-6 border border-slate-200/60 dark:border-slate-800 shadow-sm text-center bg-white/80 dark:bg-slate-900/50 transition-all duration-300 hover:scale-[1.02]">
            <div class="w-12 h-12 mx-auto bg-gradient-to-br from-emerald-400 to-teal-500 rounded-2xl flex items-center justify-center mb-3 shadow-md shadow-emerald-500/10">
                <i class="fas fa-book-reader text-white text-lg"></i>
            </div>
            <p class="text-xl sm:text-3xl font-black text-slate-800 dark:text-white mb-1"><?php echo number_format($studentCounts['junior']); ?></p>
            <p class="text-[10px] sm:text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">ระดับชั้น ม.ต้น</p>
        </div>
        <div class="glass-card rounded-3xl p-6 border border-slate-200/60 dark:border-slate-800 shadow-sm text-center bg-white/80 dark:bg-slate-900/50 transition-all duration-300 hover:scale-[1.02]">
            <div class="w-12 h-12 mx-auto bg-gradient-to-br from-violet-400 to-purple-500 rounded-2xl flex items-center justify-center mb-3 shadow-md shadow-purple-500/10">
                <i class="fas fa-user-tie text-white text-lg"></i>
            </div>
            <p class="text-xl sm:text-3xl font-black text-slate-800 dark:text-white mb-1"><?php echo number_format($studentCounts['senior']); ?></p>
            <p class="text-[10px] sm:text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">ระดับชั้น ม.ปลาย</p>
        </div>
    </div>

    <!-- Attendance Status Details -->
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-1.5 h-8 bg-gradient-to-b from-indigo-500 to-purple-500 rounded-full"></div>
            <h3 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white">สรุปสถานะรายละเอียดวันนี้</h3>
        </div>
        
        <div class="grid grid-cols-3 md:grid-cols-6 gap-4">
            <?php foreach ($status_labels as $key => $info): ?>
            <div class="glass-card rounded-3xl border border-slate-200/60 dark:border-slate-800 p-4 sm:p-5 flex flex-col items-center bg-white/80 dark:bg-slate-900/50 transition-all duration-300 hover:scale-[1.03] shadow-sm">
                <div class="text-3xl sm:text-4xl mb-3 transform hover:scale-110 transition-transform"><?php echo $info['emoji']; ?></div>
                <p class="text-xl sm:text-2xl font-black <?php echo $info['text']; ?> mb-0.5"><?php echo number_format($status_count[$key]); ?></p>
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2.5"><?php echo $info['label']; ?></p>
                <span class="inline-block px-2.5 py-0.5 bg-gradient-to-r <?php echo $info['gradient']; ?> text-white text-[9px] font-black rounded-full shadow-sm">
                    <?php echo $total ? round($status_count[$key] * 100 / $total, 1) : 0; ?>%
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="grid grid-cols-1 xl:grid-cols-5 gap-8">
        <!-- Pie Chart Box -->
        <div class="xl:col-span-2 glass-card rounded-3xl p-6 border border-slate-200/60 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 shadow-sm">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-pink-400 to-rose-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-rose-500/10">
                    <i class="fas fa-chart-pie text-md"></i>
                </div>
                <h4 class="text-base sm:text-lg font-black text-slate-800 dark:text-white">แผนภูมิสัดส่วนการลงเวลาเรียน</h4>
            </div>
            <div class="relative h-[280px] sm:h-[320px] flex items-center justify-center">
                <canvas id="pieChartOverview"></canvas>
            </div>
        </div>

        <!-- Room Breakdowns Table -->
        <div class="xl:col-span-3 glass-card rounded-3xl p-6 border border-slate-200/60 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 shadow-sm overflow-hidden flex flex-col">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-500/10">
                        <i class="fas fa-table text-md"></i>
                    </div>
                    <h4 class="text-base sm:text-lg font-black text-slate-800 dark:text-white">รายละเอียดการเช็คชื่อจำแนกตามห้อง</h4>
                </div>
                
                <!-- Custom Filters Panel -->
                <div class="flex items-center gap-3 flex-wrap">
                    <!-- Dropdown Filter -->
                    <div class="flex items-center gap-2 bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-sm">
                        <i class="fas fa-filter text-indigo-500 text-xs"></i>
                        <label for="classFilter" class="sr-only">ระดับชั้นเรียน</label>
                        <select id="classFilter" class="bg-transparent border-none focus:ring-0 text-slate-700 dark:text-slate-200 font-bold text-xs cursor-pointer p-0">
                            <option value="">ทุกระดับชั้น</option>
                            <?php
                            $class_set = [];
                            foreach ($classes as $c) {
                                $class_set[$c['Stu_major']] = true;
                            }
                            ksort($class_set);
                            foreach (array_keys($class_set) as $major) {
                                echo '<option value="ม.' . htmlspecialchars($major) . '">ม.' . htmlspecialchars($major) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    
                    <!-- Text Search input -->
                    <div class="flex items-center gap-2 bg-white dark:bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-sm">
                        <i class="fas fa-search text-slate-400 text-xs"></i>
                        <label for="tableSearch" class="sr-only">ค้นหาห้องเรียน</label>
                        <input type="text" id="tableSearch" placeholder="ค้นหาห้อง..." class="bg-transparent border-none focus:ring-0 text-slate-700 dark:text-slate-200 font-semibold text-xs p-0 w-24 sm:w-32">
                    </div>
                </div>
            </div>

            <!-- Table content -->
            <div class="overflow-x-auto -mx-6 px-6">
                <table id="attendanceTable" class="min-w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-850">
                            <th class="pb-3 text-[10px] font-black uppercase tracking-widest text-slate-450 dark:text-slate-500">ชั้น</th>
                            <th class="pb-3 text-[10px] font-black uppercase tracking-widest text-slate-450 dark:text-slate-500">ห้อง</th>
                            <th class="pb-3 text-[10px] font-black uppercase tracking-widest text-slate-450 dark:text-slate-500 text-center">นักเรียน</th>
                            <?php foreach ($status_labels as $info): ?>
                                <th class="pb-3 text-center text-lg sm:text-xl" title="<?php echo $info['label']; ?>"><?php echo $info['emoji']; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-850">
                        <?php foreach ($classes as $c): ?>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors duration-150">
                            <td class="py-3.5">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-indigo-500/10 dark:bg-indigo-500/25 text-indigo-600 dark:text-indigo-300 font-black text-xs rounded-xl">
                                    ม.<?php echo htmlspecialchars($c['Stu_major']); ?>
                                </span>
                            </td>
                            <td class="py-3.5 font-bold text-slate-700 dark:text-slate-200 text-xs sm:text-sm">ห้อง <?php echo htmlspecialchars($c['Stu_room']); ?></td>
                            <td class="py-3.5 text-center">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-350 font-bold rounded-lg text-xs">
                                    <?php echo $c['count']; ?>
                                </span>
                            </td>
                            <?php foreach ($status_labels as $k => $info): ?>
                            <td class="py-3.5 text-center">
                                <?php if($c['status'][$k] > 0): ?>
                                <span class="inline-block px-2.5 py-0.5 <?php echo $info['bg']; ?> <?php echo $info['text']; ?> font-bold rounded-lg text-xs">
                                    <?php echo $c['status'][$k]; ?>
                                </span>
                                <?php else: ?>
                                <span class="text-slate-200 dark:text-slate-800">-</span>
                                <?php endif; ?>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Fallback for empty table -->
            <?php if (empty($classes)): ?>
            <div class="py-12 text-center text-slate-400 dark:text-slate-500">
                <i class="fas fa-folder-open text-4xl mb-3 block opacity-40"></i>
                <p class="text-xs font-bold">ไม่มีข้อมูลสถิติห้องเรียนในระบบสำหรับวันนี้</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

</section>

<!-- Script initialization logic -->
<script>
$(document).ready(function() {
    // Doughnut Chart Setup
    var ctx = document.getElementById('pieChartOverview').getContext('2d');
    
    // Create gradients for chart slices
    const gradients = [
        ctx.createLinearGradient(0, 0, 0, 300),
        ctx.createLinearGradient(0, 0, 0, 300),
        ctx.createLinearGradient(0, 0, 0, 300),
        ctx.createLinearGradient(0, 0, 0, 300),
        ctx.createLinearGradient(0, 0, 0, 300),
        ctx.createLinearGradient(0, 0, 0, 300)
    ];
    
    gradients[0].addColorStop(0, '#34d399'); gradients[0].addColorStop(1, '#10b981'); // Present
    gradients[1].addColorStop(0, '#f87171'); gradients[1].addColorStop(1, '#ef4444'); // Absent
    gradients[2].addColorStop(0, '#fbbf24'); gradients[2].addColorStop(1, '#f59e0b'); // Late
    gradients[3].addColorStop(0, '#60a5fa'); gradients[3].addColorStop(1, '#3b82f6'); // Sick
    gradients[4].addColorStop(0, '#a78bfa'); gradients[4].addColorStop(1, '#8b5cf6'); // Personal
    gradients[5].addColorStop(0, '#f472b6'); gradients[5].addColorStop(1, '#ec4899'); // Activity
    
    const dataValues = [<?php echo implode(',', array_values($status_count)); ?>];
    const totalCount = dataValues.reduce((a, b) => a + b, 0);
    
    let chartData = {
        labels: [
            <?php foreach ($status_labels as $info): ?>
                "<?php echo $info['label']; ?>",
            <?php endforeach; ?>
        ],
        datasets: [{
            data: dataValues,
            backgroundColor: gradients,
            borderWidth: 0,
            hoverOffset: 12,
            borderRadius: 6,
            spacing: 3
        }]
    };
    
    // Fallback: If no checks are found today, show a placeholder gray ring
    if (totalCount === 0) {
        chartData = {
            labels: ["ไม่มีข้อมูลการเช็คชื่อสำหรับวันนี้"],
            datasets: [{
                data: [1],
                backgroundColor: ['#cbd5e1'],
                borderWidth: 0,
                hoverOffset: 0,
                borderRadius: 0,
                spacing: 0
            }]
        };
    }
    
    new Chart(ctx, {
        type: 'doughnut',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { 
                        font: { size: window.innerWidth < 768 ? 10 : 12, weight: 'bold', family: 'Sarabun' },
                        color: document.documentElement.classList.contains('dark') ? '#94a3b8' : '#475569',
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleFont: { size: 13, weight: 'bold', family: 'Sarabun' },
                    bodyFont: { size: 12, family: 'Sarabun' },
                    padding: 10,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(context) {
                            if (totalCount === 0) {
                                return ' ' + context.label;
                            }
                            const percentage = ((context.raw / totalCount) * 100).toFixed(1);
                            return ` ${context.label}: ${context.raw} คน (${percentage}%)`;
                        }
                    }
                }
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1200,
                easing: 'easeOutQuart'
            }
        }
    });

    // Initialize DataTable
    var table = $('#attendanceTable').DataTable({
        paging: true,
        pageLength: 8,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: false,
        responsive: true,
        dom: 'rtp',
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.7/i18n/th.json"
        },
        columnDefs: [
            { targets: '_all', orderable: false },
            { targets: [0, 1, 2], orderable: true }
        ],
        order: [[0, 'asc'], [1, 'asc']]
    });

    // Dropdown filter listener
    $('#classFilter').on('change', function() {
        var val = $(this).val();
        table.column(0).search(val ? val : '', true, false).draw();
    });

    // Custom search input listener
    $('#tableSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
});
</script>
