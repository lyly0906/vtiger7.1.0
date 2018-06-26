/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_Popup_Js("ITS4YouMultiCompany_Popup_Js", {}, {

    registerEventForListViewEntryClick : function(){
        var thisInstance = this;
        var popupPageContentsContainer = this.getPopupPageContainer();
        popupPageContentsContainer.off('click', 'a.btn.btn-default');
        popupPageContentsContainer.on('click','a.btn.btn-default',function(e){
            thisInstance.getListViewEntries(e);
        });
    },

    registerEvents: function () {
        this._super();
    }
});        