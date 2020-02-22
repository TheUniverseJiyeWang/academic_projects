var formApp = angular.module("formApp",[]);
formApp.controller("formController",function($scope){
	$scope.commodity = {
		first_name:"Jiye",
		last_name:"Wang",
		address:"Saint Mary's University",
		email:"jiye.wang@smu.ca",
		phone:"9022370517"
	};
});