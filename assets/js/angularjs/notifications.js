angular.module('Tuplan.Notification', ['ngTable'])

.controller('listNotification', function($scope, $http, $location){
	var _PATH 	=	$location.host();
	var url_get =	'/angular/getNotifications';
	$http.get(url_get).then(function(response){

	
		//console.log(response.data.listAlert);
		$scope.listNotification = response.data.listAlert;
	});
})	
.controller('introController', function(NgTableParams, $scope){
    var self = this;
    var data = [{name: "Moroni", age: 50},
        {name: "Simon", age: 43},
        {name: "Jacob", age: 27},
        {name: "Nephi", age: 29},
        {name: "Christian", age: 34},
        {name: "Tiancum", age: 43},
        {name: "Jacob", age: 27}
    ];
    $scope.users = data;
    self.tableParams = new NgTableParams({ count: 5}, { counts: [5, 10, 25], dataset: data});
})