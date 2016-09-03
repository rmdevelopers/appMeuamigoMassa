// friends factory
app.factory('NewsApp',['$http', 'Config', function($http, Config) {
	/*var data = {};
	data.getPosts = function (page, category) {
		if(category){
			return $http(
				{
					method: 'GET', url:Config.WebUrl+'api/news/posts/?offset='+page+'&category='+category
				}
			);
		} else {
			return $http(
				{
					method: 'GET', url:Config.WebUrl+'api/news/posts/?offset='+page
				}
			);
		}
	},
	data.getCategries = function () {
		return $http(
			{
				method: 'GET', url:Config.WebUrl+'api/news/category/'
			}
		);
	},
	data.searchPosts = function (query, page) {
		return $http(
			{
				method: 'GET', url:Config.WebUrl+'api/news/search/?offset='+page+'&query='+query
			}
		);
	}
  	return data;*/

  		var data = {};
		data.getPosts = function (page, category) {		
			return $http(
				{
					method: 'GET', url:Config.WebUrl+'api/news/posts/?offset='+page+'&category='+category
				}
			);
	}
  	return data;
}]);
// GaleriaApp factory
app.factory('GaleriaApps',['$http', 'Config', function($http, Config) {
	var data = {};
	data.getPosts = function (page, category) {		
			return $http(
				{
					method: 'GET', url:Config.WebUrl+'api/news/posts/?offset='+page+'&category='+category
				}
			);
	}
  	return data;
}]);

// global factory
app.factory('globalFactory', function() {
	return {
		// get first image or feed
		getPostImageFeed: function( postContent ) {
			var div = document.createElement('div');
			div.innerHTML = postContent;
			var img = div.getElementsByTagName("img");
			var iframe = div.getElementsByTagName("iframe");
			if (img.length >= 1) {
				imgthumb = img[0].src;
				return imgthumb;
			} else if (iframe.length >= 1){
				iframeVideo = iframe[0].src;
				var re = /(\?v=|\/\d\/|\/embed\/)([a-zA-Z0-9\-\_]+)/;
				videokeynum = iframeVideo.match(re);
				if(videokeynum) {
					videokey = iframeVideo.match(re)[2];
					imageurl = 'http://i2.ytimg.com/vi/'+videokey+'/0.jpg';
					return imageurl;	              
			  }
			}
		},
		getDateData: function(dt){
			var dates = {
				'01' : 'January',
				'02' : 'February',
				'03' : 'March',
				'04' : 'April',
				'05' : 'May',
				'06' : 'June',
				'07' : 'July',
				'08' : 'August',
				'09' : 'September',
				'10' : 'October',
				'11' : 'November',
				'12' : 'December',
			}
			return dates[dt];
		}
	};
});
app.factory('myPushNotification', ['$http', 'PushNoti', function ($http, PushNoti) {
  return {
	
  };
}]);
// push notification push to server
app.factory('SendPush',['$http', 'Config', function($http, Config) {
	var SendPush = {};
	SendPush.saveDetails = function(token, device_id, platform) {
		return  $http({method: "post", url: Config.WebUrl+'device/',
			data: {
				token: token,
				device_id: device_id,
				platform: platform
			}
		});
	}
	SendPush.getDetails = function(device_id) {
		return  $http({
			method: "GET", url: Config.WebUrl+'device/pushstatus?device_id='+device_id,
		});
	}
	SendPush.savePushDetails = function(device_id,status) {
		return  $http({method: "post", url: Config.WebUrl+'device/push',
			data: {
				device_id: device_id,
				status: status
			}
		});
	}
  	return SendPush;
}]);