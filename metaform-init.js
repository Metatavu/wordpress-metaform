/* global ajaxurl */
(function ($) {
  'use strict';
  
  $(document).ready(function () {
    
    $('.metaform').each(function (index, metaformElement) {
      var viewModel = JSON.parse($(metaformElement).attr('data-json'));
      var formValues = null;
      var html = mfRender({
        viewModel: viewModel,
        formValues: formValues
      });

      $(metaformElement)
        .html(html)
        .metaform();     
    });

  });

  
  
})(jQuery);