<!-- views/frontend/student_list.php -->
<!-- Public Student List Card Profiles & Printable Checksheet View -->

<!-- Beautiful Styled Excel Export library -->
<script src="https://cdn.jsdelivr.net/npm/xlsx-js-style@1.2.0/dist/xlsx.min.js"></script>

<style>
    /* Roster Table Styles for Printing */
    .print-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
        color: #000000 !important;
    }

    .print-table th, .print-table td {
        border: 1px solid #000000 !important;
        padding: 4px 6px;
        font-size: 12px;
        text-align: center;
        vertical-align: middle;
        color: #000000 !important;
    }

    .print-table th {
        font-weight: 700;
        background-color: #f1f5f9 !important;
    }

    .print-table td.text-left {
        text-align: left;
    }

    /* Column Width Classes */
    .th-no { width: 8%; }
    .th-id { width: 14%; }
    .th-name { width: 35%; }
    .th-blank { width: auto; }

    /* Signatures Section */
    .doc-signatures {
        margin-top: auto;
        padding-top: 30px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
        page-break-inside: avoid;
    }

    .sig-block {
        text-align: center;
        font-size: 0.85rem;
        line-height: 1.8;
        color: #000000 !important;
    }

    /* Headings & Document Header */
    .doc-header {
        text-align: center;
        margin-bottom: 12px;
        line-height: 1.4;
        color: #000000 !important;
    }

    .doc-title {
        font-size: 1.15rem;
        font-weight: 800;
        margin: 0;
        color: #000000 !important;
    }

    .doc-subrow {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.95rem;
        margin-top: 6px;
        padding: 0 4px;
        color: #000000 !important;
    }

    .doc-advisors {
        text-align: left;
        font-size: 0.9rem;
        margin-top: 4px;
        padding-left: 4px;
        color: #000000 !important;
    }

    /* Empty/Welcome screens */
    .no-data {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 80px 20px;
        text-align: center;
        color: #64748b;
        border: 2px dashed #cbd5e1;
        border-radius: 24px;
        margin: auto;
        max-width: 600px;
    }

    .no-data i {
        font-size: 3.5rem;
        color: #6366f1;
        margin-bottom: 20px;
    }

    .no-data h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        color: #1e293b;
    }

    .dark .no-data {
        border-color: #334155;
    }
    .dark .no-data h3 {
        color: #cbd5e1;
    }

    /* Print area layout is completely hidden on screen */
    #printArea {
        display: none;
    }

    /* Print Styles Overrides */
    @media print {
        /* Hide navbar, footer, accessibility controls, screen controls/panels */
        header, 
        footer, 
        #pdpa-banner, 
        .no-print,
        .accessibility-toolbar,
        div.bg-white\/95,
        div.flex.items-center.gap-4.justify-between,
        .student-list-wrapper {
            display: none !important;
        }

        /* Setup full height page filling */
        html, body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            background: white !important;
            color: black !important;
        }

        /* Display print area */
        #printArea {
            display: flex !important;
            flex-direction: column !important;
            height: 100% !important;
            width: 100% !important;
            box-sizing: border-box !important;
            background: white !important;
            color: black !important;
        }

        .doc-header {
            flex-shrink: 0 !important;
            margin-bottom: 6px !important;
        }

        .print-table {
            flex-grow: 1 !important;
            height: 1% !important; /* Force flex-grow table behavior */
            border-collapse: collapse !important;
            width: 100% !important;
        }

        .print-table tr {
            height: auto !important; /* Distribute row height automatically */
        }

        .print-table th {
            background-color: transparent !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .doc-signatures {
            flex-shrink: 0 !important;
            margin-top: 15px !important;
            padding-top: 10px !important;
        }
    }
</style>

<!-- Dynamic print layout orientation rules -->
<style id="printOrientationStyle"></style>

