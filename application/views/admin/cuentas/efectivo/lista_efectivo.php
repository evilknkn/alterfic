<ol class="breadcrumb hidden-xs">
    <li><a href="<?=base_url($this->session->userdata('base_perfil'))?>">Inicio</a></li>
   	<li>Efectivo</li>
</ol>
<h4 class="page-title">Efectivo </h4>

<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Ingreso</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

    <div class="table-responsive overflow">
    	
        <table class="table tile">
            <thead>
                <tr>
                    <th>Efectivo</th>
                    <th>Monto de retiro</th>
                    <th>Folio</th>
                </tr>
            </thead>
            <tbody>
            	
            </tbody>
        </table>
    </div>
</div>


<div class="block-area" id="responsiveTable">
    <h3 class="block-title">Retiro</h3>
    <?php if($this->session->flashdata('success')):?>
    <div class="text-center col-sm-12 col-xs-12">
        <div class="alert alert-success text-success text-center col-xs-6 col-sm-6"> <?php echo $this->session->flashdata('success');?></div>
    </div>
    <?php endif;?>

    <div class="table-responsive overflow">
        
        <table class="table tile">
            <thead>
                <tr>
                    <th>Efectivo</th>
                    <th>Monto de retiro</th>
                    <th>Folio</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>