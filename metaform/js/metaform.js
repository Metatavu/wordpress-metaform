/* global ajaxurl */
(function ($) {
  'use strict';

  /**
   * Returns query params as object
   * 
   * @return {Object} query params as object
   */
  function getQueryParams() {
    var result = {};
    var search = window.location.search.substring(1);
    if (search) {
      var pairs = search.split("&");
      for (var i = 0; i < pairs.length; i++) {
        var pair = pairs[i].split("=");
        result[pair[0]] = pair[1];
      }
    }

    return result;
  } 

  /**
   * Returns page url without query part
   * 
   * @return {String} page url without query part
   */
  function getBaseUrl() {
    var href = window.location.href;
    var queryIndex = href.indexOf("?");
    return queryIndex > -1 ? href.substring(0, queryIndex) : href;
  }
  
  /**
   * Merges query params from object into string
   * 
   * @param {Object} queryParams query params as object
   * @return {String} stringified query params
   */
  function mergeQueryParams(queryParams) {
    var pairs = [];
    var keys = Object.keys(queryParams);
    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var value = queryParams[key];
      pairs.push(key + '=' + value);
    }

    return pairs.join("&");
  }

  /**
   * Executes Wordpress ajax request
   * 
   * @param {Object} postOptions post options
   * @param {Function} callback callback function 
   */
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

  /**
   * Returns values from Metaform
   * 
   * @param {jQuery} metaform metaform
   * @returns {Object} metaform values 
   */
  function getMetaformData(metaform) {
    var valuesArray = metaform.metaform('val', true); 
    var values = {};

    for (var i = 0; i < valuesArray.length; i++) {
      var name = valuesArray[i].name;
      var value = valuesArray[i].value;
      if (values[name]) {
        var oldValue = values[name];
        values[name] = $.isArray(oldValue) ? oldValue : [oldValue].concat([value]);
      } else {
        values[name] = value;
      }
    }

    return values;
  }

  /**
   * Mails created draft link to given email address
   * 
   * @param {String} email email address
   * @param {String} draftId  draft id
   * @param {String} draftUrl draft url
   * @param {Function} callback callback 
   */
  function mailDraft(email, draftId, draftUrl, callback) {
    wpAjaxPost({
      'action': 'metaform_email_draft',
      'email': email,
      'draft-id': draftId,
      'draft-url': draftUrl
    }, callback);
  }

  /**
   * Creates a draft of the Metaform
   * 
   * @param {jQuery} metaform metaform 
   * @param {Function} callback
   */
  function draftMetaform(metaform, callback) {
    var id = metaform.closest('.metaform-container').attr('data-id');
    var postOptions = {
      'action': 'metaform_save_draft',
      'id': id,
      'values': JSON.stringify(getMetaformData(metaform))
    };

    wpAjaxPost(postOptions, function (err, data) {
      callback(err);
      
      if (err) {
        alert(err);
      } else {
        var draftId = data.draftId;
        var queryParams = getQueryParams();
        queryParams["metaform-draft"] = draftId;
        var draftUrl = getBaseUrl() + "?" + mergeQueryParams(queryParams);
        var message = 
          "<p>Pääset muokkaamaan lomaketta osoitteessa:<br/>" +
          "<a href=\"" + draftUrl + "\" target=\"_blank\">" + draftUrl + "</a></p>" + 
          "<p>Voit myös lähettää osoitteen itsellesi syöttämällä sähköpostiosoitteen kentään:<br/>" +
          "<input class=\"form-control\" name=\"email\" type=\"email\"/>" +
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

  /**
   * Saves the Metaform
   * 
   * @param {jQuery} metaform metaform
   */
  function saveMetaform(metaform) {
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
        .addClass("btn btn-info create-metaform-draft-button")
        .prependTo(element);
    });
  });

  $(document).on('click', '.create-metaform-draft-button', function (event) {
    event.preventDefault();
    var button = $(event.target).addClass("disabled");
    var metaform = button.closest('.metaform-container').find('.metaform');

    draftMetaform(metaform, function () {
      button.removeClass("disabled");
    });
  });

  $(document).on('click', 'input[type="submit"]', function (event) {
    var button = $(event.target);
    var metaform = button.closest('.metaform-container').find('.metaform');
    if (metaform && metaform.length > 0) {
      var valid = typeof metaform[0].checkValidity === 'function' ? metaform[0].checkValidity() : true;
      if (valid) {
        event.preventDefault();
        saveMetaform(metaform);
      }
    }
  });

})(jQuery);