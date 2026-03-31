<div class="col-12 card-no-border">
    <?php $this->load->view('comum/busca'); ?>

    <div class="card">
        <div class="card-header border-0 pb-0">
            <div>
                <h4 class="mb-0 text-black fs-20">
                Listagem
                </h4>
                <span class="card-subtitle text-muted mb-2">
                    Faça uma busca, visualize os dados e manipule as informações.
                </span>
            </div>
        </div>
        <div class="card-body p-3 pb-0">
            <?php if ($items){ ?>
                <div class="table-responsive">
                    <table class="table color-table info-table">
                        <thead>
                            <tr>
                                <th width="20">#</th>
                                <th><?php echo T_('Nome'); ?></th>
                                <th><?php echo T_('E-mail'); ?></th>
                                <th class="text-center"><?php echo T_('Status'); ?></th>
                                <th class="text-right"><?php echo T_('Ações'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $key => $item){ ?>
                            <?php if ($this->auth->data('id') != 1 && $item->id == 1) { ?>
                                <!-- Faz nada não -->
                            <?php } else { ?>
                                <tr data-id="<?php echo $item->id; ?>">
                                    <td class="text-middle" data-title="#"><?php echo $item->id; ?></td>
                                    <td class="text-middle" data-title="<?php echo T_('Nome'); ?>"><?php echo $item->nome; ?></td>
                                    <td class="text-middle" data-title="<?php echo T_('E-mail'); ?>"><?php echo $item->email; ?></td>
                                    <td class='text-center' data-title="<?php echo T_('Status'); ?>">
                                        <?php echo statusLabel($item->status, $item->id); ?>
                                    </td>
                                    <td class='text-right' data-title="<?php echo T_('Ações'); ?>">
                                        <?php echo editButton($item->id);  ?>
                                        <?php echo deleteButton($item->id); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php echo $paginacao; ?>
            <?php }else{ ?>
                <div class="row">
                    <div class="col-12 text-truncate text-center font-weight-light p-5">
                        <?php echo T_('Nenhum usuário encontrado.'); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>