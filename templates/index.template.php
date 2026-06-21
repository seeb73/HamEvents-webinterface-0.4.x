<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($name) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        /* Stylistyka Głębokiego Dark Mode */
        body {
            background-color: #12141a;
            color: #e2e8f0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        /* Sekcje jako karty odklejające się od tła */
        .section-box {
            background-color: #1a1d24;
            border: 1px solid #2d3139;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
            margin-bottom: 25px;
        }

        /* Liczniki stylizowane na nowoczesny dashboard */
        .counter-box {
            background: #1e222b;
            color: #ffffff;
            border: 1px solid #2d3139;
            border-radius: 8px;
            padding: 15px 10px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 110px;
            position: relative;
            overflow: hidden;
        }

        /* Akcenty kolorystyczne dla liczników */
        .counter-box.qso-total { border-top: 4px solid #f59e0b; }
        .counter-box.hunters-total { border-top: 4px solid #10b981; }
        .counter-box.countries-total { border-top: 4px solid #3b82f6; }
        .counter-box.days-total { border-top: 4px solid #ef4444; }

        .counter-box h2 {
            margin-bottom: 2px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .counter-box .label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #cbd5e1;
            font-weight: 600;
        }

        /* Aktywne stacje - styl kafelków */
        .station-card {
            background-color: #22262f !important;
            border: 1px solid #343a46 !important;
            color: #ffffff !important;
            transition: border-color 0.2s;
        }
        .station-card:hover {
            border-color: #f59e0b !important;
        }

        /* Tabela Live QSO */
        .table-dark-custom {
            --bs-table-bg: transparent !important;
            color: #e2e8f0 !important;
        }
        .table-dark-custom th {
            color: #94a3b8 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #2d3139 !important;
            background-color: #161920 !important;
            padding: 10px 8px;
        }
        .table-dark-custom td {
            border-bottom: 1px solid #2d3139 !important;
            background-color: transparent !important;
            color: #cbd5e1 !important;
            padding: 10px 8px;
        }
        .table-dark-custom tbody tr:hover td {
            background-color: #22262f !important;
            color: #ffffff !important;
        }

        /* POPRAWIONA SZUKAJKA: Pełna widoczność i kontrast */
        .form-control-dark {
            background-color: #22262f !important;
            border: 1px solid #3d4452 !important;
            color: #ffffff !important;
        }
        .form-control-dark::placeholder {
            color: #94a3b8 !important;
            opacity: 1;
        }
        .form-control-dark:focus {
            background-color: #2a303c !important;
            border-color: #f59e0b !important;
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2) !important;
        }
        .btn-dark-custom {
            background-color: #2d3139 !important;
            border: 1px solid #3d4452 !important;
            color: #ffffff !important;
            font-weight: bold;
        }
        .btn-dark-custom:hover {
            background-color: #ef4444 !important; /* Czerwony akcent na czyszczenie */
            border-color: #ef4444 !important;
            color: #ffffff !important;
        }

        /* POPRAWIONA PAGINACJA: Stylowe, widoczne przyciski */
        .pagination .page-link {
            background-color: #22262f !important;
            border-color: #3d4452 !important;
            color: #cbd5e1 !important;
            padding: 6px 12px;
        }
        .pagination .page-link:hover {
            background-color: #2a303c !important;
            color: #f59e0b !important;
            border-color: #f59e0b !important;
        }
        .pagination .page-item.disabled .page-link {
            background-color: #161920 !important;
            border-color: #2d3139 !important;
            color: #4b5563 !important; /* Ciemniejszy szary dla zablokowanych */
        }

        /* POPRAWIONY TEKST DLA PUSTYCH SEKCJI */
        .text-muted-custom {
            color: #94a3b8 !important; /* Jaśniejszy szary, żeby tekst był czytelny */
        }

        /* Badge z modem stacji */
        .badge-mod {
            font-size: 0.75em;
            padding: 4px 6px;
            font-weight: 600;
        }
        .badge-orange { background-color: #f59e0b; color: #12141a; }

        /* Animowana kropka LIVE w nagłówku */
        .live-dot {
            height: 8px;
            width: 8px;
            background-color: #10b981;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        @media (max-width: 576px) { .counter-box h2 { font-size: 1.5rem; } }
    </style>
</head>
<body>

<div class="container-fluid px-4 mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 pb-3 border-bottom border-secondary border-opacity-10">
        <div>
            <h1 class="text-white fw-bold h3 mb-1"><?= htmlspecialchars(strtoupper($name)) ?></h1>
            <div class="text-muted-custom small">Akcja dyplomowa: <span class="text-light"><?= $start_date ?></span> do <span class="text-light"><?= $end_date ?></span></div>
        </div>
        <div class="mt-2 mt-md-0 bg-dark bg-opacity-50 px-3 py-2 rounded border border-secondary border-opacity-10 text-muted-custom small">
            <span class="live-dot"></span> Log łączności i statystyki odświeżają się w czasie rzeczywistym (Live QSO).
        </div>
    </div>

    <div class="row text-center mb-4 row-cols-2 row-cols-md-4 g-3">
        <div class="col"><div class="counter-box qso-total"><h2 id="stat-qso" class="text-warning"><?= $qso ?></h2><div class="label">QSO</div></div></div>
        <div class="col"><div class="counter-box hunters-total"><h2 id="stat-hunters" class="text-success"><?= $hunters ?></h2><div class="label">Hunterzy</div></div></div>
        <div class="col"><div class="counter-box countries-total"><h2 id="stat-countries" class="text-info"><?= $countries ?></h2><div class="label">Kraje</div></div></div>
        <div class="col">
            <div class="counter-box days-total">
                <h2 class="text-danger"><?= $current_day ?></h2>
                <div class="label">Dzień akcji</div>
                <div class="text-light opacity-75" style="font-size: 0.75rem; font-weight: 500;"><?= $days_left_text ?></div>
            </div>
        </div>
    </div>

    <div class="section-box">
        <h6 class="fw-bold text-uppercase tracking-wider text-warning small mb-3">⚡ Aktywne stacje (ostatnie 15 min)</h6>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-2" id="active-stations-container">
            <?php if (empty($active_stations)): ?>
                <div class="col-12 text-muted-custom small py-2">Brak aktywnych stacji w tej chwili.</div>
            <?php else: ?>
                <?php foreach ($active_stations as $row): ?>
                    <div class="col">
                        <div class="p-2 rounded station-card">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong class="text-white"><?= htmlspecialchars($row['callsign']) ?></strong>
                                <span class="badge bg-dark border border-secondary text-light badge-mod"><?= htmlspecialchars($row['mode']) ?></span>
                            </div>
                            <div class="small text-muted-custom mt-1"><?= htmlspecialchars($row['band']) ?> / <span class="text-warning"><?= htmlspecialchars($row['freq']) ?> MHz</span></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="section-box">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3 gap-2">
            <h5 class="fw-bold text-white mb-0">Log łączności</h5>
            <div class="input-group input-group-sm" style="max-width: 300px;">
                <input type="text" id="search-input" class="form-control form-control-dark" placeholder="Szukaj swojego znaku..." aria-label="Szukaj znaku">
                <button class="btn btn-dark-custom" type="button" id="clear-search-btn">X</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-dark-custom table-sm align-middle small mb-0">
                <thead>
                    <tr>
                        <th>CALLSIGN</th>
                        <th>BAND</th>
                        <th>FREQ</th>
                        <th>MODE</th>
                        <th>RST/S</th>
                        <th>RST/R</th>
                        <th>DATE / UTC</th>
                        <th>STATION</th>
                    </tr>
                </thead>
                <tbody id="recent-qso-rows">
                    <?php if (empty($recent_qsos)): ?>
                        <tr><td colspan="8" class="text-center text-muted-custom py-3">Brak łączności w logu.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent_qsos as $qso_row): ?>
                            <tr>
                                <td><strong class="text-white"><?= htmlspecialchars($qso_row['station_called']) ?></strong></td>
                                <td><span class="text-info font-monospace fw-bold"><?= htmlspecialchars($qso_row['band']) ?></span></td>
                                <td><?= htmlspecialchars($qso_row['freq']) ?> MHz</td>
                                <td><span class="badge badge-orange badge-mod"><?= htmlspecialchars($qso_row['mode']) ?></span></td>
                                <td><?= htmlspecialchars($qso_row['rst_sent']) ?></td>
                                <td><?= htmlspecialchars($qso_row['rst_rcvd']) ?></td>
                                <td class="text-muted-custom"><?= htmlspecialchars($qso_row['qso_date'] . ' ' . $qso_row['time_on']) ?></td>
                                <td>
                                    <?php
                                    if (!empty($qso_row['station_callsign']) && $qso_row['station_callsign'] !== $qso_row['operator']) {
                                        echo htmlspecialchars($qso_row['station_callsign'] . ' (' . $qso_row['operator'] . ')');
                                    } else {
                                        echo htmlspecialchars($qso_row['operator']);
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-secondary border-opacity-10">
            <div class="small text-muted-custom" id="page-info">
                Strona 1 z <?= $total_pages ?>
            </div>
            <nav aria-label="Nawigacja stron logu">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled" id="btn-prev-container">
                        <button class="page-link" id="btn-prev" onclick="changePage(-1)">Poprzednia</button>
                    </li>
                    <li class="page-item" id="btn-next-container">
                        <button class="page-link" id="btn-next" onclick="changePage(1)">Następna</button>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="section-box mb-5">
        <h6 class="text-muted-custom text-uppercase small mb-2" style="letter-spacing: 0.5px;">Stacje przyznające punkty</h6>
        <ul class="list-inline small text-muted-custom mb-0">
            <?php foreach ($scorers as $row): ?>
                <li class="list-inline-item me-3 mb-1">
                    <span class="text-warning">•</span> <strong class="text-light"><?= htmlspecialchars($row['callsign']) ?></strong><?= $row['operator_name'] ? " <span class='text-muted-custom'>(" . htmlspecialchars($row['operator_name']) . ")</span>" : "" ?> <span class="text-success text-opacity-75">[1 pkt + mnożnik]</span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
const eventId = <?= $event_id ?>;
let currentPage = 1;
let totalPages = <?= $total_pages ?>;
let searchQuery = '';

function fetchLogData() {
    const url = `/get_qso.php?event_id=${eventId}&page=${currentPage}&search=${encodeURIComponent(searchQuery)}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) return;

            document.getElementById('stat-qso').innerText = data.qso_count;
            document.getElementById('stat-hunters').innerText = data.hunter_count;
            document.getElementById('stat-countries').innerText = data.country_count;
            updateActiveStations(data.active_stations);

            totalPages = data.total_pages;
            currentPage = data.current_page;

            document.getElementById('page-info').innerText = `Strona ${currentPage} z ${totalPages} (${data.total_rows} pozycji)`;

            document.getElementById('btn-prev-container').classList.toggle('disabled', currentPage <= 1);
            document.getElementById('btn-next-container').classList.toggle('disabled', currentPage >= totalPages);

            const recentTbody = document.getElementById('recent-qso-rows');
            if (data.recent_qsos.length === 0) {
                recentTbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted-custom py-3">Brak wyników.</td></tr>';
            } else {
                let recentHtml = '';
                data.recent_qsos.forEach(qso => {
                    // Bezpieczna obsługa formatu daty i czasu zależnie od tego, co zwraca endpoint JSON
                    let fullDate = '';
                    if (qso.time_on) {
                        fullDate = (qso.qso_date ? qso.qso_date + ' ' : '') + qso.time_on;
                    } else if (qso.time) {
                        fullDate = qso.time;
                    }

                    // Logika łączenia znaków stacji (station_callsign + operator)
                    let stationDisplay = '';
                    if (qso.station_callsign && qso.station_callsign !== qso.operator) {
                        stationDisplay = `${qso.station_callsign} (${qso.operator})`;
                    } else {
                        stationDisplay = qso.operator || qso.station_callsign || '';
                    }

                    // Pobieramy poprawną nazwę stacji wołanej (obsługa różnych wariantów kluczy z API)
                    let calledStation = qso.station_called || qso.callsign || '';

                    recentHtml += `
                        <tr>
                            <td><strong class="text-white">${escapeHtml(calledStation)}</strong></td>
                            <td><span class="text-info font-monospace fw-bold">${escapeHtml(qso.band)}</span></td>
                            <td>${escapeHtml(qso.freq)} MHz</td>
                            <td><span class="badge badge-orange badge-mod">${escapeHtml(qso.mode)}</span></td>
                            <td>${escapeHtml(qso.rst_sent || qso.rst_s || '')}</td>
                            <td>${escapeHtml(qso.rst_rcvd || qso.rst_r || '')}</td>
                            <td class="text-muted-custom">${escapeHtml(fullDate)}</td>
                            <td>${escapeHtml(stationDisplay)}</td>
                        </tr>`;
                });
                recentTbody.innerHTML = recentHtml;
            }
        }
    ).catch(err => console.error('Błąd pobierania danych:', err));
}

function updateActiveStations(stations) {
    const activeContainer = document.getElementById('active-stations-container');
    if (!stations || stations.length === 0) {
        activeContainer.innerHTML = '<div class="col-12 text-muted-custom small py-2">Brak aktywnych stacji w tej chwili.</div>';
        return;
    }
    let activeHtml = '';
    stations.forEach(st => {
        activeHtml += `
            <div class="col">
                <div class="p-2 rounded station-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="text-white">${escapeHtml(st.callsign)}</strong>
                        <span class="badge bg-dark border border-secondary text-light badge-mod">${escapeHtml(st.mode)}</span>
                    </div>
                    <div class="small text-muted-custom mt-1">${escapeHtml(st.band)} / <span class="text-warning">${escapeHtml(st.freq)} MHz</span></div>
                </div>
            </div>`;
    });
    activeContainer.innerHTML = activeHtml;
}

function changePage(direction) {
    const targetPage = currentPage + direction;
    if (targetPage >= 1 && targetPage <= totalPages) {
        currentPage = targetPage;
        fetchLogData();
    }
}

document.getElementById('search-input').addEventListener('input', function(e) {
    searchQuery = e.target.value.trim();
    currentPage = 1;
    fetchLogData();
});

document.getElementById('clear-search-btn').addEventListener('click', function() {
    const input = document.getElementById('search-input');
    if (input.value !== '') {
        input.value = '';
        searchQuery = '';
        currentPage = 1;
        fetchLogData();
    }
});

function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

//const qsoStream = new EventSource(`/stream_qso.php?event_id=${eventId}`);
const qsoStream = new EventSource(`/sub?id=${eventId}`);
qsoStream.onmessage = function(event) {
    const data = JSON.parse(event.data);
    if (data.refresh) {
        console.log('Nowe QSO wykryte w bazie. Odświeżam log i statystyki...');
        fetchLogData();
    }
};
qsoStream.onerror = function(err) {
    console.log('Strumień oczekuje na ponowne połączenie...');
};
</script>

</body>
</html>
