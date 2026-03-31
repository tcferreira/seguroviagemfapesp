<div class="d-flex justify-content-center align-items-center h-100" id="postLoad">
    <div class="container px-4 mx-auto">
        <div class="card0">
            <div class="d-flex flex-lg-row flex-column-reverse">
                <div class="card-login card1">
                    <div class="row justify-content-center my-auto">
                        <div class="col-md-10 col-12 mb-5">
                            <div class="row justify-content-center px-3 mb-3">
                                <img class="mb-4" src="<?php echo base_img('logo-color.png'); ?>" alt="" height="100" id="logo">
                            </div>


                            <form class="form-signin no-ajax" id="loginform">
                                <div class="form-group">
                                    <label class="mb-1"><?php echo T_('Seu e-mail'); ?></label>
                                    <input type="email" id="inputEmail" name="username" class="form-control" placeholder="Digite seu e-mail" required autofocus>
                                </div>
                                <div class="form-group mb-1">
                                    <label class="mb-1"><?php echo T_('Sua Senha'); ?></label>
                                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Digite sua senha" required>
                                </div>
                                <!-- csrf -->
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <!-- <div class="form-row d-flex justify-content-end">
                                    <div class="form-group">
                                        <a href="<?php echo site_url('esqueci') ?>"><?php echo T_('Esqueci minha senha'); ?></a>
                                    </div>
                                </div> -->
                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-primary btn-block"><?php echo T_('Entrar'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>