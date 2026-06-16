<?php
// public/index.php
// Central Entry Point & Front Controller for PHP MVC

// Start session management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load Localization & Helper
require_once dirname(__DIR__) . '/includes/lang_helper.php';

// Load Core Infrastructure configs
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/database.php';

// Autoload Controllers and Models automatically
spl_autoload_register(function ($class) {
    $controllerPath = ROOT_PATH . 'controllers/' . $class . '.php';
    $modelPath = ROOT_PATH . 'models/' . $class . '.php';

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    } elseif (file_exists($modelPath)) {
        require_once $modelPath;
    }
});

// Load Dynamic Settings Loader
require_once dirname(__DIR__) . '/config/settings_loader.php';

// Load active scrolling tickers globally
$activeTickers = [];
try {
    $urgentModel = new UrgentNews();
    $activeTickers = $urgentModel->getAll(true);
} catch (Exception $e) {
    error_log("Failed to load active scrolling tickers: " . $e->getMessage());
}

// Parse requested URI and resolve path
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path'] ?? '/';

// Get the base path from BASE_URL (e.g., '/main_web/')
$basePath = parse_url(BASE_URL, PHP_URL_PATH) ?? '/';
if (substr($basePath, -1) !== '/') {
    $basePath .= '/';
}

// Compute the clean MVC Route
$route = '/';
if (strpos($path, $basePath) === 0) {
    $route = '/' . substr($path, strlen($basePath));
} else {
    $route = $path;
}
$route = '/' . trim($route, '/');

// Strip 'public/' from the route for backward compatibility
if (strpos($route, '/public/') === 0) {
    $route = '/' . substr($route, 8);
} elseif ($route === '/public') {
    $route = '/';
}
$route = '/' . trim($route, '/');

// Central Routing Table Mapping Path to [Controller, Method]
$routes = [
    '/' => ['NewsController', 'index'],
    '/news' => ['NewsController', 'archive'],
    '/news/detail' => ['NewsController', 'detail'],
    '/search' => ['SearchController', 'index'],
    '/journal' => ['JournalController', 'index'],
    '/journal/detail' => ['JournalController', 'detail'],
    '/about' => ['AboutController', 'index'],
    '/info' => ['InfoController', 'index'],
    '/schoolboard' => ['AboutController', 'schoolboard'],
    '/tammanoon' => ['AboutController', 'tammanoon'],
    '/contact' => ['AboutController', 'contact'],
    '/ita' => ['ItaController', 'index'],
    '/student-schedule' => ['ScheduleController', 'student'],
    '/teacher-schedule' => ['ScheduleController', 'teacher'],
    '/student-handbook' => ['RulesController', 'studentHandbook'],
    '/student-support-handbook' => ['RulesController', 'studentSupportHandbook'],
    '/discipline-rules' => ['RulesController', 'disciplineRules'],
    '/dress-rules' => ['RulesController', 'dressRules'],
    '/campus' => ['RulesController', 'campus'],
    '/student-list' => ['StudentController', 'index'],
    '/student-list/ajax' => ['StudentController', 'ajaxGetStudents'],
    '/school-staff' => ['StaffController', 'index'],
    '/attendance-stats' => ['AttendanceController', 'index'],
    '/feedback' => ['FeedbackController', 'index'],
    '/complaints' => ['ComplaintsController', 'index'],
    '/no-gift' => ['PolicyController', 'noGift'],
    '/dos-donts' => ['PolicyController', 'dosDonts'],
    '/login' => ['UserController', 'login'],
    '/logout' => ['UserController', 'logout'],
    '/admin' => ['UserController', 'dashboard'],
    '/admin/news/create' => ['NewsController', 'create'],
    '/admin/news/edit' => ['NewsController', 'edit'],
    '/admin/news/delete' => ['NewsController', 'delete'],
    '/admin/ita/update' => ['ItaController', 'update'],
    '/admin/ita/upload' => ['ItaController', 'upload'],
    '/admin/ita/delete' => ['ItaController', 'delete'],
    '/admin/about/update' => ['AboutController', 'update'],
    '/admin/statistics/update' => ['InfoController', 'update'],
    '/admin/settings' => ['AdminSettingController', 'index'],
    '/admin/settings/update' => ['AdminSettingController', 'update'],
    '/admin/settings/schedules' => ['AdminSettingController', 'updateSchedules'],
    '/admin/settings/feedback' => ['AdminSettingController', 'updateFeedback'],
    '/admin/settings/complaints' => ['AdminSettingController', 'updateComplaints'],
    '/admin/documents/upload' => ['AdminSettingController', 'uploadDocument'],
    '/admin/hero/create' => ['HeroController', 'create'],
    '/admin/hero/edit' => ['HeroController', 'edit'],
    '/admin/hero/delete' => ['HeroController', 'delete'],
    '/admin/hero/toggle' => ['HeroController', 'toggleStatus'],
    '/admin/hero/reorder' => ['HeroController', 'reorder'],
    '/admin/ticker/create' => ['UrgentNewsController', 'create'],
    '/admin/ticker/edit' => ['UrgentNewsController', 'edit'],
    '/admin/ticker/delete' => ['UrgentNewsController', 'delete'],
    '/admin/ticker/toggle' => ['UrgentNewsController', 'toggleStatus'],
];

// Check if route exists, execute route or throw 404
if (array_key_exists($route, $routes)) {
    list($controllerName, $action) = $routes[$route];
    if (class_exists($controllerName)) {
        $controllerInstance = new $controllerName();
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            handle404("Action '$action' not found in controller '$controllerName'.");
        }
    } else {
        handle404("Controller class '$controllerName' not found.");
    }
} else {
    handle404("Route '$route' not defined.");
}

/**
 * Renders a fallback 404 view
 */
function handle404($debugMsg = '') {
    header("HTTP/1.0 404 Not Found");
    
    // Page Title
    $title = "ไม่พบหน้าเว็บ | " . SCHOOL_NAME;
    
    // Include Layout Header
    require ROOT_PATH . 'views/layouts/header.php';
    ?>
    <section class="min-h-[70vh] flex items-center justify-center px-4 py-16 bg-gradient-to-tr from-slate-900 via-slate-800 to-indigo-950 text-white">
        <div class="max-w-md w-full text-center space-y-6 bg-white/10 backdrop-blur-md p-8 rounded-2xl border border-white/20 shadow-2xl">
            <h1 class="text-7xl font-extrabold bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">404</h1>
            <div class="space-y-2">
                <h2 class="text-2xl font-bold">ไม่พบหน้าเว็บที่คุณเรียกหา</h2>
                <p class="text-slate-300 text-sm leading-relaxed">ลิงก์ที่เข้าใช้อาจไม่ถูกต้อง มีการเปลี่ยนเส้นทาง หรือไฟล์นั้นถูกลบออกไปจากเซิร์ฟเวอร์แล้ว</p>
            </div>
            <div>
                <a href="<?php echo BASE_URL; ?>" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    กลับไปยังหน้าหลัก
                </a>
            </div>
            <?php if (!empty($debugMsg) && (defined('DEVELOPMENT') && DEVELOPMENT === true)): ?>
                <div class="text-left mt-6 bg-red-900/30 border border-red-500/30 p-3 rounded-lg text-xs font-mono text-red-300">
                    <strong>Debug:</strong> <?php echo htmlspecialchars($debugMsg); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    // Include Layout Footer
    require ROOT_PATH . 'views/layouts/footer.php';
    exit();
}
