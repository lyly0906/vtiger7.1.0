{*<!--
/*********************************************************************************
 * The content of this file is subject to the ITS4YouMultiCompany license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
********************************************************************************/
-->*} 
{strip}
    <div class="companyNumberingInfoContainer">
        {if $SUPPORTED_MODULES_COUNT > 0}
            {include file="partials/RelatedListHeader.tpl"|vtemplate_path:"ITS4YouMultiCompany"}
            <div class="relatedContents companyNumberingInfoContents col-lg-12 col-md-12 col-sm-12 table-container">
                <table id="listview-table" class="table listview-table">
                    <thead>
                    <tr class="listViewHeaders">
                        <th style="min-width:100px"></th>
                        <th class="nowrap">{vtranslate('LBL_MODULE', $QUALIFIED_MODULE)}</th>
                        <th class="nowrap">{vtranslate('LBL_PREFIX', $QUALIFIED_MODULE)}</th>
                        <th class="nowrap">{vtranslate('LBL_START_INDEX', $QUALIFIED_MODULE)}</th>
                        <th class="nowrap">{vtranslate('LBL_CURRENT_INDEX', $QUALIFIED_MODULE)}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach key=index item=MODULE_MODEL from=$SUPPORTED_MODULES}
                        {assign var=MODULE_DATA value=$MODULE_MODEL->getModuleCustomNumberingData($smarty.request.record)}
                        {assign var=MODULE_NAME value=$MODULE_MODEL->get('name')}
                        <tr class="listViewEntries numberingListViewEntries" data-url="{$MODULE_MODEL->getEditNumberingUrl()}&record={$smarty.request.record}&sourceModule={$MODULE_NAME}&tab_label={$TAB_LABEL}">
                            <td class="related-list-actions">
                            <span class="actionImages">
                                <a name="companyNumberingEdit"
                                   data-url="{$MODULE_MODEL->getEditNumberingUrl()}&record={$smarty.request.record}&sourceModule={$MODULE_NAME}&tab_label={$TAB_LABEL}">
                                    <i title="{vtranslate('LBL_EDIT', $MODULE)}"
                                       class="fa fa-pencil"></i></a>
                            </span>
                            </td>
                            <td class="relatedListEntryValues">
                                <span class="value textOverflowEllipsis">{vtranslate($MODULE_NAME, $MODULE_NAME)}</span>
                            </td>
                            <td class="relatedListEntryValues">
                                <span class="value textOverflowEllipsis">{$MODULE_DATA['prefix']}</span>
                            </td>
                            <td class="relatedListEntryValues">
                                <span class="value textOverflowEllipsis">{$MODULE_DATA['start_id']}</span>
                            </td>
                            <td class="relatedListEntryValues">
                                <span class="value textOverflowEllipsis">{$MODULE_DATA['cur_id']}</span>
                            </td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
            </div>
        {/if}
    </div>
    <div class="clearfix"></div>
{/strip}