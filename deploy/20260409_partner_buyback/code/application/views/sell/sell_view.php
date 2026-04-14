<?php
$complete_message = isset($complete_message) && $complete_message
    ? $complete_message
    : $this->session->flashdata('complete_message');
?>
<?php if ($complete_message): ?>
    <script>
        alert("<?php echo $complete_message; ?>");
    </script>
<?php endif; ?>
<?php $buyback_base_path = isset($buyback_base_path) && $buyback_base_path ? trim($buyback_base_path, '/') : 'sell'; ?>

<main class="flex-grow py-8 md:py-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="mb-8 text-center md:text-left">
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">중고 기기 매입 신청</h1>
<p class="text-gray-500 dark:text-gray-400">빠르고 안전한 리맨 매입 서비스를 통해 최적의 가격을 확인하세요.</p>
</div>
<div class="flex flex-col lg:flex-row gap-8">
<div class="flex-grow lg:w-2/3">

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-6">
<div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
<h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2"><span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary text-white text-xs">1</span>판매하실 기기를 선택해주세요</h2>
</div>
<div class="p-6">
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
<div id="device-notebook" onclick="selectDevice('notebook', '노트북')" class="device-selector cursor-pointer border-2 border-primary bg-primary/5 dark:bg-primary/10 rounded-xl p-4 flex flex-col items-center justify-center gap-3 transition-all relative">
<div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
<span class="material-icons text-3xl">laptop_mac</span>
</div>
<span class="font-bold text-primary">노트북</span>
<span class="absolute top-2 right-2 text-primary material-icons text-lg check-icon">check_circle</span>
</div>
<div id="device-desktop" onclick="selectDevice('desktop', '데스크탑')" class="device-selector cursor-pointer border border-gray-200 dark:border-gray-700 hover:border-primary/50 rounded-xl p-4 flex flex-col items-center justify-center gap-3 transition-all hover:bg-gray-50 dark:hover:bg-gray-700 opacity-60 relative">
<div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
<span class="material-icons text-3xl">desktop_windows</span>
</div>
<span class="font-medium text-gray-600 dark:text-gray-300">데스크탑</span>
<span class="absolute top-2 right-2 text-primary material-icons text-lg check-icon hidden">check_circle</span>
</div>
<div id="device-monitor" onclick="selectDevice('monitor', '모니터')" class="device-selector cursor-pointer border border-gray-200 dark:border-gray-700 hover:border-primary/50 rounded-xl p-4 flex flex-col items-center justify-center gap-3 transition-all hover:bg-gray-50 dark:hover:bg-gray-700 opacity-60 relative">
<div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
<span class="material-icons text-3xl">monitor</span>
</div>
<span class="font-medium text-gray-600 dark:text-gray-300">모니터</span>
<span class="absolute top-2 right-2 text-primary material-icons text-lg check-icon hidden">check_circle</span>
</div>
<div id="device-parts" onclick="selectDevice('parts', '부품')" class="device-selector cursor-pointer border border-gray-200 dark:border-gray-700 hover:border-primary/50 rounded-xl p-4 flex flex-col items-center justify-center gap-3 transition-all hover:bg-gray-50 dark:hover:bg-gray-700 opacity-60 relative">
<div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
<span class="material-icons text-3xl">memory</span>
</div>
<span class="font-medium text-gray-600 dark:text-gray-300">부품</span>
<span class="absolute top-2 right-2 text-primary material-icons text-lg check-icon hidden">check_circle</span>
</div>
</div>
</div>
</div>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-primary/20 overflow-hidden">
<div class="p-6 border-b border-gray-100 dark:border-gray-700">
<h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
<span class="flex items-center justify-center w-6 h-6 rounded-full bg-primary text-white text-xs">2</span>
              상세 스펙 입력
            </h2>
