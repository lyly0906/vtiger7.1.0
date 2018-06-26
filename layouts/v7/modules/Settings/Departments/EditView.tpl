{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Roles/views/EditAjax.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}
<div class="editViewPageDiv viewContent">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="editViewHeader">
                {if $RECORD_MODEL->getId()}
                    <h4>
                        {vtranslate('LBL_EDIT_DEPARTMENT', $QUALIFIED_MODULE)}
                    </h4>
                {else}
                    <h4>
                        {vtranslate('LBL_CREATE_DEPARTMENT', $QUALIFIED_MODULE)}
                    </h4>
                {/if}
            </div>
            <hr>
        <form class="form-horizontal" id="EditView" name="EditRole" method="post" action="index.php" enctype="multipart/form-data">
            <div class="editViewBody">
                <div class="editViewContents">
                    <input type="hidden" name="module" value="Departments">
                    <input type="hidden" name="action" value="Save">
                    <input type="hidden" name="parent" value="Settings">
                    {assign var=RECORD_ID value=$RECORD_MODEL->getId()}
                    <input type="hidden" name="record" value="{$RECORD_ID}" />
                    <input type="hidden" name="mode" value="{$MODE}">
                    <input type="hidden" name="profile_directly_related_to_role_id" value="{$PROFILE_ID}" />
                    {assign var=HAS_PARENT value="{if $RECORD_MODEL->getParent()}true{/if}"}
                    {if $HAS_PARENT}
                        <input type="hidden" name="parent_roleid" value="{$RECORD_MODEL->getParent()->getId()}">
                        <input type="hidden" name="companyId" value="{$parent_company}">
                    {/if}
                    <div name='editContent'>
                        <div class="form-group">
                            <label class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">
                                <strong>{vtranslate('LBL_NAME', $QUALIFIED_MODULE)}&nbsp;<span class="redColor">*</span></strong>
                            </label>
                            <div class="controls fieldValue col-lg-4 col-md-4 col-sm-4" >
                                <div class=""> <input type="text" class="inputElement" name="rolename" id="profilename" value="{$RECORD_MODEL->getName()}" data-rule-required='true'  />
                                </div> </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">
                                <strong>{vtranslate('LBL_REPORTS_TO', $QUALIFIED_MODULE)}</strong>
                            </label>
                            <div class="controls fieldValue col-lg-4 col-md-4 col-sm-4" >
                                <input type="hidden" name="parent_roleid" {if $HAS_PARENT}value="{$RECORD_MODEL->getParent()->getId()}"{/if}>
                                <div class=""> <input type="text" class="inputElement" name="parent_roleid_display" {if $HAS_PARENT}value="{$RECORD_MODEL->getParent()->getName()}"{/if} readonly>
                                </div></div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-3 fieldLabel control-label">
                                {vtranslate('LBL_SYNLHC', $QUALIFIED_MODULE)}
                            </label>
                            <div class="fieldValue col-lg-9 col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input class="inputElement" name="synlhc" id="synlhc" type="checkbox" value="1" {if $RECORD_MODEL->getSynlhc()}checked{/if}/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {if $ShowMultiCompany}
                        <div class="form-group row">
                            <label class="col-lg-3 col-md-3 col-sm-3 fieldLabel control-label">
                                {vtranslate('LBL_COMPANY', $QUALIFIED_MODULE)}
                            </label>
                            <div class="fieldValue col-lg-9 col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <select style="width: 140px;" class="select2 referenceModulesList" name="companyId">
                                            <option value=""></option>
                                            {foreach key=index item=value from=$MultiCompany}
                                                <option value="{$index}" {if $its4you_company == $index}selected="selected"{/if}>{$value->getname()}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/if}
                    </div>
                </div>
            <div class='modal-overlay-footer  clearfix'>
                <div class="row clearfix">
                    <div class=' textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                        <button type='submit' class='btn btn-success saveButton' >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
                        <a class='cancelLink'  href="javascript:history.back()" type="reset">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                    </div>
                </div>
            </div>
    </div>
    </form>
    </div>
</div>
</div>
</div>
