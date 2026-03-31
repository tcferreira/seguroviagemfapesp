<div class="deznav">
    <div class="deznav-scroll">
        <?php
        if($this->session->userdata('user_data')){
            $usergroup = $this->session->userdata('user_data')->grupo;
            $username = $this->session->userdata('user_data')->nome;
            $photo = $this->session->userdata('user_data')->image;
            $email = $this->session->userdata('user_data')->email;
            $username = explode(' ', $username);
            $username = $username[0];
        }
        ?>

        <div class="main-profile">
            <div class="image-bx">
                <?php if($photo) { ?>
                    <img src="/userfiles/administration/users/<?php echo $photo; ?>" class="rounded" width="20" height="20" />
                <?php } else { ?>
                    <img src="<?php echo base_img('placeholder-user.jpg'); ?>" class="rounded" width="20" height="20">
                <?php }  ?>
                <a href="<?php echo site_url('meu-perfil'); ?>" title="Meu Perfil" class="has-tooltip">
                    <i class="fa-regular fa-user" style="color: #009a9d;"></i>
                </a>
            </div>
            <h5 class="name"><span class="font-w400">Olá,</span> <?php echo $username ?></h5>
            <p class="email"><?php echo $email; ?></p>
        </div>

        <ul class="metismenu" id="menu">
            <?php echo $sidebar_menu; ?>
        </ul>

        <div class="copyright">
            <p><strong>FCode.com.br</strong><br> © 2026 Todos os direitos reservados</p>
        </div>
    </div>
</div>