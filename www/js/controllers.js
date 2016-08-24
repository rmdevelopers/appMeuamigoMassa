// Ionic Starter App
// Meu amigo é massa 206


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
			  window.plugins.socialsharing.share(title, Config.AppName, res.URI, url)
		  }
		},'jpg',70);
	}
}])
/* recent posts controller */
app.controller('HomeCtrl', ['$scope', 'NewsApp', '$state', 'Config', '$cordovaToast', 'ConfigAdmob', function($scope, NewsApp, $state, Config, $cordovaToast, ConfigAdmob) {	
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
	}

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

app.controller('SettingsCtrl', ['$scope','SendPush','Config', function( $scope, SendPush, Config ) {
	
	$scope.AndroidAppUrl = Config.AndroidAppUrl;
	$scope.AppName = Config.AppName;
	
	$scope.pushNot = [];
	$scope.pushNot.pushStatus = false;
	document.addEventListener("deviceready", function(){
		SendPush.getDetails(device.uuid)
		.success(function (data) {
			if(data.enable == 'yes') {
				$scope.pushNot.pushStatus = true;
			}
		})
		.error(function (error) {
			//alert('error'+data)
		});
	});
	$scope.savePushDetails = function(){
		$scope.sendStatus = 'no';
		if($scope.pushNot.pushStatus == true){
			$scope.sendStatus = 'yes';
		}
		SendPush.savePushDetails(device.uuid, $scope.sendStatus)
		.success(function (data) {
			// alert success
		})
		.error(function (error) {
			//alert('error'+data)
		});
	}
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
		ballon_y = $ballon.offset().top - $canvas.offset().top + 110;
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