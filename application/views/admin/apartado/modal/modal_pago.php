<div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-hidden="true" ng-controller="apartadoGeneralCtrl">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id=""> Confirmar</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input  id="id_depto_pago" type="hidden">
                   <h4 class="modal-title" id="legend-modal"> Confirmar</h4>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="savePago()">Pagar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">No Pagar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function savePago(){

        var path = "<?= $this->uri->segment(3);?>"
        var _url = "/ws/apartados/pagar_deposito";
        var _idDeposito = $("#id_depto_pago").val();

        var dataPost = { id_deposito: _idDeposito };
        
        console.log( '////el deposito id es: '+ _idDeposito );
        console.log(path);

        $.ajax({
                  type:'POST',
                  dataType:'json',
                  url:_url,
                  data: dataPost,
                  success: function(data){
                    console.log(data);
                    if(data.success == 'true' && path =='pendiente_asignar'){
                        $( "#pay_depto_"+_idDeposito ).removeClass( "btn-primary" );
                        $( "#pay_depto_"+_idDeposito ).addClass( "btn-success" );
                        $( "#pay_depto_"+_idDeposito ).html("Pagado");
                        $('#modalPago').modal('hide');
                    }

                    if(data.success == 'true' && path =='pendiente_retorno'){

                        $( "#pay_depto_"+_idDeposito ).removeClass( "btn-primary" );
                        $( "#pay_depto_"+_idDeposito ).addClass( "btn-success" );
                        $( "#pay_depto_"+_idDeposito ).html("Pagado");
                        $( "#deposito_"+_idDeposito).remove();
                        $('#modalPago').modal('hide');
                    }

                    //conosle.log(data);
                  }
              });
    }


     
</script>