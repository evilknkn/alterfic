<div class="sidebar" id="sidebar">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="icon-signal"></i>
            </button>

            <button class="btn btn-info">
                <i class="icon-pencil"></i>
            </button>

            <button class="btn btn-warning">
                <i class="icon-group"></i>
            </button>

            <button class="btn btn-danger">
                <i class="icon-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- #sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li>
            <a href="<?=base_url('admin/dashboard')?>">
                <i class="icon-home"></i>
                <span class="menu-text"> Inicio </span>
            </a>
        </li>
        <?php if($this->session->userdata('consulta') == 'active'): ?>
            <?php if($this->session->userdata('ID_PERFIL') == 5 or $this->session->userdata('ID_PERFIL') == 6): ?>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-dollar "></i>
                        <span class="menu-text"> Cuentas </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="<?=base_url('cuentas/pendiente_retorno/pendiente_retorno_general')?>">
                                <i class="icon-double-angle-right"></i>
                                Pendientes de retorno
                            </a>
                        </li>
                    </ul>
                </li>
            <?php endif;?>

            <?php if($this->session->userdata('ID_PERFIL') == 3): ?>
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-dollar "></i>
                        <span class="menu-text"> Cuentas </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                       <li>
                            <a href="<?=base_url('cuentas/depositos')?>">
                                <i class="icon-double-angle-right"></i>
                                Depósitos empresas
                            </a>
                        </li>
                    </ul>
                </li>

            <?php endif;?>


            <?php if($this->session->userdata('ID_PERFIL') == 6 or $this->session->userdata('ID_PERFIL') == 5 or $this->session->userdata('ID_PERFIL') == 7): ?>
                <li>
                    <a href="<?=base_url('catalogos/banks')?>">
                        <i class="icon-credit-card"></i>
                        <span class="menu-text"> Lista de bancos </span>
                    </a>
                </li>

                 <li>
                    <a href="<?=base_url('catalogos/corps')?>">
                        <i class="fa fa-institution bigger-140"></i>
                        <span class="menu-text"> Lista de empresas </span>
                    </a>
                </li>

                <li>
                    <a href="<?=base_url('users/clientes')?>">
                        <i class="icon-list "></i>
                        <span class="menu-text"> Clientes </span>
                    </a>
                </li>
                    <?php if($this->session->userdata('ID_PERFIL') == 1000006 or $this->session->userdata('ID_PERFIL') == 100000005): ?>
                        <li>
                           <a href="#" class="dropdown-toggle">
                                <i class="icon-folder-open "></i>
                                <span class="menu-text"> Solicitudes </span>

                                <b class="arrow icon-angle-down"></b>
                            </a> 
                            <ul class="submenu">
                                <li>
                                    <a href="<?=base_url('cuentas/formato_retorno/getClientes')?>">
                                        <i class="icon-double-angle-right"></i>
                                        Formato de retorno
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
              
                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-dollar "></i>
                        <span class="menu-text"> Cuentas </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li>
                            <a href="<?=base_url('cuentas/depositos')?>">
                                <i class="icon-double-angle-right"></i>
                                Depósitos empresas
                            </a>
                        </li>

                        <li>
                            <a href="<?=base_url('cuentas/pendiente_retorno')?>">
                                <i class="icon-double-angle-right"></i>
                                Pendientes de retorno
                            </a>
                        </li>
                        <?php if($this->session->userdata('ID_PERFIL') == 5 or $this->session->userdata('ID_PERFIL') == 6):?>
                            <li>
                                <a href="<?=base_url('cuentas/comisiones')?>">
                                    <i class="icon-double-angle-right"></i>
                                    Comisiones
                                </a>
                            </li>

                            <li>
                                <a href="<?=base_url('cuentas/comisiones/clientes_pagos')?>">
                                    <i class="icon-double-angle-right"></i>
                                    <span class="menu-text"> Clientes lista de pagos </span>
                                </a>
                            </li>

                            <li>
                                <a href="<?=base_url('cuentas/gastos')?>">
                                    <i class="icon-double-angle-right"></i>
                                    Gastos
                                </a>
                            </li>
                        <?php endif;?>
                        <!-- <li>
                            <a href="<?=base_url('cuentas/caja_chica')?>">
                                <i class="icon-double-angle-right"></i>
                                Caja Chica
                            </a>
                        </li> -->

                        


                        <!-- <li>
                            <a href="<?=base_url('cuentas/gastos_camion')?>">
                                <i class="icon-double-angle-right"></i>
                                Gastos camión
                            </a>
                        </li> -->
                    </ul>
                </li>

                <li>
                    <a href="#" class="dropdown-toggle">
                        <i class="icon-dollar "></i>
                        <span class="menu-text"> Apartados </span>

                        <b class="arrow icon-angle-down"></b>
                    </a>

                    <ul class="submenu">
                        <li><a href="<?=base_url('apartado/depositos/general')?>">General</a></li>
                        <li><a href="<?=base_url('apartado/depositos/pendiente_asignar')?>">Pendiente de asignar</a></li>
                        <li><a href="<?=base_url('apartado/depositos/pendiente_retorno')?>">Asignados pendientes de retorno </a></li>
                        <li><a href="<?=base_url('apartado/depositos/pagados')?>">Pagado</a></li>
                        
                    </ul>
                </li>
               
                 <!-- <li>
                    <a href="<?=base_url('cuentas/deposito_persona')?>">
                        <i class="icon-user"></i>
                        <span class="menu-text"> Depósitos persona </span>
                    </a>
                </li> -->
                <?php if($this->session->userdata('ID_PERFIL') == 5 or $this->session->userdata('ID_PERFIL') == 6):?>
                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-group"></i>
                            <span class="menu-text"> Usuarios </span>

                            <b class="arrow icon-angle-down"></b>
                        </a>

                        <ul class="submenu">
                            <li>
                                <a href="<?=base_url('users/admin_users/list_admin/1')?>">
                                    <i class="icon-double-angle-right"></i>
                                    Administradores
                                </a>
                            </li>

                          
                        </ul>
                    </li>
                <?php endif; // fin  filtro users ?>    
            <?php endif;?>
        <?php endif;?>
    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>