<!-- views/frontend/index.php -->
<!-- Landing Page for General Public -->

<!-- 1. Full-width Hero Image Carousel Section (Clean Images, Unobstructed Showcase) -->
<section class="relative w-full h-[220px] sm:h-[350px] md:h-[450px] lg:h-[550px] xl:h-[650px] bg-slate-950 overflow-hidden shadow-2xl">
    <?php if (empty($slides)): ?>
        <!-- Slide Fallback -->
        <div class="slide absolute inset-0 w-full h-full opacity-100 transition-opacity duration-1000 ease-in-out">
            <img src="https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1600&auto=format&fit=crop" alt="Default School Slide" class="w-full h-full object-cover object-center" fetchpriority="high">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/30 to-slate-950/20"></div>
        </div>
    <?php else: ?>
        <?php foreach ($slides as $index => $slide): ?>
            <!-- Slide <?php echo $index + 1; ?> -->
            <div class="slide absolute inset-0 w-full h-full <?php echo $index === 0 ? 'opacity-100 z-10' : 'opacity-0 pointer-events-none z-0'; ?> transition-all duration-1000 ease-in-out">
                <img src="<?php echo htmlspecialchars($slide['image_url']); ?>" alt="<?php echo htmlspecialchars($slide['title'] ?? 'Slide image'); ?>" class="w-full h-full object-cover object-center" <?php echo $index === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-950/15 to-slate-950/30"></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Navigation Arrows -->
    <button onclick="prevSlide()" class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-2xl bg-white/10 hover:bg-indigo-600/80 border border-white/20 backdrop-blur-md flex items-center justify-center text-white transition-all duration-300 active:scale-90 z-20 shadow-lg cursor-pointer hidden sm:flex" title="Previous Slide">
        <i class="fa-solid fa-chevron-left text-sm"></i>
    </button>
    <button onclick="nextSlide()" class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-2xl bg-white/10 hover:bg-indigo-600/80 border border-white/20 backdrop-blur-md flex items-center justify-center text-white transition-all duration-300 active:scale-90 z-20 shadow-lg cursor-pointer hidden sm:flex" title="Next Slide">
        <i class="fa-solid fa-chevron-right text-sm"></i>
    </button>

    <!-- Elegant Dot Indicators -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3 z-20 bg-slate-950/40 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/10">
        <?php 
        $slideCount = count($slides);
        if ($slideCount === 0) $slideCount = 1;
        for ($i = 0; $i < $slideCount; $i++): 
        ?>
            <button onclick="changeSlide(<?php echo $i; ?>, true)" class="slider-dot <?php echo $i === 0 ? 'w-8 bg-indigo-500' : 'w-2.5 bg-white/40 hover:bg-white/70'; ?> h-2.5 rounded-full transition-all duration-300" title="Slide <?php echo $i + 1; ?>"></button>
        <?php endfor; ?>
    </div>
</section>

<!-- 2. Why Choose Us Section -->
<section class="py-16 relative overflow-hidden">
    <!-- Decorative Blurs -->
    <div class="absolute w-[250px] h-[250px] bg-indigo-500/5 blur-[80px] rounded-full top-20 left-[-100px] pointer-events-none"></div>
    <div class="absolute w-[250px] h-[250px] bg-emerald-500/5 blur-[80px] rounded-full bottom-20 right-[-100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center space-y-3 mb-12">
            <span class="text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-3.5 py-1.5 rounded-full border border-indigo-500/20 inline-block">ทำไมต้องเลือกเรา</span>
            <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Why Choose Us</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs max-w-lg mx-auto">โรงเรียนที่พร้อมขับเคลื่อนการเรียนรู้รอบด้าน เพื่อสร้างโอกาสและอนาคตที่ดีที่สุดให้กับผู้เรียนทุกคน</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="glass-card p-6 rounded-3xl border border-slate-200 dark:border-white/10 shadow-lg hover:shadow-indigo-500/10 hover:border-indigo-500/30 transition-all duration-300 hover:-translate-y-1.5 group h-full flex flex-col">
                <span class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-500 dark:text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-xl mb-5 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-graduation-cap"></i>
                </span>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Academic Excellence</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed flex-grow">เน้นการจัดการเรียนรู้อย่างเข้มข้น ส่งเสริมความเป็นเลิศทางวิชาการและเตรียมพร้อมสู่ระดับอุดมศึกษา</p>
            </div>
            <!-- Card 2 -->
            <div class="glass-card p-6 rounded-3xl border border-slate-200 dark:border-white/10 shadow-lg hover:shadow-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 hover:-translate-y-1.5 group h-full flex flex-col">
                <span class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xl mb-5 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-microscope"></i>
                </span>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Modern Innovation</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed flex-grow">ประยุกต์ใช้สื่อและเทคโนโลยีการสอนที่ทันสมัย เสริมสร้างทักษะการวิจัย คิดวิเคราะห์ และสร้างนวัตกรรมใหม่</p>
            </div>
            <!-- Card 3 -->
            <div class="glass-card p-6 rounded-3xl border border-slate-200 dark:border-white/10 shadow-lg hover:shadow-amber-500/10 hover:border-amber-500/30 transition-all duration-300 hover:-translate-y-1.5 group h-full flex flex-col">
                <span class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-500 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center text-xl mb-5 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-handshake-angle"></i>
                </span>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Virtue & Morality</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed flex-grow">ปลูกฝังคุณธรรม จริยธรรม ระเบียบวินัย และจิตสาธารณะ เพื่อเติบโตเป็นบุคลากรที่มีคุณภาพของสังคม</p>
            </div>
            <!-- Card 4 -->
            <div class="glass-card p-6 rounded-3xl border border-slate-200 dark:border-white/10 shadow-lg hover:shadow-rose-500/10 hover:border-rose-500/30 transition-all duration-300 hover:-translate-y-1.5 group h-full flex flex-col">
                <span class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-500 dark:text-rose-400 border border-rose-500/20 flex items-center justify-center text-xl mb-5 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-earth-americas"></i>
                </span>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Global Connectivity</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed flex-grow">เสริมสร้างความรู้ทักษะชีวิต ภาษาต่างประเทศเพื่อการสื่อสาร และเตรียมตัวก้าวสู่สากล</p>
            </div>
        </div>
    </div>
