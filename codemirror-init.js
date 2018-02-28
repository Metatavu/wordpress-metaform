/* global ajaxurl */
(function ($) {
  'use strict';
  
  $(document).ready(function () {
    $('.codemirror').each(function (index, codemirror) {
      CodeMirror.fromTextArea(codemirror, {
        lineNumbers: true
      });
    });
  });

})(jQuery);