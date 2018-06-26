/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_List_Js("ITS4YouMultiCompany_Uninstall_Js", {
    uninstallInstance: false,
    getInstance: function () {
        if (ITS4YouMultiCompany_Uninstall_Js.uninstallInstance == false) {
            var instance = new window["ITS4YouMultiCompany_Uninstall_Js"]();
            ITS4YouMultiCompany_Uninstall_Js.uninstallInstance = instance;
            return instance;
        }

        return ITS4YouMultiCompany_Uninstall_Js.uninstallInstance;
    }
}, {
    uninstallITS4YouMultiCompany: function () {
        var message = app.vtranslate('LBL_UNINSTALL_CONFIRM','ITS4YouMultiCompany');
        app.helper.showConfirmationBox({'message': message}).then(function() {
            app.helper.showProgress();
            app.request.post({'url':'index.php?module=ITS4YouMultiCompany&action=UninstallMultiCompany'}).then(
                function (err, response) {
                    app.helper.hideProgress();
                    if(err === null) {
                        if (response.success === true) {
                            app.helper.showSuccessNotification({message: app.vtranslate('JS_ITEMS_DELETED_SUCCESSFULLY')});
                            window.location.href = "index.php";
                        } else {
                            app.helper.showErrorNotification({message: ''});
                        }
                    } else {
                        app.helper.showErrorNotification({message: err.message});
                    }
                }
            );
        });
    },
    registerActions : function() {
        var thisInstance = this;
        jQuery('#uninstall_its4youmulticompany_btn').click(function(e) {
            thisInstance.uninstallITS4YouMultiCompany();
        });
    },
    registerEvents: function () {
        this.registerActions();
    }
});    