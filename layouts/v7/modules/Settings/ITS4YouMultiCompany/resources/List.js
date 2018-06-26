/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Settings_Vtiger_List_Js("Settings_ITS4YouMultiCompany_List_Js", {}, {
    registerSaveAllowedModules: function () {
        var self = this;
        var form = jQuery('.numberingModulesForm');
        jQuery(form).on('submit', function (e) {
            e.preventDefault();

            var formData = form.serializeFormData();
            var params = {
                "type": "POST",
                "module": app.getModuleName(),
                "parent": app.getParentModuleName(),
                "action": "SaveAllowedModules",
                "formData": formData,
                "dataType": 'json'
            };

            app.helper.showProgress();
            app.request.post({data: params}).then(
                function (err, response) {
                    app.helper.hideProgress();
                    if (err === null) {
                        var insertedRows = response.inserted;
                        if (insertedRows) {
                            app.helper.showSuccessNotification({message: response.message});
                        }
                        else {
                            app.helper.showAlertNotification({message: response.message});
                        }
                    } else {
                        app.helper.showErrorNotification({message: err.message});
                    }
                }
            );
        })
    },
    registerEvents: function () {
        this.registerSaveAllowedModules();
    }
});  