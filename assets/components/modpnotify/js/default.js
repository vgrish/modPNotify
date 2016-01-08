if (typeof(modPNotify) == 'undefined') {
	modPNotify = {
		Init: false
	};
}

modPNotifyConfig = {
	assetsUrl: '/assets/components/modpnotify/',
	defaults: {
		message: {
			title: {
				success: 'success',
				error: 'error',
				info: 'info'
			}
		},
		yes: 'yes',
		no: 'no'
	}
};

modPNotify = {
	initialize: function () {
		if (!jQuery().pnotify) {
			document.write('<script src="' + modPNotifyConfig.assetsUrl + 'build/pnotify.custom.js"><\/script>');
			$('<link/>', {
				rel: 'stylesheet',
				type: 'text/css',
				href: modPNotifyConfig.assetsUrl + 'build/pnotify.custom.css'
			}).appendTo('head');
		}

		$(document).ready(function () {
			PNotify.prototype.options.styling = "bootstrap3";

		});
		modPNotify.Init = true;
	}
};


modPNotify.Message = {
	defaults: {
		delay: 4000,
		addclass: 'modPNotify-message'
	},
	success: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'success';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.message.title.success : title;
		new PNotify($.extend({}, this.defaults, notify));
	},
	error: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'error';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.message.title.error : title;
		new PNotify($.extend({}, this.defaults, notify));
	},
	info: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'info';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.message.title.info : title;
		new PNotify($.extend({}, this.defaults, notify));
	},
	remove: function () {
		PNotify.removeAll();
	}
};

modPNotify.Confirm = {
	defaults: {
		hide: false,
		addclass: 'modPNotify-сonfirm',
		icon: 'glyphicon glyphicon-question-sign',
		confirm: {
			confirm: true,
			buttons: [{
				text: modPNotifyConfig.defaults.yes,
				addClass: 'btn-primary'

			}, {
				text: modPNotifyConfig.defaults.no,
				addClass: 'btn-danger'

			}]
		},
		buttons: {
			closer: false,
			sticker: false
		},
		history: {
			history: false
		}
	},
	success: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'success';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.confirm.title.success : title;
		return new PNotify($.extend({}, this.defaults, notify));
	},
	error: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'error';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.confirm.title.error : title;
		return new PNotify($.extend({}, this.defaults, notify));
	},
	info: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'info';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.confirm.title.info : title;
		return new PNotify($.extend({}, this.defaults, notify));
	},
	form: function (form, type, title, message) {
		if (!type) return false;
		if (form) {
			$.extend(this.defaults, {
				before_init: function (opts) {
					$(form).find('input[type="button"], button, a').attr('disabled', true);
				},
				after_close: function (PNotify, timer_hide) {
					$(form).find('input[type="button"], button, a').attr('disabled', false);
				}
			});
		}

		switch (type) {
			case 'success':
				return this.success(title, message);
			default:
			case 'error':
				return this.error(title, message);
			case 'info':
				return this.info(title, message);
		}
	},
	remove: function () {
		return PNotify.removeAll();
	}
};

modPNotify.initialize();