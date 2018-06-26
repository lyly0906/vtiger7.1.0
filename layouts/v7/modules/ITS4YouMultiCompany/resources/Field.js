/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_Reference_Field_Js("ITS4YouMultiCompany_Reference_Field_Js", {}, {
    /**
     * Function to add the validation for the element
     */
    addValidationToElement : function(element) {
        var element = jQuery(element);
        var addValidationToElement = element;
        var elementInStructure = element.find('[name="'+this.getName()+'"]');
        if(elementInStructure.length > 0){
            addValidationToElement = elementInStructure;
        }
        if(this.isMandatory()) {
            addValidationToElement.attr('data-rule-required', 'true');
            var type = this.getType();
            if (type == 'reference') {
                addValidationToElement.attr('data-rule-its4you_mc_role_reference_required', 'true');
            }
        }
        addValidationToElement.attr('data-fieldinfo',JSON.stringify(this.getData())).attr('data-specific-rules',JSON.stringify(this.getData().specialValidator));
        return element;
    },
});
