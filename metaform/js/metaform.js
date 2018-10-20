/* global ajaxurl */
(function ($) {
  'use strict';

  function wpAjaxPost(postOptions, callback) {
    var ajaxurl = metaformwp.ajaxurl;
    
    $.post(ajaxurl, postOptions, function (response) { 
      if (!response.success) {
        callback((response.data ? response.data.message : null) || "Unknown error occurred");
      } else {
        callback(null, response.data || {});
      }
    })
    .fail(function (response) {
      callback(response.responseText || response.statusText || "Unknown error occurred");
    });
  }

  function getMetaformData(metaform) {
    var valuesArray = metaform.metaform('val', true); 
    var values = {};

    for (var i = 0; i < valuesArray.length; i++) {
      var name = valuesArray[i].name;
      var value = valuesArray[i].value;
      values[name] = value;
    }

    return values;
  }

  function mailDraft(email, draftId, draftUrl, callback) {
    wpAjaxPost({
      'action': 'metaform_email_draft',
      'email': email,
      'draft-id': draftId,
      'draft-url': draftUrl
    }, callback);
  }

  function draftMetaform(metaform, callback) {
    var id = metaform.closest('.metaform-container').attr('data-id');
    var postOptions = {
      'action': 'metaform_save_draft',
      'id': id,
      'values': JSON.stringify(getMetaformData(metaform))
    };

    wpAjaxPost(postOptions, function (err, data) {
      if (err) {
        alert(err);
      } else {
        var draftId = data.draftId;
        var draftUrl = window.location.href + (window.location.length > 1 ? "&" : "?") + "metaform-draft=" + draftId;
        var message = 
          "<p>Pääset muokkaamaan lomaketta osoitteessa:<br/>" +
          "<a href=\"" + draftUrl + "\" target=\"_blank\">" + draftUrl + "</a></p>" + 
          "<p>Voit myös lähettää osoitteen itsellesi syöttämällä sähköpostiosoitteen kentään:<br/>" +
          "<input name=\"email\" type=\"email\"/>" +
          "</p>";

        var dialog = $("<div>").html(message);
        dialog.dialog({
          title: "Vedos tallennettu",
          resizable: false,
          height: "auto",
          width: "90%",
          modal: true,
          buttons: {
            "Lähetä sähköpostilla": function() {
              var email = dialog.find("[name='email']").val();
              mailDraft(email, draftId, draftUrl, function (err) {
                if (err) {
                  alert(err);
                } else {
                  $(dialog).dialog("close");
                }
              });
            },
            "Sulje": function() {
              $(dialog).dialog("close");
            }
          }
        });
      }
    });
  }

  function saveMetaform(metaform, callback) {
    var ajaxurl = metaformwp.ajaxurl;
    var id = metaform.closest('.metaform-container').attr('data-id');
    var postOptions = {
      'action': 'metaform_save_reply',
      'id': id,
      'values': JSON.stringify(getMetaformData(metaform))
    };

    wpAjaxPost(postOptions, function (err, data) {
      if (err) {
        alert(err);
      } else {
        $("<div>").text("Lomake lähetettiin onnistuneesti.").dialog({
          title: "Lähetys onnistui",
          modal: true,
          buttons: {
            Ok: function() {
              window.location.reload(true);
            }
          }
        });
      }
    });
  }
    
  $(document).on('ready', function() {
    $(".metaform-container[data-allow-drafts='true']").each(function (index, element) {
      $("<a>")
        .text("Tallenna vedos")
        .addClass("btn btn-info float-right create-metaform-draft-button")
        .prependTo(element);
    });
  });

  $(document).on('click', '.create-metaform-draft-button', function (event) {
    event.preventDefault();
    var button = $(event.target);
    var metaform = button.closest('.metaform-container').find('.metaform');

    draftMetaform(metaform, function (err) {
      if (err) {
        alert(err);
      }
    });
  });

  $(document).on('click', 'input[type="submit"]', function (event) {
    var button = $(event.target);
    var metaform = button.closest('.metaform-container').find('.metaform');
    var valid = typeof metaform[0].checkValidity === 'function' ? metaform[0].checkValidity() : true;
  
    if (valid) {
      event.preventDefault();
      saveMetaform(metaform, function (err) {
        if (err) {
          alert(err);
        }
      });
    }
  });

})(jQuery);