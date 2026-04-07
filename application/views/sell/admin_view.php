
    <main class="flex-grow py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">수거 신청 목록</h1>
                <span class="text-sm text-gray-500" id="total-count">총 0건</span>
            </div>
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">신청일시</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">신청자 정보</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">기기 정보</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">수거 정보</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">예상 매입가</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">관리</th>
                            </tr>
                        </thead>
                        <tbody id="request-list" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <!-- Data will be populated here -->
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    데이터를 불러오는 중입니다...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function loadRequests() {
            try {
                const data = JSON.parse(localStorage.getItem('remann_requests') || '[]');
                return Array.isArray(data) ? data : [];
            } catch (e) {
                return [];
            }
        }

        function fetchRequests() {
            renderTable(loadRequests());
        }

        function renderTable(data) {
            const tbody = document.getElementById('request-list');
            document.getElementById('total-count').textContent = `총 ${data.length}건`;
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            신청 내역이 없습니다.
                        </td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = data.map(item => {
                let devices = null;
                if (Array.isArray(item.devices)) devices = item.devices;
                if (!devices) {
                    try {
                        if (item.devices_json) devices = JSON.parse(item.devices_json);
                    } catch (e) {}
                }
                let deviceCell = '';
                if (devices && Array.isArray(devices) && devices.length > 0) {
                    const first = devices[0];
                    let spec = '';
                    let manu = '-';
                    if (first.specs) {
                        if (first.device === '노트북' || first.device === '데스크탑' || first.device === '모니터') {
                            spec = first.specs.name || '상세 미선택';
                            manu = first.specs.category || '-';
                        } else if (first.device === '부품') {
                            spec = [first.specs.part_type, first.specs.name].filter(Boolean).join(' / ');
                            manu = first.specs.category || '-';
                        }
                    } else {
                        // fallback for old structure
                        spec = first.device === '모니터'
                            ? [first.screen_size, first.panel_type].filter(Boolean).join(' / ')
                            : (first.device === '부품'
                                ? [first.parts_type, first.part_detail].filter(Boolean).join(' / ')
                                : [first.cpu, first.ram, first.storage].filter(Boolean).join(' / '));
                        manu = first.manufacturer || '';
                        if (first.year) manu += ` (${first.year})`;
                    }
                    
                    const totalUnits = devices.reduce((n, d) => n + (d.qty || 1), 0);
                    deviceCell = `
                        <div class="text-sm font-bold text-primary">다중 기기 (${totalUnits}대)</div>
                        <div class="text-sm text-gray-900 dark:text-white">${first.device} · ${manu}</div>
                        <div class="text-xs text-gray-500 mt-1">${spec} · ${first.condition}</div>
                    `;
                } else {
                    deviceCell = `
                        <div class="text-sm font-bold text-primary">${item.device_type}</div>
                        <div class="text-sm text-gray-900 dark:text-white">${item.manufacturer} (${item.model_year})</div>
                        <div class="text-xs text-gray-500 mt-1">
                            ${item.cpu} / ${item.ram} / ${item.storage}
                        </div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mt-1">
                            ${item.condition}
                        </span>
                    `;
                }
                const priceText = item.total_price && item.total_price.trim() ? item.total_price : item.price;
                return `
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        ${item.created_at ? new Date(item.created_at).toLocaleString() : ''}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">${item.applicant_name || item.name || ''}</div>
                        <div class="text-sm text-gray-500">${item.phone}</div>
                        <div class="text-xs text-gray-400 mt-1">${item.address} ${item.address_detail}</div>
                    </td>
                    <td class="px-6 py-4">
                        ${deviceCell}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                        <div><span class="font-medium">방문:</span> ${item.visit_date} ${item.visit_time}</div>
                        <div><span class="font-medium">장소:</span> ${item.pickup_location}</div>
                        ${item.pickup_memo ? `<div class="text-xs mt-1 text-gray-400">Memo: ${item.pickup_memo}</div>` : ''}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                        ${priceText}
                        <div class="text-xs font-normal text-gray-500 mt-1">
                            ${item.bank_name} ${item.account_number}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button onclick="deleteRequest(${item.id})" class="text-red-600 hover:text-red-900 dark:hover:text-red-400">삭제</button>
                    </td>
                </tr>
                `;
            }).join('');
        }

        function deleteRequest(id) {
            if (!confirm('정말 삭제하시겠습니까?')) return;
            const list = loadRequests().filter(x => x && x.id !== id);
            localStorage.setItem('remann_requests', JSON.stringify(list));
            fetchRequests();
        }

        // Initial fetch
        fetchRequests();
    </script>