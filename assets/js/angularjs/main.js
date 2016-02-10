var app = angular.module('Tuplan', ['Tuplan.Notification', 'datatables'],function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});