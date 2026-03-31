<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

function notFound(string $message = NULL): void
{
    $messageTranslate = ($message) ? T_($message) : T_('Nenhum registro encontrado para os filtros selecionados.');
    echo "<div class='row'>
        <div class='col-12 text-truncate text-center font-weight-light p-5'>
            $messageTranslate
        </div>
    </div>";
}

function statusField($item)
{
    $label = T_('Status');
    echo "<div class='form-row'>
        <div class='form-group col-md-6'>
            <label for='inputStatus'>$label</label>
            <div class='d-block'>";
                if ( !isset($item) || $item->status == 1 ){
                    echo "<input type='checkbox'
                        data-toggle='switch'
                        name='status'
                        id='inputStatus'
                        value='1'
                        checked/>";
                } else {
                    echo "<input type='checkbox'
                        data-toggle='switch'
                        name='status'
                        value='1'
                        id='inputStatus'/>";
                }
        echo "</div>
        </div>
    </div>";
}