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

  
  $scope.getUrl = '';
  $scope.listaGeneral = function(getUrl){
    
    $scope.getUrl = getUrl;
  	var getUrl= $scope.getUrl +"ws/apartados/depositos_general/";
  	 
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
    });

  	// $http.get(getUrl).then(function(response){
   //    $scope.dtOptions = DTOptionsBuilder.newOptions()
   //      .withPaginationType('full_numbers')
   //      .withDisplayLength(100);
  	// 	$scope.list_depositos = response.data;
  	// });
  };

  $scope.listaGeneralFiltro = function(){
    
    var caja1 = $( "input[name='fecha_ini']" ).val();
    var caja2 = $( "input[name='fecha_fin']" ).val();


    var getUrl = $scope.getUrl+"ws/apartados/depositos_general/"+caja1+"/"+caja2;
    //console.log(getUrl);
    $("#exportar-general").attr("href", $scope.getUrl+"excel/apartados/info/general/"+caja1+"/"+caja2 );
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
        console.log(vm.list_depositos);
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

.controller('apartadoPendienteAsignadosCtrl', function ($scope, $http, $resource, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.getUrl = '';

  $scope.listaPendientes = function(getUrl){
    $scope.getUrl = getUrl;  
    var getUrl = getUrl+"ws/apartados/depositos_pendientes_asignar/";
      
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
    });
    // $http.get(getUrl).then(function(response){
    //   $scope.dtOptions = DTOptionsBuilder.newOptions()
    //     .withPaginationType('full_numbers')
    //     .withDisplayLength(100);

    //   $scope.list_depositos = response.data;
    // });
  }

  $scope.listaGeneralFiltro = function(){
    
    var caja1 = $( "input[name='fecha_ini']" ).val();
    var caja2 = $( "input[name='fecha_fin']" ).val();

    var getUrl = $scope.getUrl+"ws/apartados/depositos_pendientes_asignar/"+caja1+"/"+caja2;
    //console.log(getUrl);
    $("#exportar-general").attr("href", $scope.getUrl+"excel/apartados/info/pendientesAsignar/"+caja1+"/"+caja2 );
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
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
.controller('apartadoAsignadosCtrl', function ($scope, $http, $resource, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.getUrl = '';
  $scope.listaAsignados = function(getUrl){
    $scope.getUrl = getUrl;
    var getUrl = getUrl+"ws/apartados/depositos_asignados/";
    
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
    });

    // $http.get(getUrl).then(function(response){
    //   $scope.dtOptions = DTOptionsBuilder.newOptions()
    //     .withPaginationType('full_numbers')
    //     .withDisplayLength(100);
        

    //   $scope.list_depositos = response.data;
    // });
  }

  $scope.listaGeneralFiltro = function(){
    
    var caja1 = $( "input[name='fecha_ini']" ).val();
    var caja2 = $( "input[name='fecha_fin']" ).val();

    var getUrl = $scope.getUrl+"ws/apartados/depositos_asignados/"+caja1+"/"+caja2;
    //console.log(getUrl);
    $("#exportar-general").attr("href", $scope.getUrl+"excel/apartados/info/noPagado/"+caja1+"/"+caja2 );
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
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
.controller('apartadoPagadosCtrl', function ($scope, $http, $resource, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.getUrl = '';

  $scope.listaPagos = function(getUrl){
    $scope.getUrl = getUrl;  
    var getUrl = getUrl+"ws/apartados/depositos_pagados/";
    $("#exportar-general").attr("href", $scope.getUrl+"excel/apartados/info/genera/"+caja1+"/"+caja2 );
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
    });
    // $http.get(getUrl).then(function(response){
    //   $scope.dtOptions = DTOptionsBuilder.newOptions()
    //     .withPaginationType('full_numbers')
    //     .withDisplayLength(100);

    //   $scope.list_depositos = response.data;
    // });
  }

  $scope.listaGeneralFiltro = function(){
    
    var caja1 = $( "input[name='fecha_ini']" ).val();
    var caja2 = $( "input[name='fecha_fin']" ).val();

    var getUrl = $scope.getUrl+"ws/apartados/depositos_pagados/"+caja1+"/"+caja2;
    //console.log(getUrl);
    $("#exportar-general").attr("href", $scope.getUrl+"excel/apartados/info/Pagado/"+caja1+"/"+caja2 );
    var vm = this;
    $resource(getUrl).query().$promise.then(function(list_depositos) {
        vm.list_depositos = list_depositos;
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

