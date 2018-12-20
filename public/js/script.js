/*function disableF5(e) { if ((e.which || e.keyCode) == 116) e.preventDefault(); };
$(document).on("keydown", disableF5);*/

$("html").on("contextmenu",function(){
   return false;
});

(function() {
		var 
			fullScreenApi = { 
				supportsFullScreen: false,
				isFullScreen: function() { return false; }, 
				requestFullScreen: function() {}, 
				cancelFullScreen: function() {},
				fullScreenEventName: '',
				prefix: ''
			},
			browserPrefixes = 'webkit moz o ms khtml'.split(' ');
		if (typeof document.cancelFullScreen != 'undefined') {
			fullScreenApi.supportsFullScreen = true;
		} else {	 
			for (var i = 0, il = browserPrefixes.length; i < il; i++ ) {
				fullScreenApi.prefix = browserPrefixes[i];
				if (typeof document[fullScreenApi.prefix + 'CancelFullScreen' ] != 'undefined' ) {
					fullScreenApi.supportsFullScreen = true;
					break;
				}
			}
		}
		// update methods to do something useful
		if (fullScreenApi.supportsFullScreen) {
			fullScreenApi.fullScreenEventName = fullScreenApi.prefix + 'fullscreenchange';
			fullScreenApi.isFullScreen = function() {
				switch (this.prefix) {	
					case '':
						return document.fullScreen;
					case 'webkit':
						return document.webkitIsFullScreen;
					default:
						return document[this.prefix + 'FullScreen'];
				}
			}
			fullScreenApi.requestFullScreen = function(el) {
				return (this.prefix === '') ? el.requestFullScreen() : el[this.prefix + 'RequestFullScreen']();
			}
			fullScreenApi.cancelFullScreen = function(el) {
				return (this.prefix === '') ? document.cancelFullScreen() : document[this.prefix + 'CancelFullScreen']();
			}		
		}

		// jQuery plugin
		if (typeof jQuery != 'undefined') {
			jQuery.fn.requestFullScreen = function() {
				return this.each(function() {
					var el = jQuery(this);
					if (fullScreenApi.supportsFullScreen) {
						fullScreenApi.requestFullScreen(el);
					}
				});
			};
		}
		// export api
		window.fullScreenApi = fullScreenApi;	
	})();

	var fsButton = document.getElementById('start-exam'),
		fsElement = document.getElementById('specialstuff'),
		fsStatus = document.getElementById('fsstatus');
	if (window.fullScreenApi.supportsFullScreen) {
		fsStatus.innerHTML = '<i class="fa fa-check-square"></i> Browser anda support buat ujian ini';
		fsStatus.className = 'fullScreenSupported';
		
		// handle button click
		fsButton.addEventListener('click', function() {
			window.fullScreenApi.requestFullScreen(fsElement);
		}, true);
		
		fsElement.addEventListener(fullScreenApi.fullScreenEventName, function() {
			if (fullScreenApi.isFullScreen()) {
				// fsStatus.innerHTML = 'Selamat mengerjakan soal-soalnya...';
			} else {
				$("#specialstuff").hide();
				// fsStatus.innerHTML = 'Back to normal';
			}
		}, true);
	} else {
		fsStatus.innerHTML = 'Maaf, sepertinya browser anda tidak bisa untuk ujian. Silahkan upgrade terlebih dahulu!';
	}