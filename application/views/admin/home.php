<!-- Breadcrumb -->
<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   
</ol>

<h4 class="page-title">Bienvenido a ALTERFISC </h4>
<br><br>


<div class="table-responsive overflow col-sm-5 col-xs-5">
<h2 class="page-title">Resumen financiero Empresas</h2>    	
    <table class="table tile">
            <tr>
                <th>Total saldos</th>
                <td>$<?=$saldos?></td>
            </tr>

            <tr>
                <th>Pendientes de retorno</th>
                <td>$<?=$retorno?></td>
            </tr>

            <tr>
                <th>Comisiones</th>
                <td>$<?=$comision?></td>
            </tr>

            <tr>
                <th>Gastos</th>
                <td>$<?=$gastos?></td>
            </tr>

            <tr>
                <th>Retiro de comisiones</th>
                <td>$<?=$retiros?></td>
            </tr>
            
            <tr>
                <th>Total resumen</th>
                <td>$<?=$resumen?></td>
            </tr>
    </table>
</div>



<div class="table-responsive overflow col-sm-5 col-xs-5">
<h2 class="page-title">Resumen financiero Personas</h2>        
    <table class="table tile">
            <tr>
                <th>Total depòsitos</th>
                <td>$<?=$depositos?></td>
            </tr>

            <tr>
                <th>Total salidas</th>
                <td>$<?=$salidas?></td>
            </tr>

           
            
            <tr>
                <th>Total resumen</th>
                <td>$<?=$saldo_persona?></td>
            </tr>
    </table>
</div>

