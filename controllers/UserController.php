<?php
// controllers/UserController.php
// Manages authentication flow (login/logout) and admin dashboard authorization

class UserController {
    private $userModel;
    private $newsModel;
    private $itaModel;

    public function __construct() {
        $this->userModel = new User();
        $this->newsModel = new News();
        $this->itaModel = new Ita();
    }

    /**
     * Handles administrator login page display and form submission
     */
    public function login() {
        // If already logged in, redirect straight to admin dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'admin');
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($username) || empty($password)) {
                $error = 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน';
            } else {
                $user = $this->userModel->authenticate($username, $password);
                if ($user) {
                    // Save user credentials in session
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['role'] = $user['role'];

                    header('Location: ' . BASE_URL . 'admin');
                    exit();
                } else {
                    $error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
                }
            }
        }

        $title = "เข้าสู่ระบบหลังบ้าน | " . SCHOOL_NAME;
        require ROOT_PATH . 'views/layouts/header.php';
        
        // Render login page
        ?>
        <section class="min-h-[80vh] flex items-center justify-center px-4 py-16 relative overflow-hidden transition-colors duration-300">
            <!-- Decorative Blurred Circles -->
            <div class="absolute w-[300px] h-[300px] bg-purple-600/5 dark:bg-purple-600/10 blur-[80px] rounded-full top-1/4 left-10"></div>
            <div class="absolute w-[400px] h-[400px] bg-blue-600/5 dark:bg-blue-600/10 blur-[100px] rounded-full bottom-1/4 right-10"></div>

            <div class="max-w-md w-full glass-card p-8 rounded-3xl shadow-2xl relative z-10 transition-all duration-300">
                <div class="text-center space-y-2 mb-8">
                    <span class="inline-flex items-center justify-center p-3 bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-2xl border border-indigo-500/20 dark:border-indigo-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <h2 class="text-2xl font-bold tracking-tight mt-3 text-slate-900 dark:text-white">เข้าสู่ระบบแอดมิน</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs font-semibold">สำหรับครูและบุคลากรในการจัดการเนื้อหาเว็บและ ITA</p>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="mb-5 p-4 bg-red-500/10 dark:bg-red-900/30 border border-red-500/20 dark:border-red-500/30 rounded-xl text-red-600 dark:text-red-300 text-xs flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span><?php echo htmlspecialchars($error); ?></span>
                    </div>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>login" method="POST" class="space-y-5">
                    <div class="space-y-1">
                        <label for="username" class="text-xs font-semibold text-slate-700 dark:text-slate-300">ชื่อผู้ใช้งาน</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </span>
                            <input id="username" name="username" type="text" required class="w-full glass-input rounded-xl pl-10 pr-4 py-3 text-xs placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-300" placeholder="Username">
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="password" class="text-xs font-semibold text-slate-700 dark:text-slate-300">รหัสผ่าน</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-slate-400 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input id="password" name="password" type="password" required class="w-full glass-input rounded-xl pl-10 pr-4 py-3 text-xs placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all duration-300" placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white font-semibold text-xs rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 flex items-center justify-center gap-2">
                        <span>เข้าสู่ระบบ</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="<?php echo BASE_URL; ?>" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline transition-colors">← กลับหน้าเว็บไซต์หลัก</a>
                </div>
            </div>
        </section>
        <?php

        require ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Terminate current administrative session
     */
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: ' . BASE_URL . 'login');
        exit();
    }

    /**
     * Guards and renders admin panel dashboard with summaries and lists
     */
    public function dashboard() {
        // Auth Guard
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . 'login');
            exit();
        }

        // Fetch news and ITA progress metrics
        $allNews = $this->newsModel->getAll();
        $itaItems = $this->itaModel->getAll();
        $itaMetrics = $this->itaModel->getMetrics();
        
        $heroModel = new Hero();
        $allHeroes = $heroModel->getAll();

        $landingModel = new LandingSlide();
        $allLandingSlides = $landingModel->getAll();

        $urgentModel = new UrgentNews();
        $allTickers = $urgentModel->getAll();

        $aboutModel = new About();
        $aboutSections = $aboutModel->getAllSections();

        // Load specific dashboard view
        require ROOT_PATH . 'views/admin/dashboard.php';
    }
}
