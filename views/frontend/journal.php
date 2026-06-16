<?php
/**
 * Journal List View - วารสารโรงเรียน
 */

// Helper: format date to Thai Buddhist era
function journal_thai_date($dateStr) {
    if (empty($dateStr)) return '-';
    $months = ['', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'];
    $time = strtotime($dateStr);
    if ($time === false) return '-';
    $day = date('j', $time);
    $month = $months[(int)date('n', $time)];
    $year = date('Y', $time) + 543;
    return "{$day} {$month} {$year}";
}

// Helper: get first image from images JSON
function journal_get_first_image($imagesData) {
    if (empty($imagesData)) return null;
    $decoded = json_decode($imagesData, true);
    if (is_array($decoded) && !empty($decoded)) {
        return $decoded[0];
    }
    return null;
}

$totalJournals = count($journals);
?>

<section class="relative overflow-hidden py-16 md:py-20 bg-gradient-to-br from-amber-600 via-orange-500 to-red-500">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-32 -left-32 w-64 h-64 bg-yellow-300/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-12 left-[10%] text-white/10 text-6xl animate-bounce">📰</div>
    </div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-10">
            <div class="flex-shrink-0">
                <div class="relative w-28 h-28 md:w-36 md:h-36 flex items-center justify-center bg-white/20 backdrop-blur-lg rounded-full border border-white/30 shadow-2xl">
                    <span class="text-5xl md:text-6xl">📰</span>
                </div>
            </div>
            <div class="text-center md:text-left text-white">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-sm text-sm font-medium mb-4">
                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    ข้อมูลจากระบบบริหารงานทั่วไป
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-3 drop-shadow-lg">
                    <?php echo __('school_journal'); ?>
                </h1>
                <p class="text-lg md:text-xl text-white/80 max-w-xl">
                    ติดตามข่าวสาร กิจกรรม และความเคลื่อนไหวล่าสุดของโรงเรียน
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Cards -->
<section class="max-w-6xl mx-auto px-4 -mt-8 relative z-20 mb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-2xl p-4 border border-white/50 shadow-lg border-l-4 border-l-amber-500">
            <p class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white"><?php echo number_format($stats['total']); ?></p>
            <p class="text-xs text-gray-500">ข่าวทั้งหมด</p>
        </div>
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-2xl p-4 border border-white/50 shadow-lg border-l-4 border-l-emerald-500">
            <p class="text-xl md:text-2xl font-bold text-emerald-600"><?php echo number_format($stats['this_month']); ?></p>
            <p class="text-xs text-gray-500">เดือนนี้</p>
        </div>
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-2xl p-4 border border-white/50 shadow-lg border-l-4 border-l-purple-500">
            <p class="text-xl md:text-2xl font-bold text-purple-600"><?php echo number_format($stats['total_views']); ?></p>
            <p class="text-xs text-gray-500">ยอดอ่านรวม</p>
        </div>
        <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-2xl p-4 border border-white/50 shadow-lg border-l-4 border-l-blue-500">
            <p class="text-xl md:text-2xl font-bold text-blue-600"><?php echo number_format($stats['this_year']); ?></p>
            <p class="text-xs text-gray-500">ปีนี้</p>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-4 mb-12">
    <div class="bg-white/70 dark:bg-slate-800/70 backdrop-blur-xl rounded-2xl border border-white/50 shadow-lg overflow-hidden">
        <div class="p-5 md:p-6">
            <?php if (empty($journals)): ?>
                <div class="text-center py-16">
                    <p class="text-gray-500 text-lg">ยังไม่มีวารสารในขณะนี้</p>
                </div>
            <?php else: ?>
                <div id="journalGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 md:gap-6">
                    <?php 
                    $colors = ['from-cyan-500 to-blue-500', 'from-purple-500 to-pink-500', 'from-emerald-500 to-teal-500', 'from-amber-500 to-orange-500'];

                    foreach ($journals as $idx => $j): 
                        $imgFile = journal_get_first_image($j['images'] ?? null);
                        $imageUrl = null;
                        $date = journal_thai_date($j['news_date'] ?? $j['created_at'] ?? null);
                        $views = (int)($j['view_count'] ?? 0);
                        $colorClass = $colors[$idx % count($colors)];
                        $searchTitle = htmlspecialchars($j['title'] ?? '', ENT_QUOTES);

                        if (!empty($imgFile)) {
                            if (strpos($imgFile, 'http') === 0) {
                                $imageUrl = $imgFile;
                            } else {
                                // ล้างชื่อโฟลเดอร์ซ้ำซ้อน
                                $fileName = str_replace(['uploads/newsletter/', 'uploads/newsletters/'], '', $imgFile);
                                $fileName = ltrim($fileName, '/');
                                
                                $base = rtrim(GENERAL_ASSETS_URL, '/');
                                $imageUrl = $base . '/uploads/newsletter/' . $fileName;
                            }
                        }
                    ?>
                    <a href="<?php echo BASE_URL; ?>journal/detail?id=<?php echo $j['id']; ?>" 
                       class="journal-card group glass-card rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all h-full flex flex-col"
                       data-title="<?php echo strtolower($searchTitle); ?>"
                       data-date="<?php echo $j['news_date'] ?? $j['created_at'] ?? ''; ?>"
                       data-views="<?php echo $views; ?>">
                        
                        <div class="aspect-[4/3] bg-gray-100 dark:bg-slate-800 overflow-hidden relative">
                            <?php if ($imageUrl): ?>
                                <img src="<?php echo htmlspecialchars($imageUrl); ?>" 
                                     alt="<?php echo $searchTitle; ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="<?php echo $idx < 4 ? 'eager' : 'lazy'; ?>"
                                     decoding="async"
                                     fetchpriority="<?php echo $idx < 4 ? 'high' : 'low'; ?>"
                                     onerror="this.onerror=null; this.src=''; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center bg-gradient-to-br <?php echo $colorClass; ?>\'><span class=\'text-5xl\'>📰</span></div>'">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br <?php echo $colorClass; ?>">
                                    <span class="text-5xl">📰</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute top-3 right-3 px-2.5 py-1 bg-black/50 backdrop-blur text-white text-xs rounded-full">
                                <i class="far fa-eye"></i> <?php echo number_format($views); ?>
                            </div>
                        </div>

                        <div class="p-4 flex-grow flex flex-col justify-between">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 min-h-[3rem] text-sm md:text-base">
                                <?php echo htmlspecialchars($j['title'] ?? 'ไม่มีชื่อ'); ?>
                            </h3>
                            <div class="flex items-center justify-between text-sm mt-auto">
                                <span class="text-gray-500 dark:text-gray-400 text-xs">
                                    <i class="far fa-calendar-alt"></i> <?php echo $date; ?>
                                </span>
                                <span class="text-amber-600 font-medium text-xs">อ่านต่อ →</span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>