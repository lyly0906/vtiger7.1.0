/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_Edit_Js("ITS4YouMultiCompany_EditNumbering_Js", {}, {

    params: {
        "type": "POST",
        "module": app.getModuleName(),
        "dataType": 'json'
    },

    form: false,
    getForm: function () {
        this.form = false;
        if (this.form === false) {
            this.form = jQuery('#EditView');
        }
        return this.form;
    },

    registerModulePicklistChangeEvent: function () {
        var self = this;
        jQuery('#sourceModule').on('change', function (e) {
            var params = self.params;
            params["view"] = "ListAjax";
            params["mode"] = "editCompanyRecordNumbering";
            params["sourceModule"] = jQuery(e.currentTarget).val();
            params["record"] = jQuery('#companyid').val();

            app.helper.showProgress();
            app.request.post({data: params}).then(
                function (err, response) {
                    app.helper.hideProgress();
                    jQuery('#recordNumberingContents').html(response);
                    var box = jQuery('#special_values');
                    app.changeSelectElementView(box);
                }
            )
        });
    },

    saveModuleNumbering: function () {
        var self = this;
        var form = self.getForm();
        //     // console.log(form);
        var formData = form.serializeFormData();
        var sourceModule = form.find('[name="sourceModule"]').val();
        var sourceModuleLabel = form.find('option[value="' + sourceModule + '"]').text();
        var prefix = form.find('[name="prefix"]');
        var currentPrefix = jQuery.trim(prefix.val());
        var oldPrefix = prefix.data('oldPrefix');
        var sequenceNumberElement = form.find('[name="sequenceNumber"]');
        var sequenceNumber = sequenceNumberElement.val();
        var oldSequenceNumber = sequenceNumberElement.data('oldSequenceNumber');

        if ((sequenceNumber < oldSequenceNumber) && (currentPrefix === oldPrefix)) {
            var errorMessage = app.vtranslate('JS_SEQUENCE_NUMBER_MESSAGE') + " " + oldSequenceNumber;
            app.helper.showErrorNotification({'message': errorMessage});
            return;
        }
        var companyId = jQuery('#companyid').val();
        var tabLabel = jQuery('#tab_label').val();

        var params = self.params;
        params["action"] = "CustomNumberingAjax";
        params["mode"] = "saveModuleCustomNumberingData";
        params["sourceModule"] = sourceModule;
        params["prefix"] = currentPrefix;
        params["sequenceNumber"] = sequenceNumber;
        params["companyid"] = companyId;

        app.helper.showProgress();
        app.request.post({data: params}).then(
            function (err, response) {
                var successfullSaveMessage = app.vtranslate('JS_RECORD_NUMBERING_SAVED_SUCCESSFULLY_FOR') + " " + sourceModuleLabel;
                app.helper.hideProgress();
                if (err === null) {
                    window.onbeforeunload = null;
                    app.helper.showSuccessNotification({'message':successfullSaveMessage});
                    window.location.href = 'index.php?module='+app.getModuleName()+'&view=Detail&record='+companyId+"&mode=showCompanyNumbering&tab_label="+ tabLabel;
                } else {
                    var errorMessage = currentPrefix + " " + app.vtranslate(err.message);
                    app.helper.showErrorNotification({'message':errorMessage});
                }
            }
        );
    },

    /**
     * Function to handle update record with the given sequence number
     */
    registerEventToUpdateRecordsWithSequenceNumber: function()
    {
        var editViewForm = this.getForm();
        editViewForm.find('[name="updateRecordWithSequenceNumber"]').on('click', function() {
            var params = {};
            var sourceModule = editViewForm.find('[name="sourceModule"]').val();
            var sourceModuleLabel = editViewForm.find('option[value="' + sourceModule + '"]').text();

            params = {
                'module': app.getModuleName(),
                'action': "CustomNumberingAjax",
                'mode': "updateRecordsWithSequenceNumber",
                'sourceModule': sourceModule,
                'companyid': jQuery('#companyid').val()
            };

            app.request.post({data: params}).then(
                function (err, response) {
                    if (err === null) {
                        var successfullSaveMessage = app.vtranslate('JS_RECORD_NUMBERING_UPDATED_SUCCESSFULLY_FOR') + " " + sourceModuleLabel;
                        app.helper.showSuccessNotification({'message': successfullSaveMessage});
                    } else {
                        app.helper.showErrorNotification({'message': err.message});
                    }
                });
        });
    },

    registerSaveButtonClickEvent: function () {
        var thisInstance = this;

        jQuery(".btn.btn-success.saveButton").on('click', function (e) {
            thisInstance.validateForm();
        });
    },

    validateForm: function () {
        var thisInstance = this;
        var form = this.getForm();

        form.vtValidate();
        if (form.valid()) {
            thisInstance.saveModuleNumbering();
        }

    },

    registerEvents: function () {
        this._super();
        this.registerModulePicklistChangeEvent();
        this.registerEventToUpdateRecordsWithSequenceNumber();
        this.registerSaveButtonClickEvent();
    }
});

