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
    <div class="detailViewContainer viewContent clearfix">
        <div class="block">
            <br>
            {*<div class="row">*}
                {*<div class="col-lg-12 col-md-12 col-sm-12">*}
                    {*<div class="clearfix">*}
                        {*<div class="btn-group pull-right" style="margin-top: 10px;">*}
                            {*<button type="button" class="btn addButton btn-default"*}
                                    {*name="updateRecordWithSequenceNumber">{vtranslate('LBL_UPDATE_MISSING_RECORD_SEQUENCE', $QUALIFIED_MODULE)}</button>*}
                        {*</div>*}
                    {*</div>*}
                {*</div>*}
            {*</div>*}
            {*<hr>*}
            <div id="CompanyDetailsContainer">
                {*<form id="EditCompanyRecordNumberingForm" method="POST">*}
                    <div class="row">
                        <div class="CompanyDetailsContainer col-lg-12 col-md-12 col-sm-12">
                            <input type="hidden" id="companyid" name="companyid" value="{$smarty.request.record}">
                            {if $SUPPORTED_MODULES_COUNT > 0}
                                {assign var=DEFAULT_MODULE_DATA value=$DEFAULT_MODULE_MODEL->getModuleCustomNumberingData($smarty.request.record)}
                                {assign var=DEFAULT_MODULE_NAME value=$DEFAULT_MODULE_MODEL->getName()}
                                <br>
                                <div class="table form-horizontal no-border" id="customRecordNumbering">
                                    <div class="row form-group">
                                        <div class="col-lg-3 col-md-3 col-sm-3 control-label fieldLabel">
                                            <label><b>{vtranslate('LBL_MODULE', $QUALIFIED_MODULE)}</b></label>
                                        </div>
                                        <div class=" col-lg-5 col-md-5 col-sm-5">
                                            <select class="select2 inputElement " name="sourceModule" id="sourceModule" disabled>
                                                {foreach key=index item=MODULE_MODEL from=$SUPPORTED_MODULES}
                                                {assign var=MODULE_NAME value=$MODULE_MODEL->get('name')}
                                                <option value={$MODULE_NAME} {if $MODULE_NAME eq $DEFAULT_MODULE_NAME} selected {/if}>
                                                    {vtranslate($MODULE_NAME, $MODULE_NAME)}
                                                    {/foreach}
                                            </select>
                                        </div>
                                    </div>
                                    <div id="recordNumberingContents">
                                        {include file="CompanyRecordNumbering.tpl"|@vtemplate_path:'ITS4YouMultiCompany'}
                                    </div>
                                </div>
                            {else}
                                <label>{vtranslate('no_supported_module_info', $QUALIFIED_MODULE)}</label>
                            {/if}
                        </div>
                    </div>
                    <br>
                {*</form>*}
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <br>
    <br>
    <br>
{/strip}