<!-- views/frontend/dos_donts.php -->
<!-- Do's and Don'ts Ethical Guidelines View -->

<!-- Hero Header Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-emerald-600/5 dark:bg-emerald-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-300 text-xs font-bold uppercase tracking-wider">
            <?php echo __('cat_transparency_participation'); ?>
        </span>
        <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
            <?php echo __('info_dos_donts'); ?>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-2xl mx-auto leading-relaxed">
            Do's & Don'ts พฤติกรรมทางจริยธรรมของข้าราชการครูและบุคลากรทางการศึกษา โรงเรียนพิชัย เพื่อยึดถือปฏิบัติและรักษาวินัยอย่างเคร่งครัด
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow space-y-12">
    <!-- Ethics Guidelines Cards Grid -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-slate-850 dark:text-white flex items-center gap-2">
            <i class="fa-solid fa-scale-balanced text-indigo-500"></i>
            <span>มาตรฐานพฤติกรรมทางจริยธรรม (Do's & Don'ts)</span>
        </h2>
        
        <div class="grid grid-cols-1 gap-6">
            <?php
            $items = [
                [
                    'num' => '01',
                    'do' => 'ยึดมั่นในชาติ ศาสนา พระมหากษัตริย์ และการปกครองระบอบประชาธิปไตยอันมีพระมหากษัตริย์ทรงเป็นประมุข',
                    'dont' => 'ไม่ด้อยค่าความเป็นไทย ไม่จงรักภักดีต่อสถาบันพระมหากษัตริย์ ไม่สนับสนุนกลุ่มคนที่ด้อยค่าศาสนาใดศาสนาหนึ่ง'
                ],
                [
                    'num' => '02',
                    'do' => 'ซื่อสัตย์สุจริต มีจิตสำนึกที่ดี มีความรับผิดชอบต่อหน้าที่และผู้เกี่ยวข้องในฐานะข้าราชการครูและบุคลากรทางการศึกษา',
                    'dont' => 'ไม่ทุจริตต่อหน้าที่ราชการ หรือปฏิบัติหน้าที่ฝ่าฝืนข้อกำหนด ระเบียบ กฎหมาย'
                ],
                [
                    'num' => '03',
                    'do' => 'กล้าคิด กล้าตัดสินใจ กล้าแสดงออก และกระทำในสิ่งที่ถูกต้องชอบธรรม',
                    'dont' => 'ไม่ประพฤติปฏิบัติตนในทางที่เสื่อมเสีย ขาดคุณธรรม จริยธรรมและศีลธรรมของวิชาชีพ'
                ],
                [
                    'num' => '04',
                    'do' => 'มีจิตอาสา จิตสาธารณะ มุ่งประโยชน์ส่วนรวมมากกว่าประโยชน์ส่วนตัวหรือพวกพ้อง',
                    'dont' => 'ไม่เอื้อประโยชน์ให้พวกพ้อง และไม่มีประโยชน์ทับซ้อนจากการปฏิบัติหน้าที่ราชการ'
                ],
                [
                    'num' => '05',
                    'do' => 'มุ่งผลสัมฤทธิ์ของงาน มุ่งมั่นในการปฏิบัติงานอย่างเต็มกำลังความสามารถ',
                    'dont' => 'ไม่ละทิ้งทอดทิ้งหน้าที่ราชการเป็นเหตุให้ราชการเสียหาย'
                ],
                [
                    'num' => '06',
                    'do' => 'ปฏิบัติหน้าที่อย่างเป็นธรรมและไม่เลือกปฏิบัติ',
                    'dont' => 'ไม่รับสิ่งของ หรือผลประโยชน์ตอบแทนใดๆ เพื่อแลกกับการให้บริการ'
                ],
                [
                    'num' => '07',
                    'do' => 'ดำรงตนเป็นแบบอย่างที่ดีและรักษาภาพลักษณ์ของข้าราชการครูและบุคลากรทางการศึกษา เคารพในศักดิ์ศรีความเป็นมนุษย์ คำนึงถึงสิทธิเด็ก และยอมรับความแตกต่างของบุคคล',
                    'dont' => 'ไม่ประพฤติตนในทางที่เสื่อมเสียเกียรติศักดิ์ ศักดิ์ศรีของข้าราชการครูและบุคลากรทางการศึกษา และละเมิดศักดิ์ศรีความเป็นมนุษย์ หรือด้อยค่าจากความแตกต่างของบุคคล'
                ]
            ];

            foreach ($items as $idx => $item):
            ?>
                <div class="glass-card rounded-3xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-lg bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl transition-all duration-300 hover:shadow-xl">
                    <div class="flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-slate-100 dark:divide-slate-800">
                        <!-- Left Side: Do's (Green Theme) -->
                        <div class="p-6 md:p-8 flex-1 bg-emerald-500/5 dark:bg-emerald-500/[0.02]">
                            <div class="flex items-start gap-4">
                                <span class="text-xs font-black text-emerald-500 font-english bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20 shrink-0">
                                    <?php echo $item['num']; ?>
                                </span>
                                <div class="space-y-2">
                                    <h4 class="text-xs font-extrabold text-emerald-600 dark:text-emerald-400 tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-check text-sm shrink-0"></i>
                                        <span>สิ่งที่ควรปฏิบัติ (DO)</span>
                                    </h4>
                                    <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-350 leading-relaxed font-semibold">
                                        <?php echo htmlspecialchars($item['do']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Right Side: Don'ts (Red Theme) -->
                        <div class="p-6 md:p-8 flex-1 bg-rose-500/5 dark:bg-rose-500/[0.02]">
                            <div class="flex items-start gap-4">
                                <span class="text-xs font-black text-rose-500 font-english bg-rose-500/10 px-2.5 py-1 rounded-lg border border-rose-500/20 shrink-0">
                                    <?php echo $item['num']; ?>
                                </span>
                                <div class="space-y-2">
                                    <h4 class="text-xs font-extrabold text-rose-600 dark:text-rose-400 tracking-wider flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-xmark text-sm shrink-0"></i>
                                        <span>สิ่งที่ไม่ควรปฏิบัติ (DON'T)</span>
                                    </h4>
                                    <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-350 leading-relaxed font-semibold">
                                        <?php echo htmlspecialchars($item['dont']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- PDF Document View Frame Section -->
    <div class="glass-card rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl p-6 sm:p-8 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
            <div class="space-y-1">
                <h3 class="text-base sm:text-lg font-bold text-slate-850 dark:text-white flex items-center gap-2">
                    <i class="fa-regular fa-file-pdf text-red-500 text-xl animate-pulse"></i>
                    <span>เอกสารประกาศแนวปฏิบัติ Do's & Don'ts อย่างเป็นทางการ</span>
                </h3>
                <p class="text-[10px] sm:text-xs text-slate-400 dark:text-slate-500">
                    ประกาศหลักเกณฑ์พฤติกรรมทางจริยธรรมของข้าราชการครูและบุคลากรทางการศึกษา
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
                <iframe src="<?php echo $pdfUrl; ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay" loading="lazy" title="<?php echo htmlspecialchars(__('info_dos_donts') ?: 'เอกสารประกาศแนวปฏิบัติ Do\'s & Don\'ts อย่างเป็นทางการ'); ?>"></iframe>
            </div>
        <?php else: ?>
            <div class="max-w-2xl mx-auto bg-slate-50/50 dark:bg-slate-950/20 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-inner">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg font-bold text-slate-850 dark:text-white">ยังไม่มีการอัปโหลดไฟล์เอกสารแนวปฏิบัติ</h3>
                    <p class="text-slate-400 dark:text-slate-500 text-xs leading-relaxed">
                        ขณะนี้อยู่ในระหว่างการจัดเตรียมเอกสาร สามารถตรวจสอบการอัปโหลดได้ที่ <a href="<?php echo BASE_URL; ?>admin?tab=documents" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">หน้าจัดการเอกสารหลังบ้าน</a>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
