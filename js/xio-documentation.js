(function ($) {
  var hideText = '';
  var showText = '';

  function showDocumentationButton() {
    buttonText = $('#documentation-toggle').text().split('|');
    hideText = buttonText[0];
    showText = buttonText[1];

    var cToggle = getCookie("site_documentation");

    switch (cToggle) {
      case 'hidden':
        $('body').addClass('documentation-hidden');
        $('#documentation-toggle').text(showText);
        $('#documentation-toggle').addClass('show');
        break;

      default:
        setCookie("site_documentation", "visible", 365);
        $('#documentation-toggle').text(hideText);
        $('#documentation-toggle').addClass('hide');
        break;
    }

    if ($('.description.full-text').length == 0) {
      $('#documentation-toggle').hide();
    }
  }

  function showDocumentationContent() {
    $('#documentation-toggle').click(function () {

      if ($(this).hasClass('hide')) {
        // Hide the documentation.
        $('body').addClass('documentation-hidden');
        setCookie("site_documentation", "hidden", 365);

        $('#documentation-toggle').text(showText);
        $('#documentation-toggle').addClass('show');
        $('#documentation-toggle').removeClass('hide');

      }
      else {
        // Show the documentation.
        $('body').removeClass('documentation-hidden');
        setCookie("site_documentation", "shown", 365);

        $('#documentation-toggle').text(hideText);
        $('#documentation-toggle').addClass('hide');
        $('#documentation-toggle').removeClass('show');

      }
    });
  }

  if (document.addEventListener) {
    document.addEventListener('DOMContentLoaded', showDocumentationButton);
    document.addEventListener('DOMContentLoaded', showDocumentationContent);
  }

  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
  }

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

})(jQuery);