<!-- MAIN CONTAINER ON SCREEN -->
<div class="student-list-wrapper w-full min-h-screen bg-slate-50 dark:bg-slate-900/30 py-8 px-4 sm:px-6 lg:px-8 transition-colors duration-300">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <!-- TOP CONTROL CARD: FILTERS, ACTIONS & SETTINGS -->
        <div class="no-print bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-white/10 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 transition-all duration-300">
            
            <!-- Logo & Heading -->
            <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800/80">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600/10 dark:bg-indigo-600/20 border border-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <i class="fas fa-print text-xl"></i>
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-black text-slate-800 dark:text-white tracking-wide">รายชื่อนักเรียนโรงเรียนพิชัย</h1>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 font-english leading-none mt-1.5">Interactive Student Directory & Checksheet Print System</p>
                </div>
            </div>

            <!-- CLASS FILTERS TABS -->
            <div class="space-y-2">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-indigo-500"></i> เลือกระดับชั้นเรียน
                </label>
                <div id="classButtonsContainer" class="flex flex-wrap gap-2 pt-1">
                    <!-- Class buttons will populate here -->
                </div>
            </div>

            <!-- ROOM FILTERS TABS (Dynamically shown) -->
            <div id="roomButtonsWrapper" class="space-y-2 hidden border-t border-slate-100 dark:border-slate-800/60 pt-4">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                    <i class="fa-solid fa-door-open text-indigo-500"></i> เลือกห้องเรียน
                </label>
                <div id="roomButtonsContainer" class="flex flex-wrap gap-2 pt-1">
                    <!-- Room buttons will populate here -->
                </div>
            </div>

            <!-- ACTION BUTTONS ROW -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-slate-100 dark:border-slate-800/60 pt-6">
                <!-- Status Info -->
                <div id="filterStatusInfo" class="text-xs font-semibold text-slate-500 dark:text-slate-400 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-slate-400"></i>
                    <span>กรุณาเลือกระดับชั้นและห้องเรียนด้านบนเพื่อเริ่มตรวจสอบข้อมูล</span>
                </div>

                <!-- Print Options and Export actions -->
                <div class="flex items-center flex-wrap gap-2.5 sm:ml-auto">
                    <button id="btnToggleSettings" onclick="toggleSettingsPanel()" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl border border-slate-200 dark:border-white/10 transition-all cursor-pointer opacity-50 cursor-not-allowed" disabled>
                        <i id="settingsToggleIcon" class="fas fa-cog transition-transform duration-300"></i>
                        <span>ตั้งค่าการพิมพ์</span>
                    </button>
                    
                    <button id="btnActionPrint" onclick="window.print()" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-indigo-500/20 transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer opacity-50 cursor-not-allowed" disabled>
                        <i class="fas fa-print"></i>
                        <span>พิมพ์รายชื่อ (Checksheet)</span>
                    </button>
                    
                    <button id="btnActionExcel" onclick="exportToExcel()" class="flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-lg hover:shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-0.5 cursor-pointer opacity-50 cursor-not-allowed" disabled>
                        <i class="fas fa-file-excel"></i>
                        <span>ส่งออก Excel</span>
                    </button>
                </div>
            </div>

            <!-- COLLAPSIBLE PRINT SETTINGS PANEL -->
            <div id="settingsPanel" class="hidden bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-inner transition-all duration-300">
                <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-indigo-500"></i> การกำหนดค่าตารางตรวจสอบสำหรับการพิมพ์
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <!-- Column 1: Document details -->
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label for="customTitle" class="text-[10px] font-bold text-slate-500 dark:text-slate-400">หัวข้อหัวกระดาษ</label>
                            <input type="text" id="customTitle" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all" value="รายชื่อนักเรียนระดับชั้นมัธยมศึกษาปีที่">
                        </div>

                        <div class="space-y-1">
                            <label for="learningPlan" class="text-[10px] font-bold text-slate-500 dark:text-slate-400">แผนการเรียน / ห้องเรียน</label>
                            <input type="text" id="learningPlan" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="เช่น วิทย์ - คณิต, ESC, ทั่วไป">
                        </div>
                    </div>

                    <!-- Column 2: Advisor & school configs -->
                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label for="advisorNames" class="text-[10px] font-bold text-slate-500 dark:text-slate-400">ครูที่ปรึกษา (แก้ไขได้)</label>
                            <input type="text" id="advisorNames" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all" placeholder="ครูที่ปรึกษา 1, ครูที่ปรึกษา 2">
                        </div>

                        <div class="space-y-1">
                            <label for="schoolYear" class="text-[10px] font-bold text-slate-500 dark:text-slate-400">ปีการศึกษา</label>
                            <input type="text" id="schoolYear" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all" value="<?php echo htmlspecialchars($defaultPee); ?>">
                        </div>
                    </div>

                    <!-- Column 3: Paper layout orientations -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="space-y-1">
                                <label for="pageOrientation" class="text-[10px] font-bold text-slate-500 dark:text-slate-400">แนวตั้ง / แนวนอน</label>
                                <select id="pageOrientation" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                    <option value="portrait">แนวตั้ง (A4 Portrait)</option>
                                    <option value="landscape">แนวนอน (A4 Landscape)</option>
                                </select>
                            </div>
                            
                            <div class="space-y-1">
                                <label for="pageMargin" class="text-[10px] font-bold text-slate-500 dark:text-slate-400">ระยะขอบ</label>
                                <select id="pageMargin" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-white focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                                    <option value="5mm">แคบ (5 มม.)</option>
                                    <option value="8mm" selected>มาตรฐาน (8 มม.)</option>
                                    <option value="10mm">กว้าง (10 มม.)</option>
                                    <option value="15mm">กว้างพิเศษ (15 มม.)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Checkboxes switches options -->
                        <div class="space-y-2 pt-1">
                            <label class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300 cursor-pointer select-none">
                                <input type="checkbox" id="showAdvisorsHeader" class="w-4 h-4 rounded border-slate-200 dark:border-slate-800 text-indigo-600 focus:ring-indigo-500 accent-indigo-600" checked>
                                <span>แสดงที่ปรึกษาด้านบนตารางพิมพ์</span>
                            </label>
                            <label class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300 cursor-pointer select-none">
                                <input type="checkbox" id="showAdvisorsFooter" class="w-4 h-4 rounded border-slate-200 dark:border-slate-800 text-indigo-600 focus:ring-indigo-500 accent-indigo-600">
                                <span>แสดงที่ปรึกษาด้านล่างกระดาษ</span>
                            </label>
                            <label class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-300 cursor-pointer select-none">
                                <input type="checkbox" id="showSupervisorFooter" class="w-4 h-4 rounded border-slate-200 dark:border-slate-800 text-indigo-600 focus:ring-indigo-500 accent-indigo-600">
                                <span>แสดงส่วนลงชื่อหัวหน้าระดับ</span>
                            </label>
                        </div>
                    </div>

                    <!-- Column 4: Sizing range values (Full row on small screens) -->
                    <div class="lg:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-slate-200 dark:border-slate-800/80 pt-4">
                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                <span>จำนวนช่องเช็คชื่อตาราง</span>
                                <span id="blankColsVal" class="text-indigo-600 dark:text-indigo-400 font-bold">12 ช่อง</span>
                            </div>
                            <input type="range" id="blankColsRange" min="1" max="20" value="12" class="w-full accent-indigo-600 bg-slate-200 dark:bg-slate-800 rounded-lg cursor-pointer">
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                <span>ขนาดตัวอักษรบนกระดาษ</span>
                                <span id="fontSizeVal" class="text-indigo-600 dark:text-indigo-400 font-bold">10px</span>
                            </div>
                            <input type="range" id="fontSizeRange" min="10" max="22" value="10" class="w-full accent-indigo-600 bg-slate-200 dark:bg-slate-800 rounded-lg cursor-pointer">
                        </div>

                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                <span>ความสูงแถวตารางพิมพ์</span>
                                <span id="rowHeightVal" class="text-indigo-600 dark:text-indigo-400 font-bold">20px</span>
                            </div>
                            <input type="range" id="rowHeightRange" min="20" max="55" value="20" class="w-full accent-indigo-600 bg-slate-200 dark:bg-slate-800 rounded-lg cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MAIN INTERACTIVE RENDER AREA (Profile Cards Grid) -->
        <div id="paperContent" class="transition-all duration-300">
            <!-- Dynamic welcome banner displays before user filters database -->
            <div class="no-data" id="emptyDisplay">
                <i class="fas fa-info-circle"></i>
                <h3>กรุณาเลือก ระดับชั้น และ ห้องเรียน</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mt-2 max-w-sm">
                    เลือกเมนูกรองด้านบนเพื่อเปิดดูรายชื่อประวัตินักเรียนและครูที่ปรึกษาประจำห้อง พร้อมสั่งพิมพ์รายชื่อในรูปแบบตารางตรวจสอบ
                </p>
            </div>
        </div>
    </div>
