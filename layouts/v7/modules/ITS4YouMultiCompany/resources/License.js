/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_List_Js("ITS4YouMultiCompany_License_Js", {
    licenseInstance: false,
    getInstance: function () {
        if (ITS4YouMultiCompany_License_Js.licenseInstance == false) {
            var instance = new window["ITS4YouMultiCompany_License_Js"]();
            ITS4YouMultiCompany_License_Js.licenseInstance = instance;
            return instance;
        }

        return ITS4YouMultiCompany_License_Js.licenseInstance;
    }
}, {
    /*
     * Function to get the value of the step
     * returns 1 or 2 or 3
     */
    getStepValue : function(){
        var container = this.currentInstance.getContainer();
        return jQuery('.step',container).val();
    },
    /*
     * Function to initiate all the operations for a step
     * @params step value
     */
    initiateStep : function(stepVal) {
        var step = 'step'+stepVal;
        this.activateHeader(step);
        jQuery('#stepContent'+(stepVal - 1)).hide();
        jQuery('#stepContent'+stepVal).show();
    },
    /*
     * Function to activate the header based on the class
     * @params class name
     */
    activateHeader : function(step) {
        var headersContainer = jQuery('.crumbs');
        headersContainer.find('.active').removeClass('active');
        jQuery('#'+step,headersContainer).addClass('active');
    },
    saveLicenseKey: function (form,is_install) {
        var thisInstance = this;
        if (is_install){
            var licensekey_val = jQuery('#licensekey').val();

            var params = {
                module : app.getModuleName(),
                licensekey : licensekey_val,
                action : 'License',
                mode : 'editLicense',
                type : 'activate'
            };
        }
        else {
            var params = jQuery(form).serializeFormData();
        }
        thisInstance.validateLicenseKey(params).then(
            function(data) {
                if (!is_install){
                    app.hideModalWindow();
                    app.helper.showSuccessNotification({"message":data.message});

                    jQuery('#license_key_val').val(data.licensekey);
                    jQuery('#license_key_label').html(data.licensekey);

                    jQuery('#divgroup1').hide();
                    jQuery('#divgroup2').show();
                } else {
                    thisInstance.initiateStep(2);
                }
            }
        );

    },
    validateLicenseKey: function (data) {
        var thisInstance = this;
        var aDeferred = jQuery.Deferred();
        thisInstance.checkLicenseKey(data).then(
            function(data) {
                aDeferred.resolve(data);
            },
            function(err){
                aDeferred.reject();
            }
        );
        return aDeferred.promise();
    },
    checkLicenseKey : function(params) {
        var aDeferred = jQuery.Deferred();
        app.helper.showProgress();
        app.request.post({'data' : params}).then(function(err,response) {
            app.helper.hideProgress();
            if(err === null){
                var result = response.success;
                if(result == true) {
                    aDeferred.resolve(response);
                } else {
                    app.helper.showErrorNotification({"message":response.message});
                    aDeferred.reject(response);
                }
            } else{
                app.helper.showErrorNotification({"message":err});
                aDeferred.reject();
            }
        });
        return aDeferred.promise();
    },
    registerStepNextBtnEvent: function () {
        var thisInstance = this;
        jQuery('#step3NextBtn').on('click', function (e){
            var element = e.currentTarget;
            var step = jQuery(element).data('step');
            var nextStep = step + 1;
            thisInstance.initiateStep(nextStep);
            if (nextStep === 4) {
                app.helper.showProgress();
                thisInstance.saveFirstCompany().then(
                    function (data) {
                        thisInstance.showStep4Content(data);
                        app.helper.hideProgress();
                    }
                );
            }
        });
    },
    showStep4Content:function (data) {
        var params = {
            module: app.getModuleName(),
            view: "ListAjax",
            success: data.success,
            recordId: data.recordId,
            mode: "step4Content"
        };

        app.request.post({data: params}).then(
            function(err, response) {
                if(err === null) {
                    jQuery("#step4content").html(response);
                }
            }
        )
    },
    saveFirstCompany: function () {
        var aDeferred = jQuery.Deferred();
        var par = {
            module: app.getModuleName(),
            action: 'SaveFirstCompany'
        };
        app.request.post({'data': par}).then(function(err,response) {
            if(err === null){
                aDeferred.resolve(response);
            } else {
                app.helper.showErrorNotification({"message":err});
                aDeferred.reject(response);
            }
        });
        return aDeferred.promise();
    },
    editLicense : function($type) {
        var aDeferred = jQuery.Deferred();
        var thisInstance = this;

        app.helper.showProgress();

        var license_key = jQuery('#license_key_val').val();
        var url = "index.php?module=ITS4YouMultiCompany&view=IndexAjax&mode=editLicense&type="+$type+"&key="+license_key;

        app.request.post({'url':url}).then(
            function (err, response) {
                if (err === null) {
                    app.helper.hideProgress();
                    app.helper.showModal(response, {
                        'cb': function (modalContainer) {
                            modalContainer.find('#js-edit-license').on('click', function (e){
                                var form = modalContainer.find('#editLicense');
                                var params = {
                                    submitHandler: function (form) {
                                        if (!this.valid) {
                                            return false;
                                        }
                                        thisInstance.saveLicenseKey(form, false);
                                    }
                                };
                                form.vtValidate(params);
                            });
                        }
                    });
                }
            }
        );

        return aDeferred.promise();
    },
    registerActions : function() {
        var thisInstance = this;
        jQuery('#activate_license_btn').click(function() {
            thisInstance.editLicense('activate');
        });
        jQuery('#reactivate_license_btn').click(function() {
            thisInstance.editLicense('reactivate');
        });

        jQuery('#deactivate_license_btn').click(function() {
            thisInstance.deactivateLicense();
        });
    },
    registerEvents: function() {
        this.registerActions();
    },
    deactivateLicense: function () {
        app.helper.showProgress();
        var license_key = jQuery('#license_key_val').val();
        var deactivateActionUrl = 'index.php?module=ITS4YouMultiCompany&action=License&mode=deactivateLicense&key='+license_key;

        app.request.post({'url':deactivateActionUrl + '&type=control'}).then(
            function (err, response) {
                if (err === null) {
                    app.helper.hideProgress();
                    if (response.success) {
                        var message = app.vtranslate('LBL_DEACTIVATE_QUESTION','ITS4YouMultiCompany');
                        app.helper.showConfirmationBox({'message': message}).then(function(data) {
                            app.helper.showProgress();
                            app.request.post({'url':deactivateActionUrl}).then(
                                function (err2, response2) {
                                    if (err2 === null) {
                                        if (response2.success) {
                                            app.helper.showSuccessNotification({message: response2.deactivate});

                                            jQuery('#license_key_val').val("");
                                            jQuery('#license_key_label').html("");

                                            jQuery('#divgroup1').show();
                                            jQuery('#divgroup2').hide();
                                        }
                                        else {
                                            app.helper.showErrorNotification({message: response2.deactivate});
                                        }
                                    }
                                    else {
                                        app.helper.showErrorNotification({"message":err2});
                                    }
                                    app.helper.hideProgress();
                                }
                            );
                        });
                    } else {
                        app.helper.showErrorNotification({message: response.deactivate});
                    }
                } else {
                    app.helper.hideProgress();
                    app.helper.showErrorNotification({"message":err});
                }
            }
        );
    },
    saveAllowedModulesForMultiCompany: function (form) {
        var thisInstance = this;
        var formData = form.serializeFormData();
        var params = {
            "type": "POST",
            "module": app.getModuleName(),
            "parent": "Settings",
            "action": "SaveAllowedModules",
            "formData": formData,
            "dataType": 'json'
        };

        app.helper.showProgress();
        app.request.post({data: params}).then(
            function (err, response) {
                app.helper.hideProgress();
                if (err === null) {
                    app.helper.showSuccessNotification({message: response.message});
                    thisInstance.initiateStep(3);
                } else {
                    app.helper.showErrorNotification({message: err.message})
                }
            }
        );
    },
    registerSelectRoleBtnEvent: function () {

        jQuery('#selectRoleBtn').on('click', function () {
            var win = window.open("index.php?module=Roles&parent=Settings&view=Index", '_blank');
            win.focus();
        });
    },
    registerInstallEvents: function() {
        var thisInstance = this;
        var form = jQuery('#editLicense');
        form.on('submit', function(e){
            e.preventDefault();
            thisInstance.saveLicenseKey(form,true);
        });

        var modulesForm = jQuery("#enableNumberingModulesForm");
        modulesForm.on('submit', function (e) {
            e.preventDefault();
            thisInstance.saveAllowedModulesForMultiCompany(modulesForm);
        });

        this.registerStepNextBtnEvent();
        this.registerSelectRoleBtnEvent();
    }
});