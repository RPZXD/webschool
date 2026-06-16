<!-- views/frontend/contact.php -->
<!-- Public Contact Us View -->

<?php
$lang = getActiveLang();
?>

<!-- Title Banner Section -->
<section class="relative py-16 bg-slate-100 dark:bg-slate-950 overflow-hidden border-b border-slate-200 dark:border-white/5 transition-colors duration-300">
    <div class="absolute inset-0 bg-cover bg-center opacity-5" style="background-image: url('https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?q=80&w=1200&auto=format&fit=crop');"></div>
    <div class="absolute top-0 right-0 w-80 h-80 bg-indigo-600/5 dark:bg-indigo-600/10 rounded-full blur-[100px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4 relative z-10 animate-fade-in-up">
        <span class="px-3.5 py-1.5 rounded-full bg-indigo-500/10 border border-indigo-500/20 text-indigo-600 dark:text-indigo-300 text-xs font-bold uppercase tracking-wider font-english">
            <?php echo $lang === 'th' ? 'ช่องทางการติดต่อ' : 'Contact Channels'; ?>
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white"><?php echo __('contact_us'); ?></h1>
        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm max-w-xl mx-auto leading-relaxed">
            <?php echo $lang === 'th' ? 'หากคุณมีคำถาม ข้อสงสัย หรือต้องการข้อมูลเพิ่มเติมเกี่ยวกับการจัดการศึกษาสามารถกรอกฟอร์มหรือติดต่อเราตามรายละเอียดด้านล่างนี้' : 'If you have any questions, inquiries, or need more information about our education management, feel free to fill out the form or reach us below.'; ?>
        </p>
    </div>
</section>

