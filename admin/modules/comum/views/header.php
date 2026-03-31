<div class="nav-header">
    <a href="<?php echo site_url('/home'); ?>" class="brand-logo">
        <img src="<?php echo base_img('logo-color.png'); ?>" height="50">

    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <!-- <div class="text-white">
                        <small class="d-block">Bem-vindo a</small>
                        <strong></strong>
                    </div> -->
                </div>
                <ul class="navbar-nav header-right main-notification">
                    <li class="nav-item dropdown header-profile">
                        <?php
                        if ($this->session->userdata('user_data')) {
                            $usergroup = $this->session->userdata('user_data')->grupo;
                            $username = $this->session->userdata('user_data')->nome;
                            $photo = $this->session->userdata('user_data')->image;
                            $username = explode(' ', $username);
                            $username = $username[0];
                        }
                        ?>

                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <?php if ($photo) { ?>
                                <img src="/userfiles/administration/users/<?php echo $photo; ?>" class="rounded" width="20" height="20">
                            <?php } else { ?>
                                <img src="<?php echo base_img('placeholder-user.jpg'); ?>" class="rounded" width="20" height="20">
                            <?php }  ?>
                            <div class="header-info">
                                <span><?php echo $username ?></span>
                                <small>Minha Conta</small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="<?php echo site_url('meu-perfil'); ?>" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span class="ml-2">Meu Perfil </span>
                            </a>
                            <a href="<?php echo site_url('logout'); ?>" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span class="ml-2">Sair </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <?php if (isset($projeto) && $projeto) { ?>
            <div class="sub-header justify-content-between flex-wrap mr-auto">
                <h5 class="dashboard_bar">
                    <?php echo T_('TAREFAS - '); ?>
                    <?php echo $projeto->titulo . ' | ' ?>
                    <?php echo $projeto->nome_cliente ?>
                </h5>
                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#add-task" id="add-new-task">
                    <i class="fa fa-plus"></i>&nbsp;
                    <?php echo T_('Tarefa'); ?>
                </button>
            </div>
        <?php } else { ?>
            <div class="sub-header">
                <div class="d-flex align-items-center flex-wrap mr-auto">
                    <h5 class="dashboard_bar"><?php echo $current_module->name ?></h5>
                </div>
                <?php if (isset($breadcrumb)) { ?>
                    <div class="d-flex align-items-center">
                        <?php echo $breadcrumb; ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>