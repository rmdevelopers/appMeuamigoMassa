/**
 * Created pela equipe Meu amigo é Massa 
 */
var controllers = angular.module("app.controllers", [])

  .controller('CameraCtrl', function ($scope, $ionicPlatform, ImageService, FileService, $cordovaSocialSharing, $cordovaDevice, $cordovaFile) {

    $ionicPlatform.ready(function () {      
      $scope.$apply();
      alert($scope.images);
      $scope.images = FileService.getImages();
    });

    $scope.captureImage = function () {
      ImageService.takePicture();
      $scope.images = FileService.getImages();
    };

    $scope.compartilharImage = function(img) {
        var filePath = cordova.file.externalRootDirectory + 'MeuAmigoMassa/'+ img;
        $cordovaSocialSharing.share("Este é o meu amigo massa!", " ", filePath, "https://www.linkdoapp.com");
    };

    $scope.urlForImage = function (imageName) {
      var filePath = cordova.file.externalRootDirectory + 'MeuAmigoMassa/' + imageName;
      return filePath;
    };

    // appends file path to imageName
    $scope.urlForImage = function (imageName) {
      var trueOrigin = cordova.file.externalRootDirectory + 'MeuAmigoMassa/' + imageName;
      return trueOrigin;
    };


  });


