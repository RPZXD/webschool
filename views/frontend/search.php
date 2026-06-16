<!-- views/frontend/search.php -->
<!-- Site-wide search results view -->

<!-- Hero Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5 transition-opacity" style="background-image: url('https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-600/5 dark:bg-purple-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider font-english">
            Search Engine
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white leading-tight">
            ผลการค้นหาเว็บไซต์
        </h1>
        
        <!-- Search bar inside results page -->
        <div class="max-w-xl mx-auto mt-4">
            <form action="<?php echo BASE_URL; ?>search" method="GET" class="relative">
                <input type="text" name="search" value="<?php echo htmlspecialchars($query); ?>" placeholder="ค้นหาข้อมูล หรือพิมพ์ตัวชี้วัด เช่น O1, คู่มือ..." class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-white/10 rounded-2xl pl-12 pr-28 py-3.5 text-sm text-slate-800 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-xl transition-all">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-lg"></i>
                </span>
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-xs font-bold shadow-md hover:shadow-indigo-500/20 active:scale-95 transition-all cursor-pointer">
                    ค้นหาใหม่
                </button>
            </form>
        </div>

        <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold">
            <?php if ($query !== ''): ?>
                พบข้อมูลที่เกี่ยวข้องทั้งหมด <span class="text-indigo-600 dark:text-indigo-400 font-bold"><?php echo $totalResults; ?></span> รายการสำหรับคำหลัก: "<?php echo htmlspecialchars($query); ?>"
            <?php else: ?>
                กรุณากรอกคำค้นหาด้านบนเพื่อค้นหาข้อมูลภายในเว็บไซต์
            <?php endif; ?>
        </p>
    </div>
</section>

<!-- Content Sections Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-grow">
    <?php if ($query === ''): ?>
        <!-- Initial empty state -->
        <div class="max-w-2xl mx-auto bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-xl">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-500">
                <i class="fa-solid fa-search text-3xl animate-pulse"></i>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-bold text-slate-850 dark:text-white">กรุณาระบุคำค้นหา</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed max-w-sm mx-auto">
                    พิมพ์ข้อความข่าวสาร ประกาศจัดซื้อจัดจ้าง รหัสตัวชี้วัด ITA (เช่น O1, O15) รายชื่ออาจารย์ หรือชื่องานเอกสารคู่มือต่างๆ
                </p>
            </div>
        </div>
    <?php elseif ($totalResults === 0): ?>
        <!-- No results state -->
        <div class="max-w-2xl mx-auto bg-white/80 dark:bg-slate-900/50 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center space-y-6 shadow-xl">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
            </div>
            <div class="space-y-2">
                <h3 class="text-lg font-bold text-slate-850 dark:text-white">ไม่พบผลลัพธ์การค้นหา</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed max-w-sm mx-auto">
                    ขออภัย ไม่พบเนื้อหาที่ตรงกับ "<span class="font-bold text-slate-700 dark:text-slate-300"><?php echo htmlspecialchars($query); ?></span>" กรุณาตรวจสอบการสะกดคำ หรือเปลี่ยนไปใช้คำหลักอื่น
                </p>
            </div>
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800/50">
                <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider mb-3">คำค้นหาแนะนำ</p>
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <a href="?search=จัดซื้อจัดจ้าง" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-semibold transition-all">#จัดซื้อจัดจ้าง</a>
                    <a href="?search=คู่มือนักเรียน" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-semibold transition-all">#คู่มือนักเรียน</a>
                    <a href="?search=No Gift" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-semibold transition-all">#No Gift Policy</a>
                    <a href="?search=ตารางเรียน" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-semibold transition-all">#ตารางเรียน</a>
                    <a href="?search=O1" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-indigo-600 hover:text-white rounded-xl text-[10px] font-semibold transition-all">#O1 โครงสร้าง</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="space-y-12">
            
            <!-- Category Tabs Menu -->
            <div class="flex flex-wrap gap-2 justify-center border-b border-slate-200 dark:border-slate-850 pb-6">
                <button onclick="filterResults('all')" id="btn-all" class="search-tab px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/10 cursor-pointer transition-all">
                    ผลลัพธ์ทั้งหมด (<?php echo $totalResults; ?>)
                </button>
                <?php if (count($results['news']) > 0): ?>
                    <button onclick="filterResults('news')" id="btn-news" class="search-tab px-4 py-2 bg-slate-100 dark:bg-slate-900/60 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer transition-all">
                        ข่าวสาร & กิจกรรม (<?php echo count($results['news']); ?>)
                    </button>
                <?php endif; ?>
                <?php if (count($results['pages']) > 0): ?>
                    <button onclick="filterResults('pages')" id="btn-pages" class="search-tab px-4 py-2 bg-slate-100 dark:bg-slate-900/60 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer transition-all">
                        หน้าเว็บ & คู่มือ (<?php echo count($results['pages']); ?>)
                    </button>
                <?php endif; ?>
                <?php if (count($results['ita']) > 0): ?>
                    <button onclick="filterResults('ita')" id="btn-ita" class="search-tab px-4 py-2 bg-slate-100 dark:bg-slate-900/60 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer transition-all">
                        ตัวชี้วัด ITA Online (<?php echo count($results['ita']); ?>)
                    </button>
                <?php endif; ?>
                <?php if (count($results['staff']) > 0): ?>
                    <button onclick="filterResults('staff')" id="btn-staff" class="search-tab px-4 py-2 bg-slate-100 dark:bg-slate-900/60 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer transition-all">
                        บุคลากร & ครู (<?php echo count($results['staff']); ?>)
                    </button>
                <?php endif; ?>
                <?php if (count($results['journal']) > 0): ?>
                    <button onclick="filterResults('journal')" id="btn-journal" class="search-tab px-4 py-2 bg-slate-100 dark:bg-slate-900/60 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer transition-all">
                        วารสารโรงเรียน (<?php echo count($results['journal']); ?>)
                    </button>
                <?php endif; ?>
            </div>

            <!-- Group 1: News results -->
            <?php if (count($results['news']) > 0): ?>
                <div class="search-section space-y-6" id="section-news">
                    <h2 class="text-md font-bold text-slate-850 dark:text-white flex items-center gap-2 border-l-4 border-indigo-600 pl-3">
                        <i class="fa-regular fa-newspaper text-indigo-500"></i>
                        <span>ข่าวประชาสัมพันธ์และประกาศ (<?php echo count($results['news']); ?> รายการ)</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($results['news'] as $item): 
                            $catLabel = 'ประชาสัมพันธ์';
                            $catColor = 'bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-500/20';
                            if ($item['category'] === 'procurement') {
                                $catLabel = 'จัดซื้อจัดจ้าง';
                                $catColor = 'bg-red-500/10 text-red-600 dark:text-red-400 border-red-500/20';
                            } elseif ($item['category'] === 'announcement') {
                                $catLabel = 'ประกาศ';
                                $catColor = 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-500/20';
                            } elseif ($item['category'] === 'activity') {
                                $catLabel = 'ภาพข่าวกิจกรรม';
                                $catColor = 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border-emerald-500/20';
                            } elseif ($item['category'] === 'award') {
                                $catLabel = 'ผลงานและรางวัล';
                                $catColor = 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20';
                            }
                        ?>
                            <div class="glass-card rounded-2xl border border-slate-200 dark:border-white/5 p-5 flex gap-4 hover:shadow-xl hover:border-indigo-500/20 transition-all duration-300">
                                <?php if (!empty($item['image_url'])): ?>
                                    <div class="w-20 h-20 rounded-xl bg-slate-900 overflow-hidden shrink-0 shadow-inner">
                                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="cover" class="w-full h-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="w-20 h-20 rounded-xl bg-gradient-to-tr from-slate-900 to-indigo-950 flex items-center justify-center shrink-0 text-slate-500 border border-slate-800 shadow-inner">
                                        <i class="fa-solid fa-image text-xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="space-y-1.5 min-w-0">
                                    <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase border <?php echo $catColor; ?>"><?php echo $catLabel; ?></span>
                                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate">
                                        <a href="<?php echo BASE_URL; ?>news/detail?id=<?php echo $item['id']; ?>" class="hover:text-indigo-500 dark:hover:text-indigo-400">
                                            <?php echo htmlspecialchars($item['title']); ?>
                                        </a>
                                    </h3>
                                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-400 line-clamp-2">
                                        <?php echo htmlspecialchars(strip_tags($item['content'])); ?>
                                    </p>
                                    <div class="text-[9px] text-slate-400 dark:text-slate-500 font-english">
                                        โพสต์เมื่อ: <?php echo date('d/m/Y', strtotime($item['created_at'])); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Group 1.5: Journal results -->
            <?php if (count($results['journal']) > 0): ?>
                <div class="search-section space-y-6" id="section-journal">
                    <h2 class="text-md font-bold text-slate-850 dark:text-white flex items-center gap-2 border-l-4 border-amber-500 pl-3">
                        <i class="fa-solid fa-newspaper text-amber-500"></i>
                        <span>วารสารโรงเรียน (<?php echo count($results['journal']); ?> รายการ)</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($results['journal'] as $jItem): 
                            $jImg = null;
                            if (!empty($jItem['images'])) {
                                $decoded = json_decode($jItem['images'], true);
                                if (is_array($decoded) && !empty($decoded)) $jImg = $decoded[0];
                            }
                            $jDate = !empty($jItem['news_date']) ? date('d/m/Y', strtotime($jItem['news_date'])) : '-';
                            $jViews = (int)($jItem['view_count'] ?? 0);
                        ?>
                            <a href="<?php echo BASE_URL; ?>journal/detail?id=<?php echo $jItem['id']; ?>" class="glass-card rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden hover:shadow-xl hover:border-amber-500/20 hover:-translate-y-0.5 transition-all duration-300 block">
                                <div class="aspect-[16/9] bg-gray-100 dark:bg-slate-800 overflow-hidden relative">
                                    <?php if ($jImg): ?>
                                        <img src="<?php echo htmlspecialchars($jImg); ?>" alt="cover" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden absolute inset-0 bg-gradient-to-br from-amber-500 to-orange-500 items-center justify-center">
                                            <span class="text-4xl">📰</span>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-500">
                                            <span class="text-4xl">📰</span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute top-2 right-2 px-2 py-0.5 bg-black/50 backdrop-blur text-white text-[10px] rounded-full flex items-center gap-1">
                                        <i class="far fa-eye"></i> <?php echo number_format($jViews); ?>
                                    </div>
                                </div>
                                <div class="p-4 space-y-1.5">
                                    <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase border bg-amber-500/10 text-amber-600 dark:text-amber-400 border-amber-500/20">วารสาร</span>
                                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white line-clamp-2">
                                        <?php echo htmlspecialchars($jItem['title'] ?? 'ไม่มีชื่อ'); ?>
                                    </h3>
                                    <div class="text-[9px] text-slate-400 dark:text-slate-500 font-english flex items-center gap-1">
                                        <i class="far fa-calendar-alt"></i> <?php echo $jDate; ?>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Group 2: Pages results -->
            <?php if (count($results['pages']) > 0): ?>
                <div class="search-section space-y-6" id="section-pages">
                    <h2 class="text-md font-bold text-slate-850 dark:text-white flex items-center gap-2 border-l-4 border-amber-500 pl-3">
                        <i class="fa-solid fa-file-lines text-amber-500"></i>
                        <span>หน้าข้อมูลและคู่มือทางการ (<?php echo count($results['pages']); ?> รายการ)</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($results['pages'] as $page): ?>
                            <a href="<?php echo $page['url']; ?>" class="glass-card rounded-2xl border border-slate-200 dark:border-white/5 p-5 block space-y-3 hover:shadow-xl hover:border-amber-500/20 hover:-translate-y-0.5 transition-all duration-300">
                                <div class="flex justify-between items-start">
                                    <span class="px-2.5 py-1 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 text-[9px] font-bold"><?php echo htmlspecialchars($page['category']); ?></span>
                                    <i class="fa-solid fa-external-link text-[10px] text-slate-400"></i>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white hover:text-amber-500 transition-colors"><?php echo htmlspecialchars($page['title']); ?></h3>
                                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-450 leading-relaxed"><?php echo htmlspecialchars($page['desc']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Group 3: ITA results -->
            <?php if (count($results['ita']) > 0): ?>
                <div class="search-section space-y-6" id="section-ita">
                    <h2 class="text-md font-bold text-slate-850 dark:text-white flex items-center gap-2 border-l-4 border-emerald-500 pl-3">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i>
                        <span>ตัวชี้วัดความโปร่งใส ITA Online (<?php echo count($results['ita']); ?> รายการ)</span>
                    </h2>
                    <div class="glass-card rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden shadow-xl">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-100 dark:bg-slate-950/60 border-b border-slate-200 dark:border-white/10 text-[10px] font-bold text-slate-650 dark:text-slate-350 uppercase tracking-wider">
                                        <th class="py-4 px-6 text-center w-24">รหัส OIT</th>
                                        <th class="py-4 px-6">ชื่อตัวชี้วัด / ข้อมูลเผยแพร่</th>
                                        <th class="py-4 px-6 text-center w-52">ช่องทางดาวน์โหลด</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-xs text-slate-600 dark:text-slate-300">
                                    <?php foreach ($results['ita'] as $item): ?>
                                        <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                            <td class="py-3 px-6 text-center font-english font-bold text-indigo-500 dark:text-indigo-400">
                                                <span class="bg-indigo-500/10 px-2 py-1 rounded border border-indigo-500/20 text-[10px]">
                                                    <?php echo htmlspecialchars($item['code']); ?>
                                                </span>
                                            </td>
                                            <td class="py-3 px-6 font-bold text-slate-900 dark:text-white">
                                                <?php echo htmlspecialchars($item['name']); ?>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex justify-center gap-1.5">
                                                    <?php if (!empty($item['file_path'])): ?>
                                                        <a href="<?php echo htmlspecialchars($item['file_path']); ?>" target="_blank" rel="noopener" class="px-2.5 py-1.5 bg-rose-600/10 hover:bg-rose-600/20 text-rose-600 dark:text-rose-400 border border-rose-500/20 rounded-lg text-[9px] font-bold transition-all"><i class="fa-regular fa-file-pdf mr-1"></i>PDF</a>
                                                    <?php endif; ?>
                                                    <?php if (!empty($item['link_url'])): ?>
                                                        <a href="<?php echo htmlspecialchars($item['link_url']); ?>" target="_blank" rel="noopener" class="px-2.5 py-1.5 bg-indigo-600/10 hover:bg-indigo-600/20 text-indigo-600 dark:text-indigo-400 border border-indigo-500/20 rounded-lg text-[9px] font-bold transition-all"><i class="fa-solid fa-link mr-1"></i>ดูลิงก์</a>
                                                    <?php endif; ?>
                                                    <a href="<?php echo BASE_URL; ?>ita?search=<?php echo $item['code']; ?>" class="px-2.5 py-1.5 bg-slate-100 dark:bg-slate-800/80 hover:bg-slate-200 text-slate-700 dark:text-slate-300 rounded-lg text-[9px] font-bold transition-all"><i class="fa-solid fa-table mr-1"></i>ดูในตาราง</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Group 4: Staff results -->
            <?php if (count($results['staff']) > 0): ?>
                <div class="search-section space-y-6" id="section-staff">
                    <h2 class="text-md font-bold text-slate-850 dark:text-white flex items-center gap-2 border-l-4 border-purple-500 pl-3">
                        <i class="fa-solid fa-chalkboard-user text-purple-500"></i>
                        <span>ทำเนียบคณาจารย์และบุคลากร (<?php echo count($results['staff']); ?> รายการ)</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <?php foreach ($results['staff'] as $t): 
                            $name = trim($t['Teach_name']);
                            $major = trim($t['Teach_major'] ?? 'ไม่ได้ระบุ');
                            $position = trim($t['Teach_Position2'] ?? 'ครูผู้สอน');
                            $academic = trim($t['Teach_Academic'] ?? '');
                            $photo = trim($t['Teach_photo'] ?? '');
                            $sex = $t['Teach_sex'] ?? '1'; // '1' male, '2' female

                            // Get short name/initial for fallback avatar
                            $words = explode(' ', $name);
                            $cleanName = str_replace(['นาย', 'นางสาว', 'นาง', 'ดร.'], '', $words[0]);
                            $initial = mb_substr($cleanName, 0, 1);
                            
                            $fallbackGradient = ($sex == '2') 
                                ? 'from-rose-500 to-orange-500' 
                                : 'from-blue-600 to-indigo-700';
                        ?>
                            <div class="glass-card rounded-3xl border border-slate-200 dark:border-white/5 p-6 text-center space-y-4 hover:shadow-xl hover:border-purple-500/20 transition-all duration-300">
                                <!-- Profile Photo with Failover -->
                                <div class="relative w-24 h-24 mx-auto rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-800 bg-slate-900 flex items-center justify-center">
                                    <?php if (!empty($photo)): ?>
                                        <img src="https://std.phichai.ac.th/photo/teacher/<?php echo htmlspecialchars($photo); ?>" alt="ครู" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden absolute inset-0 bg-gradient-to-tr <?php echo $fallbackGradient; ?> text-white font-bold text-3xl items-center justify-center">
                                            <?php echo $initial; ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="absolute inset-0 bg-gradient-to-tr <?php echo $fallbackGradient; ?> text-white font-bold text-3xl flex items-center justify-center">
                                            <?php echo $initial; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white truncate" title="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></h3>
                                    <p class="text-[10px] text-indigo-600 dark:text-indigo-400 font-bold"><?php echo htmlspecialchars($position); ?><?php echo !empty($academic) ? ' ('.$academic.')' : ''; ?></p>
                                    <p class="text-[9px] text-slate-400 dark:text-slate-500 truncate" title="สาขา/ฝ่าย: <?php echo htmlspecialchars($major); ?>">วิชาเอก: <?php echo htmlspecialchars($major); ?></p>
                                </div>
                                <div class="pt-2 border-t border-slate-100 dark:border-slate-850">
                                    <a href="<?php echo BASE_URL; ?>school-staff" class="inline-flex items-center text-[9px] font-bold text-purple-600 dark:text-purple-400 hover:underline">
                                        <i class="fa-solid fa-address-book mr-1"></i>ดูทำเนียบบุคลากร
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>
</section>

<!-- Filter Script -->
<script>
    function filterResults(category) {
        const sections = document.querySelectorAll('.search-section');
        const tabs = document.querySelectorAll('.search-tab');

        // Reset tabs style
        tabs.forEach(tab => {
            tab.className = "search-tab px-4 py-2 bg-slate-100 dark:bg-slate-900/60 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 cursor-pointer transition-all";
        });

        // Set active tab style
        const activeTab = document.getElementById(`btn-${category}`);
        if (activeTab) {
            activeTab.className = "search-tab px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-md shadow-indigo-500/10 cursor-pointer transition-all";
        }

        // Show/hide sections
        sections.forEach(section => {
            if (category === 'all' || section.id === `section-${category}`) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    }
</script>
