"use strict";

var swiper = new Swiper(".banner-home .swiper", {
    spaceBetween: 20,
    slidesPerView: 1,
    direction: "horizontal",
    loop: !0,
    pagination: {
      el: ".swiper-pagination",
    },
  }),
  swiper1 = new Swiper(".vidy-turov .swiper", {
    loop: !1,
    spaceBetween: 20,
    slidesPerView: "auto",
    direction: "horizontal",
    navigation: {
      nextEl: ".vidy-turov .swiper-button-next",
      prevEl: ".vidy-turov .swiper-button-prev",
    },
    breakpoints: {
      300: {
        slidesPerView: "auto",
        spaceBetween: 20,
      },
      767: {
        slidesPerView: "auto",
        spaceBetween: 30,
      },
      1200: {
        slidesPerView: "auto",
        spaceBetween: 40,
      },
    },
  }),
  swiper2 = new Swiper(".otz .swiper", {
    loop: !1,
    spaceBetween: 40,
    slidesPerView: "auto",
    direction: "horizontal",
    navigation: {
      nextEl: ".otz .swiper-button-next",
      prevEl: ".otz .swiper-button-prev",
    },
    breakpoints: {
      300: {
        slidesPerView: "auto",
        spaceBetween: 20,
      },
      767: {
        slidesPerView: "auto",
        spaceBetween: 30,
      },
      1200: {
        slidesPerView: "auto",
        spaceBetween: 40,
      },
    },
  });
!(function (e) {
  "function" != typeof e.matches &&
    (e.matches =
      e.msMatchesSelector ||
      e.mozMatchesSelector ||
      e.webkitMatchesSelector ||
      function (e) {
        for (
          var t = this,
            s = (t.document || t.ownerDocument).querySelectorAll(e),
            o = 0;
          s[o] && s[o] !== t;

        )
          ++o;
        return Boolean(s[o]);
      }),
    "function" != typeof e.closest &&
      (e.closest = function (e) {
        for (var t = this; t && 1 === t.nodeType; ) {
          if (t.matches(e)) return t;
          t = t.parentNode;
        }
        return null;
      });
})(window.Element.prototype),
  document.addEventListener("DOMContentLoaded", function () {
    var e = document.querySelectorAll(".js-open-modal"),
      t = document.querySelector(".js-overlay-modal"),
      s = document.querySelectorAll(".js-modal-close");
    e.forEach(function (e) {
      e.addEventListener("click", function (e) {
        e.preventDefault();
        var s = this.getAttribute("data-modal");
        document
          .querySelector('.modal[data-modal="' + s + '"]')
          .classList.add("active"),
          t.classList.add("active");
      });
    }),
      s.forEach(function (e) {
        e.addEventListener("click", function (e) {
          this.closest(".modal").classList.remove("active"),
            t.classList.remove("active");
        });
      }),
      document.body.addEventListener(
        "keyup",
        function (e) {
          27 == e.keyCode &&
            (document.querySelector(".modal.active").classList.remove("active"),
            document.querySelector(".overlay").classList.remove("active"));
        },
        !1
      ),
      t.addEventListener("click", function () {
        document.querySelector(".modal.active").classList.remove("active"),
          this.classList.remove("active");
      });
  });
var Tabs = /*#__PURE__*/ (function () {
  function Tabs(e) {
    _classCallCheck(this, Tabs);
    this.container = e;
    var t = e.querySelector("[data-tabs-nav]"),
      s = e.querySelector("[data-tabs-list]");
    (this.navItems = t.querySelectorAll(":scope > *")),
      (this.listItems = s.querySelectorAll(":scope > *"));
  }
  _createClass(Tabs, [
    {
      key: "init",
      value: function init() {
        var _this = this;
        for (var e = 0; e < this.navItems.length; e++) {
          var t = this.navItems[e];
          this.active && t.classList.contains("active") && (this.isActive = e),
            t.classList.remove("active"),
            (t.dataset.index = e);
        }
        this.listItems.forEach(function (e) {
          return e.classList.remove("active");
        }),
          this.active || (this.isActive = 0),
          this.toggle(this.isActive),
          this.navItems.forEach(function (e) {
            e.addEventListener("click", function () {
              _this.toggle(e.dataset.index);
            });
          });
      },
    },
    {
      key: "toggle",
      value: function toggle(e) {
        this.navItems[this.isActive].classList.remove("active"),
          this.listItems[this.isActive].classList.remove("active"),
          (this.isActive = e),
          this.navItems[this.isActive].classList.add("active"),
          this.listItems[this.isActive].classList.add("active");
      },
    },
  ]);
  return Tabs;
})();
var tabItems = document.querySelectorAll("[data-tabs]");
tabItems.forEach(function (e) {
  new Tabs(e).init();
});
var mansoryTabs = document.querySelectorAll(".tury .tab__panels .tab__element");
function openMansoryBlocks(e, t, s) {
  var o = e.querySelectorAll(".cont-tury .block:not(.show)");
  for (var _e = 0; _e < t; _e++) {
    var _t = o[_e];
    if (!_t) break;
    _t.classList.add("show");
  }
  o.length <= t && s.remove();
}
mansoryTabs.forEach(function (e) {
  var t = e.querySelector(".tury .btn-add");
  var s = 6;
  document.body.clientWidth < 1200 && (s = 4),
    document.body.clientWidth < 767 && (s = 3),
    openMansoryBlocks(e, s, t),
    t.addEventListener("click", function () {
      openMansoryBlocks(e, s, t);
    });
});
var list = document.querySelectorAll(".otz .swiper-slide");
list.forEach(function (e) {
  var t = e.querySelector(".otz .btns button"),
    s = e.querySelector(".otz .btns button span"),
    o = e.querySelector(".otz .text");
  t.addEventListener("click", function () {
    t.classList.toggle("active"),
      o.classList.toggle("text--full"),
      "Свернуть отзыв" === s.innerHTML
        ? (s.innerHTML = "Раскрыть отзыв")
        : (s.innerHTML = "Свернуть отзыв");
  });
});
var bntMenu = document.querySelector(".menu-btn"),
  closeMenu = document.querySelector(".close-menu"),
  menu = document.querySelector(".header-mid nav"),
  body = document.body;
bntMenu.addEventListener("click", function () {
  menu.classList.toggle("active"), body.classList.toggle("no_scroll");
}),
  closeMenu.addEventListener("click", function () {
    menu.classList.remove("active"), body.classList.remove("no_scroll");
  });
