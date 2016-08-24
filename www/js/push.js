window.onNotificationGCM = function(e) {
    switch (e.event) {
      case 'registered':
        if (e.regid.length > 0) {
            //alert("regID = " + e.regid);
            var elem = angular.element(document.querySelector('[ng-app]'));
            var injector = elem.injector();
            var myService = injector.get('myService');
            myService.registerID(e.regid, 'android');
            elem.scope().$apply();
        }
        break;
      case 'message':
		
		//alert(e);
        if (e.foreground) {
          console.log('FOREGROUND NOTIFICATION');
        } else {
			  //alert('test');
          if (e.coldstart) {
              console.log('COLDSTART NOTIFICATION');
          } else {
              console.log('BACKGROUND NOTIFICATION');
          }
        }
		 
        navigator.notification.alert(e.payload.title);
        break;

      case 'error':
          console.log('ERROR MESSAGE: ' + e.msg);
        break;

      default:
          console.log('UNKNOWN EVENT');
        break;
    }
}