<?php
if ($this->session->userdata('user_data')) {
    $username = $this->session->userdata('user_data')->nome;
    $username = explode(' ', $username);
    $username = $username[0];
}

$hora = (int) date('H');
if ($hora >= 0 && $hora < 10) {
    $greeting_msg = 'Tenha um ótimo dia!';
    $greeting_icon = '<i class="ml-1 fa-duotone fa-sun-bright" style="color:#FDB813;"></i>';
} elseif ($hora >= 10 && $hora < 18) {
    $greeting_msg = 'É bom ver você por aqui!';
    $greeting_icon = '<i class="ml-1 fa-duotone fa-face-smile-hearts" style="color:#FDB813;"></i>';
} else {
    $greeting_msg = 'Tenha uma boa noite!';
    $greeting_icon = '<i class="ml-1 fa-duotone fa-house-night" style="color:#0c1445;"></i>';
}

$statusLabels = [
    'novo'           => ['label' => 'Novos',          'color' => '#17a2b8', 'icon' => 'fa-star'],
    'em_atendimento' => ['label' => 'Em Atendimento', 'color' => '#ffc107', 'icon' => 'fa-headset'],
    'convertido'     => ['label' => 'Convertidos',    'color' => '#28a745', 'icon' => 'fa-check-circle'],
    'descartado'     => ['label' => 'Descartados',    'color' => '#dc3545', 'icon' => 'fa-times-circle'],
];
?>

<!-- Greeting -->
<div class="form-head mb-4 d-flex align-items-start flex-column">
    <h4 class="font-w600 mb-0 mr-auto mb-1 text-black">Bem-vindo de volta, <?php echo ucfirst($username); ?>.</h4>
    <small class="d-block text-muted"><?php echo $greeting_msg; ?> <?php echo $greeting_icon; ?></small>
</div>

