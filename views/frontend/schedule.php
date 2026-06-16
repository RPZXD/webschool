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
    <?php if (empty($scheduleUrl)): ?>
        <!-- Fallback Warning: When no schedule URL is set -->
        <div class="max-w-2xl mx-auto bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-950/5 dark:border-white/10 rounded-3xl p-8 text-center space-y-6 shadow-2xl animate-fade-in-up">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
            </div>
            <div class="space-y-2">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">ยังไม่มีการอัปโหลดข้อมูลตาราง</h2>
                <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                    ขณะนี้อยู่ในระหว่างการจัดทำและอัปเดตข้อมูลตาราง หากมีข้อสงสัยหรือต้องการข้อมูลเพิ่มเติม กรุณาติดต่อฝ่ายวิชาการ
                </p>
            </div>
            <div class="pt-4 flex flex-col sm:flex-row justify-center gap-3">
                <a href="<?php echo BASE_URL; ?>" class="inline-flex items-center justify-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fa-solid fa-home mr-2"></i>กลับไปยังหน้าหลัก
                </a>
                <a href="<?php echo BASE_URL; ?>contact" class="inline-flex items-center justify-center px-5 py-3 bg-slate-200/50 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-300 dark:border-white/10 transition-all duration-300 hover:-translate-y-0.5">
                    <i class="fa-solid fa-phone mr-2"></i>ติดต่อโรงเรียน
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Main Document Area -->
        <?php 
            $isFolder = (strpos($scheduleUrl, 'folders') !== false || strpos($embedUrl, 'embeddedfolderview') !== false);
        ?>
        <div class="bg-white/80 dark:bg-white/5 backdrop-blur-xl border border-slate-900/5 dark:border-white/10 rounded-3xl overflow-hidden shadow-2xl p-6 sm:p-8 space-y-6 transition-all duration-300 animate-fade-in-up">
            
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
</section>
