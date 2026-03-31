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
                                    <th><?php echo T_('Chave'); ?></th>
                                    <th><?php echo T_('Título'); ?></th>
                                    <th><?php echo T_('Valor'); ?></th>
                                    <th><?php echo T_('Tipo'); ?></th>
                                    <th><?php echo T_('Grupo'); ?></th>
                                    <th class='text-right'><?php echo T_('Ações'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $key => $item){ ?>
                                <tr data-id='<?php echo $item->id; ?>'>
                                    <td class='text-middle'><?php echo $item->id; ?></td>
                                    <td class='text-middle'><code><?php echo $item->chave; ?></code></td>
                                    <td class='text-middle'><?php echo $item->titulo; ?></td>
                                    <td class='text-middle'><?php echo mb_strimwidth(strip_tags($item->valor), 0, 80, '...'); ?></td>
                                    <td class='text-middle'><span class="badge badge-light"><?php echo $item->tipo; ?></span></td>
                                    <td class='text-middle'><?php echo $item->grupo; ?></td>
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
