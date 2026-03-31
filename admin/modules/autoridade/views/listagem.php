<div class='row'>
    <div class='col-12 card-no-border'>
        <?php $this->load->view('comum/busca'); ?>

        <div class='card'>
            <div class='card-body'>
                <?php if ($items){ ?>
                    <div class='table-responsive'>
                        <table class='table color-table info-table'>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo T_('Número'); ?></th>
                                    <th><?php echo T_('Label'); ?></th>
                                    <th><?php echo T_('Ícone'); ?></th>
                                    <th class='text-center'><?php echo T_('Status'); ?></th>
                                    <th class='text-right'><?php echo T_('Ações'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $key => $item){ ?>
                                <tr data-id='<?php echo $item->id; ?>'>
                                    <td class='text-middle'><?php echo $item->id; ?></td>
                                    <td class='text-middle'><strong><?php echo $item->numero; ?></strong></td>
                                    <td class='text-middle'><?php echo $item->label; ?></td>
                                    <td class='text-middle'><i class="fas <?php echo $item->icone; ?>"></i> <?php echo $item->icone; ?></td>
                                    <td class='text-center'>
                                        <?php echo statusLabel($item->status, $item->id); ?>
                                    </td>
                                    <td class='text-right' nowrap>
                                        <?php echo editButton($item->id);  ?>
                                        <?php echo deleteButton($item->id); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo $paginacao; ?>
                <?php } else {
                    notFound();
                } ?>
            </div>
        </div>
    </div>
</div>
