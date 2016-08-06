// Mobionic: Mobile Ionic Framework

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'mobionicApp' is the name of this angular module (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
angular.module('mobionicApp', ['ionic', 'mobionicApp.controllers', 'mobionicApp.data', 'mobionicApp.directives', 'mobionicApp.filters', 'mobionicApp.storage', 'ngSanitize', 'uiGmapgoogle-maps'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if(window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if(window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
      
    // Open any external link with InAppBrowser Plugin
    $(document).on('click', 'a[href^=http], a[href^=https]', function(e){

        e.preventDefault();
        var $this = $(this); 
        var target = $this.data('inAppBrowser') || '_blank';

        window.open($this.attr('href'), target);

    });
      
    // Initialize Push Notifications
    var initPushwoosh = function() {
        var pushNotification = window.plugins.pushNotification;

		if(device.platform == "Android") {
			registerPushwooshAndroid();
		}
        if (device.platform == "iPhone" || device.platform == "iOS") {
            registerPushwooshIOS();
        }
    }
    
    // Uncomment the following initialization when you have made the appropriate configuration for iOS - http://goo.gl/YKQL8k and for Android - http://goo.gl/SPGWDJ
    // initPushwoosh();
      
  });
    
})

.config(function($stateProvider, $urlRouterProvider, $ionicConfigProvider) {
    
    // $ionicConfigProvider
    // http://ionicframework.com/docs/api/provider/%24ionicConfigProvider/
    $ionicConfigProvider.tabs.position('bottom');
    $ionicConfigProvider.navBar.alignTitle('center');
    
    $stateProvider

    .state('app', {
      url: "/app",
      abstract: true,
      templateUrl: "templates/menu.html",
      controller: 'AppCtrl'
    })

    .state('app.home', {
      url: "/home",
      views: {
        'menuContent' :{
          templateUrl: "templates/home-grid-2.html",
          //templateUrl: "templates/home-grid-3.html",
          //templateUrl: "templates/home-rows.html",
          controller: 'HomeCtrl'
        }
      }
    })

    .state('app.news', {
      url: "/news",
      views: {
        'menuContent' :{
          templateUrl: "templates/news.html",
          controller: 'NewsCtrl'
        }
      }
    })

    .state('app.new', {
      url: "/news/:newId",
      views: {
        'menuContent' :{
          templateUrl: "templates/new.html",
          controller: 'NewCtrl'
        }
      }
    })
    
    .state('app.youtubevideos', {
      url: "/youtubevideos",
      views: {
        'menuContent' :{
          templateUrl: "templates/youtube-videos.html",
          controller: 'YouTubeVideosCtrl'
        }
      }
    })

    .state('app.youtubevideo', {
      url: "/youtubevideos/:videoId",
      views: {
        'menuContent' :{
          templateUrl: "templates/youtube-video.html",
          controller: 'YouTubeVideoCtrl'
        }
      }
    })

    .state('app.products', {
      url: "/products",
      views: {
        'menuContent' :{
          templateUrl: "templates/products.html",
          controller: 'ProductsCtrl'
        }
      }
    })

    .state('app.product', {
      url: "/products/:productId",
      views: {
        'menuContent' :{
          templateUrl: "templates/product.html",
          controller: 'ProductCtrl'
        }
      }
    })

    .state('app.gallery', {
      url: "/gallery",
      views: {
        'menuContent' :{
          templateUrl: "templates/gallery.html",
          controller: 'GalleryCtrl'
        }
      }
    }) 

    .state('app.map', {
      url: "/map",
      views: {
        'menuContent' :{
          templateUrl: "templates/map.html",
          controller: 'MapCtrl'
        }
      }
    })

    .state('app.about', {
      url: "/about",
      views: {
        'menuContent' :{
          templateUrl: "templates/about.html",
          controller: 'AboutCtrl'
        }
      }
    })

    .state('app.member', {
      url: "/about/:memberId",
      views: {
        'menuContent' :{
          templateUrl: "templates/member.html",
          controller: 'MemberCtrl'
        }
      }
    })

    .state('app.contact', {
      url: "/contact",
      views: {
        'menuContent' :{
          templateUrl: "templates/contact.html",
          controller: 'ContactCtrl'
        }
      }
    })

    .state('app.posts', {
      url: "/posts",
      views: {
        'menuContent' :{
          templateUrl: "templates/posts.html",
          controller: 'PostsCtrl'
        }
      }
    })

    .state('app.post', {
      url: "/posts/:postId",
      views: {
        'menuContent' :{
          templateUrl: "templates/post.html",
          controller: 'PostCtrl'
        }
      }
    })

    .state('app.serverposts', {
      url: "/serverposts",
      views: {
        'menuContent' :{
          templateUrl: "templates/serverposts.html",
          controller: 'ServerPostsCtrl'
        }
      }
    })

    .state('app.serverpost', {
      url: "/serverposts/:serverpostId",
      views: {
        'menuContent' :{
          templateUrl: "templates/serverpost.html",
          controller: 'ServerPostCtrl'
        }
      }
    })

    .state('app.elements', {
      url: "/elements",
      views: {
        'menuContent' :{
          templateUrl: "templates/elements.html"
        }
      }
    })

    .state('app.grid', {
      url: "/grid",
      views: {
        'menuContent' :{
          templateUrl: "templates/grid.html"
        }
      }
    })

    .state('app.feeds', {
      url: "/feeds",
      views: {
        'menuContent' :{
          templateUrl: "templates/feeds.html",
          controller: 'FeedsCtrl'
        }
      }
    })

    .state('app.feed', {
      url: "/feeds/:entryId",
      views: {
        'menuContent' :{
          templateUrl: "templates/feed.html",
          controller: 'FeedCtrl'
        }
      }
    })
    
    .state('app.feeds-refresher', {
      url: "/feeds-refresher",
      views: {
        'menuContent' :{
          templateUrl: "templates/feeds-refresher.html",
          controller: 'FeedsRefresherCtrl'
        }
      }
    })
    
    .state('app.feed-categories', {
      url: "/feed-categories",
      views: {
        'menuContent' :{
          templateUrl: "templates/feed-categories.html",
          controller: 'FeedPluginCategoriesCtrl'
        }
      }
    })

    .state('app.feed-category', {
      url: "/feed-category/:id",
      views: {
        'menuContent' :{
          templateUrl: "templates/feed-category.html",
          controller: 'FeedPluginCategoryCtrl'
        }
      }
    })
    
    .state('app.feed-master', {
      url: "/feed-master/:categoryId/:id",
      views: {
        'menuContent' :{
          templateUrl: "templates/feed-master.html",
          controller: 'FeedPluginMasterCtrl'
        }
      }
    })
    
    .state('app.feed-detail', {
      url: "/feed-detail/:id",
      views: {
        'menuContent' :{
          templateUrl: "templates/feed-detail.html",
          controller: 'FeedPluginDetailCtrl'
        }
      }
    })
    
    .state('app.plugins', {
      url: "/plugins",
      views: {
        'menuContent' :{
          templateUrl: "templates/plugins.html",
          controller: 'PluginsCtrl'
        }
      }
    })

    .state('app.geolocation', {
      url: "/plugins/geolocation",
      views: {
        'menuContent' :{
          templateUrl: "templates/plugins/geolocation.html",
          controller: 'GeolocationCtrl'
        }
      }
    })

    .state('app.device', {
      url: "/plugins/device",
      views: {
        'menuContent' :{
          templateUrl: "templates/plugins/device.html",
          controller: 'DeviceCtrl'
        }
      }
    })

    .state('app.notifications', {
      url: "/plugins/notifications",
      views: {
        'menuContent' :{
          templateUrl: "templates/plugins/notifications.html",
          controller: 'NotificationsCtrl'
        }
      }
    })

    .state('app.barcodescanner', {
      url: "/plugins/barcodescanner",
      views: {
        'menuContent' :{
          templateUrl: "templates/plugins/barcodescanner.html",
          controller: 'BarcodescannerCtrl'
        }
      }
    })

    .state('app.tabs', {
      url: "/tabs",
      views: {
        'menuContent' :{
          templateUrl: "templates/tabs.html"
        }
      }
    })

    .state('app.settings', {
      url: "/settings",
      views: {
        'menuContent' :{
          templateUrl: "templates/settings.html",
          controller: 'SettingsCtrl'
        }
      }
    })

    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/app/home');
});