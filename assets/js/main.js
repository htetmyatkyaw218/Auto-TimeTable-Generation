(function ($) {
  "use strict";

  // Set full height on elements with .js-fullheight class
  const fullHeight = function () {
    $('.js-fullheight').css('height', $(window).height());
    $(window).resize(function () {
      $('.js-fullheight').css('height', $(window).height());
    });
  };
  fullHeight();

  // Toggle password visibility
  $(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    input.attr("type", input.attr("type") === "password" ? "text" : "password");
  });

})(jQuery);