<p class="mt-1 text-sm text-gray-500 ml-8">정확한 모델명과 사양을 입력하시면 더 정확한 견적을 받으실 수 있습니다.</p>
</div>
<div class="p-6 space-y-6">
<div id="dynamic-specs-container" class="space-y-6"></div>
<div class="pt-4 border-t border-gray-100 dark:border-gray-700">
<h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4">기기 상태 (Condition)</h3>
<div class="space-y-3">
<label class="condition-label relative flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
<input onchange="updateCondition(this, 'A급 (정상)')" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" name="condition" type="radio"/>
<div class="ml-3 flex-grow">
<span class="block text-sm font-bold text-gray-900 dark:text-white">정상 작동 (A급)</span>
<span class="block text-xs text-gray-500 mt-1">모든 기능이 정상이며, 외관에 눈에 띄는 흠집이 거의 없음</span>
</div>
<span class="text-primary font-bold text-sm">+ 최고가</span>
</label>
<label class="condition-label relative flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 border-primary bg-primary/5 dark:bg-primary/10 transition-all group">
<input onchange="updateCondition(this, 'B급 (생활 기스)')" checked="" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" name="condition" type="radio"/>
<div class="ml-3 flex-grow">
<span class="block text-sm font-medium text-gray-900 dark:text-white">생활 기스 (B급)</span>
<span class="block text-xs text-gray-500 mt-1">기능은 정상이나 외관에 사용감이나 작은 흠집이 있음</span>
</div>
</label>
<label class="condition-label relative flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
<input onchange="updateCondition(this, 'C급 (파손/불량)')" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" name="condition" type="radio"/>
<div class="ml-3 flex-grow">
<span class="block text-sm font-medium text-gray-900 dark:text-white">기능 불량 / 파손 (C급)</span>
<span class="block text-xs text-gray-500 mt-1">화면 파손, 전원 불량, 키보드 고장 등 수리가 필요한 상태</span>
</div>
</label>
</div>
</div>
</div>
<div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 flex justify-between items-center border-t border-gray-100 dark:border-gray-700">
<button onclick="alert('이전 단계로 이동합니다.')" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium text-sm flex items-center gap-1 transition-colors">
<span class="material-icons text-base">arrow_back</span>
              이전 단계
            </button>
            <button id="add-device-btn" onclick="addCurrentDevice()" class="bg-primary hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
              판매할 기기 추가
              <span class="material-icons text-sm">add_circle</span>
            </button>
</div>
</div>
</div>
<div class="lg:w-1/3">
<div class="sticky top-24 space-y-6">
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden relative">
<div class="h-2 bg-gradient-to-r from-primary to-blue-400"></div>
<div class="p-6">
<h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
<span class="material-icons text-primary">receipt_long</span>
                매입 요약
              </h3>
<div class="space-y-4 mb-6 text-sm">
<div class="flex justify-between items-start pb-3 border-b border-gray-100 dark:border-gray-700 border-dashed">
<span class="text-gray-500">기기 종류</span>
<span id="summary-device" class="font-medium text-gray-900 dark:text-white text-right">노트북</span>
</div>
<div class="flex justify-between items-start pb-3 border-b border-gray-100 dark:border-gray-700 border-dashed">
<span class="text-gray-500">제조사</span>
<span id="summary-manufacturer" class="font-medium text-gray-900 dark:text-white text-right">삼성전자 (Samsung)</span>
</div>
<div class="flex justify-between items-start pb-3 border-b border-gray-100 dark:border-gray-700 border-dashed">
<span class="text-gray-500">주요 사양</span>
<div class="text-right">
<div id="summary-cpu" class="font-medium text-gray-900 dark:text-white">Intel Core i5</div>
<div id="summary-memory" class="text-xs text-gray-500">16GB RAM / 512GB SSD</div>
</div>
</div>
<div class="flex justify-between items-start">
<span class="text-gray-500">기기 상태</span>
<span id="summary-condition" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                      B급 (생활 기스)
                    </span>
</div>
</div>
<div class="bg-primary/5 dark:bg-gray-700/50 rounded-xl p-5 text-center border border-primary/10 mb-4">
<p class="text-sm text-gray-500 dark:text-gray-400 mb-1">예상 매입가</p>
<div id="summary-price" class="text-3xl font-bold text-primary tracking-tight">
                  ₩ 650,000 ~
                </div>
<p class="text-xs text-gray-400 mt-2">* 실제 검수 후 가격이 변동될 수 있습니다.</p>
</div>
              <div id="added-devices-section" class="mb-4 hidden">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">추가된 기기</span>
                  <span id="added-count" class="text-xs text-gray-500">0대</span>
                </div>
                <div id="added-device-list" class="space-y-2 max-h-[60vh] overflow-auto pr-1"></div>
                <div class="mt-3 text-right text-sm">
                  <span class="text-gray-500">예상 총액</span>
                  <span id="added-total" class="ml-2 font-bold text-primary">₩ 0</span>
                </div>
              </div>
