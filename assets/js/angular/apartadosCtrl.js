angular.module('apartados', [])

.controller('detallePagosCtrl', function ($scope, $http) {
  
  $scope.retornaPagos = function(getUrl, id_cliente){
  	
  	var getUrl = getUrl+"ws/apartados/detalle_pagos/"+id_cliente;
  	
  	$http.get(getUrl).then(function(response){
  		console.log(JSON.stringify(response.data.pagos));
  		$scope.list_paids = response.data.pagos;
  	});
  }

});