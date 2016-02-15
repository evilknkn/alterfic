angular.module('apartados', [])

.controller('detallePagosCtrl', function ($scope, $http) {

  $scope.retornaPagos = function(getUrl, id_cliente){
  	
  	var getUrl = getUrl+"ws/apartados/detalle_pagos/"+id_cliente;
  	
  	$http.get(getUrl).then(function(response){
  		$scope.list_paids = response.data.pagos;
  	});
  }

})

.controller('apartadoGeneralCtrl', function ($scope, $http, $location, $resource, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.listaGeneral = function(getUrl){
  	var getUrl = getUrl+"ws/apartados/depositos_general/";
  	
  	$http.get(getUrl).then(function(response){
      $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('full_numbers')
        .withDisplayLength(100);
  		$scope.list_depositos = response.data;
  	});
  };

  $scope.asignaCliente = function(id_deposito, folio)
  {    
    $("#id_depto").val(id_deposito);
    $('#title-modal').html("Asignación de cliente al folio "+folio);
    $('#modalAsignaCliente').modal('show');
  }

  
  $scope.pagarDeposito = function(id_deposito, folio)
  {    
    $("#id_depto_pago").val(id_deposito);
    $('#legend-modal').html("¿Esta seguro que desa pagar el folio "+folio+" ?");
    $('#modalPago').modal('show');
  }

  $scope.class_tr = function(id_deposito, id_cliente, status_retorno)
  {
      if( id_cliente != null){
        if(status_retorno == 'pagado'){
          $( "#deposito_"+id_deposito ).addClass( "label-success");
        $( "#deposito_"+id_deposito ).css( "color","#ffffff");
        }else{
          $( "#deposito_"+id_deposito ).addClass( "label-info");
          $( "#deposito_"+id_deposito ).css( "color","#ffffff");  
        }
      }
  }

})
.controller('apartadoAsignadosCtrl', function ($scope, $http, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.listaAsignados = function(getUrl){
    
    var getUrl = getUrl+"ws/apartados/depositos_asignados/";
    
    $http.get(getUrl).then(function(response){
      $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('full_numbers')
        .withDisplayLength(100);
        

      $scope.list_depositos = response.data;
    });
  }

  $scope.asignaCliente = function(id_deposito, folio)
  {    
    $("#id_depto").val(id_deposito);
    $('#title-modal').html("Asignación de cliente al folio "+folio);
    $('#modalAsignaCliente').modal('show');
  }

  $scope.pagarDeposito = function(id_deposito, folio)
  {    
    $("#id_depto_pago").val(id_deposito);
    $('#legend-modal').html("¿Esta seguro que desa pagar el folio "+folio+" ?");
    $('#modalPago').modal('show');
  }
  
})

.controller('apartadoPendienteAsignadosCtrl', function ($scope, $http, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.listaPendientes = function(getUrl){
    
    var getUrl = getUrl+"ws/apartados/depositos_pendientes_asignar/";
    
    $http.get(getUrl).then(function(response){
      $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('full_numbers')
        .withDisplayLength(100);

      $scope.list_depositos = response.data;
    });
  }

  $scope.asignaCliente = function(id_deposito, folio)
  {    
    $("#id_depto").val(id_deposito);
    $('#title-modal').html("Asignación de cliente al folio "+folio);
    $('#modalAsignaCliente').modal('show');
  }

  $scope.pagarDeposito = function(id_deposito, folio)
  {    
    $("#id_depto_pago").val(id_deposito);
    $('#legend-modal').html("¿Esta seguro que desa pagar el folio "+folio+" ?");
    $('#modalPago').modal('show');
  }

})
.controller('apartadoPagadosCtrl', function ($scope, $http, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.listaPagos = function(getUrl){
    
    var getUrl = getUrl+"ws/apartados/depositos_pagados/";
    
    $http.get(getUrl).then(function(response){
      $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('full_numbers')
        .withDisplayLength(100);

      $scope.list_depositos = response.data;
    });
  }

  $scope.pagarDeposito = function(id_deposito, folio)
  {    
    $("#id_depto_pago").val(id_deposito);
    $('#legend-modal').html("¿Esta seguro que desa pagar el folio "+folio+" ?");
    $('#modalPago').modal('show');
  }

  $scope.asignaCliente = function(id_deposito, folio)
  {    
    $("#id_depto").val(id_deposito);
    $('#title-modal').html("Asignación de cliente al folio "+folio);
    $('#modalAsignaCliente').modal('show');
  }

  $scope.class_tr = function(id_deposito, id_cliente, status_retorno)
  {
      if( id_cliente != null){
        if(status_retorno == 'pagado'){
          $( "#deposito_"+id_deposito ).addClass( "label-success");
        $( "#deposito_"+id_deposito ).css( "color","#ffffff");
        }else{
          $( "#deposito_"+id_deposito ).addClass( "label-info");
          $( "#deposito_"+id_deposito ).css( "color","#ffffff");  
        }
      }
  }

})

