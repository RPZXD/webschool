<!-- views/frontend/feedback.php -->
<!-- Feedback Channel View embedding Google Form -->

<!-- Hero Header Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider">
            <?php echo __('cat_transparency_participation'); ?>
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
            <?php echo __('info_feedback'); ?>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            โรงเรียนพิชัยยินดีรับฟังความคิดเห็น ข้อเสนอแนะ และข้อติชมจากผู้ปกครอง นักเรียน คณะครู และบุคคลภายนอก เพื่อนำไปพัฒนาการดำเนินงานของโรงเรียนให้ดียิ่งขึ้น
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
    <div class="bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-xl p-6 sm:p-8 space-y-6 transition-all duration-300">
        
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="space-y-1">
                <h2 class="text-base sm:text-lg font-bold text-slate-850 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-comments text-indigo-550 text-indigo-500"></i>
                    <span>กล่องรับฟังความคิดเห็นออนไลน์</span>
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500">
                    ข้อมูลของท่านจะได้รับการปกปิดและส่งตรงถึงฝ่ายบริหารเพื่อดำเนินการพิจารณา
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <a href="<?php echo htmlspecialchars($feedbackUrl); ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-indigo-500/20 transition-all duration-200">
                    <i class="fa-solid fa-up-right-from-square mr-2"></i>เปิดแบบฟอร์มในหน้าต่างใหม่
                </a>
            </div>
        </div>

        <!-- Google Form Embed Container -->
        <?php if (!empty($feedbackUrl)): ?>
            <div class="relative w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-955 bg-white dark:bg-slate-950 shadow-inner" style="height: 80dvh; min-height: 500px; max-height: 800px;" id="form-container">
                <iframe src="<?php echo htmlspecialchars($feedbackUrl); ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay" loading="lazy" title="แบบฟอร์มรับฟังความคิดเห็นออนไลน์ของโรงเรียนพิชัย">
                    กำลังโหลดแบบฟอร์ม...
                </iframe>
            </div>
        <?php else: ?>
            <div class="max-w-2xl mx-auto bg-slate-50/50 dark:bg-slate-955/20 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-inner">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-slate-850 dark:text-white">ยังไม่มีการติดตั้งลิงก์แบบฟอร์มรับฟังความคิดเห็น</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">
                        ขณะนี้อยู่ในระหว่างการจัดสรรระบบรับฟังความคิดเห็น สำหรับผู้ดูแลระบบสามารถระบุลิงก์ Google Form นี้ได้โดยตรงที่ <a href="<?php echo BASE_URL; ?>admin?tab=feedback" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">หน้าจัดการระบบหลังบ้าน</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Support Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-indigo-500/5 border border-indigo-500/10 h-full">
                <div class="p-2.5 rounded-xl bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 shrink-0">
                    <i class="fa-solid fa-shield-halved text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">การรักษาความปลอดภัยของข้อมูล</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        ระบบจะเก็บรักษาข้อมูลความคิดเห็นและข้อเสนอแนะของท่านไว้เป็นความลับ และจะถูกนำส่งถึงผู้บริหารโดยตรงเพื่อพัฒนาคุณภาพการเรียนการสอนต่อไป
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 h-full">
                <div class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 shrink-0">
                    <i class="fa-solid fa-square-poll-vertical text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">การนำข้อเสนอแนะไปปฏิบัติ</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        ทุกข้อคิดเห็นที่มีเหตุผลและสร้างสรรค์จะถูกนำเข้าที่ประชุมผู้บริหารเพื่อทบทวนนโยบาย ปรับปรุงการปฏิบัติงาน และแจ้งผลตอบรับผ่านช่องทางประชาสัมพันธ์
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-amber-500/5 border border-amber-500/10 h-full">
                <div class="p-2.5 rounded-xl bg-amber-500/10 text-amber-500 dark:text-amber-400 shrink-0">
                    <i class="fa-solid fa-circle-question text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">พบปัญหาในการส่งฟอร์ม?</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        หากท่านไม่สามารถพิมพ์ลงในกรอบได้ หรือฟอร์มไม่ขึ้นเนื่องจากบราวเซอร์ของท่าน ให้คลิกที่ปุ่ม "เปิดแบบฟอร์มในหน้าต่างใหม่" เพื่อดำเนินการส่งข้อมูลโดยตรง
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>
