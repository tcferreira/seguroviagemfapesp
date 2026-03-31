<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <span class="text-muted"><?php echo $total; ?> lead(s) no total</span>
            </div>
            <div>
                <?php if (isset($session_permissions) && is_array($session_permissions) && isset($session_permissions[$current_module->id]) && is_array($session_permissions[$current_module->id]) && in_array('cadastrar', $session_permissions[$current_module->id])){ ?>
                    <a class="btn btn-primary" href="<?php echo site_url($current_module->slug.'/cadastrar'); ?>" role="button" title="<?php echo T_('Insira um novo registro'); ?>">
                        <i class="fa-light fa-plus mr-2"></i> <?php echo T_('Cadastrar'); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="kanban-board" id="kanbanBoard">
    <?php foreach ($columns as $statusKey => $col): ?>
    <div class="kanban-column" data-status="<?php echo $statusKey; ?>">
        <div class="kanban-column-header" style="border-top: 3px solid <?php echo $col['color']; ?>;">
            <span class="kanban-column-title">
                <i class="<?php echo $col['icon']; ?> mr-1" style="color:<?php echo $col['color']; ?>;"></i>
                <?php echo $col['label']; ?>
            </span>
            <span class="badge badge-pill" style="background:<?php echo $col['color']; ?>;color:#fff;">
                <?php echo count($col['items']); ?>
            </span>
        </div>
        <div class="kanban-column-body" data-status="<?php echo $statusKey; ?>">
            <?php if (empty($col['items'])): ?>
                <div class="kanban-empty">Nenhum lead</div>
            <?php endif; ?>
            <?php foreach ($col['items'] as $lead): ?>
            <div class="kanban-card" data-id="<?php echo $lead->id; ?>">
                <div class="kanban-card-header">
                    <strong class="kanban-card-name"><?php echo htmlspecialchars($lead->nome); ?></strong>
                    <a href="<?php echo site_url('leads/editar/'.$lead->id); ?>" class="kanban-card-edit" title="Editar">
                        <i class="fas fa-pen fa-sm"></i>
                    </a>
                </div>
                <?php if ($lead->email): ?>
                <div class="kanban-card-info">
                    <i class="fas fa-envelope fa-sm text-muted mr-1"></i>
                    <span><?php echo htmlspecialchars($lead->email); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($lead->telefone): ?>
                <div class="kanban-card-info">
                    <i class="fas fa-phone fa-sm text-muted mr-1"></i>
                    <span><?php echo htmlspecialchars($lead->telefone); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($lead->modalidade_bolsa): ?>
                <div class="kanban-card-info">
                    <i class="fas fa-graduation-cap fa-sm text-muted mr-1"></i>
                    <span><?php echo htmlspecialchars($lead->modalidade_bolsa); ?></span>
                </div>
                <?php endif; ?>
                <?php if ($lead->pais_destino): ?>
                <div class="kanban-card-info">
                    <i class="fas fa-globe-americas fa-sm text-muted mr-1"></i>
                    <span><?php echo htmlspecialchars($lead->pais_destino); ?></span>
                </div>
                <?php endif; ?>
                <div class="kanban-card-footer">
                    <small class="text-muted">
                        <i class="fas fa-clock mr-1"></i>
                        <?php echo date('d/m/Y H:i', strtotime($lead->created_at)); ?>
                    </small>
                    <?php if ($lead->origem): ?>
                    <small class="badge badge-light"><?php echo htmlspecialchars($lead->origem); ?></small>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
.kanban-board {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 16px;
    min-height: 70vh;
    align-items: flex-start;
}
.kanban-column {
    flex: 1;
    min-width: 280px;
    max-width: 340px;
    background: #f4f6f9;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
}
.kanban-column-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px 10px;
    border-radius: 10px 10px 0 0;
    background: #fff;
}
.kanban-column-title {
    font-weight: 600;
    font-size: 14px;
    color: #333;
}
.kanban-column-body {
    padding: 10px;
    flex: 1;
    min-height: 100px;
    transition: background 0.2s;
    border-radius: 0 0 10px 10px;
}
.kanban-column-body.drag-over,
.kanban-column-body.drag-active {
    background: rgba(0,154,157,0.08);
}
.kanban-empty {
    text-align: center;
    color: #adb5bd;
    font-size: 13px;
    padding: 30px 10px;
    font-style: italic;
}
.kanban-card {
    background: #fff;
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    cursor: grab;
    transition: box-shadow 0.2s, transform 0.15s, opacity 0.2s;
    border-left: 3px solid transparent;
}
.kanban-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transform: translateY(-1px);
}
.kanban-card-ghost {
    opacity: 0.4;
    background: #e3f2fd;
    border-left: 3px solid #009a9d;
}
.kanban-card-chosen {
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}
.kanban-card-drag {
    opacity: 0;
}
.kanban-card-fallback {
    opacity: 0.9 !important;
    transform: rotate(2deg);
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
}
.drag-active {
    background: rgba(0,154,157,0.04);
    min-height: 120px;
}
.kanban-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
}
.kanban-card-name {
    font-size: 14px;
    color: #222;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 85%;
}
.kanban-card-edit {
    color: #adb5bd;
    transition: color 0.2s;
}
.kanban-card-edit:hover {
    color: #009a9d;
    text-decoration: none;
}
.kanban-card-info {
    font-size: 12px;
    color: #666;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.kanban-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
    padding-top: 6px;
    border-top: 1px solid #f0f0f0;
}

