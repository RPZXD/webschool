<!-- views/frontend/news.php -->
<!-- News & Announcements List Page -->
<?php
$allMergedNews = array_merge($announcements ?? [], $activities ?? [], $generalNews ?? [], $awards ?? [], $procurements ?? []);
usort($allMergedNews, function($a, $b) {
    return strtotime($b['created_at']) - strtotime($a['created_at']);
});

// Capture search parameter
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$hasSearch = ($searchQuery !== '');

if ($hasSearch) {
    $allMergedNews = array_filter($allMergedNews, function($item) use ($searchQuery) {
        $searchQueryLower = mb_strtolower($searchQuery);
        $titleMatch = mb_strpos(mb_strtolower($item['title']), $searchQueryLower) !== false;
        $contentMatch = mb_strpos(mb_strtolower($item['content']), $searchQueryLower) !== false;
        return $titleMatch || $contentMatch;
    });
}

// Detect category filter from GET parameter
$initialFilter = trim($_GET['filter'] ?? 'all');
if (!in_array($initialFilter, ['all', 'general', 'activity', 'announcement', 'award', 'procurement'])) {
    $initialFilter = 'all';
}
?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 transition-colors duration-300 min-h-[80vh]">
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12 border-b border-slate-200 dark:border-white/5 pb-8">
        <div class="space-y-2 text-center md:text-left">
            <span class="text-xs font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-500/10 px-3.5 py-1.5 rounded-full border border-indigo-500/20 inline-block">ข่าวสารและประกาศ</span>
            <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                <?php if ($hasSearch): ?>
                    ผลการค้นหาสำหรับ: "<?php echo htmlspecialchars($searchQuery); ?>"
                <?php else: ?>
                    คลังข่าวสารและประกาศ
                <?php endif; ?>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 text-xs max-w-md">
                <?php if ($hasSearch): ?>
                    พบข่าวสารที่เกี่ยวข้องทั้งหมด <?php echo count($allMergedNews); ?> รายการ 
                    <a href="?" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-bold ml-1.5 hover:underline flex-inline items-center gap-0.5"><i class="fa-solid fa-circle-xmark text-[11px]"></i> ล้างการค้นหา</a>
                <?php else: ?>
                    ติดตามข่าวประชาสัมพันธ์ ภาพกิจกรรม และการจัดซื้อจัดจ้างทั้งหมดของโรงเรียน
                <?php endif; ?>
            </p>
        </div>

        <!-- News Category Filters (tabs UI) -->
        <div class="flex flex-wrap gap-1.5 bg-slate-200/80 dark:bg-slate-900/60 border border-slate-300 dark:border-white/10 p-1.5 rounded-2xl transition-all shadow-inner">
            <button onclick="changeNewsFilter('all')" id="tab-all" class="category-tab px-4.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer">
                <?php echo __('all'); ?>
            </button>
            <button onclick="changeNewsFilter('announcement')" id="tab-announcement" class="category-tab px-4.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer">
                <?php echo __('announcement'); ?>
            </button>
            <button onclick="changeNewsFilter('general')" id="tab-general" class="category-tab px-4.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer">
                <?php echo __('general'); ?>
            </button>
            <button onclick="changeNewsFilter('procurement')" id="tab-procurement" class="category-tab px-4.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer">
                <?php echo __('procurement'); ?>
            </button>
            <button onclick="changeNewsFilter('activity')" id="tab-activity" class="category-tab px-4.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer">
                <?php echo __('activity'); ?>
            </button>
            <button onclick="changeNewsFilter('award')" id="tab-award" class="category-tab px-4.5 py-2.5 rounded-xl text-xs font-bold transition-all duration-300 cursor-pointer">
                รางวัลและผลงาน
            </button>
        </div>
    </div>

    <!-- News Grid Container -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="news-grid-container">
        <?php if (empty($allMergedNews)): ?>
            <div class="col-span-3 text-center py-20 bg-slate-100/50 dark:bg-white/5 border border-slate-200 dark:border-white/5 rounded-3xl">
                <i class="fa-regular fa-folder-open text-4xl text-slate-400 dark:text-slate-500 mb-4"></i>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-semibold"><?php echo __('no_news'); ?></p>
            </div>
        <?php else: 
            foreach ($allMergedNews as $item):
                $catLabel = __('general');
                $catColor = 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
                if ($item['category'] === 'procurement') {
                    $catLabel = __('procurement');
                    $catColor = 'bg-red-500/10 text-red-600 dark:text-red-400 border-red-500/20';
                } elseif ($item['category'] === 'announcement') {
                    $catLabel = __('announcement');
                    $catColor = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-500/20';
                } elseif ($item['category'] === 'activity') {
                    $catLabel = __('activity');
                    $catColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
                } elseif ($item['category'] === 'award') {
                    $catLabel = 'รางวัลและผลงาน';
                    $catColor = 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
                }
        ?>
            <div class="news-archive-card glass-card rounded-3xl overflow-hidden flex flex-col h-full border border-slate-200 dark:border-white/5 hover:border-indigo-500/20 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" data-category="<?php echo $item['category']; ?>">
                <!-- Cover Image -->
                <div class="h-52 overflow-hidden bg-slate-950 relative">
                    <?php if (!empty($item['image_url'])): ?>
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-full object-contain bg-slate-950/60 transition-transform duration-500 hover:scale-105">
                    <?php else: ?>
                        <!-- Standard fallback background gradient -->
                        <div class="w-full h-full bg-gradient-to-br from-indigo-950/60 to-purple-950/60 flex items-center justify-center p-4">
                            <span class="text-slate-600 text-6xl"><i class="fa-solid fa-image"></i></span>
                        </div>
                    <?php endif; ?>
                    <span class="absolute top-4 left-4 px-3 py-1.5 rounded-lg border text-[10px] font-bold <?php echo $catColor; ?> backdrop-blur-md shadow-md">
                        <?php echo $catLabel; ?>
                    </span>

                    <?php if ($item['category'] === 'procurement' && !empty($item['doc_number'])): ?>
                        <span class="absolute bottom-4 right-4 bg-red-600 text-white border border-red-500/30 text-[8px] font-bold px-2 py-1 rounded shadow-md font-english">
                            <?php echo htmlspecialchars($item['doc_number']); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <!-- Text info -->
                <div class="p-6 flex flex-col flex-grow space-y-3.5">
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-english font-medium flex items-center gap-1"><i class="fa-regular fa-clock text-xs"></i><?php echo date('d M Y', strtotime($item['created_at'])); ?></span>
                    
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white leading-snug line-clamp-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        <a href="<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>">
                            <?php echo htmlspecialchars($item['title']); ?>
                        </a>
                    </h3>
                    
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed line-clamp-3">
                        <?php echo htmlspecialchars($item['content']); ?>
                    </p>
                    
                    <div class="pt-4 mt-auto border-t border-slate-900/5 dark:border-white/5 flex items-center justify-between">
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold"><?php echo __('by'); ?>: <?php echo htmlspecialchars($item['author_name'] ?? 'ผู้ดูแลระบบ'); ?></span>
                        <a href="<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>" class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-bold flex items-center gap-1">
                            <?php echo __('read_more'); ?> <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php 
            endforeach;
        endif; 
        ?>
    </div>
</section>

<script>
    // Handle category filter on client side
    function changeNewsFilter(cat) {
        const cards = document.querySelectorAll('.news-archive-card');
        const tabs = document.querySelectorAll('.category-tab');
        
        // Reset tabs style
        tabs.forEach(tab => {
            tab.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
            tab.classList.add('text-slate-500', 'dark:text-slate-400', 'hover:text-slate-900', 'dark:hover:text-white');
        });
        
        const activeTab = document.getElementById(`tab-${cat}`);
        if (activeTab) {
            activeTab.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
            activeTab.classList.remove('text-slate-500', 'dark:text-slate-400', 'hover:text-slate-900', 'dark:hover:text-white');
        }

        // Toggle cards visibility
        let matchCount = 0;
        cards.forEach(card => {
            if (cat === 'all' || card.dataset.category === cat) {
                card.style.display = 'flex';
                matchCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Set URL param silently without reload
        const url = new URL(window.location);
        url.searchParams.set('filter', cat);
        window.history.pushState({}, '', url);
    }

    // Init tab selection on load based on PHP parameter
    document.addEventListener('DOMContentLoaded', () => {
        const initialFilter = '<?php echo $initialFilter; ?>';
        changeNewsFilter(initialFilter);
    });
</script>
