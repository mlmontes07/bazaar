!function(e, n, a) {
    "use strict";
    var t = a("html")
      , s = a("body");
    if (a(e).on("load", (function() {
        var i = !1;
        s.hasClass("menu-collapsed") && (i = !0),
        a("html").data("textdirection"),
        setTimeout((function() {
            t.removeClass("loading").addClass("loaded")
        }
        ), 1200),
        a.app.menu.init(i);
        !1 === a.app.nav.initialized && a.app.nav.init({
            speed: 300
        }),
        Unison.on("change", (function(e) {
            a.app.menu.change()
        }
        )),
        a('[data-toggle="tooltip"]').tooltip({
            container: "body"
        }),
        a(".navbar-hide-on-scroll").length > 0 && (a(".navbar-hide-on-scroll.fixed-top").headroom({
            offset: 205,
            tolerance: 5,
            classes: {
                initial: "headroom",
                pinned: "headroom--pinned-top",
                unpinned: "headroom--unpinned-top"
            }
        }),
        a(".navbar-hide-on-scroll.fixed-bottom").headroom({
            offset: 205,
            tolerance: 5,
            classes: {
                initial: "headroom",
                pinned: "headroom--pinned-bottom",
                unpinned: "headroom--unpinned-bottom"
            }
        })),
        setTimeout((function() {
            var e;
            a("body").hasClass("vertical-content-menu") && (e = a(".main-menu").height(),
            a(".content-body").height() < e && a(".content-body").css("height", e))
        }
        ), 500),
        a('a[data-action="collapse"]').on("click", (function(e) {
            e.preventDefault(),
            a(this).closest(".card").children(".card-content").collapse("toggle"),
            a(this).closest(".card").find('[data-action="collapse"] i').toggleClass("ft-plus ft-minus")
        }
        )),
        a('a[data-action="expand"]').on("click", (function(e) {
            e.preventDefault(),
            a(this).closest(".card").find('[data-action="expand"] i').toggleClass("ft-maximize ft-minimize"),
            a(this).closest(".card").toggleClass("card-fullscreen")
        }
        )),
        a(".scrollable-container").length > 0 && a(".scrollable-container").each((function() {
            new PerfectScrollbar(a(this)[0],{
                wheelPropagation: !1
            })
        }
        )),
        a('a[data-action="reload"]').on("click", (function() {
            a(this).closest(".card").block({
                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                timeout: 2e3,
                overlayCSS: {
                    backgroundColor: "#FFF",
                    cursor: "wait"
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: "none"
                }
            })
        }
        )),
        a('a[data-action="close"]').on("click", (function() {
            a(this).closest(".card").removeClass().slideUp("fast")
        }
        )),
        setTimeout((function() {
            a(".row.match-height").each((function() {
                a(this).find(".card").not(".card .card").matchHeight()
            }
            ))
        }
        ), 500),
        a('.card .heading-elements a[data-action="collapse"]').on("click", (function() {
            var e, n = a(this).closest(".card");
            parseInt(n[0].style.height, 10) > 0 ? (e = n.css("height"),
            n.css("height", "").attr("data-height", e)) : n.data("height") && (e = n.data("height"),
            n.css("height", e).attr("data-height", ""))
        }
        )),
        a(".main-menu-content").find("li.active").parents("li").addClass("menu-collapsed-open");
        var o = s.data("menu");
        "vertical-compact-menu" != o && "horizontal-menu" != o && !1 === i && a(".main-menu-content").find("li.active").parents("li").addClass("open"),
        "vertical-compact-menu" != o && "horizontal-menu" != o || (a(".main-menu-content").find("li.active").parents("li:not(.nav-item)").addClass("open"),
        a(".main-menu-content").find("li.active").parents("li").addClass("active")),
        a(".heading-elements-toggle").on("click", (function() {
            a(this).parent().children(".heading-elements").toggleClass("visible")
        }
        ));
        var l = a(".chartjs")
          , r = l.children("canvas").attr("height");
        l.css("height", r);
        var c = a(".search-input input").data("search");
        a(".nav-link-search").on("click", (function() {
            a(this);
            a(this).parent(".nav-search").find(".search-input").addClass("open"),
            setTimeout((function() {
                a(".search-input.open .input").focus()
            }
            ), 50),
            a(".search-input .search-list li").remove(),
            a(".search-input .search-list").addClass("show")
        }
        )),
        a(".search-input-close i").on("click", (function() {
            a(this);
            var e = a(this).closest(".search-input");
            e.hasClass("open") && (e.removeClass("open"),
            a(".search-input input").val(""),
            a(".search-input input").blur(),
            a(".search-input .search-list").removeClass("show"),
            a(".app-content").hasClass("show-overlay") && a(".app-content").removeClass("show-overlay"))
        }
        )),
        a(".app-content").on("click", (function() {
            var e = a(".search-input-close")
              , n = a(e).parent(".search-input")
              , t = a(".search-list");
            n.hasClass("open") && n.removeClass("open"),
            t.hasClass("show") && t.removeClass("show"),
            a(".app-content").hasClass("show-overlay") && a(".app-content").removeClass("show-overlay")
        }
        )),
        a(".search-input .input").on("keyup", (function(e) {
            if (38 !== e.keyCode && 40 !== e.keyCode && 13 !== e.keyCode) {
                27 == e.keyCode && (a(".search-input input").val(""),
                a(".search-input input").blur(),
                a(".search-input").removeClass("open"),
                a(".search-list").hasClass("show") && (a(this).removeClass("show"),
                a(".search-input").removeClass("show")));
                var n = a(this).val().toLowerCase();
                if (a("ul.search-list li").remove(),
                "" != n) {
                    a(".app-content").addClass("show-overlay");
                    var t = ""
                      , s = ""
                      , i = ""
                      , o = 0;
                    console.log('searcing for: '+n);
                } else
                    a(".app-content").hasClass("show-overlay") && a(".app-content").removeClass("show-overlay")
            }
        }
        )),
        a(e).on("keydown", (function(n) {
            var t, s, i = a(".search-list li.current_item");
            if (40 === n.keyCode ? (t = i.next(),
            i.removeClass("current_item"),
            i = t.addClass("current_item")) : 38 === n.keyCode && (s = i.prev(),
            i.removeClass("current_item"),
            i = s.addClass("current_item")),
            13 === n.keyCode && a(".search-list li.current_item").length > 0) {
                var o = a(".search-list li.current_item a");
                e.location = o.attr("href"),
                a(o).trigger("click")
            }
        }
        )),
        a(n).on("mouseenter", ".search-list li", (function(e) {
            a(this).siblings().removeClass("current_item"),
            a(this).addClass("current_item")
        }
        )),
        a(n).on("click", ".search-list li", (function(e) {
            e.stopPropagation()
        }
        ))
    }
    )),
    a(n).on("click", ".sidenav-overlay", (function(e) {
        return a.app.menu.hide(),
        !1
    }
    )),
    "undefined" != typeof Hammer) {
        var i;
        "rtl" == a("html").data("textdirection") && (i = !0);
        var o = n.querySelector(".drag-target")
          , l = "panright"
          , r = "panleft";
        if (!0 === i && (l = "panleft",
        r = "panright"),
        a(o).length > 0)
            new Hammer(o).on(l, (function(e) {
                if (s.hasClass("vertical-overlay-menu"))
                    return a.app.menu.open(),
                    !1
            }
            ));
        setTimeout((function() {
            var e, t = n.querySelector(".main-menu");
            a(t).length > 0 && ((e = new Hammer(t)).get("pan").set({
                direction: Hammer.DIRECTION_ALL,
                threshold: 100
            }),
            e.on(r, (function(e) {
                if (s.hasClass("vertical-overlay-menu"))
                    return a.app.menu.hide(),
                    !1
            }
            )))
        }
        ), 300);
        var c = n.querySelector(".sidenav-overlay");
        if (a(c).length > 0)
            new Hammer(c).on(r, (function(e) {
                if (s.hasClass("vertical-overlay-menu"))
                    return a.app.menu.hide(),
                    !1
            }
            ))
    }
    a(n).on("click", ".menu-toggle, .modern-nav-toggle", (function(n) {
        return n.preventDefault(),
        a(".user-profile .user-info .dropdown").hasClass("show") && (a(".user-profile .user-info .dropdown").removeClass("show"),
        a(".user-profile .user-info .dropdown .dropdown-menu").removeClass("show")),
        a.app.menu.toggle(),
        setTimeout((function() {
            a(e).trigger("resize")
        }
        ), 200),
        a("#collapsed-sidebar").length > 0 && setTimeout((function() {
            s.hasClass("menu-expanded") || s.hasClass("menu-open") ? a("#collapsed-sidebar").prop("checked", !1) : a("#collapsed-sidebar").prop("checked", !0)
        }
        ), 1e3),
        a(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").hasClass("show") && a(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").removeClass("show"),
        !1
    }
    )),
    a(n).on("click", ".open-navbar-container", (function(e) {
        Unison.fetch.now()
    }
    )),
    a(".navigation").find("li").has("ul").addClass("has-sub"),
    a(".carousel").carousel({
        interval: 2e3
    }),
    a(".nav-link-expand").on("click", (function(e) {
        "undefined" != typeof screenfull && screenfull.isEnabled && screenfull.toggle()
    }
    )),
    "undefined" != typeof screenfull && screenfull.isEnabled && a(n).on(screenfull.raw.fullscreenchange, (function() {
        screenfull.isFullscreen ? a(".nav-link-expand").find("i").toggleClass("ft-minimize ft-maximize") : a(".nav-link-expand").find("i").toggleClass("ft-maximize ft-minimize")
    }
    )),
    a(n).on("click", ".mega-dropdown-menu", (function(e) {
        e.stopPropagation()
    }
    )),
    a(n).ready((function() {
        a(".step-icon").each((function() {
            var e = a(this);
            e.siblings("span.step").length > 0 && (e.siblings("span.step").empty(),
            a(this).appendTo(a(this).siblings("span.step")))
        }
        ))
    }
    )),
    a(e).resize((function() {
        a.app.menu.manualScroller.updateHeight(),
        a(e).width() > 768 && (a(".search-input input").val(""),
        a(".search-input input").blur(),
        a(".search-input").removeClass("open"),
        a(".header-navbar").find(".search-list.show") && a(".header-navbar").find(".search-list.show").removeClass("show"),
        a(".app-content").removeClass("show-overlay"))
    }
    )),
    a("#sidebar-page-navigation").on("click", "a.nav-link", (function(e) {
        e.preventDefault(),
        e.stopPropagation();
        var n = a(this)
          , t = n.attr("href")
          , s = a(t).offset().top - 80;
        a("html, body").animate({
            scrollTop: s
        }, 0),
        setTimeout((function() {
            n.parent(".nav-item").siblings(".nav-item").children(".nav-link").removeClass("active"),
            n.addClass("active")
        }
        ), 100)
    }
    )),
    a(".dropdown-language .dropdown-item").on("click", (function() {
        var e = a(this);
        e.siblings(".selected").removeClass("selected"),
        e.addClass("selected");
        var n = e.text()
          , t = e.find(".flag-icon").attr("class");
        a("#dropdown-flag .selected-language").text(n),
        a("#dropdown-flag .flag-icon").removeClass().addClass(t);
        var s = e.data("language");
        i18next.changeLanguage(s, (function(e, n) {
            a(".main-menu , .navbar-horizontal").localize()
        }
        ))
    }
    ))
}(window, document, jQuery);
