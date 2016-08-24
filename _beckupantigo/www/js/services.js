var services = angular.module("app.services", []);

services.factory("ImageService", function ($cordovaCamera, $cordovaFile, FileService) {

  // retorno
  self = {};

  makeID = function () {
    var text = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i = 0; i < 5; i++) {
      text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    ;
    return text;
  };

  self.takePicture = function () {

    // camera opções
    var options = {
      destinationType : Camera.DestinationType.FILE_URI, 
      sourceType : Camera.PictureSourceType.CAMERA, 
      allowEdit : true,
      encodingType: Camera.EncodingType.JPEG,
      targetWidth: 800,
      targetHeight: 800,
      saveToPhotoAlbum: false

    };

    // Abrindo a aplicação nativa da camera e obtendo a URL da imagem
    $cordovaCamera.getPicture(options).then(function (imageUrl) {

      var d = new Date();
      // timestamp para o nome do arquivo
      var timeStamp = d.getDate() + '-' + d.getMonth() + '-' + d.getYear() + '-' + d.getHours() + '-' + d.getMinutes()
      // Obtendo o caminho completo para a imagem armazenada no dispositivo
      var namePath = imageUrl.substr(0, imageUrl.lastIndexOf('/') + 1);

      // Obtendo o nome do arquivo armazenado no dispositivo, obtendo a última parte do caminho do arquivo
      var name = imageUrl.substr(imageUrl.lastIndexOf('/') + 1);

      // Acrescenta timeStamp ao nome da imagem que ficará dentro do app
      var newName = timeStamp + name;

      $cordovaFile.copyFile(namePath, name, cordova.file.externalRootDirectory + 'MeuAmigoMassa/', newName)
        .then(function () {
          FileService.addImage(newName);
        }, function (e) {
          console.log(e);
        });
    }, function (error) {

    });
  };

  return self;

});

services.factory("FileService", function ($cordovaFile) {
  var self = {};
  var images;
  var IMAGE_STORAGE_KEY = 'images';

  self.getImages = function () {
    var img = window.localStorage.getItem(IMAGE_STORAGE_KEY);

    if (img) {
      images = JSON.parse(img);
    } else {
      images = [];
    }
    return images
  };

  self.addImage = function (img) {
    images.push(img);
    window.localStorage.setItem(IMAGE_STORAGE_KEY, JSON.stringify(images));
  }

  return self;

});