/* Responsive */
@media (max-width: 991px) {
    .kanban-board {
        flex-direction: column;
    }
    .kanban-column {
        max-width: 100%;
        min-width: 100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var csrfName  = '<?php echo $this->security->get_csrf_token_name(); ?>';
    var csrfHash  = '<?php echo $this->security->get_csrf_hash(); ?>';
    var updateUrl = '<?php echo site_url("leads/update-status"); ?>';

    // Initialize SortableJS on each column
    document.querySelectorAll('.kanban-column-body').forEach(function(col) {
        new Sortable(col, {
            group: 'kanban',
            animation: 200,
            ghostClass: 'kanban-card-ghost',
            chosenClass: 'kanban-card-chosen',
            dragClass: 'kanban-card-drag',
            draggable: '.kanban-card',
            filter: '.kanban-empty, .kanban-card-edit',
            preventOnFilter: false,
            forceFallback: true,
            fallbackClass: 'kanban-card-fallback',
            fallbackOnBody: true,
            onStart: function() {
                document.querySelectorAll('.kanban-column-body').forEach(function(c) {
                    c.classList.add('drag-active');
                });
            },
            onEnd: function(evt) {
                document.querySelectorAll('.kanban-column-body').forEach(function(c) {
                    c.classList.remove('drag-active');
                });

                var leadId    = evt.item.dataset.id;
                var newStatus = evt.to.dataset.status;

                // Remove empty message from target
                var empty = evt.to.querySelector('.kanban-empty');
                if (empty) empty.remove();

                // Update badge counts
                updateBadgeCounts();

                // AJAX update
                var formData = new FormData();
                formData.append('id', leadId);
                formData.append('status', newStatus);
                formData.append(csrfName, csrfHash);

                fetch(updateUrl, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (data.success) {
                        if (data.csrf_hash) csrfHash = data.csrf_hash;
                        var colTitle = evt.to.closest('.kanban-column').querySelector('.kanban-column-title').textContent.trim();
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Lead movido para <strong>' + colTitle + '</strong>');
                        }
                    } else {
                        // Revert: move card back to original column
                        if (evt.from !== evt.to) {
                            evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex] || null);
                        }
                        updateBadgeCounts();
                        if (typeof toastr !== 'undefined') {
                            toastr.error(data.message || 'Erro ao atualizar status.');
                        }
                    }
                })
                .catch(function() {
                    // Revert on error
                    if (evt.from !== evt.to) {
                        evt.from.insertBefore(evt.item, evt.from.children[evt.oldIndex] || null);
                    }
                    updateBadgeCounts();
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Erro de conexão.');
                    }
                });
            }
        });
    });

    function updateBadgeCounts() {
        document.querySelectorAll('.kanban-column').forEach(function(col) {
            var body  = col.querySelector('.kanban-column-body');
            var badge = col.querySelector('.badge-pill');
            var count = body.querySelectorAll('.kanban-card').length;
            badge.textContent = count;

            var empty = body.querySelector('.kanban-empty');
            if (count === 0 && !empty) {
                var div = document.createElement('div');
                div.className = 'kanban-empty';
                div.textContent = 'Nenhum lead';
                body.appendChild(div);
            } else if (count > 0 && empty) {
                empty.remove();
            }
        });
    }
});
</script>
