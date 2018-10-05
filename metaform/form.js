/*jshint esversion: 6 */
/* global Modernizr, pdfMake, MetaformUtils, hyperform, bootbox */
(function($) {
  'use strict';

  $.widget("custom.metaformMultivalueAutocomplete", {
    options: {
      customSource: null
    },

    _create : function() {
      this._sourceUrl = this.element.attr('data-source-url');
      this._required = !!this.element.attr('data-required');
      
      this.element.autocomplete({
        select: $.proxy(this._onSelect, this),
        source: $.proxy(this._onSource, this),
        change: $.proxy(this._onChange, this)
      });
      
      this._valuesContainer = $('<div>')
        .addClass('metaform-multivalue-values')
        .insertAfter(this.element);

      this._valuesContainer.on('click', '.metaform-multivalue-autocomplete-delete', $.proxy(this._onValueRemoveClick, this));
      
      this._loadValues();
    },
    
    val: function (values) {
      this._valuesContainer.find('.metaform-multivalue-autocomplete-item').remove();
      this._addValues(values);
    },
     
    _loadValues: function () {
      const valuesAttr = this.element.attr('data-values');
      
      if (valuesAttr) {
        this._addValues(JSON.parse(valuesAttr));
      }
    },
    
    _addValues: function (values) {
      if (values) {
        for (let i = 0; i < values.length; i++) {
          this._addItem(values[i].value, values[i].label);
        }
        
        this._updateValues();
      }
    },
    
    _addItem: function (value, label) {
      $('<span>')
        .addClass('metaform-multivalue-autocomplete-item')
        .attr('data-value', value)
        .attr('data-label', label)
        .append($('<a>').attr('href', '#').addClass('fa fa-times metaform-multivalue-autocomplete-delete'))
        .append('&nbsp;')
        .append(label)
        .appendTo(this._valuesContainer);
    },
    
    _updateValues: function () {
      const values = this._valuesContainer.find('.metaform-multivalue-autocomplete-item').map(function (index, element) {
        return $(element).attr('data-value');
      }).get();
      
      var inputName = this.element.attr('data-name');
      this.element.closest('.metaform').find('input[name="' + inputName + '"]').val(values.join(','));
      
      if (this._required) {
        var empty = !this.element.closest('.metaform').find('input[name="' + inputName + '"]').val();
        this.element[0].setCustomValidity(empty ? 'This is a required field' : '');
      }
    },
    
    _onValueRemoveClick: function (event) {
      event.preventDefault();
      $(event.target)
        .closest('.metaform-multivalue-autocomplete-item')
        .remove();      

      this._updateValues();
    },
      
    _onSelect: function (event, ui) {
      event.preventDefault();
      var item = ui.item;
      this.element.val('');
      this._addItem(item.value, item.label);
      this._updateValues();
    },

    _onSource: function (input, callback) {
      if (this.options.customSource) {
        this.options.customSource(input, callback);
      } else {
        var sourceUrl = this._sourceUrl + (this._sourceUrl.indexOf('?') === -1 ? '?q=' + input.term : '&q=' + input.term);
        $.get(sourceUrl, function(items) {
          callback($.map(items, function (item) {
            return { 
              value: item.value,
              label: item.label
            }; 
          }));
        }, "json");
      }
    },
    
    _onChange: function (input, callback) {
      this.element.val('');
    }
  });
  
  $.widget("custom.metaformAutocomplete", {
    options: {
      customSource: null
    },
    
    _create : function() {
      this._sourceUrl = this.element.attr('data-source-url');
      this._selected = false;
      
      this.element.on("focus", $.proxy(this._onFocus, this));
      
      this.element.autocomplete({
        select: $.proxy(this._onSelect, this),
        source: $.proxy(this._onSource, this),
        change: $.proxy(this._onChange, this)
      });
    },
    
    val: function (item) {
      const valueInput = this._getInput();
      
      if (item === undefined) {
        let value = null;
        if (valueInput.length > 0) {
          value = valueInput.val();
        } else {
          value = this.element.attr('data-value');
        }
        return {
          value: value,
          label: this.element.val()
        };
      } else {
        this.element.val(item.label);
        if (valueInput.length > 0) {
          valueInput.val(item.value);
        } else {
          this.element.attr('data-value', item.value);
        }
      }
    },
    
    _getInput: function () {
      var inputName = this.element.attr('data-name');
      return this.element.closest('.metaform').find('input[name="' + inputName + '"]');
    },
    
    _onFocus: function () {
      this._originalValue = this._getInput().val();
      this._originalLabel = this.element.val();
      this._selected = false;
    },
      
    _onSelect: function (event, ui) {
      event.preventDefault();
      var item = ui.item;
      this.val(item);
      this._selected = true;
    },

    _onSource: function (input, callback) {
      if (this.options.customSource) {
        this.options.customSource(input, callback);
      } else {
        var sourceUrl = this._sourceUrl + (this._sourceUrl.indexOf('?') === -1 ? '?q=' + input.term : '&q=' + input.term);
        $.get(sourceUrl, function(items) {
          callback($.map(items, function (item) {
            return { 
              value: item.value,
              label: item.label
            }; 
          }));
        }, "json");
      }
    },
    
    _onChange: function (input, callback) {
      if (!this._selected) {
        this.val({
          value: this._originalValue, 
          label: this._originalLabel
        });
      }
      
      this._originalValue = null;
      this._originalLabel = null;
      this._selected = false;
    }
  });
	
  $.widget("custom.metaform", {

    options: {
      animation: {
        framework: 'default'
      }
    },
    
    _create : function() {
      this.element.find('.file-component').fileField();
      this.element.find('.table-field').tableField();
    
      this.attachedVisibleIfListeners = [];
      
      this.element.on("submit", $.proxy(this._onFormSubmit, this));
      if (!Modernizr.formvalidation) {
        hyperform(this.element[0]);
      }
      
      this.element.find('*[data-visible-if]').each(function (index, element) {
        $(element).find('*[required]').each(function (inputIndex, inputElement) {
          $(inputElement).removeAttr('required');
          $(inputElement).attr('data-required', 'required');
        }.bind(this));
        
        var formGroupId = $(element).attr('id');
        var rule = JSON.parse($(element).attr('data-visible-if'));
        this._registerVisibleIfRule(formGroupId, rule, rule);
        this.attachedVisibleIfListeners = [];
      }.bind(this));
      
      this.element.find('input:checked').change();
      this._createDatePickers();
      this._createTimePickers();
      this._createDateTimePickers();
      this._createAutocompleteFields();
      this._createReadonlyDateTimes();

      $(document).on('click', "#saveMetaformDraft", $.proxy(this._saveDraft, this));
    },
    
    val: function (returnArray) {
      return returnArray ? this.element.serializeArray() : this.element.serialize();
    },
    
    submit: function () {
      this.element.submit();
    },
    
    addData: function(key, value) {
      var dataInput = $('<input>')
        .attr('name', key)
        .attr('type', 'hidden')
        .val(value);

      this.element.append(dataInput);
    },

    _saveDraft: function (event) {
      console.log("test");
      var data = this.val(false);

      $.ajax({
        url: '/formDraft',
        data: data,
        method: 'POST',
        success: (response) => {
          console.log(response);
          $('.draft-response')
            .text('Tällä linkillä pääset jatkamaan lomakkeen täyttämistä: ')
            .show();
        },
        error: (jqXHR, textStatus) => {
          var errorMessage = textStatus ? jqXHR.responseText || jqXHR.statusText || textStatus : null;
          $('.draft-response')
            .text('Lomakkeen tallennus epäonnistui: ' + errorMessage)
            .show();
          }
      });
    },
    
    _createDatePickers: function () {
      this.element.find('input[data-type="date"]').each(function (index, input) {
        MetaformUtils.createDatePicker(input);
      });
    },
    
    _createTimePickers: function () {
      this.element.find('input[data-type="time"]').each(function (index, input) {
        MetaformUtils.createTimePicker(input);
      });
    },
    
    _createDateTimePickers: function () {
      this.element.find('input[data-type="date-time"]').each(function (index, input) {
        MetaformUtils.createDateTimePicker(input);
      });
    },

    _createReadonlyDateTimes: function () {
      if (typeof moment !== "function") {
        return;
      }

      const language = window.navigator.userLanguage || window.navigator.language;
      if (language) {
        moment.locale(language);
      }

      this.element.find(".date-time-readonly").each(function (index, element) {
        const value = $(element).text();
        const format = $(element).attr("data-format");
        if (value) {
          $(element).text(moment(value).format(format || "LLL"));
        }
      });
    },
    
    _createAutocompleteFields: function () {
      this.element.find('input[data-type="autocomplete"]').metaformAutocomplete();
      this.element.find('input[data-type="autocomplete-multiple"]').metaformMultivalueAutocomplete();
    },
    
    _registerVisibleIfRule: function (formGroupId, currentRule, rule) {
      if (typeof(currentRule.field) !== 'undefined' && this.attachedVisibleIfListeners.indexOf(currentRule.field) === -1) {
        this.attachedVisibleIfListeners.push(currentRule.field);
        
        this.element.find('input[name="'+currentRule.field+'"],select[name="'+currentRule.field+'"]')
          .change($.proxy(this._createFormChangeFunction(formGroupId, rule), this))
          .keyup($.proxy(this._createFormChangeFunction(formGroupId, rule), this));
      }
      
      if (typeof(currentRule.and) !== 'undefined') {
        for (var i = 0; i < currentRule.and.length; i++) {
          var andSubRule = currentRule.and[i];
          this._registerVisibleIfRule(formGroupId, andSubRule, rule);
        }
      }
      
      if (typeof(currentRule.or) !== 'undefined') {
        for (var j = 0; j < currentRule.or.length; j++) {
          var orSubRule = currentRule.or[j];
          this._registerVisibleIfRule(formGroupId, orSubRule, rule);
        }
      }
      
      if (!this._evaluateFormRule(rule)) {
        this.element.find(`#${formGroupId}`).hide();
      }
    },
    
    _evaluateFormRule: function(rule) {
      var equals = false;
      var analyzed = false;
      
      if (typeof(rule.field) !== 'undefined') {
        var inputElement = this.element.find('input[name="'+rule.field+'"],select[name="'+rule.field+'"]').first();
        var currentValue = '';
        var checked = false;
        
        if( inputElement.is(':checkbox') || inputElement.is(':radio')) {
          checked = this.element.find('input[name="'+rule.field+'"]:checked').length > 0;
          currentValue = this.element.find('input[name="'+rule.field+'"]:checked').val();
        } else {
          checked = inputElement.val() ? true : false;
          currentValue = inputElement.val();
        }

        analyzed = true;
        
        if (rule.equals === true) {
          equals = checked;
        } else if (typeof(rule.equals) !== 'undefined') {
          equals = rule.equals === currentValue;
        } else if (rule['not-equals'] === true) {
          equals = !checked;
        } else if (typeof(rule['not-equals']) !== 'undefined') {
          equals = rule['not-equals'] !== currentValue;
        }
      }
      
      if (typeof(rule.and) !== 'undefined') {
        var andResult = true;
        for (var i = 0; i < rule.and.length; i++) {
          var andSubRule = rule.and[i];
          andResult = andResult && this._evaluateFormRule(andSubRule);
          if (!andResult) {
            break;
          }
        }
        equals = analyzed ? equals && andResult : andResult;
      }

      if (typeof(rule.or) !== 'undefined') {
        var orResult = false;
        for (var j = 0; j < rule.or.length; j++) {
          var orSubRule = rule.or[j];
          orResult = orResult || this._evaluateFormRule(orSubRule);
          if (orResult) {
            break;
          }
        }
        equals = analyzed ? equals || orResult : orResult;
      }
      
      return equals;
    },
    
    _createFormChangeFunction: function(formGroupId, rule) {
      return function(e) {
        const formGroup = this.element.find(`#${formGroupId}`);
        const equals = this._evaluateFormRule(rule);

        if (equals) {
          this.element.trigger("beforeShow", {
            target: formGroup
          });
        
          this._show(formGroup, () => {
            this._onRequiredFieldsVisibilityChange(formGroup, 'SHOW');
            this.element.trigger("afterShow", {
              target: formGroup
            });
          });
        } else if(!equals) {
          this.element.trigger("beforeHide", {
            target: formGroup
          });
        
          this._hide(formGroup, () => {
            this._onRequiredFieldsVisibilityChange(formGroup, 'HIDE');
            this.element.trigger("afterHide", {
              target: formGroup
            });
          });
        }
      };
    },

    _show: function (element, callback) {
      const show = this.options.animation.show || {};
      const duration = show.duration || 400;
      const options = show.options || {};
      const effect = show.effect || 'slide';

      switch (this.options.animation.framework) {
        case 'jquery-ui':
          element.show(effect, options, duration, callback);
        break;
        default:
          element.slideDown(duration, callback);
        break;
      }
    },

    _hide: function (element, callback) {
      const hide = this.options.animation.hide || {};
      const duration = hide.duration || 400;
      const options = hide.options || {};
      const effect = hide.effect || 'slide';

      switch (this.options.animation.framework) {
        case 'jquery-ui':
          element.hide(effect, options, duration, callback);
        break;
        default:
          element.slideUp(duration, callback);
        break;
      }
    },

    _onRequiredFieldsVisibilityChange: function(container, action) {  
      $(container).find('*[data-required]').each(function (inputIndex, inputElement) {
        if (action === 'SHOW' && $(inputElement).is(':visible')) {
          $(inputElement).attr('required', 'required');
        } else if (action === 'HIDE') {
          $(inputElement).removeAttr('required');
        }
      });
    },

    _onFormSubmit: function (event) {
      event.preventDefault();
      if ($.isFunction(this.options.beforeFormSubmit)) {
        this.options.beforeFormSubmit();
      }
      
      var data = this.val(false);

      $.ajax({
        url: this.element.attr('data-action') || '/formReply',
        data: data,
        method: 'POST',
        success: (response) => {
          if ($.isFunction(this.options.onPostSuccess)) {
            this.options.onPostSuccess(response);
          } else {
            bootbox.alert({
              message: '<i class="fa fa-check" /><h3>Lomake lähetettiin onnistuneesti.</h3>',
              backdrop: true,
              callback: function(){
                window.location.reload(true);
              }
            });
          }
        },
        error: (jqXHR, textStatus) => {
          var errorMessage = textStatus ? jqXHR.responseText || jqXHR.statusText || textStatus : null;
          if ($.isFunction(this.options.onPostError)) {
            this.options.onPostError(errorMessage, jqXHR);
          } else {
            $('<div>')
              .addClass('alert alert-danger fixed-top')
              .text('Lomakkeen lähetys epäonnistui: ' + errorMessage)
              .appendTo(document.body);
          }
        }
      });
    }
  
  });
  
  $.widget("custom.tableField", {
    
    _create : function() {
      this.tableRow = this.element.find('tbody tr:first-child').clone();
      this.element.on('click', '.add-table-row', $.proxy(this._onAddTableRowClick, this));
      this.element.on('click', '.print-table', $.proxy(this._onPrintTableClick, this));
      this.element.on('change', 'input', $.proxy(this._onInputChange, this));
      this.element.on('change', 'td[data-column-type="enum"] select', $.proxy(this._onEnumSelectChange, this));
      this.element.on('click', 'td button[data-action="delete-row"]', $.proxy(this._onDeleteRowClick, this));

      if (this.element.find('th[data-calculate-sum="true"]').length) {
        this.element.find('tfoot').find('td:nth-of-type(1)')
          .html('Yhteensä:');
      } else {
        this.element.find('tfoot').find('td')
          .html('&nbsp;');
      }
      
      if (this.element.attr('data-draggable')) {
        this.element.find('tbody').sortable({
          handle: ".sort-handle",
          stop: (event, ui) => {
            this._refresh(); 
          }
        });
      }
      
      this.element.find('tbody tr').each($.proxy(function (index, row) {
        this._processTableRow(row);
      }, this));
      
      this._refresh();
      this._loadValues();
    },
    
    removeAllRows: function () {
      this.element.find('tbody').empty();
    },
    
    /**
     * Adds new row to table.
     * 
     * @param {Object} data object containing name - value pairs of data
     * @returns {Element} Added row element
     */
    addRow: function (data) {
      return this._addRow(data);
    },
    
    setCellValue: function (columnName, rowIndex, value) {
      const row = this.element.find(`tbody tr:nth-of-type(${rowIndex + 1})`);
      const cell = row.find(`td[data-column-name="${columnName}"]`);
      this._setCellValue(cell, value);
      this._refresh();
    },
    
    _loadValues: function () {
      const valuesAttr = this.element.attr('data-values');
      
      if (valuesAttr) {
        this.removeAllRows();
        
        const rowDatas = JSON.parse(valuesAttr);
        rowDatas.forEach((rowData) => {
          this.addRow(rowData);
        });
      }
    },
    
    _processTableRow: function(row) {
      $(row).find('[data-column-type="enum"] select').each($.proxy(function (index, select) {
        this._refreshEnumSelect($(select));
      }, this));
      
      $(row).find('input[data-type="table-date"]').each($.proxy(function (index, input) {
        MetaformUtils.createDatePicker(input);
      }, this));

      $(row).find('input[data-type="table-time"]').each($.proxy(function (index, input) {
        MetaformUtils.createTimePicker(input);
      }, this));

      $(row).find('input[data-type="autocomplete"]').each($.proxy(function (index, input) {
        $(input).metaformAutocomplete();
      }, this));
      
      if (this.options.afterProcessRow) {
        this.options.afterProcessRow(row);
      }
    },
    
    _addRow: function (data) {
      const clonedRow = this.tableRow.clone();
      clonedRow.appendTo(this.element.find('tbody'));
      clonedRow.find('input,select').each($.proxy(function (index, input) {
        const columnName = $(input).closest('td').attr('data-column-name');
        $(input).val(data ? data[columnName] : '');
      }, this));
      
      this._processTableRow(clonedRow);
      this._refresh();
      
      return clonedRow;
    },
    
    _refresh: function () {
      var datas = [];
      
      this.element.find('thead th[data-calculate-sum="true"]').each($.proxy(function (rowIndex, row) {
        var sum = 0;
        var columnIndex = $(row).index();
        
        this.element.find('tbody td:nth-of-type(' + (columnIndex + 1) + ' )').each(function (index, column) {
          var value = $(column).find('input').val();
          if (value) {
            sum += parseFloat(value);
          }
        });

        this.element.find('tfoot td:nth-of-type(' + (columnIndex + 1) + ' ) .sum').text(sum);
      }, this));

      this.element.find('tbody tr').each($.proxy(function (indexRow, row) {
        var rowDatas = {};
        
        $(row).find('td').each($.proxy(function (index, cell) {
          var value = this._getCellValue(cell);
          var columnName = $(cell).attr('data-column-name');
          rowDatas[columnName] = value;
        }, this));
        
        datas.push(rowDatas);
      }, this));
      
      this.element.find('input[name="' + this.element.attr('data-field-name') + '"]').val(JSON.stringify(datas));
    },
    
    _refreshEnumSelect: function (enumSelect) {
      var other = !!$(enumSelect).find('option:checked').attr('data-other');
      if (other) {
        $('<input>')
          .addClass('enum-other form-control')
          .css({'width': '50%', 'display': 'inline'})
          .insertAfter(enumSelect);
          enumSelect.css({'width': 'calc(50% - 4px)', 'display': 'inline', 'margin-right': '4px'});
      } else {
        enumSelect.parent().find('.enum-other').remove();
        enumSelect.css({'width': '100%', 'display': 'block'});
      }
    },
    
    _getCellValue: function (cell) {
      const columnType = $(cell).attr('data-column-type');
      
      switch (columnType) {
        case 'enum':
          var option = $(cell).find('option:checked');
          if (option.attr('data-other')) {
            return option.text() + ' ' + $(cell).find('input.enum-other').val();
          } else {
            var value = option.attr('value');
            if (value) {
              return value;
            }
            
            return option.text();
          }
        break;
        case 'autocomplete':
          return $(cell).find('input[data-type="autocomplete"]').metaformAutocomplete('val').value;
        default:
          return $(cell).find('input').val();
        break;
      }
      
      return null;
    },
    
    _setCellValue: function (cell, value) {
      const columnType = $(cell).attr('data-column-type');
      
      switch (columnType) {
        case 'autocomplete':
          $(cell).find('input[data-type="autocomplete"]').metaformAutocomplete('val', {
            value: value
          });
        break;
        default:
          $(cell).find('input').val(value);
        break;
      }
    },
    
    _generatePrintableTable: function () {
      var tableHeaders = $.map(this.element.find('thead tr th'), function (th) {
        return {
          text: $(th).text(),
          style: 'tableHeader'
        };
      });
      
      var tableWidths = ['*'];
      for (var i = 1; i < tableHeaders.length; i++) {
        tableWidths.push('auto');  
      }
      
      var tableBody = [ tableHeaders ];
      
      this.element.find('tbody tr').each($.proxy(function (rowIndex, tr) {
        var row = [];
        
        $(tr).find('td').each($.proxy(function (cellIndex, cell) {
          var value = this._getCellValue(cell);
          row.push({
            text: value||'' 
          });
        }, this));
        
        tableBody.push(row);
      }, this));
      
      this.element.find('tfoot tr').each(function (rowIndex, tr) {
        var row = [];
        
        $(tr).find('td').each(function (cellIndex, cell) {
          var value = $(cell).text();
          row.push({
            text: value||'',
            style: 'tableFooter'
          });
        });
        
        tableBody.push(row);
      });
      
      return {
        content: [{ 
          text: this.element.attr('data-field-title')||'', 
          style: 'header' 
        }, {
          table: {
            body: tableBody,
            widths: tableWidths
          }
        }],
        styles: { 
          header: {
            fontSize: 18,
            bold: true,
            marginBottom: 10
          },
          tableHeader: {
            bold: true
          },
          tableFooter: {
            bold: true
          }
        }
      };
    },
    
    _onPrintTableClick: function (event) {
      event.preventDefault();
      
      var docDefinition = this._generatePrintableTable();
      
      pdfMake.createPdf(docDefinition)
        .download(this.element.attr('data-field-name') + '.pdf');
    },
    
    _onAddTableRowClick: function (event) {
      event.preventDefault();
      this._addRow();
    },
    
    _onInputChange: function (event) {
      event.preventDefault();
      this._refresh();
    },
    
    _onEnumSelectChange: function (event) {
      this._refreshEnumSelect($(event.target));
      this._refresh();
    },
    
    _onDeleteRowClick: function (event) {
      $(event.target).closest('tr').remove();
      this._refresh();
    }
    
  });
	
  $.widget("custom.fileField", {
    
    _create : function() {
      this._uploadUrl = this.element.attr('data-upload-url') ? this.element.attr('data-upload-url') : '/upload/';
      this._singleFile = this.element.attr('data-single-file') ? true : false;
      this._onlyImages = this.element.attr('data-only-images') ? true : false;
      this._maxFileSize = this.element.attr('data-max-file-size') ? parseInt(this.element.attr('data-max-file-size')) : 209715200;
      this.element.find('.add-file-button').on("click", $.proxy(this._onAddFileButtonClick, this));
      this.element.on('click', '.remove-file-button', $.proxy(this._onRemoveFileButtonClick, this));
      
      
      const fileUploadOptions = {
        maxFileSize: this._maxFileSize,
        dataType: 'json',
        url: this._uploadUrl,
        add : $.proxy(this._onUploadAdd, this),
        fail: $.proxy(this._onUploadFail, this),
        done : $.proxy(this._onUploadDone, this),
        progressall : $.proxy(this._onProgressAll, this) 
      };
      
      if (this._onlyImages) {
        fileUploadOptions.acceptFileTypes = /(\.|\/)(gif|jpe?g|png)$/i;
      }
      
      this.element.find('.progress-bar').hide();
      this.element.find('input[type="file"]')
        .css({
          opacity: 0
        })
        .fileupload(fileUploadOptions);
    },
    
    _onAddFileButtonClick: function (event) {
       event.preventDefault();
       
       this.element.find('.progress-bar')
         .show()
         .removeClass('bg-success')
         .addClass('progress-bar-animated progress-bar-striped')
         .css({
           'width': '0%'  
         });

       this.element.find('input[type="file"]')[0].click();
    },

    _onUploadAdd: function (event, data) {
      this.element.find('.add-file-button')
        .attr('disabled', 'disabled')
        .prop('disabled', true)
        .addClass('disabled');
      
      data.submit();
    },
    
    _onUploadFail: function (event, data) {
      const notification = $('<div>')
         .addClass('alert alert-danger fixed-top')
         .text('Kuvan lähetys epäonnistui. Tarkista koko ja tiedostomuoto.')
         .appendTo(document.body);
 
      this.element.find('.add-file-button')
        .removeAttr('disabled')
        .prop('disabled', false)
        .removeClass('disabled');

      setTimeout(() => {
        notification.remove();
      }, 5000);
    },
    
    _onUploadDone: function (event, data) {
      if (this._singleFile) {
        this.element.find('.remove-file-button').click();
      }
      
      this.element.find('.add-file-button')
        .removeAttr('disabled')
        .prop('disabled', false)
        .removeClass('disabled');

      this.element.find('.progress-bar')
        .removeClass('progress-bar-animated progress-bar-striped')
        .addClass('bg-success')
        .css({
          'width': '100%'  
        });
      
      $.each(data.result, $.proxy(function (index, file) {
        const fileId = file._id || file.fileData || file.filename;
        const fileUrl = file.url || this._uploadUrl + fileId;
        const deleteUrl = file.deleteUrl || '';
        const deleteKey = file.deleteKey || '';
        const originalName = file.originalname;
        const fieldName = this.element.attr('data-field-name');

        const row = $('<div>')
          .addClass('file row')
          .appendTo(this.element.find('.files'));
        
        const cell = $('<div>')
          .addClass('col-12')
          .appendTo(row);
        
        $('<input>')
          .attr({
            'type': 'hidden',
            'name': fieldName,
            'value': fileId
          })
          .appendTo(cell);
        
        $('<a>')
          .attr({
            'href': fileUrl,
            'target': 'blank'
          })
          .text(originalName)
          .appendTo(cell);
       
        $('<button>')
          .addClass('remove-file-button btn btn-danger btn-sm float-right')
          .attr('data-id', fileId)
          .attr('data-delete-key', deleteKey)
          .attr('data-delete-url', deleteUrl)
          .text('Poista')
          .appendTo(cell);
        
        $(this.element).trigger('metaform:file-added');
        
      }, this));
    },
    
    _onProgressAll: function (event, data) {
      var progress = parseInt(data.loaded / data.total * 100, 10);
      this.element.find('.progress-bar')
        .css({
          'width': progress + '%'  
        });
    },
    
    _onRemoveFileButtonClick: function (event) {
      event.preventDefault();
      const button = $(event.target).closest('.remove-file-button');
      const fileId = button.attr('data-id');
      const deleteKey = button.attr('data-delete-key');
      const deleteUrl = button.attr('data-delete-url');

      let url = null;

      if (deleteUrl) {
        url = deleteUrl;
      } else {
        url = this._uploadUrl + fileId;
        if (deleteKey && deleteKey.length > 0) {
          url += '?c=' + deleteKey;
        }
      }
      
      $.ajax({
        url: url,
        method: 'DELETE',
        success: $.proxy(function(res) {
          $(button).closest('.file').remove();
          $(this.element).trigger('metaform:file-removed');
        }, this)
      });
    }
  });
  
  $(document).ready(function () {
    if ((typeof Modernizr) === 'undefined') {
      alert('Modernizr is not loaded');
    }
    
    $('form.metaform').metaform();
  });
  
})(jQuery);