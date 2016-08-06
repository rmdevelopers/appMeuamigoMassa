angular.module('mobionicApp.storage', [])

.factory('NewsStorage', function() {
  return {
    all: function() {
      var news = window.localStorage['news'];
      if(news) {
        return angular.fromJson(news);
      }
      return {};
    },
    save: function(news) {
      window.localStorage['news'] = angular.toJson(news);
    },
    clear: function() {
      window.localStorage.removeItem('news');
    }
  }
})

.factory('ProductsStorage', function() {
  return {
    all: function() {
      var products = window.localStorage['products'];
      if(products) {
        return angular.fromJson(products);
      }
      return {};
    },
    save: function(products) {
      window.localStorage['products'] = angular.toJson(products);
    },
    clear: function() {
      window.localStorage.removeItem('products');
    }
  }
})

.factory('AboutStorage', function() {
  return {
    all: function() {
      var about = window.localStorage['about'];
      if(about) {
        return angular.fromJson(about);
      }
      return {};
    },
    save: function(about) {
      window.localStorage['about'] = angular.toJson(about);
    },
    clear: function() {
      window.localStorage.removeItem('about');
    }
  }
})

.factory('PostsStorage', function() {
  return {
    all: function() {
      var posts = window.localStorage['posts'];
      if(posts) {
        return angular.fromJson(posts);
      }
      return {};
    },
    save: function(posts) {
      window.localStorage['posts'] = angular.toJson(posts);
    },
    clear: function() {
      window.localStorage.removeItem('posts');
    }
  }
})

.factory('ServerPostsStorage', function() {
  return {
    all: function() {
      var serverposts = window.localStorage['serverposts'];
      if(serverposts) {
        return angular.fromJson(serverposts);
      }
      return {};
    },
    save: function(serverposts) {
      window.localStorage['serverposts'] = angular.toJson(serverposts);
    },
    clear: function() {
      window.localStorage.removeItem('serverposts');
    }
  }
})

.factory('FeedsStorage', function() {
  return {
    all: function() {
      var feeds = window.localStorage['feeds'];
      if(feeds) {
        return angular.fromJson(feeds);
      }
      return {};
    },
    save: function(feeds) {
      window.localStorage['feeds'] = angular.toJson(feeds);
    },
    clear: function() {
      window.localStorage.removeItem('feeds');
    }
  }
})

.factory('SettingsStorage', function() {
  return {
    all: function() {
      var settings = window.localStorage['settings'];
      if(settings) {
        return angular.fromJson(settings);
      }
      return {
            // Initial App Setting Values
            options: [
            {
               name: 'First Option',
               checked: true
            }, 
            {
               name: 'Second Option',
               checked: false
            }, 
            {
               name: 'Third Option',
               checked: false
            }, 
            {
               name: 'Fourth Option',
               checked: false
            }, 
            {
               name: 'Fifth Option',
               checked: false
            }],
            sorting: 'A',
            range:30
        };
    },
    save: function(settings) {
      window.localStorage['settings'] = angular.toJson(settings);
    },
    clear: function() {
      window.localStorage.removeItem('settings');
    }
  }
})