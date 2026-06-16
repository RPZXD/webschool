<!-- views/layouts/footer.php -->
<!-- Website Footer & PDPA Consent Manager -->
    </main>

    <footer class="bg-slate-900 dark:bg-darkblue-950 border-t border-slate-900/5 dark:border-white/5 mt-auto relative z-10 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 md:gap-12">
                <!-- Col 1: Brand details -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <?php if (!empty(SCHOOL_LOGO)): ?>
                            <img src="<?php echo UPLOAD_URL . SCHOOL_LOGO; ?>" alt="School Logo" class="w-10 h-10 rounded-xl object-cover border border-slate-700 shadow-md">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-purple-600 flex items-center justify-center border border-indigo-400/20">
                                <span class="text-white font-english font-black text-sm"><?php echo SCHOOL_SHORT_NAME; ?></span>
                            </div>
                        <?php endif; ?>
                        <span class="text-md font-bold text-white tracking-wide"><?php echo SCHOOL_NAME; ?></span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        มุ่งเน้นการพัฒนานักเรียนในด้านวิทยาศาสตร์ นวัตกรรม และเทคโนโลยี ควบคู่คุณธรรม ความโปร่งใส และการสร้างสรรค์สังคมดิจิทัลแห่งอนาคต
                    </p>
                    <div class="flex items-center gap-3 text-slate-400">
                        <?php if (!empty(SCHOOL_FACEBOOK)): ?>
                            <a href="<?php echo SCHOOL_FACEBOOK; ?>" target="_blank" rel="noopener" aria-label="Facebook Account Link" class="hover:text-indigo-400 transition-colors"><i class="fab fa-facebook-f text-lg"></i></a>
                        <?php endif; ?>
                        <?php if (!empty(SCHOOL_YOUTUBE)): ?>
                            <a href="<?php echo SCHOOL_YOUTUBE; ?>" target="_blank" rel="noopener" aria-label="YouTube Channel Link" class="hover:text-red-400 transition-colors"><i class="fab fa-youtube text-lg"></i></a>
                        <?php endif; ?>
                        <?php if (!empty(SCHOOL_LINE)): ?>
                            <a href="<?php echo SCHOOL_LINE; ?>" target="_blank" rel="noopener" aria-label="Line Official Link" class="hover:text-green-400 transition-colors"><i class="fab fa-line text-lg"></i></a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Col 2: Internal Navigation -->
                <div class="space-y-4">
                    <h3 class="text-xs font-semibold text-slate-300 uppercase tracking-widest font-english">เมนูหลัก / Menu</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="<?php echo BASE_URL; ?>" class="hover:text-indigo-400 hover:translate-x-1 inline-block transition-all"><?php echo __('home'); ?></a></li>
                        <li><a href="<?php echo BASE_URL; ?>ita" class="hover:text-indigo-400 hover:translate-x-1 inline-block transition-all"><?php echo __('ita'); ?></a></li>
                        <li><a href="<?php echo BASE_URL; ?>login" class="hover:text-indigo-400 hover:translate-x-1 inline-block transition-all"><?php echo __('admin_panel'); ?></a></li>
                    </ul>
                </div>

                <!-- Col 3: Contact Info -->
                <div class="space-y-4">
                    <h3 class="text-xs font-semibold text-slate-300 uppercase tracking-widest font-english"><?php echo __('contact_us'); ?></h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-map-marker-alt text-indigo-400 mt-0.5 animate-pulse"></i>
                            <span><?php echo (getActiveLang() === 'th') ? SCHOOL_ADDRESS_TH : SCHOOL_ADDRESS_EN; ?></span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-indigo-400"></i>
                            <span><?php echo SCHOOL_PHONE; ?></span>
                        </li>
                        <?php if (!empty(SCHOOL_FAX)): ?>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-fax text-indigo-400"></i>
                            <span><?php echo SCHOOL_FAX; ?></span>
                        </li>
                        <?php endif; ?>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-indigo-400"></i>
                            <span><?php echo SCHOOL_EMAIL; ?></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="mt-12 pt-8 border-t border-slate-800 dark:border-white/5 flex flex-col md:flex-row items-center justify-between gap-4 text-slate-500 text-[10px] sm:text-xs">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SCHOOL_NAME_EN; ?>. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-slate-300"><?php echo __('privacy_policy'); ?></a>
                    <a href="#" class="hover:text-slate-300"><?php echo __('terms_of_use'); ?></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- PDPA Consent Modal/Banner (Glassmorphism layout) -->
    <div id="pdpa-banner" class="hidden fixed bottom-6 left-6 right-6 md:left-auto md:max-w-md bg-white/95 dark:bg-slate-900/80 backdrop-blur-2xl border border-slate-200 dark:border-white/10 p-6 rounded-2xl shadow-2xl z-50 transform translate-y-24 opacity-0 transition-all duration-700 ease-out">
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <div class="p-2.5 bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-xl border border-indigo-500/20">
                    <i class="fa-solid fa-cookie-bite text-xl"></i>
                </div>
                <div class="space-y-1">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white"><?php echo __('pdpa_title'); ?></h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        <?php echo __('pdpa_desc'); ?>
                    </p>
                </div>
            </div>
            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button id="pdpa-reject" class="px-4 py-2 hover:bg-slate-200 dark:hover:bg-white/5 border border-slate-300 dark:border-white/10 hover:border-slate-400 dark:hover:border-white/20 text-slate-600 dark:text-slate-300 text-[11px] font-semibold rounded-xl transition-all duration-200">
                    <?php echo __('pdpa_reject'); ?>
                </button>
                <button id="pdpa-accept" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-[11px] font-semibold rounded-xl shadow-lg transition-all duration-200">
                    <?php echo __('pdpa_accept'); ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Core Script Controls -->
    <script>
        // Mobile drawer UI/UX controller
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (!mobileMenu) return;

            const backdrop = document.getElementById('mobile-menu-backdrop');
            const drawerPanel = mobileMenu.querySelector('.drawer-panel');
            const closeBtn = document.getElementById('mobile-menu-close');

            function openDrawer() {
                mobileMenu.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Force a browser reflow/repaint to ensure transitions animate
                void mobileMenu.offsetHeight;

                if (backdrop) {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                }
                if (drawerPanel) {
                    drawerPanel.classList.remove('translate-x-full');
                    drawerPanel.classList.add('translate-x-0');
                }
            }

            function closeDrawer() {
                if (backdrop) {
                    backdrop.classList.remove('opacity-100');
                    backdrop.classList.add('opacity-0');
                }
                if (drawerPanel) {
                    drawerPanel.classList.remove('translate-x-0');
                    drawerPanel.classList.add('translate-x-full');
                }
                document.body.style.removeProperty('overflow');
                
                // Wait for the transition to finish before hiding the container
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }

            if (menuBtn) {
                menuBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    openDrawer();
                });
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    closeDrawer();
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', (e) => {
                    closeDrawer();
                });
            }
        });

        // PDPA Cookie Consent Manager
        document.addEventListener('DOMContentLoaded', () => {
            const pdpaBanner = document.getElementById('pdpa-banner');
            const acceptBtn = document.getElementById('pdpa-accept');
            const rejectBtn = document.getElementById('pdpa-reject');

            // Helper check cookie function
            function getCookie(name) {
                const value = `; ${document.cookie}`;
                const parts = value.split(`; ${name}=`);
                if (parts.length === 2) return parts.pop().split(';').shift();
                return null;
            }

            // Helper set cookie function
            function setCookie(name, value, days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                const expires = "expires=" + date.toUTCString();
                document.cookie = `${name}=${value}; ${expires}; path=/`;
            }

            // Check if user already consented
            if (!getCookie('pdpa_consent')) {
                // Show banner with slide-up effect
                if (pdpaBanner) {
                    pdpaBanner.classList.remove('hidden');
                    setTimeout(() => {
                        pdpaBanner.classList.remove('translate-y-24', 'opacity-0');
                        pdpaBanner.classList.add('translate-y-0', 'opacity-100');
                    }, 100);
                }
            }

            // Action: Accept All Cookies
            acceptBtn.addEventListener('click', () => {
                setCookie('pdpa_consent', 'accepted', 365);
                closeBanner();
            });

            // Action: Reject
            rejectBtn.addEventListener('click', () => {
                setCookie('pdpa_consent', 'rejected', 30);
                closeBanner();
            });

            function closeBanner() {
                pdpaBanner.classList.remove('translate-y-0', 'opacity-100');
                pdpaBanner.classList.add('translate-y-24', 'opacity-0');
                setTimeout(() => {
                    pdpaBanner.remove();
                }, 700);
            }
        });
    </script>

    <!-- Scroll Reveal Animation Observer -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const revealElements = document.querySelectorAll('.scroll-reveal, .scroll-reveal-left, .scroll-reveal-right, .scroll-reveal-scale');
            if (!revealElements.length) return;

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -40px 0px'
            });

            revealElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
