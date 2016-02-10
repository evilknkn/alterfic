<ul class="list-unstyled side-menu">
    <li>
        <a class="" href="<?=base_url('admin/dashboard')?>">
            <i class="glyphicon glyphicon-home fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Inicio</span>
        </a>
    </li>

    <li>
        <a class="" href="<?=base_url('catalogos/banks')?>">
            <i class="fa fa-credit-card fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Lista de bancos</span>
        </a>
    </li>

    <li>
        <a class="" href="<?=base_url('catalogos/corps')?>">
            <i class="fa fa-university  fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Lista de empresas</span>
        </a>
    </li>  

     <li>
        <a class="" href="<?=base_url('users/clientes')?>">
            <i class="fa fa-list-alt fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Clientes</span>
        </a>
    </li>

    <li class="dropdown">
         <a class="" >
            <i class="fa fa-dollar fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Cuentas</span>
        </a>
        <ul class="list-unstyled menu-item">
            <li>&nbsp;</li>
            <li><a href="<?=base_url('cuentas/depositos')?>">Depósitos empresas</a></li>
            <li><a href="<?=base_url('cuentas/pendiente_retorno')?>">Pendiente de retorno</a></li>
            <li><a href="<?=base_url('cuentas/comisiones')?>">Comisiones</a></li>
            
            <li><a href="<?=base_url('cuentas/gastos')?>">Gastos</a></li>
            <li><a href="<?=base_url('cuentas/caja_chica')?>">Caja chica</a></li>
            <!--<li><a href="form-components.html">Form Components</a></li>-->
        </ul>
    </li>

    <li class="dropdown">
         <a class="" >
            <i class="fa fa-dollar fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Apartados</span>
        </a>
        <ul class="list-unstyled menu-item">
            <li>&nbsp;</li>
            <li><a href="<?=base_url('apartado/depositos/general')?>">Genera-l</a></li>
            <li><a href="<?=base_url('apartado/depositos/pendiente_asignar')?>">Pendiente de asignar</a></li>
            <li><a href="<?=base_url('apartado/depositos/pendiente_retorno')?>">Asignados pendientes de retorno </a></li>
            <li><a href="<?=base_url('apartado/depositos/pagados')?>">Pagado</a></li>
        </ul>
    </li>

    <li>
        <a class="" href="<?=base_url('cuentas/deposito_persona')?>">
            <i class="fa fa-user fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Depòsitos persona</span>
        </a>
    </li>

    <li class="dropdown">
        <a class="" >
            <i class="fa fa-group fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Usuarios</span>
        </a>
        <ul class="list-unstyled menu-item">
            <li>&nbsp;</li>
            <li><a href="<?=base_url('users/admin_users/list_admin/1')?>">Administradores</a></li>
            <!--<li><a href="form-components.html">Form Components</a></li>-->
        </ul>
    </li>
    
    <li >
        <a href="<?=base_url('login/logout')?>" class="text-center" >
            <i class="fa fa-power-off fa-lg" style="margin-top:10px"></i>
            <span class="menu-item">Cerrar sesión</span>
        </a>
    </li>
</ul>