</div>

<!-- PRINT ONLY CONTAINER (Clean A4 checksheet table) -->
<div id="printArea" class="hidden">
    <!-- Checksheet Table contents rendered here dynamically -->
</div>

<!-- CLIENT SCRIPT LOGIC -->
<script>
    // Config values parsed from PHP MVC
    const classesData = <?php echo json_encode($classesData); ?>;
    let loadedStudents = [];
    let loadedAdvisors = [];
    let selectedClass = '';
    let selectedRoom = '';

    // DOM selectors
    const customTitle = document.getElementById('customTitle');
    const learningPlan = document.getElementById('learningPlan');
    const advisorNames = document.getElementById('advisorNames');
    const schoolYear = document.getElementById('schoolYear');
    const pageOrientation = document.getElementById('pageOrientation');
    const pageMargin = document.getElementById('pageMargin');
    
    // Sliders
    const blankColsRange = document.getElementById('blankColsRange');
    const fontSizeRange = document.getElementById('fontSizeRange');
    const rowHeightRange = document.getElementById('rowHeightRange');
    
    // Value labels
    const blankColsVal = document.getElementById('blankColsVal');
    const fontSizeVal = document.getElementById('fontSizeVal');
    const rowHeightVal = document.getElementById('rowHeightVal');

    // Display configuration checkboxes
    const showAdvisorsHeader = document.getElementById('showAdvisorsHeader');
    const showAdvisorsFooter = document.getElementById('showAdvisorsFooter');
    const showSupervisorFooter = document.getElementById('showSupervisorFooter');

    // Render Targets
    const paperContent = document.getElementById('paperContent');
    const printArea = document.getElementById('printArea');
    const printOrientationStyle = document.getElementById('printOrientationStyle');

    // Action buttons
    const btnToggleSettings = document.getElementById('btnToggleSettings');
    const btnActionPrint = document.getElementById('btnActionPrint');
    const btnActionExcel = document.getElementById('btnActionExcel');
    const filterStatusInfo = document.getElementById('filterStatusInfo');

    // Render horizontal Class button filters
    function renderClassButtons() {
        const classContainer = document.getElementById('classButtonsContainer');
        classContainer.innerHTML = '';
        
        const sortedClasses = Object.keys(classesData).sort((a, b) => parseInt(a) - parseInt(b));
        sortedClasses.forEach(c => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `px-5 py-2.5 text-xs font-bold rounded-xl transition-all border duration-300 cursor-pointer hover:scale-[1.03] ${
                selectedClass === c 
                ? 'bg-indigo-600 text-white border-indigo-600 shadow-lg shadow-indigo-500/20' 
                : 'bg-white dark:bg-slate-950/40 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900'
            }`;
            btn.textContent = `มัธยมศึกษาปีที่ ${c}`;
            btn.addEventListener('click', () => {
                selectedClass = c;
                selectedRoom = ''; // Reset room on class change
                renderClassButtons();
                renderRoomButtons();
                clearPaper();
                updateActionButtonsState();
            });
            classContainer.appendChild(btn);
        });
    }

    // Render horizontal Room button filters
    function renderRoomButtons() {
        const roomWrapper = document.getElementById('roomButtonsWrapper');
        const roomContainer = document.getElementById('roomButtonsContainer');
        roomContainer.innerHTML = '';
        
        if (!selectedClass || !classesData[selectedClass]) {
            roomWrapper.classList.add('hidden');
            return;
        }
        
        roomWrapper.classList.remove('hidden');
        const rooms = classesData[selectedClass].sort((a, b) => parseInt(a) - parseInt(b));
        rooms.forEach(r => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `px-4 py-2 text-xs font-bold rounded-xl transition-all border duration-300 cursor-pointer hover:scale-[1.03] ${
                selectedRoom === r 
                ? 'bg-indigo-600 text-white border-indigo-600 shadow-lg shadow-indigo-500/20' 
                : 'bg-white dark:bg-slate-950/40 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900'
            }`;
            btn.textContent = `ห้อง ${r}`;
            btn.addEventListener('click', () => {
                selectedRoom = r;
                renderRoomButtons();
                fetchStudents();
            });
            roomContainer.appendChild(btn);
        });
    }

    // Reset layout view
    function clearPaper() {
        loadedStudents = [];
        loadedAdvisors = [];
        paperContent.innerHTML = `
            <div class="no-data" id="emptyDisplay">
                <i class="fas fa-info-circle"></i>
                <h3>กรุณาเลือก ห้องเรียน</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mt-2 max-w-sm">
                    เลือกระดับห้องเรียนของ ชั้น ม.${selectedClass} เพื่อเปิดดูการ์ดโปรไฟล์และตารางรายงานเช็คชื่อ
                </p>
            </div>
        `;
        printArea.innerHTML = '';
        updateActionButtonsState();
    }

    // Toggle print settings panel
    function toggleSettingsPanel() {
        const panel = document.getElementById('settingsPanel');
        const icon = document.getElementById('settingsToggleIcon');
        
        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            icon.classList.add('rotate-45');
        } else {
            panel.classList.add('hidden');
            icon.classList.remove('rotate-45');
        }
    }

    // Enable/disable action controls based on roster data state
    function updateActionButtonsState() {
        const hasData = loadedStudents.length > 0;
        
        if (hasData) {
            btnToggleSettings.disabled = false;
            btnToggleSettings.classList.remove('opacity-50', 'cursor-not-allowed');
            
            btnActionPrint.disabled = false;
            btnActionPrint.classList.remove('opacity-50', 'cursor-not-allowed');
            
            btnActionExcel.disabled = false;
            btnActionExcel.classList.remove('opacity-50', 'cursor-not-allowed');
            
            filterStatusInfo.innerHTML = `
                <span class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                    <i class="fa-solid fa-circle-check"></i> ดึงข้อมูลสำเร็จ: ม.${selectedClass}/${selectedRoom} (${loadedStudents.length} คน)
                </span>
            `;
        } else {
            btnToggleSettings.disabled = true;
            btnToggleSettings.classList.add('opacity-50', 'cursor-not-allowed');
            
            btnActionPrint.disabled = true;
            btnActionPrint.classList.add('opacity-50', 'cursor-not-allowed');
            
            btnActionExcel.disabled = true;
            btnActionExcel.classList.add('opacity-50', 'cursor-not-allowed');
            
            if (selectedClass) {
                filterStatusInfo.innerHTML = `
                    <span class="flex items-center gap-1.5 text-indigo-500">
                        <i class="fa-solid fa-spinner fa-spin"></i> กำลังรอเลือกห้องเรียนของชั้น ม.${selectedClass}
                    </span>
                `;
            } else {
                filterStatusInfo.innerHTML = `
                    <span class="flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info"></i> กรุณาเลือกระดับชั้นเรียนด้านบน
                    </span>
                `;
            }
        }
    }

    // Fetch students roster via AJAX
    function fetchStudents() {
        if (!selectedClass || !selectedRoom) {
            clearPaper();
            return;
        }

        // Show fetching spinner
        paperContent.innerHTML = `
            <div class="no-data animate-pulse">
                <i class="fas fa-spinner fa-spin text-indigo-600 dark:text-indigo-400"></i>
                <h3>กำลังดึงข้อมูลระบบ...</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-2">กำลังเชื่อมโยงข้อมูลนักเรียน ห้อง ม.${selectedClass}/${selectedRoom} จากคลังสารสนเทศ</p>
            </div>
        `;

        fetch(`<?php echo BASE_URL; ?>student-list/ajax?class=${selectedClass}&room=${selectedRoom}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadedStudents = data.students;
                    loadedAdvisors = data.advisors;
                    
                    // Retrieve settings cached in localStorage
                    const localPlanKey = `plan_${selectedClass}_${selectedRoom}`;
                    const localAdvisorsKey = `adv_${selectedClass}_${selectedRoom}`;
                    
                    if (localStorage.getItem(localPlanKey)) {
                        learningPlan.value = localStorage.getItem(localPlanKey);
                    } else {
                        learningPlan.value = "แผนการเรียนทั่วไป";
                    }
                    
                    if (localStorage.getItem(localAdvisorsKey)) {
                        advisorNames.value = localStorage.getItem(localAdvisorsKey);
                    } else {
                        if (loadedAdvisors.length > 0) {
                            advisorNames.value = loadedAdvisors.map((adv, i) => `${i+1}.${adv.Teach_name}`).join(' ');
                        } else {
                            advisorNames.value = '';
                        }
                    }

                    schoolYear.value = data.year;
                    
                    updateActionButtonsState();
                    renderPaper();
                } else {
                    paperContent.innerHTML = `
                        <div class="no-data" style="border-color: #ef4444;">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                            <h3 class="text-red-500">การนำเข้าล้มเหลว</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-2">${data.message}</p>
                        </div>
                    `;
                    updateActionButtonsState();
                }
            })
            .catch(err => {
                console.error(err);
                paperContent.innerHTML = `
                    <div class="no-data" style="border-color: #ef4444;">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                        <h3 class="text-red-500">เกิดข้อผิดพลาดในการเชื่อมต่อ</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-2">กรุณาตรวจสอบการเชื่อมต่อฐานข้อมูลหรือติดต่อผู้ดูแลระบบ</p>
                    </div>
                `;
                updateActionButtonsState();
            });
    }

    // Local storage caching for learning plans and homeroom advisors
    learningPlan.addEventListener('input', function() {
        if (selectedClass && selectedRoom) {
            localStorage.setItem(`plan_${selectedClass}_${selectedRoom}`, this.value);
        }
        renderPaper();
    });

    advisorNames.addEventListener('input', function() {
        if (selectedClass && selectedRoom) {
            localStorage.setItem(`adv_${selectedClass}_${selectedRoom}`, this.value);
        }
        renderPaper();
    });

    // Update layout on configurations edit
    [customTitle, schoolYear, pageOrientation, pageMargin, showAdvisorsHeader, showAdvisorsFooter, showSupervisorFooter].forEach(el => {
        el.addEventListener('change', renderPaper);
        el.addEventListener('input', renderPaper);
    });

    // Sliders change event listeners
    blankColsRange.addEventListener('input', function() {
        blankColsVal.textContent = `${this.value} ช่อง`;
        renderPaper();
    });
    fontSizeRange.addEventListener('input', function() {
        fontSizeVal.textContent = `${this.value}px`;
        renderPaper();
    });
    rowHeightRange.addEventListener('input', function() {
        rowHeightVal.textContent = `${this.value}px`;
        renderPaper();
    });

    // Renders screen card profiles and prints checksheet tables
    function renderPaper() {
        if (loadedStudents.length === 0) return;

        const titleText = customTitle.value;
        const planText = learningPlan.value;
        const advisorsText = advisorNames.value;
        const yearVal = schoolYear.value;
        const orientation = pageOrientation.value;
        const marginVal = pageMargin.value;
        
        const blankCols = parseInt(blankColsRange.value);
        const fontSize = fontSizeRange.value + 'px';
        const rowHeight = rowHeightRange.value + 'px';
        
        const showAdvHead = showAdvisorsHeader.checked;
        const showAdvFoot = showAdvisorsFooter.checked;
        const showSupFoot = showSupervisorFooter.checked;

        // Apply page size and margins dynamically
        if (orientation === 'landscape') {
            printOrientationStyle.innerHTML = `
                @media print {
                    @page {
                        size: A4 landscape;
                        margin: ${marginVal};
                    }
                }
            `;
        } else {
            printOrientationStyle.innerHTML = `
                @media print {
                    @page {
                        size: A4 portrait;
                        margin: ${marginVal};
                    }
                }
            `;
        }

        // Apply print configurations
        printArea.style.padding = marginVal;
        printArea.style.fontSize = fontSize;

        // ----------------------------------------------------
        // 1. BUILD INTERACTIVE PROFILE CARDS INTERFACE (Screen)
        // ----------------------------------------------------
        let screenHtml = '';
        
        // Header summary bar on screen
        screenHtml += `
            <div class="mb-6 bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-white/10 rounded-3xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-base sm:text-lg font-black text-slate-800 dark:text-white flex items-center gap-2">
                        <span>ชั้นมัธยมศึกษาปีที่ ${selectedClass}/${selectedRoom}</span>
                        <span class="text-xs px-2.5 py-1 rounded-full bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">ปีการศึกษา ${yearVal}</span>
                    </h2>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-1.5">
                        แผนการเรียน: <span class="font-bold text-slate-700 dark:text-slate-300">${planText || '-'}</span> | จำนวนนักเรียนทั้งหมด: <span class="font-bold text-slate-700 dark:text-slate-300">${loadedStudents.length} คน</span>
                    </p>
                </div>
            </div>
        `;

        // Homeroom Advisor cards
        const splitAdvisors = advisorsText.split(/\s+\d+\./).map(name => name.replace(/^\d+\./, '').trim()).filter(name => name !== '');
        if (loadedAdvisors.length > 0) {
            screenHtml += `
                <div class="mb-8">
                    <h3 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-indigo-500"></i> ครูที่ปรึกษาประจำชั้นเรียน
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            `;
            loadedAdvisors.forEach((adv, index) => {
                const advPhotoUrl = adv.Teach_photo ? `https://std.phichai.ac.th/teacher/uploads/phototeach/${adv.Teach_photo}` : '';
                
                screenHtml += `
                    <div onclick="showAdvisorDetails(${index})" class="cursor-pointer bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-white/10 rounded-2xl p-4 flex items-center gap-4 shadow-sm hover:shadow-md hover:scale-[1.02] hover:border-indigo-500/30 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center shrink-0 overflow-hidden relative shadow-inner">
                            <i class="fa-solid fa-chalkboard-user text-xl absolute inset-0 flex items-center justify-center text-slate-400 dark:text-slate-500"></i>
                            ${advPhotoUrl ? `<img src="${advPhotoUrl}" class="w-full h-full object-cover relative z-10" onerror="this.style.display='none'">` : ''}
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider">Homeroom Advisor</span>
                            <h4 class="text-sm font-bold text-slate-800 dark:text-white mt-0.5">${adv.Teach_name}</h4>
                        </div>
                    </div>
                `;
            });
            screenHtml += `
                    </div>
                </div>
            `;
        }

        // Student Profile Cards Grid
        screenHtml += `
            <div>
                <h3 class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-users text-indigo-500"></i> รายชื่อประวัตินักเรียนในห้อง
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        `;
        loadedStudents.forEach((student, index) => {
            const fullName = `${student.Stu_pre}${student.Stu_name} ${student.Stu_sur}`;
            // Gender-based gradient detection
            const isFemale = (student.Stu_pre.includes('หญิง') || student.Stu_pre.includes('นางสาว') || student.Stu_pre.includes('ด.ญ.') || student.Stu_pre.includes('น.ส.'));
            const bgGradient = isFemale ? 'from-rose-400 to-pink-500 dark:from-rose-500/80 dark:to-pink-600/80' : 'from-blue-400 to-indigo-500 dark:from-blue-500/80 dark:to-indigo-600/80';
            const initials = student.Stu_name.charAt(0);
            
            // Build student photo URL using Stu_picture first, then fallback to Stu_id.jpg
            const photoUrl = student.Stu_picture ? `https://std.phichai.ac.th/photo/${student.Stu_picture}` : `https://std.phichai.ac.th/photo/${student.Stu_id}.jpg`;
            
            screenHtml += `
                <div onclick="showStudentDetails(${index})" class="cursor-pointer bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-white/10 rounded-2xl p-4 flex items-center gap-4 shadow-sm hover:shadow-md hover:scale-[1.02] hover:border-indigo-500/30 transition-all duration-300 relative group">
                    <!-- Roll No top-right badge -->
                    <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-[10px] font-bold text-slate-500 dark:text-slate-400">
                        เลขที่ ${student.Stu_no}
                    </span>
                    
                    <!-- Color Gradient Avatar Container -->
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-tr ${bgGradient} text-white flex items-center justify-center font-black text-lg shadow-inner shrink-0 overflow-hidden relative">
                        <!-- Falls back to Initials under the photo -->
                        <span class="absolute inset-0 flex items-center justify-center">${initials}</span>
                        <!-- Student Photo with error event to fallback -->
                        <img src="${photoUrl}" class="w-full h-full object-cover relative z-10" onerror="this.style.display='none'">
                    </div>
                    
                    <!-- Student details -->
                    <div class="space-y-0.5 pr-8">
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">${fullName}</h4>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">รหัสประจำตัว: ${student.Stu_id}</p>
                    </div>
                </div>
            `;
        });
        screenHtml += `
                </div>
            </div>
        `;

        // Inject Card View on screen
        paperContent.innerHTML = screenHtml;

        // ----------------------------------------------------
        // 2. BUILD PRINT CHECKSHEET TABLE VIEW (Hidden printArea)
        // ----------------------------------------------------
        let printHtml = '';

        // Document print headers
        printHtml += `<div class="doc-header">`;
        printHtml += `    <div class="doc-title">${titleText} ม.${selectedClass}/${selectedRoom} โรงเรียนพิชัย ปีการศึกษา ${yearVal}</div>`;
        printHtml += `    <div class="doc-subrow">`;
        printHtml += `        <div>แผนการเรียน: ${planText ? planText : '-'}</div>`;
        printHtml += `        <div>จำนวนนักเรียน: ${loadedStudents.length} คน</div>`;
        printHtml += `    </div>`;

        if (showAdvHead && advisorsText) {
            printHtml += `    <div class="doc-advisors">ครูที่ปรึกษา: ${advisorsText}</div>`;
        }
        printHtml += `</div>`;

        // Checks table grid
        printHtml += `<table class="print-table" id="rosterTable">`;
        printHtml += `    <thead>`;
        printHtml += `        <tr>`;
        printHtml += `            <th class="th-no" style="font-size: ${fontSize};">เลขที่</th>`;
        printHtml += `            <th class="th-id" style="font-size: ${fontSize};">เลขประจำตัว</th>`;
        printHtml += `            <th class="th-name" style="font-size: ${fontSize};">ชื่อ - สกุล</th>`;
        
        // Blank checks columns
        for (let i = 1; i <= blankCols; i++) {
            printHtml += `        <th class="th-blank" style="font-size: ${fontSize};"></th>`;
        }
        
        printHtml += `            <th style="width: 10%; font-size: ${fontSize};">หมายเหตุ</th>`;
        printHtml += `        </tr>`;
        printHtml += `    </thead>`;
        printHtml += `    <tbody>`;

        // Student roster rows
        loadedStudents.forEach((student) => {
            const fullName = `${student.Stu_pre}${student.Stu_name} ${student.Stu_sur}`;
            printHtml += `    <tr style="height: ${rowHeight};">`;
            printHtml += `        <td style="font-size: ${fontSize}; font-weight: bold;">${student.Stu_no}</td>`;
            printHtml += `        <td style="font-size: ${fontSize}; font-family: 'Outfit', 'Sarabun', sans-serif;">${student.Stu_id}</td>`;
            printHtml += `        <td class="text-left" style="font-size: ${fontSize};">${fullName}</td>`;
            
            // Blank cells
            for (let i = 1; i <= blankCols; i++) {
                printHtml += `    <td></td>`;
            }
            
            printHtml += `        <td></td>`;
            printHtml += `    </tr>`;
        });

        printHtml += `    </tbody>`;
        printHtml += `</table>`;

        // Advisor/supervisor signatures block
        if (showAdvFoot || showSupFoot) {
            printHtml += `<div class="doc-signatures">`;
            
            if (showAdvFoot) {
                if (splitAdvisors.length > 0) {
                    splitAdvisors.forEach(name => {
                        printHtml += `    <div class="sig-block">`;
                        printHtml += `        <p>ลงชื่อ..........................................................ครูที่ปรึกษา</p>`;
                        printHtml += `        <p>( ${name} )</p>`;
                        printHtml += `    </div>`;
                    });
                } else {
                    printHtml += `    <div class="sig-block">`;
                    printHtml += `        <p>ลงชื่อ..........................................................ครูที่ปรึกษา</p>`;
                    printHtml += `        <p>( .......................................................... )</p>`;
                    printHtml += `    </div>`;
                }
            }
            
            if (showSupFoot) {
                printHtml += `    <div class="sig-block">`;
                printHtml += `        <p>ลงชื่อ..........................................................หัวหน้าระดับ</p>`;
                printHtml += `        <p>( .......................................................... )</p>`;
                printHtml += `    </div>`;
            }
            
            printHtml += `</div>`;
        }

        // Inject A4 checksheet print HTML
        printArea.innerHTML = printHtml;
    }

    // Styled Excel Exporter Mechanism using SheetJS
    function exportToExcel() {
        if (loadedStudents.length === 0) {
            alert("กรุณาเลือกและโหลดข้อมูลระดับชั้นก่อนส่งออก Excel");
            return;
        }

        const planText = learningPlan.value;
        const advisorsText = advisorNames.value;
        const yearVal = schoolYear.value;
        const blankCols = parseInt(blankColsRange.value);

        const excelRows = [];

        // Title and meta
        excelRows.push([`รายชื่อนักเรียน ชั้น ม.${selectedClass}/${selectedRoom} ปีการศึกษา ${yearVal} (โรงเรียนพิชัย)`]);
        excelRows.push([`แผนการเรียน: ${planText ? planText : '-'} | ครูที่ปรึกษา: ${advisorsText ? advisorsText : '-'}`]);
        excelRows.push([]); // Gap

        // Headers
        const headers = ['เลขที่', 'เลขประจำตัว', 'ชื่อ-นามสกุล'];
        for (let i = 1; i <= blankCols; i++) {
            headers.push('');
        }
        headers.push('หมายเหตุ');
        excelRows.push(headers);

        // Student Data Rows
        loadedStudents.forEach(student => {
            const fullName = `${student.Stu_pre}${student.Stu_name} ${student.Stu_sur}`;
            const row = [parseInt(student.Stu_no) || student.Stu_no, student.Stu_id, fullName];
            
            for (let i = 0; i < blankCols; i++) {
                row.push('');
            }
            row.push('');
            excelRows.push(row);
        });

        // Initialize worksheet
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(excelRows);

        // Excel cell styling declarations
        const titleStyle = {
            font: { name: 'Tahoma', sz: 14, bold: true, color: { rgb: "1E293B" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        const subtitleStyle = {
            font: { name: 'Tahoma', sz: 10, color: { rgb: "475569" } },
            alignment: { horizontal: "center", vertical: "center" }
        };

        const headerStyle = {
            font: { name: 'Tahoma', sz: 10, bold: true, color: { rgb: "1E293B" } },
            fill: { fgColor: { rgb: "F1F5F9" } },
            alignment: { horizontal: "center", vertical: "center" },
            border: {
                top: { style: "thin", color: { rgb: "94A3B8" } },
                bottom: { style: "medium", color: { rgb: "1E293B" } },
                left: { style: "thin", color: { rgb: "CBD5E1" } },
                right: { style: "thin", color: { rgb: "CBD5E1" } }
            }
        };

        const dataStyleCenter = {
            font: { name: 'Tahoma', sz: 10 },
            alignment: { horizontal: "center", vertical: "center" },
            border: {
                top: { style: "thin", color: { rgb: "E2E8F0" } },
                bottom: { style: "thin", color: { rgb: "E2E8F0" } },
                left: { style: "thin", color: { rgb: "E2E8F0" } },
                right: { style: "thin", color: { rgb: "E2E8F0" } }
            }
        };

        const dataStyleLeft = {
            font: { name: 'Tahoma', sz: 10 },
            alignment: { horizontal: "left", vertical: "center" },
            border: {
                top: { style: "thin", color: { rgb: "E2E8F0" } },
                bottom: { style: "thin", color: { rgb: "E2E8F0" } },
                left: { style: "thin", color: { rgb: "E2E8F0" } },
                right: { style: "thin", color: { rgb: "E2E8F0" } }
            }
        };

        const totalCols = 3 + blankCols + 1;
        
        // Loop and apply styles
        for (let key in ws) {
            if (key.indexOf('!') === 0) continue;
            
            const colLetter = key.match(/[A-Z]+/)[0];
            const rowNum = parseInt(key.match(/\d+/)[0]);
            
            let colIndex = 0;
            for (let i = 0; i < colLetter.length; i++) {
                colIndex = colIndex * 26 + (colLetter.charCodeAt(i) - 64);
            }
            colIndex = colIndex - 1;
            
            const cell = ws[key];
            
            if (rowNum === 1) {
                cell.s = titleStyle;
            } else if (rowNum === 2) {
                cell.s = subtitleStyle;
            } else if (rowNum === 4) {
                cell.s = headerStyle;
            } else if (rowNum > 4) {
                if (colIndex === 2) {
                    cell.s = dataStyleLeft;
                } else {
                    cell.s = dataStyleCenter;
                }
            }
        }

        // Columns width dimensions
        const wscols = [
            { wch: 8 },  // Col A: เลขที่
            { wch: 15 }, // Col B: เลขประจำตัว
            { wch: 30 }  // Col C: ชื่อ-นามสกุล
        ];
        for (let i = 1; i <= blankCols; i++) {
            wscols.push({ wch: 6 });
        }
        wscols.push({ wch: 15 }); // หมายเหตุ
        ws['!cols'] = wscols;

        // Custom heights
        const wsrows = [
            { hpt: 28 }, // Title
            { hpt: 20 }, // Subtitle
            { hpt: 12 }  // Spacer
        ];
        wsrows.push({ hpt: 24 }); // Headers
        for (let i = 0; i < loadedStudents.length; i++) {
            wsrows.push({ hpt: 20 }); // Roster rows
        }
        ws['!rows'] = wsrows;

        // Merges
        ws['!merges'] = [
            { s: { r: 0, c: 0 }, e: { r: 0, c: totalCols - 1 } },
            { s: { r: 1, c: 0 }, e: { r: 1, c: totalCols - 1 } }
        ];

        XLSX.utils.book_append_sheet(wb, ws, "Roster Listing");
        XLSX.writeFile(wb, `รายชื่อนักเรียน_ม.${selectedClass}_${selectedRoom}_ปี_${yearVal}.xlsx`);
    }

    // Initialize horizontal button triggers
    window.addEventListener('DOMContentLoaded', () => {
        // Parse URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const classParam = urlParams.get('class');
        const roomParam = urlParams.get('room');
        
        if (classParam) {
            selectedClass = classParam;
            renderClassButtons();
            renderRoomButtons();
            
            if (roomParam && classesData[classParam] && classesData[classParam].includes(roomParam)) {
                selectedRoom = roomParam;
                renderRoomButtons();
                fetchStudents();
            }
        } else {
            renderClassButtons();
            renderRoomButtons();
        }
        updateActionButtonsState();
    });

    window.showStudentDetails = function(index) {
        const student = loadedStudents[index];
        if (student) {
            openProfileModal(student);
        }
    };

    window.showAdvisorDetails = function(index) {
        const adv = loadedAdvisors[index];
        if (adv) {
            openAdvisorProfileModal(adv);
        }
    };

    function openProfileModal(student) {
        const modal = document.getElementById('profileModal');
        const box = document.getElementById('profileModalBox');
        
        // Map student details
        document.getElementById('modalHeaderTitle').textContent = 'โปรไฟล์และข้อมูลนักเรียน';
        document.getElementById('modalStudentName').textContent = `${student.Stu_pre}${student.Stu_name} ${student.Stu_sur}`;
        document.getElementById('modalStudentClassRoom').textContent = `ระดับชั้น มัธยมศึกษาปีที่ ${selectedClass}/${selectedRoom} | แผนการเรียน: ${learningPlan.value || '-'}`;
        document.getElementById('modalLabelId').textContent = 'รหัสประจำตัว';
        document.getElementById('modalStudentId').textContent = student.Stu_id;
        
        document.getElementById('modalNoContainer').style.display = 'block';
        document.getElementById('modalLabelNo').textContent = 'เลขที่ในห้องเรียน';
        document.getElementById('modalStudentNo').textContent = `เลขที่ ${student.Stu_no}`;
        
        // Avatar gradient fallback
        const isFemale = (student.Stu_pre.includes('หญิง') || student.Stu_pre.includes('นางสาว') || student.Stu_pre.includes('ด.ญ.') || student.Stu_pre.includes('น.ส.'));
        const bgGradient = isFemale ? 'from-rose-400 to-pink-500' : 'from-blue-400 to-indigo-500';
        const fallback = document.getElementById('modalAvatarFallback');
        fallback.className = `absolute inset-0 bg-gradient-to-tr ${bgGradient} flex items-center justify-center text-white font-black text-4xl shadow-inner`;
        fallback.textContent = student.Stu_name.charAt(0);
        
        // Photo binding
        const photo = document.getElementById('modalStudentPhoto');
        photo.style.display = 'block';
        photo.src = student.Stu_picture ? `https://std.phichai.ac.th/photo/${student.Stu_picture}` : `https://std.phichai.ac.th/photo/${student.Stu_id}.jpg`;
        
        // Show modal with animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function openAdvisorProfileModal(adv) {
        const modal = document.getElementById('profileModal');
        const box = document.getElementById('profileModalBox');
        
        // Map advisor details
        document.getElementById('modalHeaderTitle').textContent = 'โปรไฟล์และข้อมูลครูที่ปรึกษา';
        document.getElementById('modalStudentName').textContent = adv.Teach_name;
        document.getElementById('modalStudentClassRoom').textContent = `ครูที่ปรึกษาประจำชั้น มัธยมศึกษาปีที่ ${selectedClass}/${selectedRoom}`;
        document.getElementById('modalLabelId').textContent = 'กลุ่มสาระ';
        document.getElementById('modalStudentId').textContent = adv.Teach_major || '-';
        
        document.getElementById('modalNoContainer').style.display = 'block';
        document.getElementById('modalLabelNo').textContent = 'ตำแหน่ง';
        document.getElementById('modalStudentNo').textContent = 'ครูที่ปรึกษา';
        
        // Avatar gradient fallback
        const isFemale = (adv.Teach_name.includes('หญิง') || adv.Teach_name.includes('นางสาว') || adv.Teach_name.includes('นาง') || adv.Teach_name.includes('น.ส.'));
        const bgGradient = isFemale ? 'from-rose-400 to-pink-500' : 'from-blue-400 to-indigo-500';
        
        // Extract initial
        let name = adv.Teach_name;
        if (name.startsWith('นางสาว')) { name = name.substring(6); }
        else if (name.startsWith('นาย')) { name = name.substring(3); }
        else if (name.startsWith('นาง')) { name = name.substring(3); }
        const initial = name.charAt(0) || adv.Teach_name.charAt(0);
        
        const fallback = document.getElementById('modalAvatarFallback');
        fallback.className = `absolute inset-0 bg-gradient-to-tr ${bgGradient} flex items-center justify-center text-white font-black text-4xl shadow-inner`;
        fallback.textContent = initial;
        
        // Photo binding
        const photo = document.getElementById('modalStudentPhoto');
        photo.style.display = 'block';
        photo.src = adv.Teach_photo ? `https://std.phichai.ac.th/teacher/uploads/phototeach/${adv.Teach_photo}` : '';
        
        // Show modal with animation
        modal.classList.remove('hidden');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    window.closeProfileModal = function() {
        const modal = document.getElementById('profileModal');
        const box = document.getElementById('profileModalBox');
        
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>

<!-- INTERACTIVE STUDENT PROFILE MODAL -->
<div id="profileModal" class="no-print fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeProfileModal()"></div>
    
    <!-- Modal Box -->
    <div class="relative w-full max-w-sm bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 z-10" id="profileModalBox">
        
        <!-- Header -->
        <div class="flex items-center justify-between p-5 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-indigo-500 to-purple-600 text-white">
            <h3 class="text-xs font-bold flex items-center gap-2">
                <i class="fas fa-id-card"></i>
                <span id="modalHeaderTitle">โปรไฟล์และข้อมูลนักเรียน</span>
            </h3>
            <button onclick="closeProfileModal()" class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/20 hover:bg-white/30 transition-all hover:scale-105 active:scale-95 cursor-pointer">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        
        <!-- Modal Body Content -->
        <div class="p-6 space-y-6 flex flex-col items-center text-center">
            
            <!-- Large Image Wrapper -->
            <div class="relative w-36 h-48 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 shadow-md border-2 border-slate-200 dark:border-slate-700" id="modalPhotoContainer">
                <!-- Large avatar initials fallback under picture -->
                <div class="absolute inset-0 bg-gradient-to-tr flex items-center justify-center text-white font-black text-4xl shadow-inner" id="modalAvatarFallback">
                    --
                </div>
                <!-- Large student photo -->
                <img id="modalStudentPhoto" src="" class="w-full h-full object-cover relative z-10" onerror="this.style.display='none'">
            </div>
            
            <!-- Roster Details -->
            <div class="space-y-4 w-full">
                <!-- Name and Rank -->
                <div class="space-y-1">
                    <h4 class="text-base font-extrabold text-slate-800 dark:text-white" id="modalStudentName">--</h4>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 font-medium" id="modalStudentClassRoom">--</p>
                </div>
                
                <!-- Detailed Grid specs -->
                <div class="grid grid-cols-2 gap-3 bg-slate-50 dark:bg-slate-950/40 border border-slate-100 dark:border-slate-800 rounded-2xl p-4 text-left">
                    <div class="space-y-0.5">
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider" id="modalLabelId">รหัสประจำตัว</span>
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200" id="modalStudentId">--</div>
                    </div>
                    <div class="space-y-0.5" id="modalNoContainer">
                        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider" id="modalLabelNo">เลขที่ในห้องเรียน</span>
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200" id="modalStudentNo">--</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Foot Actions -->
        <div class="p-4 bg-slate-50 dark:bg-slate-950/40 border-t border-slate-100 dark:border-slate-800 flex justify-end">
            <button onclick="closeProfileModal()" class="px-5 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-white/5 dark:hover:bg-white/10 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-xl transition-all cursor-pointer">
                ปิดหน้าต่าง
            </button>
        </div>
    </div>
</div>
