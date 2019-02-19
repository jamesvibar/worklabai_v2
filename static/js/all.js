import "../scss/main.scss"; //Import main stylesheet to compile it.

import $ from "jquery";
import SmoothScroll from "smooth-scroll";

$(document).ready(() => {
  const scroll = new SmoothScroll('a[href*="#"]');
  adminbarMargin();
  scrollToTop();
  mmenuInit();
  // stickyHeader();
});

/**
 * Add margin-top to header if admin-bar is enabled;
 */
function adminbarMargin() {
  if (
    $(document.body).hasClass("admin-bar") &&
    $(document.body).hasClass("logged-in")
  ) {
    $(".site-header").css({ marginTop: "32px" });
  }
}

/**
 * Show back to top button if scroll > 0
 */
function scrollToTop() {
  $(window).on("scroll", () => {
    if ($(window).scrollTop() > 600) {
      $(document.body).addClass("show-back-to-top");
    } else {
      $(document.body).removeClass("show-back-to-top");
    }
  });
}

/**
 * Site mmenu
 */
function mmenuInit() {
  $("#site-mmenu").mmenu();

  const API = $("#site-mmenu").data("mmenu");
  $("#hamburger").on("click", ({ currentTarget }) => {
    $(currentTarget).toggleClass("is-active");
    API.open();
  });
}

/**
 * Sticky Nav
 */
function stickyHeader() {
  const header = $(".site-header");
  $(window).on("scroll", () => {
    if ($(window).scrollTop() > 600) {
      header.addClass("sticky");
    } else {
      header.removeClass("sticky");
    }
  });
}
