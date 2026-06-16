<!-- views/frontend/complaints.php -->
<!-- Complaint Channel View embedding Google Form -->

<!-- Hero Header Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-red-600/5 dark:bg-red-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-300 text-xs font-bold uppercase tracking-wider">
            <?php echo __('cat_transparency_participation'); ?>
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
            <?php echo __('info_complaints'); ?>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            โรงเรียนพิชัยมุ่งเน้นการดำเนินงานที่มีคุณธรรมและโปร่งใส หากท่านพบเห็นการกระทำที่ไม่ถูกต้อง ไม่เป็นธรรม หรือการทุจริต สามารถส่งเรื่องร้องเรียนผ่านช่องทางนี้ได้โดยตรง
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
    <div class="bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-xl p-6 sm:p-8 space-y-6 transition-all duration-300">
        
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="space-y-1">
                <h2 class="text-base sm:text-lg font-bold text-slate-855 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-red-500"></i>
                    <span>ระบบรับเรื่องร้องเรียนทุจริตและประพฤติมิชอบ</span>
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500">
                    ข้อมูลผู้ร้องเรียนจะได้รับการรักษาเป็นความลับสูงสุดตามมาตรฐานการคุ้มครองสิทธิ์
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <a href="<?php echo htmlspecialchars($complaintsUrl); ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-red-500/20 transition-all duration-200">
                    <i class="fa-solid fa-up-right-from-square mr-2"></i>เปิดแบบฟอร์มในหน้าต่างใหม่
                </a>
            </div>
        </div>

        <!-- Google Form Embed Container -->
        <?php if (!empty($complaintsUrl)): ?>
            <div class="relative w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950 shadow-inner" style="height: 80dvh; min-height: 500px; max-height: 800px;" id="form-container">
                <iframe src="<?php echo htmlspecialchars($complaintsUrl); ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay" loading="lazy" title="แบบฟอร์มรับเรื่องร้องเรียนทุจริตและประพฤติมิชอบออนไลน์ของโรงเรียนพิชัย">
                    กำลังโหลดแบบฟอร์ม...
                </iframe>
            </div>
        <?php else: ?>
            <div class="max-w-2xl mx-auto bg-slate-50/50 dark:bg-slate-950/20 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-inner">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-slate-850 dark:text-white">ยังไม่มีการติดตั้งลิงก์แบบฟอร์มรับเรื่องร้องเรียน</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">
                        ขณะนี้อยู่ในระหว่างการจัดสรรระบบรับเรื่องร้องเรียน สำหรับผู้ดูแลระบบสามารถระบุลิงก์ Google Form นี้ได้โดยตรงที่ <a href="<?php echo BASE_URL; ?>admin?tab=complaints" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">หน้าจัดการระบบหลังบ้าน</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Support Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-red-500/5 border border-red-500/10 h-full">
                <div class="p-2.5 rounded-xl bg-red-500/10 text-red-500 dark:text-red-400 shrink-0">
                    <i class="fa-solid fa-user-shield text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">การคุ้มครองผู้ร้องเรียน</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        ทางโรงเรียนมีมาตรการคุ้มครองผู้ร้องเรียนและผู้ให้เบาะแส โดยจะไม่มีการเปิดเผยชื่อ-นามสกุล ที่อยู่ หรือข้อมูลใดๆ ที่ระบุถึงตัวตนของท่านสู่สาธารณะ
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 h-full">
                <div class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 shrink-0">
                    <i class="fa-solid fa-gavel text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">กระบวนการพิจารณาตรวจสอบ</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        เรื่องร้องเรียนจะถูกตรวจสอบโดยคณะกรรมการที่ได้รับการแต่งตั้งขึ้นเพื่อความเป็นธรรม หากพบความผิดจริงจะมีการดำเนินการทางวินัยและกฎหมายขั้นเด็ดขาด
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-amber-500/5 border border-amber-500/10 h-full">
                <div class="p-2.5 rounded-xl bg-amber-500/10 text-amber-500 dark:text-amber-400 shrink-0">
                    <i class="fa-solid fa-circle-question text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">ข้อแนะนำการแจ้งเรื่อง</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        โปรดระบุรายละเอียด เหตุการณ์ วันเวลา สถานที่ พยานบุคคล หรือหลักฐานแนบ (ถ้ามี) ให้ชัดเจนที่สุด เพื่อความรวดเร็วและเที่ยงตรงในการสืบสวนหาข้อเท็จจริง
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>
