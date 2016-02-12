angular.module('apartados', [])

.controller('detallePagosCtrl', function ($scope, $http) {

  $scope.retornaPagos = function(getUrl, id_cliente){
  	
  	var getUrl = getUrl+"ws/apartados/detalle_pagos/"+id_cliente;
  	
  	$http.get(getUrl).then(function(response){
  		$scope.list_paids = response.data.pagos;
  	});
  }

})

.controller('apartadoGeneralCtrl', function ($scope, $http, $location, DTOptionsBuilder, DTColumnDefBuilder) {
  
  $scope.listaGeneral = function(getUrl){
  	var getUrl = getUrl+"ws/apartados/depositos_general/";
  	
  	$http.get(getUrl).then(function(response){
      $scope.dtOptions = DTOptionsBuilder.newOptions()
        .withPaginationType('full_numbers')
        .withDisplayLength(100);
  		$scope.list_depositos = response.data;
  	});
  };

  $scope.asignaCliente = function(params){
    console.log($location.host());

  }

  $scope.pagarDeposito=function(id_deposito, folio)
  {
    console.log(id_deposito);
    var _confirmar = confirm("¿Confirmar el pago del folio "+folio+"?");

    if(_confirmar == true){
      var _url = "/Alterfisc/ws/apartados/pagar_deposito";
      
      var params = {post_id_deposito: id_deposito};
      $http.post(_url, {post_id_deposito: id_deposito}).success(function(data, status) {
            console.log(data);
        })
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

})
