<!-- views/frontend/no_gift.php -->
<!-- No Gift Policy Declaration View -->

<!-- Hero Header Section -->
<section class="relative py-20 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <!-- Visual background aesthetics -->
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-amber-500/5 dark:bg-amber-500/10 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-300 text-xs font-bold uppercase tracking-wider">
            <?php echo __('cat_transparency_participation'); ?>
        </span>
        <h1 class="text-3xl sm:text-5xl font-extrabold text-slate-900 dark:text-white leading-tight">
            <?php echo __('info_no_gift'); ?>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-base max-w-2xl mx-auto leading-relaxed">
            โรงเรียนพิชัยมุ่งเน้นการปฏิรูปค่านิยมและวัฒนธรรมองค์กรเพื่อสร้างความโปร่งใส ปราศจากการรับของขวัญหรือผลประโยชน์ใดๆ จากการปฏิบัติหน้าที่
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow space-y-12">
    <!-- No Gift Main Policy Banner -->
    <div class="glass-card rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl p-8 md:p-12 transition-all duration-300 flex flex-col md:flex-row items-center gap-8 md:gap-12">
        <!-- Visual Shield/No Gift Graphics -->
        <div class="relative shrink-0 w-36 h-36 rounded-full bg-gradient-to-tr from-amber-500 to-orange-600 flex items-center justify-center border border-amber-400/20 shadow-xl">
            <span class="absolute inset-2 rounded-full border border-white/20"></span>
            <div class="flex flex-col items-center justify-center text-white text-center">
                <i class="fa-solid fa-gift text-4xl animate-pulse"></i>
                <span class="text-[9px] font-black uppercase tracking-widest mt-1 font-english">No Gift</span>
            </div>
            <!-- Forbidden badge overlay -->
            <span class="absolute -top-1 -right-1 w-10 h-10 bg-red-650 bg-red-650 bg-red-600 text-white rounded-full flex items-center justify-center border-4 border-slate-100 dark:border-slate-950 font-black text-sm">
                <i class="fa-solid fa-ban"></i>
            </span>
        </div>

        <div class="space-y-4 text-center md:text-left flex-grow">
            <h2 class="text-xl sm:text-2xl font-black text-slate-850 dark:text-white leading-snug">
                เจตนารมณ์นโยบายงดรับ งดให้ของขวัญ (No Gift Policy)
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                โรงเรียนพิชัย ประกาศเจตนารมณ์เป็นหน่วยงานที่ผู้บริหาร ข้าราชการครู และบุคลากรทางการศึกษาทุกคน <strong>"งดรับของขวัญ ของกำนัล หรือผลประโยชน์อื่นใด"</strong> จากการปฏิบัติหน้าที่ ทั้งในขณะ ก่อน และหลังปฏิบัติหน้าที่ เพื่อหลีกเลี่ยงการกระทำอันอาจมีผลต่อการดุลยพินิจหรือการตัดสินใจในการปฏิบัติหน้าที่ ซึ่งนำไปสู่การเลือกปฏิบัติและผลประโยชน์ทับซ้อน
            </p>
        </div>
    </div>

    <!-- Core Rules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Rule 1 -->
        <div class="glass-card p-8 rounded-3xl shadow-lg border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 hover:scale-[1.02] transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 flex items-center justify-center text-xl">
                <i class="fa-solid fa-hand-holding-heart"></i>
            </div>
            <h3 class="text-base font-bold text-slate-850 dark:text-white">งดรับของขวัญทุกชนิด</h3>
            <p class="text-[11px] text-slate-400 dark:text-slate-550 leading-relaxed">
                ไม่รับของขวัญ ของกำนัล หรือเงินสดจากบุคคลภายนอก ผู้มีส่วนได้ส่วนเสีย หรือผู้มาติดต่อราชการ ในทุกเทศกาลและทุกโอกาส
            </p>
        </div>

        <!-- Rule 2 -->
        <div class="glass-card p-8 rounded-3xl shadow-lg border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 hover:scale-[1.02] transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center text-xl">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <h3 class="text-base font-bold text-slate-850 dark:text-white">การบริการที่เท่าเทียม</h3>
            <p class="text-[11px] text-slate-400 dark:text-slate-550 leading-relaxed">
                ปฏิบัติหน้าที่อย่างโปร่งใส เป็นธรรม เสมอภาค และยึดประโยชน์ส่วนรวมเป็นสำคัญ โดยไม่แสวงหาผลประโยชน์มิชอบ
            </p>
        </div>

        <!-- Rule 3 -->
        <div class="glass-card p-8 rounded-3xl shadow-lg border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 hover:scale-[1.02] transition-all duration-300 space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-500 flex items-center justify-center text-xl">
                <i class="fa-solid fa-comments"></i>
            </div>
            <h3 class="text-base font-bold text-slate-850 dark:text-white">คำอวยพรทดแทน</h3>
            <p class="text-[11px] text-slate-400 dark:text-slate-550 leading-relaxed">
                แสดงความยินดีหรือส่งความปรารถนาดีในเทศกาลต่างๆ ผ่านบัตรอวยพร คำอวยพรออนไลน์ หรือคำกล่าวแสดงไมตรีจิตทดแทนการมอบสิ่งของ
            </p>
        </div>
    </div>

    <!-- Call to action block connecting to detailed Do's and Don'ts -->
    <div class="glass-card rounded-3xl border border-slate-200 dark:border-slate-800 p-8 text-center space-y-6 max-w-3xl mx-auto shadow-xl bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-550 text-indigo-550 text-indigo-500 text-xl">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
        <div class="space-y-2">
            <h3 class="text-lg font-bold text-slate-850 dark:text-white">แนวทางปฏิบัติ Do's and Don'ts</h3>
            <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">
                ร่วมศึกษาแนวทางการปฏิบัติตนตามหลักคุณธรรม จริยธรรม และข้อพึงระวังสำหรับข้าราชการครูและบุคลากรทางการศึกษาโรงเรียนพิชัย
            </p>
        </div>
        <div>
            <a href="<?php echo BASE_URL; ?>dos-donts" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all duration-200">
                <i class="fa-solid fa-arrow-right mr-2 animate-pulse"></i>ดูแนวทางปฏิบัติ Do's & Don'ts
            </a>
        </div>
    </div>

    <!-- PDF Document View Frame Section -->
    <div class="glass-card rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="space-y-1">
                <h3 class="text-base sm:text-lg font-bold text-slate-850 dark:text-white flex items-center gap-2">
                    <i class="fa-regular fa-file-pdf text-red-500 text-xl animate-pulse"></i>
                    <span>เอกสารประกาศนโยบาย No Gift Policy อย่างเป็นทางการ</span>
                </h3>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500">
                    ประกาศเจตนารมณ์ เรื่อง นโยบาย No Gift Policy จากการปฏิบัติหน้าที่
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                <a href="<?php echo $pdfUrl; ?>" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-indigo-500/20 transition-all duration-200">
                    <i class="fa-solid fa-up-right-from-square mr-2"></i>เปิดเต็มจอในแท็บใหม่
                </a>
                <a href="<?php echo $pdfUrl; ?>" download class="inline-flex items-center justify-center px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-rose-500/20 transition-all duration-200">
                    <i class="fa-solid fa-download mr-2"></i>ดาวน์โหลดไฟล์ PDF
                </a>
            </div>
        </div>

        <?php if ($fileExists): ?>
            <div class="relative w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-950 shadow-inner" style="height: 80vh;">
                <iframe src="<?php echo $pdfUrl; ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay" loading="lazy" title="<?php echo htmlspecialchars(__('info_no_gift') ?: 'เอกสารประกาศนโยบาย No Gift Policy อย่างเป็นทางการ'); ?>"></iframe>
            </div>
        <?php else: ?>
            <div class="max-w-2xl mx-auto bg-slate-50/50 dark:bg-slate-950/20 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-inner">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-slate-850 dark:text-white">ยังไม่มีการอัปโหลดไฟล์ประกาศนโยบาย</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">
                        ขณะนี้อยู่ในระหว่างการจัดเตรียมเอกสารประกาศนโยบาย สามารถตรวจสอบการอัปโหลดได้ที่ <a href="<?php echo BASE_URL; ?>admin?tab=documents" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">หน้าจัดการเอกสารหลังบ้าน</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
