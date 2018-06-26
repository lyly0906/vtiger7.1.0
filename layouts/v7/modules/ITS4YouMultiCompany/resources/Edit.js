/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_Edit_Js("ITS4YouMultiCompany_Edit_Js", {}, {

    registerImageChangeEvent : function() {
        var formElement = this.getForm();
        formElement.on('change', 'input[name="logo[]"],input[name="stamp[]"]', function() {
            var deleteImageElement = jQuery(this).closest('td.fieldValue').find('.imageDelete');
            if(deleteImageElement.length) deleteImageElement.trigger('click');
        });
    },

    registerEventForImageDelete : function(){
        var formElement = this.getForm();
        formElement.find('.imageDelete').on('click', function (e) {
            var element = jQuery(e.currentTarget);
            var imageId = element.closest('div').find('img').data().imageId;
            var parentTd = element.closest('td');
            // var imageUploadElement = parentTd.find('[name="logo[]"]');
            element.closest('div').remove();

            if(formElement.find('[name=imageid]').length !== 0) {
                var imageIdValue = JSON.parse(formElement.find('[name=imageid]').val());
                imageIdValue.push(imageId);
                formElement.find('[name=imageid]').val(JSON.stringify(imageIdValue));
            } else {
                var imageIdJson = [];
                imageIdJson.push(imageId);

                console.log(imageIdJson);
                formElement.append('<input type="hidden" name="imgDeleted" value="true" />');
                formElement.append('<input type="hidden" name="imageid" value="'+JSON.stringify(imageIdJson)+'" />');
            }
        });
    },

    registerFileElementChangeEvent : function() {
        var thisInstance = this;
        var container = this.getForm();
        container.on('change', 'input[name="logo[]"],input[name="stamp[]"]', function(e){
            console.log(e.target.name);
            if(e.target.type == "text") return false;
            var moduleName = jQuery('[name="module"]').val();
            Vtiger_Edit_Js.file = e.target.files[0];
            var element = container.find('input[name="logo[]"]');
            if (e.target.name === "stamp[]") {
                element = container.find('input[name="stamp[]"]');
            }
            //ignore all other types than file
            if(element.attr('type') != 'file'){
                return ;
            }
            var uploadFileSizeHolder = element.closest('.fileUploadContainer').find('.uploadedFileSize');
            var fileSize = e.target.files[0].size;
            var fileName = e.target.files[0].name;
            var maxFileSize = thisInstance.getMaxiumFileUploadingSize(container);
            if(fileSize > maxFileSize) {
                alert(app.vtranslate('JS_EXCEEDS_MAX_UPLOAD_SIZE'));
                element.val('');
                uploadFileSizeHolder.text('');
            }else{
                if(container.length > 1){
                    jQuery('div.fieldsContainer').find('form#I_form').find('input[name="filename"]').css('width','80px');
                    jQuery('div.fieldsContainer').find('form#W_form').find('input[name="filename"]').css('width','80px');
                } else {
                    container.find('input[name="filename"]').css('width','80px');
                }
                uploadFileSizeHolder.text(fileName+' '+thisInstance.convertFileSizeInToDisplayFormat(fileSize));
            }

            jQuery(e.currentTarget).addClass('ignore-validation');
        });
    },

    registerEvents: function() {
        this._super();
    }
});




jQuery.validator.addMethod("its4you_mc_role_reference_required", function (value, element, params){
    var referenceValue = jQuery(element).parent().parent().find('input.sourceField').val();
    if (isNaN(referenceValue)) {
        referenceValue = jQuery(element).parent().parent().find('input.sourceField').attr('value');
    }

    if (referenceValue && referenceValue in params[0]) {
        return true;
    } else {
        return false;
    }
}, jQuery.validator.format(app.vtranslate('JS_REQUIRED_FIELD')));
