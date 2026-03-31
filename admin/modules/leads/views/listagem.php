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
                                    <th><?php echo T_('Nome'); ?></th>
                                    <th><?php echo T_('E-mail'); ?></th>
                                    <th><?php echo T_('Telefone'); ?></th>
                                    <th><?php echo T_('Modalidade'); ?></th>
                                    <th><?php echo T_('País'); ?></th>
                                    <th><?php echo T_('Status'); ?></th>
                                    <th><?php echo T_('Data'); ?></th>
                                    <th class='text-right'><?php echo T_('Ações'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $key => $item){ ?>
                                <tr data-id='<?php echo $item->id; ?>'>
                                    <td class='text-middle'><?php echo $item->id; ?></td>
                                    <td class='text-middle'><?php echo $item->nome; ?></td>
                                    <td class='text-middle'><?php echo $item->email; ?></td>
                                    <td class='text-middle'><?php echo $item->telefone; ?></td>
                                    <td class='text-middle'><?php echo $item->modalidade_bolsa; ?></td>
                                    <td class='text-middle'><?php echo $item->pais_destino; ?></td>
                                    <td class='text-middle'>
                                        <?php
                                        $statusColors = [
                                            'novo' => 'badge-info',
                                            'em_atendimento' => 'badge-warning',
                                            'convertido' => 'badge-success',
                                            'descartado' => 'badge-danger',
                                        ];
                                        $statusLabels = [
                                            'novo' => 'Novo',
                                            'em_atendimento' => 'Em Atendimento',
                                            'convertido' => 'Convertido',
                                            'descartado' => 'Descartado',
                                        ];
                                        $badge = isset($statusColors[$item->status]) ? $statusColors[$item->status] : 'badge-secondary';
                                        $label = isset($statusLabels[$item->status]) ? $statusLabels[$item->status] : $item->status;
                                        ?>
                                        <span class="badge <?php echo $badge; ?>"><?php echo $label; ?></span>
                                    </td>
                                    <td class='text-middle'><?php echo date('d/m/Y H:i', strtotime($item->created_at)); ?></td>
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
