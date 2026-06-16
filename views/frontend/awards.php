<!-- views/frontend/awards.php -->
<!-- Awards & Achievements Archive List Page -->

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative overflow-hidden min-h-[80vh]">
    <!-- Decorative Blurs -->
    <div class="absolute w-[300px] h-[300px] bg-indigo-500/5 dark:bg-indigo-500/10 blur-[90px] rounded-full top-20 left-[-150px] pointer-events-none"></div>
    <div class="absolute w-[300px] h-[300px] bg-purple-500/5 dark:bg-purple-500/10 blur-[90px] rounded-full bottom-20 right-[-150px] pointer-events-none"></div>

    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-6 mb-12 border-b border-slate-200 dark:border-white/5 pb-8 relative z-10">
        <div class="space-y-2 text-center lg:text-left">
            <span class="text-xs font-bold text-amber-500 dark:text-amber-400 uppercase tracking-widest bg-amber-500/10 px-3.5 py-1.5 rounded-full border border-amber-500/20 inline-block">รางวัลและความภาคภูมิใจ</span>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Awards & Achievements</h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs max-w-lg">ผลงานเกียรติบัตรและรางวัลแห่งความสำเร็จของครู นักเรียน และสถานศึกษา</p>
        </div>

        <div class="flex flex-col sm:flex-row flex-wrap items-center gap-3 w-full lg:w-auto">
            <!-- Live Search Input -->
            <div class="relative w-full sm:w-60">
                <input type="text" id="awards-search" oninput="filterAwards()" placeholder="ค้นหารายชื่อ/รางวัล..." class="w-full pl-10 pr-4 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500/30 transition-all shadow-sm" aria-label="ค้นหารายชื่อหรือรางวัล">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500"><i class="fa-solid fa-magnifying-glass text-xs"></i></span>
            </div>

            <!-- Level Select Filter -->
            <div class="relative w-full sm:w-44">
                <select id="awards-level-select" onchange="filterAwards()" class="w-full pl-3.5 pr-8 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 transition-all shadow-sm cursor-pointer appearance-none">
                    <option value="all">ระดับทั้งหมด (All Levels)</option>
                    <option value="6">ระดับนานาชาติ (International)</option>
                    <option value="5">ระดับประเทศ (National)</option>
                    <option value="4">ระดับภาค (Regional)</option>
                    <option value="3">ระดับจังหวัด/เขตพื้นที่ฯ (Provincial/Area)</option>
                    <option value="2">ระดับอำเภอ (District)</option>
                    <option value="1">ระดับโรงเรียน/สถาบัน (School/Local)</option>
                </select>
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 pointer-events-none text-[9px]"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <!-- Type Select Filter -->
            <div class="relative w-full sm:w-44">
                <select id="awards-type-select" onchange="filterAwards()" class="w-full pl-3.5 pr-8 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-white/10 bg-white dark:bg-slate-900 text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 transition-all shadow-sm cursor-pointer appearance-none">
                    <option value="all">ประเภททั้งหมด (All Types)</option>
                    <option value="winner">ชนะเลิศ (Winner / Gold Medal)</option>
                    <option value="runner_up">รองชนะเลิศ (Runners-Up)</option>
                    <option value="other_award">รางวัลชมเชย/รางวัลพิเศษ</option>
                    <option value="certificate">เกียรติบัตรเข้าร่วม/อื่นๆ</option>
                </select>
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 pointer-events-none text-[9px]"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

            <!-- Tabs Filters -->
            <div class="flex gap-1 bg-slate-200/80 dark:bg-slate-900/60 border border-slate-300 dark:border-white/10 p-1.5 rounded-2xl transition-all shadow-inner w-full sm:w-auto overflow-x-auto">
                <button onclick="changeAwardsTab('all')" id="tab-all" class="category-tab px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer text-white bg-indigo-600 shadow-md flex-1 sm:flex-initial text-center whitespace-nowrap" aria-label="แสดงทั้งหมด">ทั้งหมด</button>
                <button onclick="changeAwardsTab('student')" id="tab-student" class="category-tab px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex-1 sm:flex-initial text-center whitespace-nowrap" aria-label="แสดงของนักเรียน">ผลงานนักเรียน</button>
                <button onclick="changeAwardsTab('teacher')" id="tab-teacher" class="category-tab px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white flex-1 sm:flex-initial text-center whitespace-nowrap" aria-label="แสดงครูและบุคลากร">ผลงานครู</button>
            </div>
        </div>
    </div>

    <!-- Awards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative z-10" id="awards-grid-container">
        <?php if (empty($awards)): ?>
            <div class="col-span-full text-center py-20 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/5 rounded-3xl">
                <i class="fa-regular fa-folder-open text-4xl text-slate-400 dark:text-slate-500 mb-4"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">ยังไม่มีบันทึกข้อมูลรางวัลและผลงานเด่นในระบบขณะนี้</p>
            </div>
        <?php else: 
            foreach ($awards as $index => $item): 
                $badgeText = $item['type'] === 'student' ? 'ผลงานนักเรียน' : 'ผลงานครู';
                $badgeClass = $item['type'] === 'student' 
                    ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20' 
                    : 'bg-indigo-600/10 text-indigo-600 dark:text-indigo-400 border-indigo-600/20'; // Indigo-600 is Crimson in config
        ?>
            <div class="award-card glass-card rounded-2xl overflow-hidden flex flex-col h-full hover:border-amber-500/30 transition-all duration-300 hover:-translate-y-1.5 shadow-lg group cursor-pointer relative" 
                 data-type="<?php echo htmlspecialchars($item['type']); ?>"
                 data-level="<?php echo htmlspecialchars($item['level_score']); ?>"
                 data-result-type="<?php echo htmlspecialchars($item['result_type']); ?>"
                 data-title="<?php echo htmlspecialchars(mb_strtolower($item['title'])); ?>"
                 data-content="<?php echo htmlspecialchars(mb_strtolower($item['content'])); ?>"
                 onclick="openLightbox('<?php echo htmlspecialchars($item['image_url'] ? $item['image_url'] : 'https://cktech.phichai.ac.th/'); ?>', '<?php echo htmlspecialchars($item['title']); ?>', '<?php echo htmlspecialchars(str_replace("\n", '\\n', $item['content'])); ?>')">
                
                <!-- Cover Image & Trophy Badge -->
                <div class="h-44 overflow-hidden bg-slate-950 relative">
                    <?php if (!empty($item['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-amber-955/40 to-slate-950 flex items-center justify-center p-4">
                            <span class="text-amber-500/40 text-4xl"><i class="fa-solid fa-trophy"></i></span>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Category Badge -->
                    <span class="absolute top-4 left-4 px-2.5 py-1 rounded-lg border text-[9px] font-bold <?php echo $badgeClass; ?> backdrop-blur-md shadow-sm">
                        <?php echo $badgeText; ?>
                    </span>
                    
                    <!-- Gold Trophy Overlay -->
                    <span class="absolute top-4 right-4 w-7 h-7 rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 text-slate-950 flex items-center justify-center text-xs shadow-md border border-yellow-300">
                        <i class="fa-solid fa-trophy"></i>
                    </span>
                </div>

                <!-- Info Area -->
                <div class="p-5 flex flex-col flex-grow space-y-2">
                    <span class="text-[9px] text-slate-400 dark:text-slate-500 font-english"><i class="fa-regular fa-clock mr-1"></i><?php echo date('d M Y', strtotime($item['date'])); ?></span>
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white leading-snug line-clamp-2 group-hover:text-amber-500 transition-colors">
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

    <!-- Empty State for JS Filter -->
    <div id="no-results" class="hidden text-center py-20 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/5 rounded-3xl mt-6 relative z-10">
        <i class="fa-regular fa-folder-open text-4xl text-slate-400 dark:text-slate-500 mb-4"></i>
        <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold">ไม่พบข้อมูลเกียรติบัตรหรือรางวัลที่ท่านค้นหา</p>
    </div>
</section>

<!-- Lightbox Modal Overlay -->
<div id="lightbox-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300" onclick="closeLightboxOnBackdrop(event)">
    <div class="w-full max-w-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300 relative flex flex-col max-h-[90vh]">
        <!-- Close Button -->
        <button onclick="closeLightbox()" class="absolute top-4 right-4 w-9 h-9 rounded-full bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors z-20 cursor-pointer shadow" aria-label="ปิดกล่องภาพ">
            <i class="fa-solid fa-times text-sm"></i>
        </button>

        <!-- Dynamic Content Body -->
        <div class="overflow-y-auto p-6 flex flex-col md:flex-row gap-6 items-center md:items-start">
            <!-- Certificate Image Container -->
            <div class="w-full md:w-3/5 bg-slate-950 rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 shadow-inner flex justify-center items-center relative group aspect-[4/3] md:aspect-auto md:min-h-[300px]">
                <img id="lightbox-img" src="" alt="เกียรติบัตรรางวัล" class="w-full h-full object-contain max-h-[60vh] bg-slate-950/40">
            </div>

            <!-- Details Block -->
            <div class="w-full md:w-2/5 flex flex-col justify-between h-full space-y-4 pt-2">
                <div class="space-y-3">
                    <span class="text-[9px] font-bold text-amber-500 dark:text-amber-400 uppercase tracking-widest bg-amber-500/10 px-2.5 py-1 rounded border border-amber-500/20 inline-block"><i class="fa-solid fa-award mr-1"></i>เกียรติบัตรผลงานดีเด่น</span>
                    <h2 id="lightbox-title" class="text-base font-bold text-slate-900 dark:text-white leading-snug"></h2>
                    <hr class="border-slate-200 dark:border-white/5">
                    <p id="lightbox-desc" class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed whitespace-pre-wrap"></p>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-white/5 space-y-3">
                    <a id="lightbox-download" href="" target="_blank" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-indigo-500/25 transition-all duration-200">
                        <i class="fa-solid fa-arrow-down-long text-xs"></i>
                        <span>ดาวน์โหลดรูปภาพเกียรติบัตร</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let activeAwardsTab = 'all';

    function changeAwardsTab(tab) {
        activeAwardsTab = tab;
        const tabs = document.querySelectorAll('.category-tab');
        
        // Reset tabs style
        tabs.forEach(t => {
            t.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
            t.classList.add('text-slate-500', 'dark:text-slate-400', 'hover:text-slate-900', 'dark:hover:text-white');
        });
        
        const currentTab = document.getElementById(`tab-${tab}`);
        if (currentTab) {
            currentTab.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
            currentTab.classList.remove('text-slate-500', 'dark:text-slate-400', 'hover:text-slate-900', 'dark:hover:text-white');
        }

        filterAwards();
    }

    function filterAwards() {
        const query = document.getElementById('awards-search').value.trim().toLowerCase();
        const activeLevel = document.getElementById('awards-level-select').value;
        const activeType = document.getElementById('awards-type-select').value;
        
        const cards = document.querySelectorAll('.award-card');
        const noResults = document.getElementById('no-results');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardType = card.dataset.type;
            const cardLevel = card.dataset.level;
            const cardResultType = card.dataset.resultType;
            
            const titleText = card.dataset.title;
            const contentText = card.dataset.content;

            const matchesTab = (activeAwardsTab === 'all' || cardType === activeAwardsTab);
            const matchesLevel = (activeLevel === 'all' || cardLevel === activeLevel);
            const matchesType = (activeType === 'all' || cardResultType === activeType);
            const matchesSearch = (!query || titleText.includes(query) || contentText.includes(query));

            if (matchesTab && matchesLevel && matchesType && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    // Lightbox modal operations
    function openLightbox(imgUrl, title, descText) {
        const modal = document.getElementById('lightbox-modal');
        const img = document.getElementById('lightbox-img');
        const titleEl = document.getElementById('lightbox-title');
        const descEl = document.getElementById('lightbox-desc');
        const downloadEl = document.getElementById('lightbox-download');

        img.src = imgUrl;
        titleEl.textContent = title;
        descEl.textContent = descText;
        downloadEl.href = imgUrl;

        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100', 'pointer-events-auto');
        
        // Scale transition animation trigger
        const panel = modal.querySelector('.transform');
        panel.classList.remove('scale-95');
        panel.classList.add('scale-100');
        
        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const modal = document.getElementById('lightbox-modal');
        modal.classList.remove('opacity-100', 'pointer-events-auto');
        modal.classList.add('opacity-0', 'pointer-events-none');
        
        const panel = modal.querySelector('.transform');
        panel.classList.remove('scale-100');
        panel.classList.add('scale-95');

        // Restore scroll
        document.body.style.overflow = '';
    }

    function closeLightboxOnBackdrop(event) {
        if (event.target === document.getElementById('lightbox-modal')) {
            closeLightbox();
        }
    }
</script>
