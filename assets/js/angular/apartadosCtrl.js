angular.module('apartados', [])

.controller('detallePagosCtrl', function ($scope, $http) {
  
  $scope.retornaPagos = function(getUrl, id_cliente){
  	
  	var getUrl = getUrl+"ws/apartados/detalle_pagos/"+id_cliente;
  	
  	$http.get(getUrl).then(function(response){
  		console.log(response.data.pagos);
  		$scope.list_paids = response.data.pagos;
  	});
  }

})

.controller('apartadoGeneralCtrl', function ($scope, $http) {
  
  $scope.listaGeneral = function(getUrl){
  	
  	var getUrl = getUrl+"ws/apartados/depositos_general/";
  	
  	$http.get(getUrl).then(function(response){
  		
  		$scope.list_depositos = response.data;
  	});
  }

})
.controller('apartadoAsignadosCtrl', function ($scope, $http) {
  
  $scope.listaAsignados = function(getUrl){
    
    var getUrl = getUrl+"ws/apartados/depositos_asignados/";
    
    $http.get(getUrl).then(function(response){
      
      $scope.list_depositos = response.data;
    });
  }

})

.controller('apartadoPendienteAsignadosCtrl', function ($scope, $http) {
  
  $scope.listaPendientes = function(getUrl){
    
    var getUrl = getUrl+"ws/apartados/depositos_pendientes_asignar/";
    
    $http.get(getUrl).then(function(response){
      
      $scope.list_depositos = response.data;
    });
  }

});