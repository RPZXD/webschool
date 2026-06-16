<!-- views/frontend/pdf_viewer.php -->
<!-- Reusable Premium PDF Document Viewer -->

<!-- Hero Header Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider">
            <?php echo __($categoryKey); ?>
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
            <?php echo __($pageTitleKey); ?>
        </h1>
        <p class="text-slate-555 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            <?php echo htmlspecialchars($description); ?>
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
    <div class="bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-xl p-6 sm:p-8 space-y-6 transition-all duration-300">
        
        <!-- Quick Toolbar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="space-y-1">
                <h2 class="text-base sm:text-lg font-bold text-slate-850 dark:text-white flex items-center gap-2">
                    <i class="fa-regular fa-file-pdf text-red-500 text-xl"></i>
                    <span>เอกสารประกาศและคู่มืออย่างเป็นทางการ</span>
                </h2>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500">
                    ไฟล์รูปแบบ PDF ท่านสามารถขยาย ค้นหา หรือสั่งพิมพ์เอกสารได้โดยตรง
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

        <!-- PDF Viewer Embed Frame -->
        <?php 
        // Resolve file existence locally
        $filename = rawurldecode(basename($pdfUrl));
        $localFilePath = UPLOAD_DIR . $filename;
        $fileExists = file_exists($localFilePath);
        
        if ($fileExists): 
        ?>
            <div class="relative w-full rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-950 shadow-inner" style="height: 80vh;" id="pdf-container">
                <iframe src="<?php echo $pdfUrl; ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay" loading="lazy" title="<?php echo htmlspecialchars(__($pageTitleKey) ?: 'เอกสารประกาศและคู่มืออย่างเป็นทางการ'); ?>"></iframe>
            </div>
        <?php else: ?>
            <div class="max-w-2xl mx-auto bg-slate-50/50 dark:bg-slate-950/20 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-inner">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-505 text-amber-500">
                    <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-slate-850 dark:text-white">ยังไม่มีการอัปโหลดไฟล์เอกสารเข้าสู่ระบบ</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">
                        ขณะนี้อยู่ในระหว่างการจัดเตรียมเอกสารฉบับทางการ สำหรับผู้ดูแลระบบสามารถอัปโหลดไฟล์เอกสาร PDF นี้ได้โดยตรงที่ <a href="<?php echo BASE_URL; ?>admin?tab=documents" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">หน้าจัดการระบบหลังบ้าน</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Supporting Information / Instruction Tips -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4">
            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-indigo-500/5 border border-indigo-550/10 dark:border-indigo-500/10">
                <div class="p-2.5 rounded-xl bg-indigo-500/10 text-indigo-650 dark:text-indigo-400 shrink-0">
                    <i class="fa-solid fa-mobile-screen text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">การดูผ่านหน้าจอสมาร์ทโฟน</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        เพื่อการอ่านที่สะดวกยิ่งขึ้น แนะนำให้แตะปุ่ม "เปิดเต็มจอในแท็บใหม่" เพื่อเรียกใช้โปรแกรมดูเอกสารบนระบบปฏิบัติการ iOS หรือ Android ของท่าน
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-emerald-500/5 border border-emerald-550/10 dark:border-emerald-500/10">
                <div class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-650 dark:text-emerald-400 shrink-0">
                    <i class="fa-solid fa-arrows-to-eye text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">การขยายและค้นหาข้อมูล</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        ท่านสามารถขยายขนาดเอกสาร ค้นหาข้อความด้วยปุ่มแว่นขยาย หรือจีบนิ้วเพื่อซูมเข้า-ออกได้ตามปกติบนตัวควบคุมของโปรแกรมอ่าน PDF
                    </p>
                </div>
            </div>

            <div class="flex items-start gap-3.5 p-5 rounded-2xl bg-amber-555/5 bg-amber-500/5 border border-amber-550/10 dark:border-amber-500/10">
                <div class="p-2.5 rounded-xl bg-amber-555/10 bg-amber-500/10 text-amber-600 dark:text-amber-400 shrink-0">
                    <i class="fa-solid fa-circle-question text-base"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">ต้องการพิมพ์เป็นกระดาษ?</h4>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 leading-relaxed">
                        สามารถสั่งพิมพ์โดยคลิกสัญลักษณ์เครื่องพิมพ์ภายในตัวควบคุมเฟรมเอกสาร หรือดาวน์โหลดลงเครื่องเพื่อนำไปพิมพ์ภายหลังได้เช่นกัน
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>
