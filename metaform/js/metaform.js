jQuery(document).on('ready', function($) {
  window.draftUrl = "/wp-json/metaform/formDraft";

  jQuery(document).on('click', 'input[type="submit"]', function (event) {
    var button = jQuery(event.target);
    var metaform = button.closest('.metaform-container').find('.metaform');
    var valid = typeof metaform[0].checkValidity === 'function' ? metaform[0].checkValidity() : true;
  
    if (valid) {
      event.preventDefault();
      saveMetaform(metaform, function (err) {
        if (err) {
          alert(err);
        } else {
          
        }
      });
    }
  });

  function saveMetaform(metaform, callback) {
    var valuesArray = metaform.metaform('val', true); 
    var id = metaform.closest('.metaform-container').attr('data-id');
    var ajaxurl = metaformwp.ajaxurl;
    var values = {};

    for (var i = 0; i < valuesArray.length; i++) {
      var name = valuesArray[i].name;
      var value = valuesArray[i].value;
      values[name] = value;
    }

    jQuery.post(ajaxurl, {
      'action': 'save_metaform',
      'id': id,
      'values': JSON.stringify(values)
    }, function (response) { 
      bootbox.alert({
        message: '<i class="fa fa-check" /><h3>Lomake lähetettiin onnistuneesti.</h3>',
        backdrop: true,
        callback: function(){
          window.location.reload(true);
        }
      });
    })
    .fail(function (response) {
      callback(response.responseText || response.statusText || "Unknown error occurred");
    });
  }
});