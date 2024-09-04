import angular from 'angular';

angular.module('myApp', []);

angular.module('myApp').controller('MyController', ['$scope', function($scope) {
  $scope.message = 'Hello, World!';
}]);
angular.module('myApp', ['ngRoute']);

angular.module('myApp').config(['$routeProvider', function($routeProvider) {
  $routeProvider
    .when('/login', {
      templateUrl: 'views/login.html',
      controller: 'LoginController'
    })
    .when('/register', {
      templateUrl: 'views/register.html',
      controller: 'RegisterController'
    });
}]);