</section>

<!-- 3. School Statistics section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-gradient-to-r from-blue-700 via-indigo-700 to-indigo-800 rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden border border-indigo-500/20">
        <!-- Background light glows -->
        <div class="absolute w-[300px] h-[300px] bg-blue-500/20 blur-[80px] rounded-full top-[-50px] left-[-50px]"></div>
        <div class="absolute w-[300px] h-[300px] bg-purple-500/20 blur-[80px] rounded-full bottom-[-50px] right-[-50px]"></div>

        <div class="relative z-10 grid grid-cols-2 lg:grid-cols-4 gap-8 text-center divide-y lg:divide-y-0 lg:divide-x divide-white/10">
            <!-- Stat 1 -->
            <div class="pt-6 first:pt-0 lg:pt-0 flex flex-col justify-center items-center space-y-2">
                <span class="w-11 h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-user-graduate"></i></span>
                <span class="text-3xl font-extrabold text-white tracking-tight font-english"><?php echo htmlspecialchars(STAT_STUDENTS); ?></span>
                <span class="text-xs text-blue-100 font-semibold"><?php echo htmlspecialchars(STAT_STUDENTS_SUB); ?></span>
            </div>
            <!-- Stat 2 -->
            <div class="pt-6 lg:pt-0 flex flex-col justify-center items-center space-y-2">
                <span class="w-11 h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-chalkboard-user"></i></span>
                <span class="text-3xl font-extrabold text-white tracking-tight font-english"><?php echo htmlspecialchars(STAT_TEACHERS); ?></span>
                <span class="text-xs text-blue-100 font-semibold"><?php echo htmlspecialchars(STAT_TEACHERS_SUB); ?></span>
            </div>
            <!-- Stat 3 -->
            <div class="pt-6 lg:pt-0 flex flex-col justify-center items-center space-y-2">
                <span class="w-11 h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-trophy"></i></span>
                <span class="text-3xl font-extrabold text-white tracking-tight font-english"><?php echo htmlspecialchars(STAT_AWARDS); ?></span>
                <span class="text-xs text-blue-100 font-semibold"><?php echo htmlspecialchars(STAT_AWARDS_SUB); ?></span>
            </div>
            <!-- Stat 4 -->
            <div class="pt-6 lg:pt-0 flex flex-col justify-center items-center space-y-2">
                <span class="w-11 h-11 rounded-2xl bg-white/10 text-white flex items-center justify-center text-lg shadow-inner"><i class="fa-solid fa-graduation-cap"></i></span>
                <span class="text-3xl font-extrabold text-white tracking-tight font-english"><?php echo htmlspecialchars(STAT_ADMISSION); ?></span>
                <span class="text-xs text-blue-100 font-semibold"><?php echo htmlspecialchars(STAT_ADMISSION_SUB); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- 4. Executive Message Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <!-- Director Image Left Column (cols 5) -->
        <div class="lg:col-span-5 flex justify-center">
            <div class="relative w-full max-w-[360px] aspect-[3/4] rounded-3xl overflow-hidden border border-slate-200 dark:border-white/10 shadow-2xl bg-slate-900 group">
                <?php if (!empty(EXEC_IMAGE)): ?>
                    <img src="<?php echo UPLOAD_URL . EXEC_IMAGE; ?>" alt="<?php echo htmlspecialchars(EXEC_NAME); ?>" class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500">
                <?php else: ?>
                    <div class="w-full h-full bg-gradient-to-br from-indigo-950 to-slate-950 flex flex-col items-center justify-center text-white p-4">
                        <i class="fa-solid fa-user-tie text-6xl text-slate-600 mb-4"></i>
                        <span class="text-xs text-slate-400 italic">ไม่ได้อัปโหลดรูปภาพ</span>
                    </div>
                <?php endif; ?>
                <!-- Executive Label Gradient Backdrop -->
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent p-6 text-white space-y-1 z-10">
                    <h4 class="text-sm font-bold tracking-wide"><?php echo htmlspecialchars(EXEC_NAME); ?></h4>
                    <p class="text-[10px] text-indigo-300 font-semibold uppercase tracking-wider"><?php echo htmlspecialchars(EXEC_POSITION); ?></p>
                </div>
            </div>
        </div>

        <!-- Director Quote Right Column (cols 7) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="space-y-3">
                <span class="text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-3.5 py-1.5 rounded-full border border-indigo-500/20 inline-block">สารจากผู้บริหาร</span>
                <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white leading-tight">ยินดีต้อนรับสู่ <?php echo SCHOOL_NAME; ?></h3>
            </div>
            
            <div class="relative pl-6 border-l-4 border-indigo-500 dark:border-indigo-500">
                <i class="fa-solid fa-quote-left absolute -left-3.5 -top-4 text-4xl text-indigo-500/20 dark:text-indigo-400/15 pointer-events-none"></i>
                <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed font-medium italic whitespace-pre-wrap">"<?php echo htmlspecialchars(EXEC_MESSAGE); ?>"</p>
            </div>

            <!-- Identity Mini Cards Subgrid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                <!-- Card 1: Vision -->
                <div class="glass-card p-4 rounded-2xl border border-slate-200 dark:border-white/5 shadow-md flex items-start gap-3">
                    <span class="w-8 h-8 shrink-0 rounded-xl bg-blue-500/10 text-blue-500 dark:text-blue-400 flex items-center justify-center text-sm"><i class="fa-solid fa-eye"></i></span>
                    <div class="space-y-0.5">
                        <h4 class="text-[11px] font-bold text-slate-900 dark:text-white">วิสัยทัศน์ (Vision)</h4>
                        <p class="text-[9px] text-slate-500 dark:text-slate-400 leading-normal">เป็นเลิศทางปัญญา คู่ศรัทธาจริยธรรม ก้าวนำนวัตกรรมระดับสากล</p>
                    </div>
                </div>
                <!-- Card 2: Mission -->
                <div class="glass-card p-4 rounded-2xl border border-slate-200 dark:border-white/5 shadow-md flex items-start gap-3">
                    <span class="w-8 h-8 shrink-0 rounded-xl bg-purple-500/10 text-purple-500 dark:text-purple-400 flex items-center justify-center text-sm"><i class="fa-solid fa-bullseye"></i></span>
                    <div class="space-y-0.5">
                        <h4 class="text-[11px] font-bold text-slate-900 dark:text-white">พันธกิจ (Mission)</h4>
                        <p class="text-[9px] text-slate-500 dark:text-slate-400 leading-normal">มุ่งยกระดับการศึกษาให้สอดรับความเปลี่ยนแปลงทางเทคโนโลยีและทักษะแห่งอนาคต</p>
                    </div>
                </div>
                <!-- Card 3: Philosophy -->
                <div class="glass-card p-4 rounded-2xl border border-slate-200 dark:border-white/5 shadow-md flex items-start gap-3">
                    <span class="w-8 h-8 shrink-0 rounded-xl bg-amber-500/10 text-amber-500 dark:text-amber-400 flex items-center justify-center text-sm"><i class="fa-solid fa-book-open"></i></span>
                    <div class="space-y-0.5">
                        <h4 class="text-[11px] font-bold text-slate-900 dark:text-white">เอกลักษณ์ (Identity)</h4>
                        <p class="text-[9px] text-slate-500 dark:text-slate-400 leading-normal">คุณธรรมนำวิชาการ สืบสานความโปร่งใส ก้าวไกลสู่สิ่งแวดล้อมสากล</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. News Board (3-column layout) -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-slate-200 dark:border-white/5">
    <div class="text-center space-y-3 mb-12">
        <span class="text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-3.5 py-1.5 rounded-full border border-indigo-500/20 inline-block">กระดานข่าวสารสารสนเทศ</span>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">News & Board</h2>
        <p class="text-slate-500 dark:text-slate-400 text-xs">ติดตามข่าวประชาสัมพันธ์ กิจกรรมต่าง ๆ และข้อมูลการจัดซื้อจัดจ้างอย่างโปร่งใส</p>
        <div class="pt-2">
            <a href="<?php echo BASE_URL; ?>news?filter=all" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600/10 dark:bg-indigo-600/20 hover:bg-indigo-600 dark:hover:bg-indigo-600 text-indigo-600 dark:text-indigo-400 hover:text-white dark:hover:text-white border border-indigo-500/20 rounded-xl text-xs font-bold transition-all duration-200">
                <i class="fa-solid fa-list-ul"></i> ดูข่าวสารและประกาศทั้งหมด
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Column 1: PR News (ทั่วไป / ประชาสัมพันธ์) -->
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-white/10">
                <span class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-bullhorn text-indigo-500"></i> ข่าวประชาสัมพันธ์</span>
                <a href="<?php echo BASE_URL; ?>news?filter=general" class="text-[10px] text-indigo-500 hover:underline">ดูทั้งหมด</a>
            </div>
            
            <div class="space-y-4">
                <?php if (empty($generalNews)): ?>
                    <div class="p-6 text-center text-xs text-slate-400 italic">ไม่มีข้อมูลข่าวสารประชาสัมพันธ์</div>
                <?php else: 
                    foreach ($generalNews as $item): 
                ?>
                    <div onclick="location.href='<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>'" class="glass-card p-4 rounded-2xl border border-slate-200 dark:border-white/5 hover:border-indigo-500/30 transition-all duration-300 shadow-md cursor-pointer flex gap-4 hover:-translate-y-0.5">
                        <div class="w-16 h-16 rounded-xl bg-slate-200 dark:bg-slate-950 overflow-hidden shrink-0 border border-slate-200 dark:border-white/10">
                            <?php if (!empty($item['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-tr from-indigo-500/10 to-indigo-500/20 text-indigo-500 flex items-center justify-center"><i class="fa-solid fa-newspaper text-lg"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-1 flex-grow min-w-0">
                            <span class="text-[9px] text-slate-400 dark:text-slate-500 font-english"><i class="fa-regular fa-clock mr-1"></i><?php echo date('d M Y', strtotime($item['created_at'])); ?></span>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate leading-snug hover:text-indigo-500 transition-colors"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-1 leading-normal"><?php echo htmlspecialchars($item['content']); ?></p>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                    endif; 
                ?>
            </div>
        </div>

        <!-- Column 2: School Activities (ภาพข่าวกิจกรรม) -->
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-white/10">
                <span class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-camera-retro text-emerald-500"></i> ภาพกิจกรรม</span>
                <a href="<?php echo BASE_URL; ?>news?filter=activity" class="text-[10px] text-emerald-500 hover:underline">ดูทั้งหมด</a>
            </div>

            <div class="space-y-4">
                <?php if (empty($activities)): ?>
                    <div class="p-6 text-center text-xs text-slate-400 italic">ไม่มีข้อมูลข่าวกิจกรรม</div>
                <?php else: 
                    foreach ($activities as $item): 
                ?>
                    <div onclick="location.href='<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>'" class="glass-card p-4 rounded-2xl border border-slate-200 dark:border-white/5 hover:border-emerald-500/30 transition-all duration-300 shadow-md cursor-pointer flex gap-4 hover:-translate-y-0.5">
                        <div class="w-16 h-16 rounded-xl bg-slate-200 dark:bg-slate-950 overflow-hidden shrink-0 border border-slate-200 dark:border-white/10">
                            <?php if (!empty($item['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-tr from-emerald-500/10 to-emerald-500/20 text-emerald-500 flex items-center justify-center"><i class="fa-solid fa-images text-lg"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="space-y-1 flex-grow min-w-0">
                            <span class="text-[9px] text-slate-400 dark:text-slate-500 font-english"><i class="fa-regular fa-clock mr-1"></i><?php echo date('d M Y', strtotime($item['created_at'])); ?></span>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate leading-snug hover:text-emerald-500 transition-colors"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-1 leading-normal"><?php echo htmlspecialchars($item['content']); ?></p>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                    endif; 
                ?>
            </div>
        </div>

        <!-- Column 3: Procurement Announcements (ประกาศจัดซื้อจัดจ้าง) -->
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200 dark:border-white/10">
                <span class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-file-invoice-dollar text-red-500"></i> จัดซื้อจัดจ้าง</span>
                <a href="<?php echo BASE_URL; ?>news?filter=announcement" class="text-[10px] text-red-500 hover:underline">ดูทั้งหมด</a>
            </div>

            <div class="space-y-4">
                <?php if (empty($announcements)): ?>
                    <div class="p-6 text-center text-xs text-slate-400 italic">ไม่มีประกาศจัดซื้อจัดจ้าง</div>
                <?php else: 
                    foreach ($announcements as $item): 
                ?>
                    <div onclick="location.href='<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>'" class="glass-card p-4 rounded-2xl border border-slate-200 dark:border-white/5 hover:border-red-500/30 transition-all duration-300 shadow-md cursor-pointer hover:-translate-y-0.5 relative overflow-hidden">
                        <!-- Invoice-style left status bar -->
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-red-500/70"></div>
                        <div class="pl-3 space-y-2">
                            <div class="flex justify-between items-center gap-2">
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-english"><i class="fa-regular fa-clock mr-1"></i><?php echo date('d M Y', strtotime($item['created_at'])); ?></span>
                                <?php if (!empty($item['doc_number'])): ?>
                                    <span class="bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20 text-[8px] font-bold px-1.5 py-0.5 rounded font-english">
                                        เลขที่ <?php echo htmlspecialchars($item['doc_number']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-white truncate leading-snug hover:text-red-500 transition-colors"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <div class="flex justify-between items-center text-[10px] text-slate-500 dark:text-slate-400 pt-1 border-t border-slate-900/5 dark:border-white/5">
                                <span>งบประมาณกลาง:</span>
                                <span class="font-english font-bold text-slate-900 dark:text-white">
                                    <?php echo !empty($item['budget']) ? number_format($item['budget'], 2) . ' บาท' : 'ไม่ระบุงบประมาณ'; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                    endif; 
                ?>
            </div>
        </div>
    </div>
</section>

<!-- 6. Awards & Achievements section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-slate-200 dark:border-white/5">
    <div class="text-center space-y-3 mb-12">
        <span class="text-xs font-bold text-amber-500 dark:text-amber-400 uppercase tracking-widest bg-amber-500/10 px-3.5 py-1.5 rounded-full border border-amber-500/20 inline-block">รางวัลและความภาคภูมิใจ</span>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Awards & Achievements</h2>
        <p class="text-slate-500 dark:text-slate-400 text-xs">ผลงานเกียรติบัตรและรางวัลแห่งความสำเร็จของครู นักเรียน และสถานศึกษา</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php if (empty($awards)): ?>
            <div class="col-span-full text-center py-12 text-slate-400 italic text-xs">ยังไม่มีบันทึกข้อมูลรางวัลและผลงานเด่นในระบบขณะนี้</div>
        <?php else: 
            foreach ($awards as $item): 
                $clickAction = !empty($item['image_url']) 
                    ? "window.open('".htmlspecialchars($item['image_url'])."', '_blank')" 
                    : "window.open('https://cktech.phichai.ac.th/', '_blank')";
        ?>
            <div onclick="<?php echo $clickAction; ?>" class="glass-card rounded-2xl overflow-hidden flex flex-col h-full hover:border-amber-500/30 transition-all duration-300 hover:-translate-y-1.5 shadow-lg group cursor-pointer relative">
                <!-- Cover Image & Trophy badge -->
                <div class="h-44 overflow-hidden bg-slate-950 relative">
                    <?php if (!empty($item['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-amber-950/40 to-slate-950 flex items-center justify-center p-4">
                            <span class="text-amber-500/40 text-4xl"><i class="fa-solid fa-trophy"></i></span>
                        </div>
                    <?php endif; ?>
                    <!-- Gold trophy badge overlay -->
                    <span class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-950 flex items-center justify-center text-sm shadow-lg border border-yellow-300 font-bold">
                        <i class="fa-solid fa-trophy"></i>
                    </span>
                </div>

                <!-- Content info -->
                <div class="p-5 flex flex-col flex-grow space-y-2">
                    <span class="text-[9px] text-slate-400 dark:text-slate-500 font-english"><i class="fa-regular fa-clock mr-1"></i><?php echo date('d M Y', strtotime($item['date'])); ?></span>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white leading-snug line-clamp-2 hover:text-amber-500 transition-colors">
                        <?php echo htmlspecialchars($item['title']); ?>
                    </h3>
                    <p class="text-[10px] text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3 whitespace-pre-line">
                        <?php echo htmlspecialchars($item['content']); ?>
                    </p>
                </div>
            </div>
        <?php 
            endforeach; 
            endif; 
        ?>
    </div>

    <!-- See More CTA Button -->
    <div class="flex justify-center mt-10">
        <a href="<?php echo BASE_URL; ?>awards" class="inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-2xl text-xs font-bold shadow-lg hover:shadow-indigo-500/25 transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95">
            <i class="fa-solid fa-trophy text-sm"></i>
            <span>ดูเกียรติยศและรางวัลทั้งหมด</span>
        </a>
    </div>
</section>


<!-- 7. Activity Gallery section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-slate-200 dark:border-white/5">
    <div class="text-center space-y-3 mb-12">
        <span class="text-xs font-bold text-emerald-500 dark:text-emerald-400 uppercase tracking-widest bg-emerald-500/10 px-3.5 py-1.5 rounded-full border border-emerald-500/20 inline-block">แกลเลอรีภาพกิจกรรม</span>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white">Activity Gallery</h2>
        <p class="text-slate-500 dark:text-slate-400 text-xs">ภาพความประทับใจ ความสำเร็จ และการมีส่วนร่วมในกิจกรรมต่าง ๆ ของรั้วโรงเรียน</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <?php 
        $activityImagesCount = 0;
        if (!empty($journalsForGallery)):
            foreach ($journalsForGallery as $j):
                $activityImagesCount++;
        ?>
                <div onclick="location.href='<?php echo BASE_URL; ?>journal/detail?id=<?php echo $j['id']; ?>'" class="relative group aspect-square rounded-2xl overflow-hidden cursor-pointer shadow-lg border border-slate-200 dark:border-white/5 bg-slate-900">
                    <img src="<?php echo htmlspecialchars($j['image_url']); ?>" alt="<?php echo htmlspecialchars($j['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4 z-10">
                        <span class="text-[10px] font-bold text-white line-clamp-2"><?php echo htmlspecialchars($j['title']); ?></span>
                    </div>
                </div>
        <?php 
            endforeach;
        endif;
        if ($activityImagesCount === 0):
        ?>
            <div class="col-span-full text-center py-12 text-slate-400 italic text-xs">ยังไม่มีข้อมูลรูปภาพกิจกรรมในขณะนี้</div>
        <?php endif; ?>
    </div>
</section>

<!-- 8. ITA Online Dashboard -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-slate-200 dark:border-white/5">
    <div class="glass-card rounded-3xl p-8 border border-slate-200 dark:border-white/10 shadow-2xl relative overflow-hidden">
        
        <!-- Decoration circles -->
        <div class="absolute w-[200px] h-[200px] bg-indigo-500/5 dark:bg-indigo-500/10 blur-[60px] rounded-full top-[-50px] right-[-50px]"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
            <!-- Left descriptive col -->
            <div class="lg:col-span-4 space-y-4">
                <span class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-3 py-1 rounded-md border border-indigo-500/20 inline-block">ITA ONLINE PORTAL</span>
                <h3 class="text-xl font-extrabold text-slate-900 dark:text-white leading-tight">ระบบเผยแพร่ข้อมูลประเมินคุณธรรมและความโปร่งใส</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">ร่วมเป็นส่วนหนึ่งของการติดตามตรวจสอบการดำเนินงานอย่างซื่อสัตย์สุจริตตามหลักธรรมาภิบาล ผ่านดัชนีชี้วัดคุณธรรมและความโปร่งใส (ITA)</p>
                <div class="pt-2">
                    <a href="<?php echo BASE_URL; ?>ita" class="inline-flex items-center gap-1.5 px-4.5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-indigo-500/20 transition-all duration-200">
                        <i class="fa-solid fa-chart-line"></i> เข้าสู่หน้า ITA เต็มรูปแบบ
                    </a>
                </div>
            </div>

            <!-- Right visualization col -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Progress stats -->
                <div class="space-y-2">
                    <div class="flex justify-between items-end text-xs">
                        <span class="font-bold text-slate-800 dark:text-white">ความคืบหน้าการเผยแพร่ตัวชี้วัด (ITA Progress)</span>
                        <?php 
                        $completed = $itaMetrics['completed'] ?? 0;
                        $total = $itaMetrics['total'] ?? 43;
                        $percent = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                        ?>
                        <span class="font-english font-black text-indigo-600 dark:text-indigo-400 text-sm"><?php echo $percent; ?>%</span>
                    </div>
                    <!-- ProgressBar bar container -->
                    <div class="w-full h-3 rounded-full bg-slate-200 dark:bg-slate-950 border border-slate-300 dark:border-white/5 overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full transition-all duration-500" style="width: <?php echo $percent; ?>%;"></div>
                    </div>
                    <p class="text-[9px] text-slate-400 dark:text-slate-500 leading-tight">มีข้อมูลเผยแพร่แล้ว <?php echo $completed; ?> หัวข้อ จากทั้งหมด <?php echo $total; ?> หัวข้ออ้างอิง</p>
                </div>

                <!-- Circular Indicators Portal -->
                <div class="space-y-2.5">
                    <h4 class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">ดัชนีชี้วัดข้อมูลสาธารณะออนไลน์ (ITA Quick View)</h4>
                    <div class="flex flex-wrap gap-1.5 max-h-[140px] overflow-y-auto pr-2 scrollbar-thin">
                        <?php 
                        $itaModel = new Ita();
                        $indicators = $itaModel->getAll('published');
                        foreach ($indicators as $ind):
                            $isActive = (!empty($ind['file_path']) || !empty($ind['link_url']));
                            if (!$isActive) continue;
                        ?>
                            <a href="<?php echo BASE_URL; ?>ita?focus=<?php echo $ind['code']; ?>" class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-english font-bold transition-all border bg-indigo-600/10 hover:bg-indigo-600 border-indigo-500/30 text-indigo-600 dark:text-indigo-400 hover:text-white" title="<?php echo htmlspecialchars($ind['name']); ?>">
                                <?php echo $ind['code']; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 9. Portals / External Quick System Portals -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 border-t border-slate-200 dark:border-white/5">
    <div class="text-center space-y-3 mb-12">
        <span class="text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-3.5 py-1.5 rounded-full border border-indigo-500/20 inline-block">ระบบสารสนเทศออนไลน์</span>
        <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white"><?php echo __('external_portals'); ?></h2>
        <p class="text-slate-500 dark:text-slate-400 text-xs max-w-md mx-auto"><?php echo __('external_portals_desc'); ?></p>
    </div>

    <?php
    $onlinePortals = [
        [
            'title' => 'ระบบรายงานการสอน',
            'desc' => 'จัดการและรายงานการสอนอย่างมีประสิทธิภาพ',
            'icon' => 'fa-chalkboard-teacher',
            'gradient' => 'from-blue-600 to-indigo-700',
            'url' => 'https://cktech.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'ระบบดูแลช่วยเหลือนักเรียน',
            'desc' => 'ระบบดูแลและพัฒนานักเรียนอย่างครบครัน',
            'icon' => 'fa-shield-alt',
            'gradient' => 'from-emerald-600 to-teal-700',
            'url' => 'https://std.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'ระบบกิจกรรมนักเรียน',
            'desc' => 'จัดการกิจกรรมและพัฒนาทักษะนักเรียน',
            'icon' => 'fa-trophy',
            'gradient' => 'from-orange-500 to-red-600',
            'url' => 'https://eventstd.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'ระบบรับสมัครชุมนุม',
            'desc' => 'สมัครเข้าร่วมชุมนุมและกิจกรรมต่างๆ',
            'icon' => 'fa-users',
            'gradient' => 'from-violet-600 to-purple-700',
            'url' => 'https://club.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'ระบบข้อมูลบุคลากร',
            'desc' => 'จัดการข้อมูลบุคลากรและครูอาจารย์',
            'icon' => 'fa-user-tie',
            'gradient' => 'from-sky-600 to-blue-700',
            'url' => 'https://person.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'ระบบเอกสารคำสั่ง',
            'desc' => 'เข้าถึงเอกสารและคำสั่งต่างๆ ของโรงเรียน',
            'icon' => 'fa-folder-open',
            'gradient' => 'from-amber-500 to-orange-600',
            'url' => 'https://doc.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'งานรับนักเรียน',
            'desc' => 'ข้อมูลการสมัครเรียนและรับนักเรียนใหม่',
            'icon' => 'fa-graduation-cap',
            'gradient' => 'from-green-600 to-emerald-700',
            'url' => 'https://sites.google.com/phichai.ac.th/student68/',
            'badge' => 'hot'
        ],
        [
            'title' => 'งานบริหารทั่วไป',
            'desc' => 'ระบบบริหารจัดการทั่วไปของโรงเรียน',
            'icon' => 'fa-briefcase',
            'gradient' => 'from-rose-600 to-pink-700',
            'url' => 'https://general.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'งานทะเบียน',
            'desc' => 'จัดการระบบทะเบียนและข้อมูลนักเรียน',
            'icon' => 'fa-clipboard-list',
            'gradient' => 'from-cyan-600 to-blue-700',
            'url' => 'https://regis.phichai.ac.th/',
            'badge' => ''
        ],
        [
            'title' => 'ชำระเงินบำรุงการศึกษา',
            'desc' => 'ระบบชำระเงินออนไลน์อย่างสะดวก',
            'icon' => 'fa-credit-card',
            'gradient' => 'from-pink-600 to-rose-700',
            'url' => 'https://schoolbilling.dev31.in.th/SBPHICHAI/Pages/PrintReportPayInForStudent.aspx',
            'badge' => ''
        ],
        [
            'title' => 'คู่มือการจ่ายเงิน',
            'desc' => 'คู่มือและวิธีการชำระเงินบำรุงการศึกษา',
            'icon' => 'fa-book-reader',
            'gradient' => 'from-indigo-600 to-violet-700',
            'url' => 'https://drive.google.com/file/d/12_uFmWt6yWXwH2DC_utnOHAzFojYtjhX/view',
            'badge' => ''
        ],
        [
            'title' => 'ระบบจัดซื้อ-จัดจ้าง',
            'desc' => 'ระบบจัดการพัสดุและการเงิน',
            'icon' => 'fa-shopping-cart',
            'gradient' => 'from-teal-600 to-cyan-700',
            'url' => '#',
            'badge' => 'soon'
        ],
        [
            'title' => 'PA ข้อตกลงการพัฒนางาน',
            'desc' => 'ระบบติดตามและประเมินผลการทำงาน',
            'icon' => 'fa-chart-line',
            'gradient' => 'from-red-600 to-orange-600',
            'url' => 'https://sites.google.com/phichai.ac.th/phichaipa/',
            'badge' => ''
        ],
        [
            'title' => 'BIG DATA Phichai School',
            'desc' => 'ระบบวิเคราะห์ข้อมูลเพื่อการตัดสินใจ',
            'icon' => 'fa-chart-bar',
            'gradient' => 'from-yellow-500 to-amber-600',
            'url' => 'https://phichai.ac.th/phichai/dataph/index.php',
            'badge' => 'new'
        ],
        [
            'title' => 'ห้องเรียนออนไลน์ 2567',
            'desc' => 'แพลตฟอร์มการเรียนการสอนออนไลน์',
            'icon' => 'fa-laptop',
            'gradient' => 'from-fuchsia-600 to-pink-600',
            'url' => 'https://sites.google.com/phichai.ac.th/online/',
            'badge' => ''
        ]
    ];
    ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
        <?php foreach ($onlinePortals as $portal): 
            $badge = trim($portal['badge'] ?? '');
            $gradientClass = str_replace('tw-', '', $portal['gradient'] ?? '');
            $url = $portal['url'];
            $target = ($url !== '#') ? 'target="_blank" rel="noopener"' : '';
        ?>
            <a href="<?php echo htmlspecialchars($url); ?>" <?php echo $target; ?> class="glass-card p-5 rounded-2xl flex flex-col items-center justify-center text-center space-y-3 hover:scale-[1.03] hover:border-indigo-500/30 transition-all duration-300 shadow-lg relative group min-h-[170px] cursor-pointer">
                <?php if ($badge === 'hot'): ?>
                    <span class="absolute top-3 right-3 bg-rose-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider animate-pulse shadow-md">HOT</span>
                <?php elseif ($badge === 'new'): ?>
                    <span class="absolute top-3 right-3 bg-emerald-500 text-white text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider shadow-md">NEW</span>
                <?php elseif ($badge === 'soon'): ?>
                    <span class="absolute top-3 right-3 bg-amber-500 text-slate-900 text-[9px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider shadow-md">SOON</span>
                <?php endif; ?>

                <span class="w-12 h-12 rounded-2xl bg-gradient-to-br <?php echo htmlspecialchars($gradientClass); ?> text-white flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <i class="fa-solid <?php echo htmlspecialchars($portal['icon']); ?>"></i>
                </span>
                <div class="space-y-1">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors leading-snug"><?php echo htmlspecialchars($portal['title']); ?></h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-normal line-clamp-2"><?php echo htmlspecialchars($portal['desc']); ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>


<!-- News Details Lightbox Modal -->
<div id="news-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="w-full max-w-2xl bg-white dark:bg-slate-900 border border-slate-900/5 dark:border-white/10 rounded-3xl shadow-2xl overflow-hidden glass-modal scale-95 transition-transform duration-300">
        <!-- Close btn -->
        <div class="p-4 border-b border-slate-900/5 dark:border-white/5 flex justify-between items-center bg-slate-100/50 dark:bg-slate-950/40">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400" id="modal-date"></span>
            <button onclick="closeNewsModal()" class="w-8 h-8 rounded-lg bg-slate-200/50 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-700 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-times"></i>
            </button>
        </div>
        <!-- Scrollable details -->
        <div class="p-6 max-h-[75vh] overflow-y-auto space-y-4">
            <div id="modal-image-container" class="h-[400px] rounded-xl overflow-hidden bg-slate-950 border border-white/5 hidden animate-fade-in">
                <img id="modal-image" src="" alt="News Image" class="w-full h-full object-contain bg-slate-950/60">
            </div>
            <div class="space-y-2">
                <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold border inline-block" id="modal-tag"></span>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white leading-snug" id="modal-title"></h2>
            </div>
            
            <div id="modal-procurement-container" class="hidden p-4 rounded-2xl bg-slate-100 dark:bg-slate-950/50 border border-slate-200 dark:border-white/5 space-y-1.5 text-xs">
                <div class="flex justify-between">
                    <span class="text-slate-500">เลขที่เอกสารประกาศ:</span>
                    <span class="font-bold text-slate-800 dark:text-white" id="modal-doc-number"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">งบประมาณโครงการ:</span>
                    <span class="font-bold text-slate-800 dark:text-white" id="modal-budget"></span>
                </div>
            </div>

            <hr class="border-slate-900/5 dark:border-white/5">
            <p class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed whitespace-pre-wrap" id="modal-content"></p>
            
            <!-- PDF Document Attachment Link Container -->
            <div id="modal-pdf-container" class="hidden pt-2">
                <a id="modal-pdf-link" href="" target="_blank" class="inline-flex items-center gap-2 px-4.5 py-2.5 bg-red-600 hover:bg-red-700 active:scale-95 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-red-500/20 transition-all duration-200">
                    <i class="fa-regular fa-file-pdf text-sm"></i>
                    <span>ดาวน์โหลด / เปิดดูไฟล์เอกสารแนบ PDF</span>
                </a>
            </div>

            <div class="text-[10px] text-slate-500 pt-4 border-t border-slate-900/5 dark:border-white/5 flex justify-between">
                <span id="modal-author"></span>
            </div>
        </div>
    </div>
</div>

<script>
    // Hero Slider Carousel
    let currentSlideIndex = 0;

    function changeSlide(index, manual = false) {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.slider-dot');
        if (index < 0 || index >= slides.length) return;
        
        slides.forEach(slide => {
            slide.classList.remove('opacity-100', 'z-10');
            slide.classList.add('opacity-0', 'pointer-events-none', 'z-0');
        });
        dots.forEach(dot => {
            dot.classList.remove('bg-indigo-500', 'w-8');
            dot.classList.add('bg-white/40', 'w-2.5');
        });

        slides[index].classList.remove('opacity-0', 'pointer-events-none', 'z-0');
        slides[index].classList.add('opacity-100', 'z-10');
        dots[index].classList.remove('bg-white/40', 'w-2.5');
        dots[index].classList.add('bg-indigo-500', 'w-8');
        
        currentSlideIndex = index;
        
        if (manual) {
            resetAutoRotate();
        }
    }

    function prevSlide() {
        const slides = document.querySelectorAll('.slide');
        let prev = (currentSlideIndex - 1 + slides.length) % slides.length;
        changeSlide(prev, true);
    }

    function nextSlide() {
        const slides = document.querySelectorAll('.slide');
        let next = (currentSlideIndex + 1) % slides.length;
        changeSlide(next, true);
    }

    // Auto rotate slides
    let autoRotateInterval = setInterval(() => {
        const slides = document.querySelectorAll('.slide');
        if (slides.length > 0) {
            let next = (currentSlideIndex + 1) % slides.length;
            changeSlide(next, false);
        }
    }, 6000);

    function resetAutoRotate() {
        clearInterval(autoRotateInterval);
        autoRotateInterval = setInterval(() => {
            const slides = document.querySelectorAll('.slide');
            if (slides.length > 0) {
                let next = (currentSlideIndex + 1) % slides.length;
                changeSlide(next, false);
            }
        }, 6000);
    }



    // Modal Details Operations
    function openNewsDetail(item) {
        const modal = document.getElementById('news-modal');
        const modalInner = modal.querySelector('.scale-95');

        document.getElementById('modal-title').innerText = item.title;
        document.getElementById('modal-content').innerText = item.content;
        document.getElementById('modal-author').innerText = `<?php echo __('by'); ?>: ${item.author_name || 'ผู้ดูแลระบบ'}`;
        
        const dateObj = new Date(item.created_at);
        document.getElementById('modal-date').innerText = `<?php echo __('oit_updated'); ?>: ${dateObj.toLocaleDateString('th-TH', {year: 'numeric', month: 'long', day: 'numeric'})}`;

        const imgContainer = document.getElementById('modal-image-container');
        const img = document.getElementById('modal-image');
        if (item.image_url) {
            img.src = item.image_url;
            imgContainer.classList.remove('hidden');
        } else {
            imgContainer.classList.add('hidden');
            img.src = '';
        }

        // Toggle PDF attachment button
        const pdfContainer = document.getElementById('modal-pdf-container');
        const pdfLink = document.getElementById('modal-pdf-link');
        if (item.attachment_pdf && item.attachment_pdf.trim() !== '') {
            pdfLink.href = item.attachment_pdf;
            pdfContainer.classList.remove('hidden');
        } else {
            pdfContainer.classList.add('hidden');
            pdfLink.href = '';
        }

        // Toggle Procurement fields
        const procContainer = document.getElementById('modal-procurement-container');
        const docLabel = document.getElementById('modal-doc-number');
        const budgetLabel = document.getElementById('modal-budget');
        if (item.category === 'announcement' && (item.doc_number || item.budget)) {
            procContainer.classList.remove('hidden');
            docLabel.innerText = item.doc_number || 'ไม่ระบุ';
            budgetLabel.innerText = item.budget ? parseFloat(item.budget).toLocaleString('th-TH', { minimumFractionDigits: 2 }) + ' บาท' : 'ไม่ระบุ';
        } else {
            procContainer.classList.add('hidden');
        }

        const tag = document.getElementById('modal-tag');
        tag.innerText = item.category === 'announcement' ? 'ประกาศจัดซื้อจัดจ้าง' : (item.category === 'activity' ? '<?php echo __('activity'); ?>' : (item.category === 'award' ? 'รางวัลและผลงาน' : '<?php echo __('general'); ?>'));
        
        tag.className = "px-2.5 py-1 rounded-md text-[10px] font-semibold border inline-block ";
        if (item.category === 'announcement') {
            tag.classList.add('bg-red-500/10', 'text-red-600', 'dark:text-red-400', 'border-red-500/20');
        } else if (item.category === 'activity') {
            tag.classList.add('bg-emerald-500/10', 'text-emerald-600', 'dark:text-emerald-400', 'border-emerald-500/20');
        } else if (item.category === 'award') {
            tag.classList.add('bg-amber-500/10', 'text-amber-600', 'dark:text-amber-400', 'border-amber-500/20');
        } else {
            tag.classList.add('bg-blue-500/10', 'text-blue-600', 'dark:text-blue-400', 'border-blue-500/20');
        }

        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            modalInner.classList.remove('scale-95');
            modalInner.classList.add('scale-100');
        }, 50);
    }

    function closeNewsModal() {
        const modal = document.getElementById('news-modal');
        const modalInner = modal.querySelector('.scale-100');

        if (modalInner) {
            modalInner.classList.remove('scale-100');
            modalInner.classList.add('scale-95');
        }
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }
</script>