<!-- KPI Cards Row -->
<div class="row">
    <!-- Total Leads -->
    <div class="col-xl-3 col-sm-6">
        <div class="card overflow-hidden">
            <div class="card-body pb-3 pt-3">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width:55px;height:55px;border-radius:50%;background:rgba(23,162,184,0.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-users fa-lg" style="color:#17a2b8;"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted font-w500" style="font-size:13px;">Total de Leads</p>
                        <h3 class="mb-0 font-w700"><?php echo $counts->leads_total; ?></h3>
                    </div>
                </div>
                <div class="mt-2">
                    <?php if ($monthly->change > 0): ?>
                        <small class="text-success font-w600"><i class="fas fa-arrow-up mr-1"></i><?php echo $monthly->change; ?>%</small>
                    <?php elseif ($monthly->change < 0): ?>
                        <small class="text-danger font-w600"><i class="fas fa-arrow-down mr-1"></i><?php echo abs($monthly->change); ?>%</small>
                    <?php else: ?>
                        <small class="text-muted font-w600"><i class="fas fa-minus mr-1"></i>0%</small>
                    <?php endif; ?>
                    <small class="text-muted ml-1">vs mês anterior</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversão -->
    <div class="col-xl-3 col-sm-6">
        <div class="card overflow-hidden">
            <div class="card-body pb-3 pt-3">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width:55px;height:55px;border-radius:50%;background:rgba(40,167,69,0.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-chart-line fa-lg" style="color:#28a745;"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted font-w500" style="font-size:13px;">Taxa de Conversão</p>
                        <h3 class="mb-0 font-w700"><?php echo $conversion; ?>%</h3>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted"><?php echo $counts->leads_convertido; ?> de <?php echo $counts->leads_total; ?> leads</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Leads este mês -->
    <div class="col-xl-3 col-sm-6">
        <div class="card overflow-hidden">
            <div class="card-body pb-3 pt-3">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width:55px;height:55px;border-radius:50%;background:rgba(255,121,0,0.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-calendar-alt fa-lg" style="color:#FF7900;"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted font-w500" style="font-size:13px;">Leads este Mês</p>
                        <h3 class="mb-0 font-w700"><?php echo $monthly->current; ?></h3>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted"><?php echo $monthly->previous; ?> no mês anterior</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="col-xl-3 col-sm-6">
        <div class="card overflow-hidden">
            <div class="card-body pb-3 pt-3">
                <div class="d-flex align-items-center">
                    <div class="mr-3" style="width:55px;height:55px;border-radius:50%;background:rgba(111,66,193,0.12);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-layer-group fa-lg" style="color:#6f42c1;"></i>
                    </div>
                    <div>
                        <p class="mb-1 text-muted font-w500" style="font-size:13px;">Itens de Conteúdo</p>
                        <h3 class="mb-0 font-w700"><?php echo $counts->banners + $counts->seguradoras + $counts->depoimentos + $counts->faq + $counts->valores; ?></h3>
                    </div>
                </div>
                <div class="mt-2">
                    <small class="text-muted"><?php echo $counts->users; ?> usuário(s) ativo(s)</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leads by Status -->
<div class="row">
    <?php foreach ($statusLabels as $key => $info):
        $prop = 'leads_' . $key;
        $val = $counts->$prop;
        $pct = $counts->leads_total > 0 ? round(($val / $counts->leads_total) * 100) : 0;
    ?>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="font-w500" style="color:<?php echo $info['color']; ?>;">
                        <i class="fas <?php echo $info['icon']; ?> mr-1"></i>
                        <?php echo $info['label']; ?>
                    </span>
                    <span class="font-w700" style="font-size:20px;"><?php echo $val; ?></span>
                </div>
                <div class="progress" style="height:6px;">
                    <div class="progress-bar" style="width:<?php echo $pct; ?>%;background:<?php echo $info['color']; ?>;"></div>
                </div>
                <small class="text-muted mt-1 d-block"><?php echo $pct; ?>% do total</small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Charts Row -->
<div class="row">
    <!-- Leads ao longo do tempo -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-w600">Leads - Últimos 30 dias</h4>
            </div>
            <div class="card-body pt-2">
                <canvas id="leadsTimeChart" height="280"></canvas>
            </div>
        </div>
    </div>

    <!-- Leads por Status (Donut) -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-w600">Leads por Status</h4>
            </div>
            <div class="card-body pt-2">
                <canvas id="leadsStatusChart" height="280"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Second Charts Row -->
<div class="row">
    <!-- Por País -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-w600">Leads por País de Destino</h4>
            </div>
            <div class="card-body pt-2">
                <canvas id="leadsPaisChart" height="260"></canvas>
            </div>
        </div>
    </div>

    <!-- Por Modalidade -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-w600">Leads por Modalidade</h4>
            </div>
            <div class="card-body pt-2">
                <canvas id="leadsModalidadeChart" height="260"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leads + Activity -->
<div class="row">
    <!-- Últimos Leads -->
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header border-0 pb-0 d-flex justify-content-between align-items-center">
                <h4 class="card-title font-w600">Últimos Leads</h4>
                <a href="<?php echo site_url('leads'); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-columns mr-1"></i> Ver Kanban
                </a>
            </div>
            <div class="card-body pt-2">
                <?php if (empty($recentLeads)): ?>
                    <p class="text-muted text-center py-4">Nenhum lead encontrado.</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover mb-0" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentLeads as $lead): ?>
                            <tr>
                                <td class="font-w600"><?php echo htmlspecialchars($lead->nome); ?></td>
                                <td><?php echo htmlspecialchars($lead->email); ?></td>
                                <td><?php echo htmlspecialchars($lead->telefone); ?></td>
                                <td>
                                    <?php
                                    $sl = isset($statusLabels[$lead->status]) ? $statusLabels[$lead->status] : ['label' => $lead->status, 'color' => '#999'];
                                    ?>
                                    <span class="badge" style="background:<?php echo $sl['color']; ?>;color:#fff;font-size:11px;">
                                        <?php echo $sl['label']; ?>
                                    </span>
                                </td>
                                <td class="text-muted"><?php echo date('d/m/Y H:i', strtotime($lead->created_at)); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Atividade Recente -->
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-w600">Atividade Recente</h4>
            </div>
            <div class="card-body pt-2">
                <?php if (empty($recentLogs)): ?>
                    <p class="text-muted text-center py-4">Nenhuma atividade registrada.</p>
                <?php else: ?>
                <div class="widget-timeline-icon">
                    <ul class="timeline" style="list-style:none;padding-left:0;">
                        <?php foreach ($recentLogs as $log): ?>
                        <li class="d-flex mb-3">
                            <div class="mr-3" style="width:36px;height:36px;border-radius:50%;background:rgba(0,154,157,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-history" style="color:#009a9d;font-size:13px;"></i>
                            </div>
                            <div style="min-width:0;">
                                <p class="mb-0 font-w500" style="font-size:13px;">
                                    <?php echo htmlspecialchars($log->user_nome ?? 'Sistema'); ?>
                                    <span class="text-muted font-w400">
                                        <?php echo htmlspecialchars($log->description ?? $log->method); ?>
                                    </span>
                                </p>
                                <small class="text-muted">
                                    <i class="far fa-clock mr-1"></i>
                                    <?php echo date('d/m/Y H:i', strtotime($log->created_at)); ?>
                                    <?php if ($log->module): ?>
                                        <span class="badge badge-light ml-1"><?php echo htmlspecialchars($log->module); ?></span>
                                    <?php endif; ?>
                                </small>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Conteúdo Summary -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title font-w600">Resumo do Conteúdo</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <?php
                    $contentItems = [
                        ['label' => 'Banners', 'count' => $counts->banners, 'icon' => 'fa-images', 'color' => '#FF7900', 'url' => 'banners'],
                        ['label' => 'Seguradoras', 'count' => $counts->seguradoras, 'icon' => 'fa-shield-alt', 'color' => '#17a2b8', 'url' => 'seguradoras'],
                        ['label' => 'Depoimentos', 'count' => $counts->depoimentos, 'icon' => 'fa-quote-right', 'color' => '#28a745', 'url' => 'depoimentos'],
                        ['label' => 'FAQ', 'count' => $counts->faq, 'icon' => 'fa-question-circle', 'color' => '#6f42c1', 'url' => 'faq'],
                        ['label' => 'Valores', 'count' => $counts->valores, 'icon' => 'fa-tags', 'color' => '#fd7e14', 'url' => 'valores'],
                    ];
                    foreach ($contentItems as $item):
                    ?>
                    <div class="col">
                        <a href="<?php echo site_url($item['url']); ?>" class="text-decoration-none">
                            <div class="py-3">
                                <div class="mb-2" style="width:50px;height:50px;border-radius:50%;background:<?php echo $item['color']; ?>15;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="fas <?php echo $item['icon']; ?> fa-lg" style="color:<?php echo $item['color']; ?>;"></i>
                                </div>
                                <h3 class="font-w700 mb-0"><?php echo $item['count']; ?></h3>
                                <p class="text-muted mb-0" style="font-size:13px;"><?php echo $item['label']; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    var colors = {
        primary: '#FF7900',
        info: '#17a2b8',
        success: '#28a745',
        warning: '#ffc107',
        danger: '#dc3545',
        purple: '#6f42c1',
        teal: '#009a9d'
    };

    // ========================
    // Leads Timeline Chart
    // ========================
    var timeLabels = <?php echo json_encode(array_map(function($d){ return date('d/m', strtotime($d)); }, array_keys($leadsChart))); ?>;
    var timeData   = <?php echo json_encode(array_values($leadsChart)); ?>;

    new Chart(document.getElementById('leadsTimeChart'), {
        type: 'line',
        data: {
            labels: timeLabels,
            datasets: [{
                label: 'Leads',
                data: timeData,
                borderColor: colors.primary,
                backgroundColor: 'rgba(255,121,0,0.08)',
                borderWidth: 2.5,
                pointRadius: 3,
                pointBackgroundColor: colors.primary,
                tension: 0.35,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { maxTicksLimit: 10, font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,0.04)' }
                }
            }
        }
    });

    // ========================
    // Leads by Status (Donut)
    // ========================
    new Chart(document.getElementById('leadsStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Novos', 'Em Atendimento', 'Convertidos', 'Descartados'],
            datasets: [{
                data: [
                    <?php echo $counts->leads_novo; ?>,
                    <?php echo $counts->leads_em_atendimento; ?>,
                    <?php echo $counts->leads_convertido; ?>,
                    <?php echo $counts->leads_descartado; ?>
                ],
                backgroundColor: [colors.info, colors.warning, colors.success, colors.danger],
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15, usePointStyle: true, pointStyle: 'circle', font: { size: 12 } }
                }
            }
        }
    });

    // ========================
    // Leads by Country (Bar)
    // ========================
    var paisLabels = <?php echo json_encode(array_column($byPais, 'pais')); ?>;
    var paisData   = <?php echo json_encode(array_map('intval', array_column($byPais, 'total'))); ?>;
    var paisColors = [colors.info, colors.primary, colors.success, colors.warning, colors.purple, colors.danger, colors.teal, '#e83e8c', '#fd7e14', '#20c997'];

    new Chart(document.getElementById('leadsPaisChart'), {
        type: 'bar',
        data: {
            labels: paisLabels,
            datasets: [{
                label: 'Leads',
                data: paisData,
                backgroundColor: paisColors.slice(0, paisLabels.length),
                borderRadius: 6,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                y: { grid: { display: false }, ticks: { font: { size: 12 } } }
            }
        }
    });

    // ========================
    // Leads by Modality (Bar)
    // ========================
    var modLabels = <?php echo json_encode(array_column($byModalidade, 'modalidade')); ?>;
    var modData   = <?php echo json_encode(array_map('intval', array_column($byModalidade, 'total'))); ?>;

    new Chart(document.getElementById('leadsModalidadeChart'), {
        type: 'bar',
        data: {
            labels: modLabels,
            datasets: [{
                label: 'Leads',
                data: modData,
                backgroundColor: paisColors.slice(0, modLabels.length),
                borderRadius: 6,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                y: { grid: { display: false }, ticks: { font: { size: 12 } } }
            }
        }
    });
});
</script>