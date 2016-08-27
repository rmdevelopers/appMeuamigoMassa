$(document).ready(function () {
	if($('#postsocial').length > 0 ){
		var top = $('#postsocial').offset().top - parseFloat($('#postsocial').css('marginTop').replace(/auto/, 0));
		$(window).scroll(function (event) {
			var y = $(this).scrollTop();
			if (y >= top) {
			  $('#postsocial').addClass('fixed');
			} else {
			  $('#postsocial').removeClass('fixed');
			}
		});
	}
});
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=459058764200061";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
(function() {
  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
  po.src = 'https://apis.google.com/js/platform.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');