<!-- Content Container -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-12">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Contact Cards Grid (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <!-- Card 1: Physical Address -->
            <div class="glass-card p-6 rounded-2xl flex gap-4 hover:scale-[1.01] transition-transform">
                <span class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shrink-0 border border-indigo-500/20 shadow-inner">
                    <i class="fa-solid fa-map-location-dot"></i>
                </span>
                <div class="space-y-1">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-english"><?php echo $lang === 'th' ? 'ที่ตั้งสถานศึกษา' : 'Address'; ?></h3>
                    <p class="text-xs sm:text-sm text-slate-900 dark:text-white font-semibold leading-relaxed">
                        <?php echo ($lang === 'th') ? SCHOOL_ADDRESS_TH : SCHOOL_ADDRESS_EN; ?>
                    </p>
                </div>
            </div>

            <!-- Card 2: Phone & Fax -->
            <div class="glass-card p-6 rounded-2xl flex gap-4 hover:scale-[1.01] transition-transform">
                <span class="w-12 h-12 rounded-xl bg-green-500/10 text-green-600 dark:text-green-400 flex items-center justify-center text-xl shrink-0 border border-green-500/20 shadow-inner">
                    <i class="fa-solid fa-phone-volume"></i>
                </span>
                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-english"><?php echo $lang === 'th' ? 'ติดต่อทางโทรศัพท์' : 'Phone & Fax'; ?></h3>
                    <div class="space-y-1 text-xs sm:text-sm text-slate-900 dark:text-white font-semibold">
                        <p class="flex items-center gap-1.5"><i class="fa-solid fa-phone text-slate-400 dark:text-slate-600"></i> <?php echo SCHOOL_PHONE; ?></p>
                        <?php if (!empty(SCHOOL_FAX)): ?>
                            <p class="flex items-center gap-1.5"><i class="fa-solid fa-fax text-slate-400 dark:text-slate-600"></i> <?php echo SCHOOL_FAX; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Card 3: Email Portal -->
            <div class="glass-card p-6 rounded-2xl flex gap-4 hover:scale-[1.01] transition-transform">
                <span class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl shrink-0 border border-blue-500/20 shadow-inner">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </span>
                <div class="space-y-1">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-english"><?php echo $lang === 'th' ? 'ไปรษณีย์อิเล็กทรอนิกส์' : 'Email Address'; ?></h3>
                    <a href="mailto:<?php echo SCHOOL_EMAIL; ?>" class="text-xs sm:text-sm text-slate-900 dark:text-white font-semibold hover:text-indigo-600 dark:hover:text-indigo-400 hover:underline block truncate">
                        <?php echo SCHOOL_EMAIL; ?>
                    </a>
                </div>
            </div>

            <!-- Card 4: Social Channels Links -->
            <div class="glass-card p-6 rounded-2xl flex gap-4 hover:scale-[1.01] transition-transform">
                <span class="w-12 h-12 rounded-xl bg-pink-500/10 text-pink-600 dark:text-pink-400 flex items-center justify-center text-xl shrink-0 border border-pink-500/20 shadow-inner">
                    <i class="fa-solid fa-share-nodes"></i>
                </span>
                <div class="space-y-3 w-full">
                    <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest font-english"><?php echo $lang === 'th' ? 'ช่องทางโซเชียลมีเดีย' : 'Social Channels'; ?></h3>
                    <div class="flex flex-wrap gap-2.5">
                        <?php if (!empty(SCHOOL_FACEBOOK)): ?>
                            <a href="<?php echo SCHOOL_FACEBOOK; ?>" target="_blank" rel="noopener" class="px-3.5 py-2 bg-blue-600/10 hover:bg-blue-600 hover:text-white text-blue-600 dark:text-blue-400 border border-blue-500/20 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                        <?php endif; ?>
                        
                        <?php if (!empty(SCHOOL_YOUTUBE)): ?>
                            <a href="<?php echo SCHOOL_YOUTUBE; ?>" target="_blank" rel="noopener" class="px-3.5 py-2 bg-red-600/10 hover:bg-red-600 hover:text-white text-red-600 dark:text-red-400 border border-red-500/20 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all">
                                <i class="fab fa-youtube"></i> YouTube
                            </a>
                        <?php endif; ?>

                        <?php if (!empty(SCHOOL_LINE)): ?>
                            <a href="<?php echo SCHOOL_LINE; ?>" target="_blank" rel="noopener" class="px-3.5 py-2 bg-green-600/10 hover:bg-green-600 hover:text-white text-green-600 dark:text-green-400 border border-green-500/20 rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all">
                                <i class="fab fa-line"></i> Line
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Interactive Form Card (7 cols) -->
        <div class="lg:col-span-7">
            <div class="glass-card p-8 rounded-3xl shadow-xl space-y-6">
                <div class="space-y-1">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white"><?php echo $lang === 'th' ? 'ส่งข้อความติดต่อเรา' : 'Send us a Message'; ?></h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs"><?php echo $lang === 'th' ? 'กรุณากรอกข้อมูลในแบบฟอร์ม เจ้าหน้าที่จะดำเนินการตอบกลับทางอีเมลหรือติดต่อกลับตามเบอร์โทรศัพท์โดยเร็วที่สุด' : 'Fill out the form below and we will get back to you as soon as possible.'; ?></p>
                </div>

                <form onsubmit="event.preventDefault(); alert('<?php echo $lang === 'th' ? 'ระบบได้รับข้อความจำลองแล้ว ขอขอบพระคุณสำหรับข้อมูลติดต่อครับ' : 'Mock message received successfully!'; ?>')" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="contact_fullname" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo $lang === 'th' ? 'ชื่อ-นามสกุล' : 'Full Name'; ?></label>
                            <input type="text" id="contact_fullname" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="John Doe">
                        </div>
                        <div class="space-y-1">
                            <label for="contact_email" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo $lang === 'th' ? 'อีเมลผู้ติดต่อ' : 'Email Address'; ?></label>
                            <input type="email" id="contact_email" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="example@mail.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label for="contact_phone" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo $lang === 'th' ? 'เบอร์โทรศัพท์' : 'Phone Number'; ?></label>
                            <input type="text" id="contact_phone" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="089-xxxxxxx">
                        </div>
                        <div class="space-y-1">
                            <label for="contact_subject" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo $lang === 'th' ? 'หัวข้อติดต่อ' : 'Subject'; ?></label>
                            <input type="text" id="contact_subject" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="สอบถามข้อมูลทั่วไป">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="contact_message" class="text-xs font-semibold text-slate-700 dark:text-slate-300"><?php echo $lang === 'th' ? 'รายละเอียดข้อความ' : 'Message Details'; ?></label>
                        <textarea id="contact_message" rows="4" required class="w-full glass-input rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-indigo-500 transition-all" placeholder="กรอกรายละเอียดข้อความ..."></textarea>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane text-xs"></i> <?php echo $lang === 'th' ? 'ส่งข้อความติดต่อ' : 'Send Message'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Google Map Embed Iframe Container -->
    <div class="space-y-4">
        <div class="text-center sm:text-left">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white"><i class="fa-solid fa-map-marked-alt text-indigo-500 mr-1.5"></i> <?php echo $lang === 'th' ? 'แผนที่ตั้งโรงเรียน' : 'School Map Location'; ?></h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs mt-1"><?php echo $lang === 'th' ? 'แสดงที่ตั้งพิกัดจริงของโรงเรียน ผ่านอินเตอร์เฟสแผนที่ปฏิสัมพันธ์' : 'View the real physical coordinates of our school via the interactive map interface.'; ?></p>
        </div>

        <div class="w-full h-[400px] rounded-3xl overflow-hidden shadow-2xl border border-slate-200 dark:border-white/10 relative">
            <?php if (!empty(GOOGLE_MAP_EMBED)): ?>
                <iframe src="<?php echo htmlspecialchars(GOOGLE_MAP_EMBED); ?>" class="w-full h-full border-0 grayscale dark:invert-[90%] dark:hue-rotate-180" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="แผนที่ตั้งโรงเรียนพิชัยบน Google Maps"></iframe>
            <?php else: ?>
                <div class="w-full h-full bg-slate-100 dark:bg-slate-900 flex flex-col items-center justify-center text-center space-y-2">
                    <i class="fa-solid fa-map-pin text-3xl text-slate-400"></i>
                    <p class="text-slate-500 text-xs">ยังไม่ได้เพิ่มลิงก์แผนที่ในระบบการตั้งค่า</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>