<button onclick="goToCollection()" class="w-full bg-white dark:bg-gray-800 border-2 border-primary text-primary hover:bg-primary/5 dark:hover:bg-primary/10 font-bold py-3 px-4 rounded-xl transition-all flex items-center justify-center gap-2 group"><span class="material-icons group-hover:scale-110 transition-transform">local_shipping</span> 수거 신청하기</button>
</div>
</div>
<div class="text-center">
<p class="text-xs text-gray-400">진행 중 어려움이 있으신가요?</p>
<a class="text-sm font-medium text-primary hover:underline" href="#">고객센터 문의하기 (1588-0000)</a>
</div>
</div>
</div>
</div>
</div>
</main>

<div class="fixed bottom-0 right-0 p-8 pointer-events-none opacity-20 hidden xl:block">
<div class="w-64 h-64 bg-primary/30 rounded-full blur-3xl"></div>
</div>

<script>
  
const priceDB = <?php echo isset($buyback_price_db_json) ? $buyback_price_db_json : '[]'; ?>;

  // State
  const state = {
    device: '노트북',
    specs: {},
    condition: 'B급 (생활 기스)'
  };

  const secondPriceTable = <?php echo isset($buyback_second_price_table_json) ? $buyback_second_price_table_json : '{}'; ?>;

  function getSecondManufacturers(device) {
    const src = secondPriceTable[device];
    if (!src) return [];
    return Object.keys(src).sort((a, b) => a.localeCompare(b, undefined, { numeric: true, sensitivity: 'base' }));
  }

  function getSecondModels(device, manufacturer) {
    const src = secondPriceTable[device] && secondPriceTable[device][manufacturer];
    if (!src) return [];
    return Object.keys(src).sort((a, b) => a.localeCompare(b, undefined, { numeric: true, sensitivity: 'base' }));
  }

  function getSecondPrice(device, manufacturer, model) {
    const src = secondPriceTable[device] && secondPriceTable[device][manufacturer];
    if (!src) return null;
    const val = src[model];
    return typeof val === 'number' ? val : null;
  }

  // Helper to get unique items from priceDB
  function getCategories(type) {
    const cats = new Set();
    priceDB.forEach(d => { if (d.type === type && d.category) cats.add(d.category); });
    return Array.from(cats).sort((a, b) => a.localeCompare(b, undefined, {numeric: true, sensitivity: 'base'}));
  }
  
  function getNames(type, category) {
    return priceDB.filter(d => d.type === type && (!category || d.category === category)).map(d => d.name).sort((a, b) => a.localeCompare(b, undefined, {numeric: true, sensitivity: 'base'}));
  }

  // Populate dropdown logic
  function renderDynamicSpecs() {
    const container = document.getElementById('dynamic-specs-container');
    let html = '';
    state.specs = {}; // reset specs
    
    if (state.device === '노트북' || state.device === '데스크탑') {
      const typeValue = state.device;
      const mans = getSecondManufacturers(typeValue);
      html = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">제조사</label>
            <select id="spec-category" onchange="updateSecondModels('${typeValue}'); updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">선택해주세요</option>
              ${mans.map(c => `<option value="${c}">${c}</option>`).join('')}
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">세대/모델</label>
            <select id="spec-name" onchange="updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">제조사를 먼저 선택해주세요</option>
            </select>
          </div>
        </div>
      `;
    } else if (state.device === '모니터') {
      const typeValue = state.device;
      const cats = getCategories(typeValue);
      html = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">제조사 (분류)</label>
            <select id="spec-category" onchange="updateNames('${typeValue}'); updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">선택해주세요</option>
              ${cats.map(c => `<option value="${c}">${c}</option>`).join('')}
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">상세 사양 (모델/크기)</label>
            <select id="spec-name" onchange="updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">제조사를 먼저 선택해주세요</option>
            </select>
          </div>
        </div>
      `;
    } else if (state.device === '부품') {
      const types = ['CPU', 'RAM', 'SSD', 'VGA'];
      html = `
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">부품 종류</label>
            <select id="spec-part-type" onchange="updatePartCategories(); updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">선택해주세요</option>
              ${types.map(t => `<option value="${t}">${t}</option>`).join('')}
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">분류/세대</label>
            <select id="spec-category" onchange="updateNames(document.getElementById('spec-part-type').value); updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">종류를 먼저 선택해주세요</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">상세 사양</label>
            <select id="spec-name" onchange="updateSummary()" class="w-full pl-3 pr-10 py-3 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 text-sm">
              <option value="">분류를 먼저 선택해주세요</option>
            </select>
          </div>
        </div>
      `;
    }
    
    container.innerHTML = html;
  }

  function updateSecondModels(device) {
    const manuEl = document.getElementById('spec-category');
    const nameSelect = document.getElementById('spec-name');
    if (!manuEl || !nameSelect) return;
    const manu = manuEl.value;
    const models = getSecondModels(device, manu);
    nameSelect.innerHTML = '<option value="">선택해주세요</option>' + models.map(n => `<option value="${n}">${n}</option>`).join('');
  }

  function updateNames(typeValue) {
    const catSelect = document.getElementById('spec-category');
    const nameSelect = document.getElementById('spec-name');
    if(!catSelect || !nameSelect) return;
    
    const cat = catSelect.value;
    const names = getNames(typeValue, cat);
    nameSelect.innerHTML = '<option value="">선택해주세요</option>' + names.map(n => `<option value="${n}">${n}</option>`).join('');
  }

  function updatePartCategories() {
    const typeValue = document.getElementById('spec-part-type').value;
    const catSelect = document.getElementById('spec-category');
    const nameSelect = document.getElementById('spec-name');
    
    if(!typeValue) {
      catSelect.innerHTML = '<option value="">종류를 먼저 선택해주세요</option>';
      nameSelect.innerHTML = '<option value="">분류를 먼저 선택해주세요</option>';
      return;
    }
    
    const cats = getCategories(typeValue);
    catSelect.innerHTML = '<option value="">선택해주세요</option>' + cats.map(c => `<option value="${c}">${c}</option>`).join('');
    nameSelect.innerHTML = '<option value="">분류를 먼저 선택해주세요</option>';
  }

  // Device Selection
  function selectDevice(type, label) {
    state.device = label;
    
    // Update UI Tabs
    document.querySelectorAll('.device-selector').forEach(el => {
      el.classList.remove('border-2', 'border-primary', 'bg-primary/5', 'dark:bg-primary/10');
      el.classList.add('border', 'border-gray-200', 'dark:border-gray-700', 'opacity-60');
      el.querySelector('.check-icon').classList.add('hidden');
    });
    
    const selected = document.getElementById(`device-${type}`);
    if(selected) {
      selected.classList.remove('border', 'border-gray-200', 'dark:border-gray-700', 'opacity-60');
      selected.classList.add('border-2', 'border-primary', 'bg-primary/5', 'dark:bg-primary/10');
      selected.querySelector('.check-icon').classList.remove('hidden');
    }

    renderDynamicSpecs();
    updateSummary();
  }

  // Condition Selection
  function updateCondition(element, label) {
    state.condition = label;
    document.querySelectorAll('.condition-label').forEach(lbl => {
      lbl.classList.remove('border-primary', 'bg-primary/5', 'dark:bg-primary/10');
      lbl.classList.add('border-gray-200', 'dark:border-gray-700');
    });

    const labelEl = element.closest('label');
    if(labelEl) {
      labelEl.classList.remove('border-gray-200', 'dark:border-gray-700');
      labelEl.classList.add('border-primary', 'bg-primary/5', 'dark:bg-primary/10');
    }
    updateSummary();
  }

  // Lookup price based on selection
  function computePriceFor(s) {
    let basePrice = 0;
    
    if (s.device === '노트북' || s.device === '데스크탑') {
      const val = getSecondPrice(s.device, s.specs.category, s.specs.name);
      if (typeof val === 'number') basePrice = val;
    } else if (s.device === '모니터') {
      const item = priceDB.find(d => d.type === s.device && d.category === s.specs.category && d.name === s.specs.name);
      if (item) basePrice = item.price;
    } else if (s.device === '부품') {
      const item = priceDB.find(d => d.type === s.specs.part_type && d.category === s.specs.category && d.name === s.specs.name);
      if (item) basePrice = item.price;
    }
    
    // Simple condition penalty logic
    // If B급: -15% or fixed amount
    // If C급: -40% or fixed amount
    if (s.condition.includes('B급')) {
      basePrice = Math.floor(basePrice * 0.85); 
    } else if (s.condition.includes('C급')) {
      basePrice = Math.floor(basePrice * 0.60);
    }
    
    return basePrice;
  }

  // Summary Update
  function updateSummary() {
    // Collect current state from DOM
    if (state.device === '노트북' || state.device === '데스크탑' || state.device === '모니터') {
      const catEl = document.getElementById('spec-category');
      const nameEl = document.getElementById('spec-name');
      state.specs.category = catEl ? catEl.value : '';
      state.specs.name = nameEl ? nameEl.value : '';
    } else if (state.device === '부품') {
      const pTypeEl = document.getElementById('spec-part-type');
      const catEl = document.getElementById('spec-category');
      const nameEl = document.getElementById('spec-name');
      state.specs.part_type = pTypeEl ? pTypeEl.value : '';
      state.specs.category = catEl ? catEl.value : '';
      state.specs.name = nameEl ? nameEl.value : '';
    }
    
    // Update Sidebar Text
    document.getElementById('summary-device').textContent = state.device;
    
    // Manufacturer and CPU area
    let manuText = '-';
    let cpuText = '-';
    let memText = '';
    
    if (state.device === '노트북' || state.device === '데스크탑' || state.device === '모니터') {
      manuText = state.specs.category || '-';
      cpuText = state.specs.name || '-';
    } else if (state.device === '부품') {
      manuText = state.specs.category || '-';
      cpuText = (state.specs.part_type || '') + ' ' + (state.specs.name || '-');
    }
    
    document.getElementById('summary-manufacturer').textContent = manuText;
    document.getElementById('summary-cpu').textContent = cpuText;
    const memEl = document.getElementById('summary-memory');
    if(memEl) memEl.innerHTML = memText ? memText : '';
    
    document.getElementById('summary-condition').textContent = state.condition;
    
    // Pricing
    const price = computePriceFor(state);
    if ((state.device === '노트북' || state.device === '데스크탑') && state.specs.category && state.specs.name) {
      const raw = getSecondPrice(state.device, state.specs.category, state.specs.name);
      document.getElementById('summary-price').textContent = typeof raw === 'number' ? `₩ ${price.toLocaleString()} ~` : '가격 문의';
    } else {
      document.getElementById('summary-price').textContent = price > 0 ? `₩ ${price.toLocaleString()} ~` : '₩ 0 ~';
    }
  }

  let devices = [];


  function renderAddedDevices() {
    const section = document.getElementById('added-devices-section');
    const list = document.getElementById('added-device-list');
    const countEl = document.getElementById('added-count');
    const totalEl = document.getElementById('added-total');
    if (!section || !list) return;
    if (devices.length === 0) {
      section.classList.add('hidden');
      list.innerHTML = '';
      countEl.textContent = '0대';
      totalEl.textContent = '₩ 0';
      return;
    }
    section.classList.remove('hidden');
    const totalUnits = devices.reduce((n, d) => n + (d.qty || 1), 0);
    countEl.textContent = totalUnits + '대';
    let total = 0;
    list.innerHTML = devices.map((d, idx) => {
      const priceVal = d.price_value || computePriceFor(d);
      const qty = d.qty || 1;
      const lineTotal = priceVal * qty;
      total += lineTotal;
      
      let specDetail = '';
      if (d.device === '노트북' || d.device === '데스크탑' || d.device === '모니터') {
        specDetail = d.specs.name;
      } else if (d.device === '부품') {
        specDetail = d.specs.part_type + ' / ' + d.specs.name;
      }
      
      let manu = d.specs.category || '-';

      const editingBadge = (editingIndex === idx) ? '<span class="ml-2 text-[10px] px-1.5 py-0.5 rounded bg-primary/10 text-primary align-middle">수정중</span>' : '';
      
      return `
        <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm ring-1 ring-primary/10 ${editingIndex === idx ? 'border-primary' : ''}">
         <div class="flex items-start justify-between">
          <div class="flex-1">
           <div class="text-sm font-bold text-gray-900 dark:text-white">${d.device} · ${manu}${editingBadge}</div>
           <div class="text-xs text-gray-500 mt-1">${specDetail || '상세 미선택'} · ${d.condition}</div>
          </div>
         </div>
         <div class="mt-2 flex items-center justify-between gap-2 flex-wrap">
          <div class="flex items-center gap-2">
           <button onclick="decQty(${idx})" class="px-2 h-7 rounded bg-red-50 border border-red-300 text-red-700 hover:bg-red-100 dark:bg-red-900/40 dark:border-red-700 dark:text-red-200 dark:hover:bg-red-800/50">-</button>
           <span class="text-xs text-gray-600 dark:text-gray-300">x${qty}</span>
           <button onclick="incQty(${idx})" class="px-2 h-7 rounded bg-red-50 border border-red-300 text-red-700 hover:bg-red-100 dark:bg-red-900/40 dark:border-red-700 dark:text-red-200 dark:hover:bg-red-800/50">+</button>
           <span class="mx-1">·</span>
           <button onclick="removeDevice(${idx})" class="text-xs text-red-500 hover:underline">제거</button>
          </div>
          <div class="text-right">
           <div class="text-base font-extrabold text-primary">₩ ${lineTotal.toLocaleString()} ~</div>
          </div>
         </div>
        </div>
       `;
    }).join('');
    totalEl.textContent = '₩ ' + total.toLocaleString();
  }

  let editingIndex = null;

  function incQty(index) {
    devices[index].qty = (devices[index].qty || 1) + 1;
    
    renderAddedDevices();
  }

  function decQty(index) {
    const current = devices[index];
    const qty = (current.qty || 1) - 1;
    if (qty <= 0) {
      devices.splice(index, 1);
    } else {
      current.qty = qty;
    }
    
    renderAddedDevices();
  }

  function addCurrentDevice() {
    const price = computePriceFor(state);
    if ((state.device === '노트북' || state.device === '데스크탑') && (!state.specs.category || !state.specs.name)) {
      alert('제조사와 세대/모델을 선택해주세요.');
      return;
    }
    if (state.device === '노트북' || state.device === '데스크탑') {
      const raw = getSecondPrice(state.device, state.specs.category, state.specs.name);
      if (raw === null) {
        alert('해당 모델은 매입가가 없어 추가할 수 없습니다.');
        return;
      }
    }
    // Copy state deeply for adding
    const device = {
      device: state.device,
      manufacturer: state.specs && state.specs.category ? state.specs.category : '',
      model: state.specs && state.specs.name ? state.specs.name : '',
      specs: JSON.parse(JSON.stringify(state.specs)),
      condition: state.condition,
      price_value: price,
      qty: 1
    };
    devices.push(device);
    
    renderAddedDevices();
    alert('기기가 추가되었습니다.');
  }

  function removeDevice(index) {
    devices.splice(index, 1);
    
    renderAddedDevices();
  }

  function goToCollection() {
	  if (!devices || devices.length === 0) {
		addCurrentDevice();
	  }

	  if (!devices || devices.length === 0) {
		alert('추가된 기기가 없습니다.');
		return;
	  }

	  const total = devices.reduce(function(sum, d) {
		return sum + (d.price_value || 0) * (d.qty || 1);
	  }, 0);

	  fetch('<?php echo site_url($buyback_base_path . '/save-devices'); ?>', {
		method: 'POST',
		headers: {
		  'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
		},
		body: new URLSearchParams({
		  devices: JSON.stringify(devices),
		  total_price: '₩ ' + total.toLocaleString()
		})
	  })
	  .then(function(response) {
		return response.json();
	  })
	  .then(function(data) {
		if (data.result === 'ok') {
		  location.href = '<?php echo site_url($buyback_base_path . '/pickup'); ?>';
		} else {
		  alert(data.message || '처리 중 오류가 발생했습니다.');
		}
	  })
	  .catch(function() {
		alert('서버 통신 중 오류가 발생했습니다.');
	  });
  }

  // Initialize 
  renderDynamicSpecs();
  updateSummary();
  renderAddedDevices();

</script>
