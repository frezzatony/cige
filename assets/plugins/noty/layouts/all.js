!
function(t) {
	t.noty.layouts.bottomLeft = {
		name: "bottomLeft",
		options: {},
		container: {
			object: '<ul id="noty_bottomLeft_layout_container" />',
			selector: "ul#noty_bottomLeft_layout_container",
			style: function() {
				t(this).css({
					bottom: 20,
					left: 20,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				}), window.innerWidth < 600 && t(this).css({
					left: 5
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px",
			"margin-top": "3px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.topRight = {
		name: "topRight",
		options: {},
		container: {
			object: '<ul id="noty_topRight_layout_container" />',
			selector: "ul#noty_topRight_layout_container",
			style: function() {
				t(this).css({
					top: 20,
					right: 20,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				}), window.innerWidth < 600 && t(this).css({
					right: 5
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.bottomRight = {
		name: "bottomRight",
		options: {},
		container: {
			object: '<ul id="noty_bottomRight_layout_container" />',
			selector: "ul#noty_bottomRight_layout_container",
			style: function() {
				t(this).css({
					bottom: 20,
					right: 20,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				}), window.innerWidth < 600 && t(this).css({
					right: 5
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px",
			"margin-top": "3px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.bottom = {
		name: "bottom",
		options: {},
		container: {
			object: '<ul id="noty_bottom_layout_container" />',
			selector: "ul#noty_bottom_layout_container",
			style: function() {
				t(this).css({
					bottom: 0,
					left: "5%",
					position: "fixed",
					width: "90%",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 9999999
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.centerRight = {
		name: "centerRight",
		options: {},
		container: {
			object: '<ul id="noty_centerRight_layout_container" />',
			selector: "ul#noty_centerRight_layout_container",
			style: function() {
				t(this).css({
					right: 20,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				});
				var o = t(this).clone().css({
					visibility: "hidden",
					display: "block",
					position: "absolute",
					top: 0,
					left: 0
				}).attr("id", "dupe");
				t("body").append(o), o.find(".i-am-closing-now").remove(), o.find("li").css("display", "block");
				var i = o.height();
				o.remove(), t(this).hasClass("i-am-new") ? t(this).css({
					top: (t(window).height() - i) / 2 + "px"
				}) : t(this).animate({
					top: (t(window).height() - i) / 2 + "px"
				}, 500), window.innerWidth < 600 && t(this).css({
					right: 5
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.topCenter = {
		name: "topCenter",
		options: {},
		container: {
			object: '<ul id="noty_topCenter_layout_container" />',
			selector: "ul#noty_topCenter_layout_container",
			style: function() {
				t(this).css({
					top: 20,
					left: 0,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				}), t(this).css({
					left: (t(window).width() - t(this).outerWidth(!1)) / 2 + "px"
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {
				"margin-bottom": 4
			}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.center = {
		name: "center",
		options: {},
		container: {
			object: '<ul id="noty_center_layout_container" />',
			selector: "ul#noty_center_layout_container",
			style: function() {
				t(this).css({
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				});
				var o = t(this).clone().css({
					visibility: "hidden",
					display: "block",
					position: "absolute",
					top: 0,
					left: 0
				}).attr("id", "dupe");
				t("body").append(o), o.find(".i-am-closing-now").remove(), o.find("li").css("display", "block");
				var i = o.height();
				o.remove(), t(this).hasClass("i-am-new") ? t(this).css({
					left: (t(window).width() - t(this).outerWidth(!1)) / 2 + "px",
					top: (t(window).height() - i) / 2 + "px"
				}) : t(this).animate({
					left: (t(window).width() - t(this).outerWidth(!1)) / 2 + "px",
					top: (t(window).height() - i) / 2 + "px"
				}, 500)
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.topLeft = {
		name: "topLeft",
		options: {},
		container: {
			object: '<ul id="noty_topLeft_layout_container" />',
			selector: "ul#noty_topLeft_layout_container",
			style: function() {
				t(this).css({
					top: 20,
					left: 20,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				}), window.innerWidth < 600 && t(this).css({
					left: 5
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.top = {
		name: "top",
		options: {},
		container: {
			object: '<ul id="noty_top_layout_container" />',
			selector: "ul#noty_top_layout_container",
			style: function() {
				t(this).css({
					top: 0,
					left: "5%",
					position: "fixed",
					width: "90%",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 9999999
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.centerLeft = {
		name: "centerLeft",
		options: {},
		container: {
			object: '<ul id="noty_centerLeft_layout_container" />',
			selector: "ul#noty_centerLeft_layout_container",
			style: function() {
				t(this).css({
					left: 20,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				});
				var o = t(this).clone().css({
					visibility: "hidden",
					display: "block",
					position: "absolute",
					top: 0,
					left: 0
				}).attr("id", "dupe");
				t("body").append(o), o.find(".i-am-closing-now").remove(), o.find("li").css("display", "block");
				var i = o.height();
				o.remove(), t(this).hasClass("i-am-new") ? t(this).css({
					top: (t(window).height() - i) / 2 + "px"
				}) : t(this).animate({
					top: (t(window).height() - i) / 2 + "px"
				}, 500), window.innerWidth < 600 && t(this).css({
					left: 5
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.inline = {
		name: "inline",
		options: {},
		container: {
			object: '<ul class="noty_inline_layout_container" />',
			selector: "ul.noty_inline_layout_container",
			style: function() {
				t(this).css({
					width: "100%",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 9999999
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none"
		},
		addClass: ""
	}
}(jQuery), function(t) {
	t.noty.layouts.bottomCenter = {
		name: "bottomCenter",
		options: {},
		container: {
			object: '<ul id="noty_bottomCenter_layout_container" />',
			selector: "ul#noty_bottomCenter_layout_container",
			style: function() {
				t(this).css({
					bottom: 20,
					left: 0,
					position: "fixed",
					width: "310px",
					height: "auto",
					margin: 0,
					padding: 0,
					listStyleType: "none",
					zIndex: 1e7
				}), t(this).css({
					left: (t(window).width() - t(this).outerWidth(!1)) / 2 + "px"
				})
			}
		},
		parent: {
			object: "<li />",
			selector: "li",
			css: {}
		},
		css: {
			display: "none",
			width: "310px"
		},
		addClass: ""
	}
}(jQuery);