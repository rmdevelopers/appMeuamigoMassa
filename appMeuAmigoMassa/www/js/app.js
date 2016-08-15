// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js

//instancia os scripts controladores ( controllers ), botões ( data ).
angular.module('starter', ['ionic', 'starter.controllers', 'starter.data'])

.run(function($ionicPlatform) {
  $ionicPlatform.ready(function() {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      cordova.plugins.Keyboard.disableScroll(true);

    }
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }

  });
})

.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider

//app base, caso tenha um side-menu
    .state('app', {
    url: '/app',
    abstract: true,
    templateUrl: 'templates/sidemenu.html',
    controller: 'AppCtrl'
  })

//menu
  .state('app.menu', {
    url: '/menu',
    views: {
      'menuContent': {
        templateUrl: 'templates/menu.html',
        controller: 'MenuCtrl'
      }
    }
  })

  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/app/menu');
});
