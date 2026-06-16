<!-- views/frontend/news_detail.php -->
<!-- News Detail Page for Reading Full Content -->
<?php
$catLabel = __('general');
$catColor = 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
if ($newsItem['category'] === 'procurement') {
    $catLabel = __('procurement');
    $catColor = 'bg-red-500/10 text-red-600 dark:text-red-400 border-red-500/20';
} elseif ($newsItem['category'] === 'announcement') {
    $catLabel = __('announcement');
    $catColor = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-500/20';
} elseif ($newsItem['category'] === 'activity') {
    $catLabel = __('activity');
    $catColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
} elseif ($newsItem['category'] === 'award') {
    $catLabel = 'รางวัลและผลงาน';
    $catColor = 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
}
?>

<section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 transition-colors duration-300">
    <!-- Back to News List link -->
    <div class="mb-6">
        <a href="<?php echo BASE_URL; ?>news" class="inline-flex items-center gap-1.5 text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-bold transition-all">
            <i class="fa-solid fa-arrow-left"></i> ย้อนกลับไปหน้าคลังข่าวสาร
        </a>
    </div>

    <!-- Article Header -->
    <div class="space-y-4 mb-8">
        <span class="px-3.5 py-1.5 rounded-full border text-xs font-bold <?php echo $catColor; ?> inline-block">
            <?php echo $catLabel; ?>
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
            <?php echo htmlspecialchars($newsItem['title']); ?>
        </h1>

        <!-- Publication Meta Info -->
        <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-white/5 pb-4">
            <span class="flex items-center gap-1.5 font-english"><i class="fa-regular fa-clock text-sm"></i><?php echo date('d M Y H:i', strtotime($newsItem['created_at'])); ?> น.</span>
            <span class="text-slate-300 dark:text-slate-700">|</span>
            <span><i class="fa-regular fa-user text-sm mr-1.5"></i><?php echo __('by'); ?>: <?php echo htmlspecialchars($newsItem['author_name'] ?? 'ผู้ดูแลระบบ'); ?></span>
        </div>
    </div>

    <!-- Image Area -->
    <?php if (!empty($newsItem['image_url'])): ?>
        <div class="w-full max-h-[500px] rounded-3xl overflow-hidden bg-slate-950 border border-slate-200 dark:border-white/10 shadow-2xl mb-8 flex justify-center items-center">
            <img src="<?php echo htmlspecialchars($newsItem['image_url']); ?>" alt="<?php echo htmlspecialchars($newsItem['title']); ?>" class="w-full h-full max-h-[500px] object-contain bg-slate-950/60">
        </div>
    <?php endif; ?>

    <!-- Procurement Special Block -->
    <?php if ($newsItem['category'] === 'procurement' && (!empty($newsItem['doc_number']) || !empty($newsItem['budget']))): ?>
        <div class="glass-card p-6 rounded-3xl border border-red-500/20 shadow-lg mb-8 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-red-500/80"></div>
            <h3 class="text-sm font-bold text-red-600 dark:text-red-400 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar"></i> รายละเอียดประกาศจัดซื้อจัดจ้าง
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="space-y-1 bg-slate-100/50 dark:bg-slate-950/30 p-3 rounded-xl border border-slate-200/50 dark:border-white/5">
                    <span class="text-slate-500">เลขที่เอกสารประกาศ:</span>
                    <p class="font-bold text-slate-800 dark:text-white font-english"><?php echo htmlspecialchars($newsItem['doc_number'] ?: 'ไม่ระบุ'); ?></p>
                </div>
                <div class="space-y-1 bg-slate-100/50 dark:bg-slate-950/30 p-3 rounded-xl border border-slate-200/50 dark:border-white/5">
                    <span class="text-slate-500">งบประมาณโครงการ:</span>
                    <p class="font-bold text-slate-800 dark:text-white font-english"><?php echo $newsItem['budget'] ? number_format($newsItem['budget'], 2) . ' บาท' : 'ไม่ระบุงบประมาณ'; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Content text -->
    <div class="prose prose-slate dark:prose-invert max-w-none text-sm text-slate-700 dark:text-slate-300 leading-relaxed space-y-6 whitespace-pre-wrap">
        <?php echo htmlspecialchars($newsItem['content']); ?>
    </div>

    <!-- PDF Attachment section -->
    <?php if (!empty($newsItem['attachment_pdf'])): ?>
        <div class="mt-10 p-6 rounded-3xl bg-slate-100/55 dark:bg-slate-950/30 border border-slate-200 dark:border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="w-12 h-12 rounded-2xl bg-red-500/10 text-red-600 dark:text-red-400 border border-red-500/20 flex items-center justify-center text-xl shrink-0"><i class="fa-regular fa-file-pdf"></i></span>
                <div class="space-y-0.5">
                    <h4 class="text-xs font-bold text-slate-800 dark:text-white">ไฟล์เอกสารแนบประกอบประกาศ</h4>
                    <p class="text-[10px] text-slate-500">ดาวน์โหลดเพื่ออ่านประกาศหรือดูรายละเอียดเพิ่มเติม</p>
                </div>
            </div>
            <a href="<?php echo htmlspecialchars($newsItem['attachment_pdf']); ?>" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-3 bg-red-600 hover:bg-red-700 active:scale-95 text-white rounded-xl text-xs font-bold shadow-md hover:shadow-red-500/20 transition-all duration-200 cursor-pointer">
                <i class="fa-regular fa-file-pdf"></i> เปิดเอกสารแนบ PDF
            </a>
        </div>
    <?php endif; ?>

    <hr class="my-12 border-slate-200 dark:border-white/5">

    <!-- Related News showcase -->
    <?php if (!empty($relatedNews)): ?>
        <div class="space-y-6">
            <h3 class="text-md font-bold text-slate-900 dark:text-white flex items-center gap-2"><i class="fa-solid fa-layer-group text-indigo-500"></i> ข่าวสารที่เกี่ยวข้อง</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <?php foreach ($relatedNews as $item): ?>
                    <div class="glass-card rounded-2xl overflow-hidden flex flex-col h-full hover:border-indigo-500/20 hover:shadow-lg transition-all duration-300">
                        <div class="h-32 overflow-hidden bg-slate-950 relative shrink-0">
                            <?php if (!empty($item['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-tr from-indigo-950/60 to-purple-950/60 flex items-center justify-center"><i class="fa-solid fa-image text-slate-600 text-3xl"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 flex flex-col flex-grow space-y-2">
                            <span class="text-[9px] text-slate-500 dark:text-slate-400 font-english"><i class="fa-regular fa-clock mr-1"></i><?php echo date('d M Y', strtotime($item['created_at'])); ?></span>
                            <h4 class="text-xs font-bold text-slate-900 dark:text-white leading-snug line-clamp-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <a href="<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </a>
                            </h4>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
