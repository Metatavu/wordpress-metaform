(function ($) {
  'use strict';
  
  $(document).ready(function () {    
    $('.metaform-container').each(function (index, metaformElement) {
      var viewModel = JSON.parse($(metaformElement).attr('data-view-model') || '{}');
      var formValues = JSON.parse($(metaformElement).attr('data-form-values') || '{}');
      var html = mfRender({
        viewModel: viewModel,
        formValues: formValues
      });

      $(metaformElement)
        .html(html)
        .find('.metaform')
        .metaform();     
    });
  });

})(jQuery);