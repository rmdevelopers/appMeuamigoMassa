angular.module('starter.controllers', [])

//Controller que recebe os itens dos botões.
.controller('MenuCtrl', function($scope, Data) {
  $scope.items = Data.items;
})

.controller('AppCtrl', function($scope, $ionicModal, $timeout) {

})



