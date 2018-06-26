/* * *******************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * ****************************************************************************** */

Vtiger_Detail_Js("ITS4YouMultiCompany_Detail_Js", {}, {

    loadSelectedTabContents: function(tabElement, urlAttributes){
        var self = this;
        var detailViewContainer = this.getDetailViewContainer();
        var url = tabElement.data('url');
        self.loadContents(url,urlAttributes).then(function(data){
            self.deSelectAllrelatedTabs();
            self.markRelatedTabAsSelected(tabElement);
            var container = jQuery('.relatedContainer');
            app.event.trigger("post.relatedListLoad.click",container.find(".searchRow"));
            // Added this to register pagination events in related list
            var relatedModuleInstance = self.getRelatedController();
            //Summary tab is clicked
            if(tabElement.data('linkKey') == self.detailViewSummaryTabLabel) {
                self.registerSummaryViewContainerEvents(detailViewContainer);
                self.registerEventForPicklistDependencySetup(self.getForm());
                self.showMapWidget();
            }

            //Detail tab is clicked
            if(tabElement.data('linkKey') == self.detailViewDetailTabLabel) {
                self.triggerDetailViewContainerEvents(detailViewContainer);
                self.registerEventForPicklistDependencySetup(self.getForm());
            }

            // Registering engagement events if clicked tab is History
            if(tabElement.data('labelKey') == self.detailViewHistoryTabLabel){
                var engagementsContainer = jQuery(".engagementsContainer");
                if(engagementsContainer.length > 0){
                    app.event.trigger("post.engagements.load");
                }
            }

            /** ITS4You start JK **/
            self.registerTableRowClickEvent();
            self.registerEditCustomNumberingIconClickEvent();
            self.showMapWidget();
            /** ITS4You end JK **/

            relatedModuleInstance.initializePaginationEvents();
            //prevent detail view ajax form submissions
            jQuery('form#detailView').on('submit', function(e) {
                e.preventDefault();
            });
        });
    },

    loadWidgets : function(){
        var self = this;
        var widgetList = jQuery('[class^="widgetContainer_"]');
        widgetList.each(function(index,widgetContainerELement){
            var widgetContainer = jQuery(widgetContainerELement);
            self.loadWidget(widgetContainer).then(function(){
                app.event.trigger('post.summarywidget.load',widgetContainer);
            });
        });
        self.showMapWidget();
    },

    showMapWidget: function () {
        var thisInstance = this;
        container = jQuery('#mapWidget');
        var params1 = {
            'module' : 'ITS4YouMultiCompany',
            'action' : 'MapAjax',
            'mode' : 'getLocation',
            'recordid' : app.getRecordId(),
            'source_module' : app.getModuleName()
        };

        app.request.post({"data":params1}).then(function(error,response) {
            var result = JSON.parse(response);
            var address = result.address;
            // alert(JSON.stringify(response));
            var location = jQuery.trim((address).replace(/\,/g," "));
            if(location == '' || location == null) {
                jQuery(container).addClass('hide');
            } else {
                container.find("#address").html(location);
                container.find('#address').removeClass('hide');

                thisInstance.loadMapScript();
            }
        });

    },

    loadMapScript : function() {
        jQuery.getScript("https://maps.google.com/maps/api/js?sensor=true&async=2&callback=initialize", function () {});
    },

    registerEditCustomNumberingIconClickEvent: function () {
        jQuery('.companyNumberingInfoContents').on('click', 'a[name="companyNumberingEdit"]', function(e) {
            e.stopImmediatePropagation();
            var element = jQuery(e.currentTarget);
            var editUrl = element.data('url');
            window.location.href = editUrl;
        });
    },

    registerTableRowClickEvent: function () {

        jQuery('.listViewEntries').each(function (index, element) {
            if (jQuery(element).hasClass('numberingListViewEntries')) {
                jQuery(element).on('click', function (e) {
                    var url = jQuery(e.currentTarget).data('url');
                    window.location.href = url;
                });
            }
        });
    },
    registerEvents: function () {
        this._super();
        this.registerEditCustomNumberingIconClickEvent();
        this.registerTableRowClickEvent();
    }
});

function initialize() {
    geocoder = new google.maps.Geocoder();
    var mapOptions = {
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
    };
    map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
    var address = jQuery(document.getElementById('address')).text();
    var label = jQuery(document.getElementById('record_label')).val();
    if (geocoder) {
        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
                    map.setCenter(results[0].geometry.location);
                    var infowindow = new google.maps.InfoWindow({
                        content: '<b>' + label + '</b><br><br>' + address,
                        size: new google.maps.Size(150, 50)
                    });
                    var marker = new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        title: address
                    });
                    google.maps.event.addListener(marker, 'click', function () {
                        infowindow.open(map, marker);
                    });
                }
            }
        });
    }
}