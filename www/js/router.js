app.config(function($stateProvider, $urlRouterProvider) {
  $stateProvider
  	//sidebar
    .state('appmam', {
      url: "/appmam",
      abstract: true,
      templateUrl: "templates/sidebar-menu.html"
    })
	 // home page
	 .state('appmam.home', {
      url: "/home",
		cache : false,
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/home.html",
		  		controller: "HomeCtrl"
        }
      },
      changeColor: 'bar-assertive'
    })

   // novidades page
   .state('appmam.novidades', {
      url: "/novidades",
    cache : true,
      views: {
        'menuWorPress' :{
            templateUrl: "templates/novidades.html",
          controller: "NovidadesCtrl"
        }
      }
    })

   // novidades page
   .state('appmam.galeria', {
      url: "/galeria",
    cache : true,
      views: {
        'menuWorPress' :{
            templateUrl: "templates/galeria.html",
          controller: "GaleriaCtrl"
        }
      }
    })

	  // articles page wordpress
	 .state('appmam.post', {
      url: "/post/:catId/:offset/:index/:type",
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/post.html",
		  		controller: "PostCtrl"
        }
      }
    })

   // articles page wordpress
   .state('appmam.selfie', {
      url: "/selfie",
      views: {
        'menuWorPress' :{
            templateUrl: "templates/selfie.html",
          controller: "CameraCtrl"
        }
      }
    })

   // articles page wordpress
   .state('appmam.moldura', {
      url: "/moldura/:imgsrc",
      cache : false,
      views: {
        'menuWorPress' :{
            templateUrl: "templates/moldura.html",
          controller: "MolduraCtrl"
        }
      }
    })

	 // Blog page
	 .state('appmam.categories', {
      url: "/categories",
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/categories.html",
		  		controller: "CategoriesCtrl"
        }
      }
    })
	 // Blog page
	 .state('appmam.category', {
      url: "/category/:category/:categoryName",
		cache : false,
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/home.html",
		  		controller: "CategoryCtrl"
        }
      }
    })
	 // Blog page
	 .state('appmam.search', {
      url: "/search",
		cache : false,
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/search.html",
		  		controller: "SearchCtrl"
        }
      }
    })
	 .state('appmam.settings', {
      url: "/settings",
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/settings.html",
		  		controller: "SettingsCtrl"
        }
      }
    })
	 .state('appmam.contact', {
      url: "/contact",
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/contact.html",
		  		controller: "ContactCtrl"
        }
      }
    })
	 .state('appmam.sobre', {
      url: "/sobre",
      cache : false,
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/sobre.html",
		  		controller: "AboutCtrl"
        }
      }
    })
	 .state('appmam.admob', {
      url: "/admob",
      views: {
        'menuWorPress' :{
          	templateUrl: "templates/admob.html",
		  		controller: "AdmobCtrl"
        }
      }
    })
   .state('appmam.localizacao', {
      url: "/localizacao",
      views: {
        'menuWorPress' :{
            templateUrl: "templates/localizacao.html",
          controller: "LocalizacaoCtrl"
        }
      }
    })
  	$urlRouterProvider.otherwise("/appmam/home");
})