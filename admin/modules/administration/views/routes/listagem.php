<div class="col-12 card-no-border">
    <?php $this->load->view('comum/busca'); ?>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Listagem</h4>
            <h6 class="card-subtitle mb-2">Faça uma busca, visualize os dados e manipule as informações.</h6>

            <?php if ($items){ ?>
                <div class="table-responsive">
                    <table class="table color-table info-table">
                        <thead>
                            <tr>
                                <th width="20">#</th>
                                <th><?php echo T_('Nome'); ?></th>
                                <th class="text-center"><?php echo T_('Status'); ?></th>
                                <th class="text-right"><?php echo T_('Ações'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $key => $item){ ?>
                            <tr data-id="<?php echo $item->id; ?>">
                                <td class="text-middle" data-title="#"><?php echo $item->id; ?></td>
                                <td class="text-middle" data-title="<?php echo T_('Nome'); ?>"><?php echo $item->label; ?></td>
                                <td class='text-center' data-title="<?php echo T_('Status'); ?>">
                                    <?php echo statusLabel($item->status, $item->id); ?>
                                </td>
                                <td class='text-right' data-title="<?php echo T_('Ações'); ?>">
                                    <?php echo editButton($item->id);  ?>
                                    <?php echo deleteButton($item->id); ?>
                                </td>
                            </tr>
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