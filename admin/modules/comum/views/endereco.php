
<div class="form-row">
    <div class="form-group col-md-3 col-12">
        <label for="inputCEP"><?php echo T_('CEP'); ?></label>
        <input type="text" class="form-control" id="inputCEP" placeholder="<?php echo T_('CEP'); ?>" value="<?php echo isset($item) ? formatarCEP($item->zipcode) : ''; ?>" required name="zipcode" data-fmask="cep"/>
    </div>
    <div class="form-group col-md-9 col-12">
        <label for="inputEndereco"><?php echo T_('Endereço'); ?></label>
        <input type="text" class="form-control" id="inputEndereco" placeholder="<?php echo T_('Endereço'); ?>" value="<?php echo isset($item) ? $item->address : ''; ?>" required maxlenght="255" name="address"/>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-2 col-12">
        <label for="inputNumero"><?php echo T_('Número'); ?></label>
        <input type="text" class="form-control" id="inputNumero" placeholder="<?php echo T_('Número'); ?>" value="<?php echo isset($item) ? $item->number : ''; ?>" required maxlenght="255" name="number"/>
    </div>
    <div class="form-group col-md-10 col-12">
        <label for="inputComplemento"><?php echo T_('Complemento'); ?></label>
        <input type="text" class="form-control" id="inputComplemento" placeholder="<?php echo T_('Complemento'); ?>" value="<?php echo isset($item) ? $item->complement : ''; ?>" name="complement"/>
    </div>
</div>

<div class="form-row">
     <div class="form-group col-md-4 col-12">
        <label for="inputBairro"><?php echo T_('Bairro'); ?></label>
        <input type="text" class="form-control" id="inputBairro" placeholder="<?php echo T_('Bairro'); ?>" value="<?php echo isset($item) ? $item->district : ''; ?>" required maxlenght="255" name="district"/>
    </div>
    <div class="form-group col-md-6 col-12">
        <label for="inputCidade"><?php echo T_('Cidade'); ?></label>
        <input type="text" class="form-control" id="inputCidade" placeholder="<?php echo T_('Cidade'); ?>" value="<?php echo isset($item) ? $item->city : ''; ?>" required maxlenght="255" name="city"/>
    </div>
    <div class="form-group col-md-2 col-12">
        <label for="inputEstado"><?php echo T_('Estado'); ?></label>
        <input type="text" class="form-control" id="inputEstado" placeholder="<?php echo T_('Estado'); ?>" value="<?php echo isset($item) ? $item->state : ''; ?>" required maxlenght="2" name="state"/>
    </div>
</div>
