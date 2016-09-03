// Ionic Starter App
// Meu amigo é massa 2016
var app = angular.module('YourApp', ['ionic','ngSanitize', 'ngCordova','ngIOS9UIWebViewPatch', 'app.services']);
app.run(function($ionicPlatform, $cordovaFile, FileService) {
  $ionicPlatform.ready(function() {
  	$cordovaFile.createDir(cordova.file.externalRootDirectory, "MeuAmigoMassa", false); 
    if(window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
  });
});

// main controller file // 
app.controller('NewsCtrl', ['$scope', '$state', '$ionicSlideBoxDelegate','Color','Config', function($scope, $state, $ionicSlideBoxDelegate, Color, Config) {
	
	$scope.appColor = Color.AppColor;
  	// Toggle left function for app sidebar
  	$scope.toggleLeft = function() {
    	$ionicSideMenuDelegate.toggleLeft();
  	};
	// sharing plugin
	$scope.shareArticle = function(title,url){
		window.plugins.socialsharing.share(title, null, null, url)
	}
	// open link url
	$scope.openLinkArticle = function(url){
		//window.open(url, '_system');
		var ref = cordova.InAppBrowser.open(url, '_blank', 'location=yes');
		//use ref
	}
	$scope.openLinkSystem = function(url){
		//window.open(url, '_system');
		var ref = cordova.InAppBrowser.open(url, '_system', 'location=yes');
		// use  ref
	}
	$scope.shareArticleImage = function(title,url) {
		navigator.screenshot.URI(function(error,res){
		  if(error){
			console.error(error);
		  }else{
			  window.plugins.socialsharing.share(title, Config.AppName, res.URI, '')
		  }
		},'jpg',70);
	}
}])
/* recent posts controller */
app.controller('NovidadesCtrl', ['$scope', 'NewsApp', '$state', 'Config', '$cordovaToast', 'ConfigAdmob', function($scope, NewsApp, $state, Config, $cordovaToast, ConfigAdmob) {	

	$scope.categoryName = 'novidades';
	$scope.category = 4;
	if($scope.categoryName){ 
		$scope.heading = $scope.categoryName;
	}
	$scope.items = [];
	$scope.times = 0 ;
	$scope.postsCompleted = false;
	// load more content function
	$scope.getPosts = function(){
		NewsApp.getPosts($scope.times, $scope.category)
		.success(function (posts) {
			$scope.items = $scope.items.concat(posts.news);
			console.log(posts.news);
			NewsApp.posts = $scope.items;
			$scope.$broadcast('scroll.infiniteScrollComplete');
			$scope.times = $scope.times + 1;
			if(posts.news.length == 0) {
			
				$scope.postsCompleted = true;
			}
		})
		.error(function (error) {
			$scope.items = [];
		});
	}
	// pull to refresh buttons
	$scope.doRefresh = function(){
		$scope.times = 0 ;
		$scope.items = [];
		$scope.postsCompleted = false;
		$scope.getPosts();
		$scope.$broadcast('scroll.refreshComplete');
	}
	// showing single post
	$scope.readMore = function(index){
		$state.go('appmam.post',{
			catId:$scope.category,
			offset:$scope.times,
			index:index,
			type:'category'
		});
	}

	/*

	// setting header -- 
	$scope.heading = Config.AppName;
	$scope.items = [];
	$scope.times = 0 ;
	$scope.postsCompleted = false;
	// load more content function
	$scope.getPosts = function(){
		NewsApp.getPosts($scope.times)
		.success(function (posts) {
			$scope.items = $scope.items.concat(posts.news);
			NewsApp.posts = $scope.items;
			$scope.$broadcast('scroll.infiniteScrollComplete');
			$scope.times = $scope.times + 1;
			if(posts.news.length == 0) {
				$cordovaToast.showLongBottom(Config.ErrorMessage).then(function(success) {
				 // success
			   }, function (error) {
				 // error
			   });
				$scope.postsCompleted = true;
			}
		})
		.error(function (error) {
			$scope.items = [];
		});
	}
	// pull to refresh buttons
	$scope.doRefresh = function(){
		$scope.times = 0 ;
		$scope.items = [];
		$scope.postsCompleted = false;
		$scope.getPosts();
		$scope.$broadcast('scroll.refreshComplete');
	}
	// showing single post
	$scope.readMore = function(index){
		$state.go('appmam.post',{
			catId:0,
			offset:$scope.times,
			index:index,
			type:'home'
		});
	}*/

}])

/* recent posts controller */
app.controller('GaleriaCtrl', ['$scope', 'GaleriaApps', '$state', 'Config', 'ConfigAdmob', '$ionicModal', function($scope, GaleriaApps, $state, Config,  ConfigAdmob, $ionicModal) {	
	
  	$scope.egal = "";
  	$ionicModal.fromTemplateUrl('image-modal.html', {
      scope: $scope,
      animation: 'slide-in-up'
    }).then(function(modal) {
      $scope.modal = modal;
    });
    $scope.openModal = function() {
      $scope.modal.show();
    };
    $scope.closeModal = function() {
      $scope.modal.hide();
    };
    $scope.$on('$destroy', function() {
      $scope.modal.remove();
    });
    $scope.$on('modal.hide', function() {
    });
    $scope.$on('modal.removed', function() {
    });
    $scope.$on('modal.shown', function() {
    });


	$scope.showImage = function(i) {
      $scope.imageSrc = $scope.items[i].image;
      $scope.openModal();
       $ImageCacheFactory.Cache([$scope.imageSrc]).then(function(){
      },function(failed){
      }); 
    }  



	$scope.categoryName = 'galeria';
	$scope.category = 3;
	if($scope.categoryName){ 
		$scope.heading = $scope.categoryName;
	}
	$scope.items = [];
	$scope.times = 0 ;
	$scope.postsCompleted = false;
	// load more content function
	$scope.getPosts = function(){
		GaleriaApps.getPosts($scope.times, $scope.category)
		.success(function (posts) {
			$scope.items = $scope.items.concat(posts.news);
			console.log(posts.news);
			GaleriaApps.posts = $scope.items;
			$scope.$broadcast('scroll.infiniteScrollComplete');
			$scope.times = $scope.times + 1;
			if(posts.news.length == 0) {
			
				$scope.postsCompleted = true;
			}
		})
		.error(function (error) {
			$scope.items = [];
		});
	}
	// pull to refresh buttons
	$scope.doRefresh = function(){
		$scope.times = 0 ;
		$scope.items = [];
		$scope.postsCompleted = false;
		$scope.getPosts();
		$scope.$broadcast('scroll.refreshComplete');
	}
	// showing single post
	$scope.readMore = function(index){
		$state.go('appmam.post',{
			catId:$scope.category,
			offset:$scope.times,
			index:index,
			type:'category'
		});
	}
}])



/* Home controller */
app.controller('HomeCtrl', ['$scope', '$state', 'Config', '$ionicPopup', '$timeout', '$ionicPlatform', '$cordovaToast', function($scope, $state, Config, $ionicPopup, $timeout , $ionicPlatform, $cordovaToast) {	
	$scope.heading = Config.AppName;
	var valida = false;
	// A confirm dialog
	$scope.showConfirm = function() {
		if (window.cordova) {
			cordova.plugins.diagnostic.isLocationEnabled(function(enabled) {
		        if(!enabled){
					var confirmPopup = $ionicPopup.show({
						title: 'Ativar GPS',
						template: 'Habilitar GPS para traçar uma rota até o Meu Amigo é Massa?',
						scope: $scope,
					    buttons: [
					      { text: 'cancelar' },
					      {
					        text: '<b>Ativar!</b>',
					        type: 'button-positive',
					        onTap: function(e) {					        	
					        	cordova.plugins.diagnostic.switchToLocationSettings();
					        	valida = true;
					        }
					      }
					    ]
					});
		        }else{
		        	$state.go('appmam.localizacao');
		        }		      
		    },
		    function(error) {
		    	alert("The following error occurred: " + error);
		    });
		};
	};

	/*DETECTA O RESUMO DE UMA ATIVIDADE*/
	$ionicPlatform.on('resume', function(){
    	cordova.plugins.diagnostic.isLocationEnabled(function(enabled) {
    		//somente quando eu sair das conf de localização
	        if(enabled && valida){
	        	$state.go('appmam.localizacao');
	        }		      
	    }, 	
	    function(error) {
	    	alert("The following error occurred: " + error);
	    });
    });
}])

/* category posts controller */
app.controller('CategoryCtrl', ['$scope', 'NewsApp', '$state', '$stateParams', 'Config', '$cordovaToast', function($scope, NewsApp, $state, $stateParams, Config, $cordovaToast) {	
	// setting header --
	
	$scope.categoryName = $stateParams.categoryName;
	$scope.category = parseInt($stateParams.category);
	if($scope.categoryName){ 
		$scope.heading = $scope.categoryName;
	}
	$scope.items = [];
	$scope.times = 0 ;
	$scope.postsCompleted = false;
	// load more content function
	$scope.getPosts = function(){
		NewsApp.getPosts($scope.times, $scope.category)
		.success(function (posts) {
			$scope.items = $scope.items.concat(posts.news);
			NewsApp.posts = $scope.items;
			$scope.$broadcast('scroll.infiniteScrollComplete');
			$scope.times = $scope.times + 1;
			if(posts.news.length == 0) {
				$cordovaToast.showLongBottom(Config.ErrorMessage).then(function(success) {
				 // success
			   }, function (error) {
				 // error
			   });
				$scope.postsCompleted = true;
			}
		})
		.error(function (error) {
			$scope.items = [];
		});
	}
	// pull to refresh buttons
	$scope.doRefresh = function(){
		$scope.times = 0 ;
		$scope.items = [];
		$scope.postsCompleted = false;
		$scope.getPosts();
		$scope.$broadcast('scroll.refreshComplete');
	}
	// showing single post
	$scope.readMore = function(index){
		$state.go('appmam.post',{
			catId:$scope.category,
			offset:$scope.times,
			index:index,
			type:'category'
		});
	}
}])
/* search controller */
app.controller('SearchCtrl', ['$scope', '$state', 'NewsApp', '$stateParams', '$sce', 'Config', '$cordovaToast', function($scope, $state, NewsApp, $stateParams, $sce, Config, $cordovaToast) {
	// getting label from params
  	$scope.query = '';
	// setting header same as label
	$scope.MainHeading = $sce.trustAsHtml($scope.query);
	$scope.query = "";
	$scope.items = [];
	$scope.searchQuery = [];
	$scope.times = 0;
	$scope.postsCompleted = false;
	// get posts function
	$scope.getPosts = function(){
		NewsApp.searchPosts($scope.query, $scope.times)
		.success(function (posts) {
			$scope.items = $scope.items.concat(posts.news);
			NewsApp.posts = $scope.items;
			$scope.$broadcast('scroll.infiniteScrollComplete');
			$scope.times = $scope.times + 1;
			if(posts.news.length == 0) {
				if($scope.query){
					$cordovaToast.showLongBottom(Config.ErrorMessage).then(function(success) {
					 // success
					}, function (error) {
					 // error
					});
				}
				$scope.postsCompleted = true;
			}
		})
		.error(function (error) {
			$scope.posts = [];
		});
	}
	$scope.searchSubmitFunction = function(){
		$scope.times = 0;
		$scope.items = [];
		$scope.query = $scope.searchQuery.query;
		//$scope.getPosts();
		$scope.postsCompleted = false;
		$scope.MainHeading = $sce.trustAsHtml($scope.query);
	}
	// showing single post
	$scope.readMore = function(index){
		$state.go('appmam.post',{
			catId:$scope.query,
			offset:$scope.times,
			index:index,
			type:'search'
		});
	}
	//
}])
/* post controller */
app.controller('PostCtrl', ['$scope', 'NewsApp', '$stateParams', '$sce', 'Config', '$cordovaToast', function($scope, NewsApp, $stateParams, $sce, Config, $cordovaToast) {
	
	
	$scope.$on("$stateChangeStart", function() {
		$scope.$root.showExtraButton = false;
	})
	//console.log(NewsApp.posts);
	// getting category id or search param -- 0 in case of home page posts
	$scope.catId = $stateParams.catId;
	$scope.times = parseInt($stateParams.offset);
	$scope.index = parseInt($stateParams.index);
	$scope.type = $stateParams.type;
	
	$scope.showPost = function(selectedIndex){
		if(NewsApp.posts[selectedIndex]){
			//$scope.item.image = '';
			$scope.item = NewsApp.posts[selectedIndex];
			$scope.heading = $scope.item.title;
			$scope.description = $sce.trustAsHtml($scope.item.description);
			$scope.$root.showExtraButton = false;
		}
	}
	$scope.showPost($scope.index);
	
	// post completed flag
	$scope.postsCompleted = false;
	// getting more posts function
	$scope.gettingPosts = false;
	$scope.getPosts = function(){
		if($scope.gettingPosts == false) {
			$scope.gettingPosts = true;
			if($scope.type == 'home') {
				NewsApp.getPosts($scope.times)
				.success(function (posts) {
					NewsApp.posts = NewsApp.posts.concat(posts.news);
					$scope.times = $scope.times + 1;
					if(posts.news.length == 0) {
						$scope.postsCompleted = true;
						$scope.showErrorToast();
					} else {
						$scope.showPost($scope.index);
					}
					$scope.gettingPosts = false;
				})
				.error(function (error) {
					$scope.gettingPosts = false;
				});
			} else if($scope.type == 'category') {
				NewsApp.getPosts($scope.times, $scope.catId)
				.success(function (posts) {
					NewsApp.posts = NewsApp.posts.concat(posts.news);
					$scope.times = $scope.times + 1;
					if(posts.news.length == 0) {
						$scope.postsCompleted = true;
						$scope.showErrorToast();
					} else {
						$scope.showPost($scope.index);
					}
					$scope.gettingPosts = false;
				})
				.error(function (error) {
					$scope.gettingPosts = false;
				});
			} else if($scope.type == 'search'){
				NewsApp.searchPosts($scope.catId, $scope.times)
				.success(function (posts) {
					NewsApp.posts = NewsApp.posts.concat(posts.news);
					$scope.times = $scope.times + 1;
					if(posts.news.length == 0) {
						$scope.postsCompleted = true;
						$scope.showErrorToast();
					} else {
						$scope.showPost($scope.index);
					}
					$scope.gettingPosts = false;
				})
				.error(function (error) {
					$scope.gettingPosts = false;
				});
			}
		}
	}
	$scope.showErrorToast = function(){

		$scope.$root.showExtraButton = false;
		$cordovaToast.showLongBottom(Config.ErrorMessage).then(function(success) {
		 // success
		}, function (error) {
		 // error
		});
	}
	$scope.onSwipeRight = function(){
		//$scope.item.image = '';
		$scope.index = $scope.index - 1;
		if($scope.index >= 0 ){
			$scope.$root.showExtraButton = true;
			$scope.showPost($scope.index)
		} else {
			$scope.index = $scope.index + 1;
		}
	}
	$scope.onSwipeLeft = function(){
		//$scope.item.image = '';
		$scope.index = $scope.index + 1;
		if(NewsApp.posts[$scope.index]){
			$scope.$root.showExtraButton = true;
			$scope.showPost($scope.index)
		} else {
			if($scope.postsCompleted == false){
				$scope.$root.showExtraButton = true;
				$scope.getPosts();
			} else {
				$scope.index = $scope.index - 1;
			}
		}
	}
	
}])
/* recent posts controller */
app.controller('CategoriesCtrl', ['$scope', 'NewsApp', '$state', function($scope, NewsApp, $state) {	
	// setting header -- 
	$scope.heading = "Categories";
	$scope.postsCompleted = false;
	$scope.categories = [];
	// load more content function
	$scope.getCategries = function(){
		NewsApp.getCategries()
		.success(function (posts) {
			$scope.categories = $scope.categories.concat(posts.categories);
			$scope.postsCompleted = true;
		})
		.error(function (error) {
			$scope.categories = [];
			$scope.postsCompleted = true;
		});
	}
}])

app.controller('SettingsCtrl', ['$scope','SendPush','Config', '$timeout', '$cordovaNativeAudio', '$ionicPlatform' , function( $scope, SendPush, Config, $timeout, $cordovaNativeAudio, SoundController, $ionicPlatform) {
	$scope.AndroidAppUrl = Config.AndroidAppUrl;
	$scope.AppName = Config.AppName;
	$scope.pushNot = [];

	  var audio = [{
    id: 1,
    key: '2016',
    title: "É tempo de viver",
    track: 'jingle/2016.mp3',
    genre: "Meu amigo é Massa 2016"
  }, {
    id: 2,
    key: '2015',
    title: "Meu amigo, Minha alegria",
    track: 'jingle/2015.mp3',
    genre: "Meu amigo é Massa 2015"
  }, {
    id: 3,
    key: '2014',
    title: "Para sempre",
    track: 'jingle/2014.mp3',
    genre: "Meu amigo é Massa 2014"
  }, {
    id: 4,
    key: '2013',
    title: "Com você na JMJ",
    track: 'jingle/2013.mp3',
    genre: "Meu amigo é Massa 2013"
  }, {
    id: 5,
    key: '2012',
    title: "Hoje tenho alegria, tenho sua companhia",
    track: 'jingle/2012.mp3',
    genre: "Meu amigo é Massa 2012"
  }, {
    id: 6,
    key: '2011',
    title: "Poderosa Proteção",
    track: 'jingle/2011.mp3',
    genre: "Meu amigo é Massa 2011"
  }, ];

  $scope.audioTracks = Array.prototype.slice.call(audio, 0);

    $scope.player = {
    	key: '' // Holds a last active track
  	}

    $scope.playTrack = function(track, key) {
    	if (key == '2015') { alert('Sem áudio! Confira os outros anos, logo abaixo!'); return false;}
      // Preload an audio track before we play it
      window.plugins.NativeAudio.preloadComplex(key, track, 1, 1, 0, function(msg) {
        // If this is not a first playback stop and unload previous audio track
        if ($scope.player.key.length > 0) {
          window.plugins.NativeAudio.stop($scope.player.key); // Stop audio track
          window.plugins.NativeAudio.unload($scope.player.key); // Unload audio track
        }
        window.plugins.NativeAudio.play(key); // Play audio track
        $scope.player.key = key; // Set a current audio track so we can close it if needed 
      }, function(msg) {
      	$scope.player.key = '';
        console.log('error: ' + msg); // Loading error
      });
    };
    $scope.stopTrack = function() {
        // If this is not a first playback stop and unload previous audio track
        if ($scope.player.key.length > 0) {
          window.plugins.NativeAudio.stop($scope.player.key); // Stop audio track
          window.plugins.NativeAudio.unload($scope.player.key); // Unload audio track
          $scope.player.key = '';
        }
    };

}])
/* About us Controller */
app.controller('AboutCtrl', ['$scope', function($scope) {
}])
/* Contact us form page */
app.controller('ContactCtrl', ['$scope', 'ConfigContact', function($scope, ConfigContact) {
	//setting heading here
	$scope.user = [];
	// contact form submit event
	$scope.submitForm = function(isValid) {
		if (isValid) {
			cordova.plugins.email.isAvailable(
				function (isAvailable) {
					window.plugin.email.open({
						to:      [ConfigContact.EmailId],
						subject: ConfigContact.ContactSubject,
						body:    '<h1>'+$scope.user.email+'</h1><br><h2>'+$scope.user.name+'</h2><br><p>'+$scope.user.details+'</p>',
						isHtml:  true
					});
				}
			);
		}
	}
}])

//////////////////*  CAMERA */

app.controller('CameraCtrl', ['$scope', '$state', 'ImageService', 'FileService', '$cordovaSocialSharing', '$cordovaDevice', '$cordovaFile', '$ionicPlatform' , function($scope, $state, ImageService, FileService, $cordovaSocialSharing, $cordovaDevice, $cordovaFile, $ionicPlatform) {	

	// passar por parâmetro a imagem clicada
	$scope.molds = function(imgs){
		var filePath = cordova.file.externalRootDirectory + 'MeuAmigoMassa/' + imgs;
		$state.go('appmam.moldura',{
			imgsrc:filePath
		});
	}

	// carregando as imagens já salvas
  	$ionicPlatform.ready(function () {
      $scope.images = FileService.getImages();
      $scope.$apply();
    });

  	// bater uma foto
    $scope.captureImage = function () {
      ImageService.takePicture();
      $scope.images = FileService.getImages();
    }

    $scope.urlForImage = function (imageName) {
      var filePath = cordova.file.externalRootDirectory + 'MeuAmigoMassa/' + imageName;
      return filePath;
    };

    $scope.urlForImage = function (imageName) {
      var trueOrigin = cordova.file.externalRootDirectory + 'MeuAmigoMassa/' + imageName;
      return trueOrigin;
    };

  }])

/****** fim CAMERA ********/

//////////////////*  MolduraCtrl */

app.controller('MolduraCtrl', ['$scope', '$ionicHistory', 'ImageService', '$stateParams', 'FileService', '$cordovaSocialSharing', '$cordovaDevice', '$cordovaFile', '$ionicPlatform' , function($scope, $ionicHistory, ImageService, $stateParams, FileService, $cordovaSocialSharing, $cordovaDevice, $cordovaFile, $ionicPlatform) {	

	/*Função para retornar*/
	$scope.myGoBack = function() {
    	$ionicHistory.goBack();
  	};

  	/*Setando dinamicamente um estilo*/
    $scope.photo = {
      style: {
        width: '287px',
        height: 'auto'
      }
    };

    /*Função retornando a imagem clicada na tela anterior*/
	$scope.imgbeck= function(){ 
		$scope.imgsrc = $stateParams.imgsrc;	
		return $scope.imgsrc;
	}
	
	/*Função que adiciona moldura e a imagem ao canvas*/	
    $scope.addmoldura= function(){   
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d');
		var background = document.getElementById('background');
		context.drawImage(background, 0, 0);
		var ballon = document.getElementById('ma_moldura');
		var $ballon = $('#ma_moldura'),
		$canvas = $('#canvas');
		var ballon_x = $ballon.offset().left - $canvas.offset().left,
		ballon_y = $ballon.offset().top - $canvas.offset().top + 140;
		context.drawImage(ballon, ballon_x, ballon_y);
		$ballon.hide();
		$('#btn-moldura').prop("disabled",true);
 
    };

    /*compartilhando com moldura*/
	$scope.commoldura= function(){
		$cordovaSocialSharing.shareViaFacebook("Este é o meu amigo massa!", canvas.toDataURL(), "https://www.linkdoapp.com")
		.then(function(result) {		
			$ionicHistory.goBack();		    	
		}, function(err) {
			// erro
		});
	};

}])

/****** fim MolduraCtrl ********/

/* Localizacao Controller */
app.controller('LocalizacaoCtrl', ['$scope','$ionicLoading' ,'$cordovaGeolocation', '$ionicPlatform', function($scope, $ionicLoading, $cordovaGeolocation, $ionicPlatform) {
	
  	var map;
	var directionsDisplay;
	var directionsService = new google.maps.DirectionsService();
	var gmarkers = [];
    $ionicPlatform.ready(function() {    
 
        $ionicLoading.show({
            template: '<ion-spinner icon="bubbles"></ion-spinner><br/>Encontrando sua localização...'
        });
         
        var posOptions = {
            enableHighAccuracy: true,
            timeout: 20000,
            maximumAge: 0
        };
 
        $cordovaGeolocation.getCurrentPosition(posOptions).then(function (position) {
            var lat  = position.coords.latitude;
            var long = position.coords.longitude;
             
            var myLatlng = new google.maps.LatLng(lat, long);
             
               
            var contentString = '<div id="content">'+   
			  '<h3 id="firstHeading" class="firstHeading">Estou aqui</h3>'+     
			  '</div>';

			var infowindow = new google.maps.InfoWindow({
			content: contentString
			});

			directionsDisplay = new google.maps.DirectionsRenderer();
		
		    var options = {
		        zoom: 16,
				center: myLatlng,
		        mapTypeId: google.maps.MapTypeId.ROADMAP
		    };

			var contentString = '<div id="content">'+   
			  '<h3 id="firstHeading" class="firstHeading">Estou aqui</h3>'+     
			  '</div>';

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

		    map = new google.maps.Map(document.getElementById("map"), options);
			directionsDisplay.setMap(map);
			directionsDisplay.setPanel(document.getElementById("trajeto-texto"));
			
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function (position) {

					pontoPadrao = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
					map.setCenter(pontoPadrao);
					
					var geocoder = new google.maps.Geocoder();
					
					geocoder.geocode({
						"location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
		            },
		            function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							$("#txtEnderecoPartida").val(results[0].formatted_address);	
							 $ionicLoading.hide(); 			
							var marker = new google.maps.Marker({
								position: pontoPadrao,
								icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
								map: map			  
							});
							gmarkers.push(marker);
							infowindow.open(map, marker);

						}
		            });
				});
			}
      
             
        }, function(err) {
            $ionicLoading.hide();
            console.log(err);

        });
   
});



	$scope.rotas= function(){ 

		
		//Instanciar o DistanceMatrixService
		var service = new google.maps.DistanceMatrixService();
		//executar o DistanceMatrixService
		service.getDistanceMatrix(
		  {

		      //Origem
		      origins: [$("#txtEnderecoPartida").val()],
		      //Destino
		      destinations: [$("#txtEnderecoChegada").val()],
		      //Modo (DRIVING | WALKING | BICYCLING)
		      travelMode: google.maps.TravelMode.DRIVING,
		      //Sistema de medida (METRIC | IMPERIAL)
		      unitSystem: google.maps.UnitSystem.METRIC
		      //Vai chamar o callback
		  }, callback);

		$("#trajeto-texto").slideUp( 300 ).delay( 800 ).fadeIn( 400 );
		event.preventDefault();
		
		var enderecoPartida = $("#txtEnderecoPartida").val();
		var enderecoChegada = '-3.7353818,-38.5691357';
		
		var request = {
			origin: pontoPadrao,
			destination: enderecoChegada,
			travelMode: google.maps.TravelMode.DRIVING
		};
		
		directionsService.route(request, function(result, status) {
			if (status == google.maps.DirectionsStatus.OK) {

				directionsDisplay.setDirections(result);

				var contentString = '<div id="content">'+  '<h3 id="firstHeading" class="firstHeading">Estou aqui</h3>'+ '</div>';

				var infowindow = new google.maps.InfoWindow({
				content: contentString
				});
				 for(i=0; i<gmarkers.length; i++){
			        gmarkers[i].setMap(null);
			    }

			}
		});
	}

	//Tratar o retorno do DistanceMatrixService
	function callback(response, status) {

	}
}])



// show ad mob here in this page
app.controller('AdmobCtrl', ['$scope', 'ConfigAdmob', function($scope, ConfigAdmob){
	$scope.showInterstitial = function(){
		if(AdMob) AdMob.showInterstitial();
	}
	document.addEventListener("deviceready", function(){
		if(AdMob) {
			// show admob banner
			if(ConfigAdmob.banner) {
				AdMob.createBanner( {
					adId: ConfigAdmob.banner, 
					position: AdMob.AD_POSITION.BOTTOM_CENTER, 
					autoShow: true 
				} );
			}
			// preparing admob interstitial ad
			if(ConfigAdmob.interstitial) {
				AdMob.prepareInterstitial( {
					adId:ConfigAdmob.interstitial, 
					autoShow:false
				} );
			}
		}
		if(ConfigAdmob.interstitial) {
			$scope.showInterstitial();
		}
	});
}]);

/*
*	ESTUDAR A POSSIBILIDADE
*	http://www.gajotres.net/using-cordova-geoloacation-api-with-google-maps-in-ionic-framework/2/
*/