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
    <div class="editContainer" style="padding-left: 2%;padding-right: 2%">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <h3>{vtranslate('LBL_MODULE_NAME',$MODULE)} {vtranslate('LBL_INSTALL',$MODULE)}</h3>
            </div>
        </div>
        <hr>
        <div class="row">
            {assign var=LABELS value = ["step1" => "LBL_VALIDATION", "step2" => "LBL_MODULES", "step3" => "LBL_ROLES", "step4" => "LBL_FINISH"]}
            {include file="BreadCrumbs.tpl"|vtemplate_path:$MODULE ACTIVESTEP=$STEP BREADCRUMB_LABELS=$LABELS MODULE=$MODULE}
        </div>
        <div class="clearfix"></div>
        <div class="installationContents">
            <div style="border:1px solid #ccc;padding:1%;{if $STEP neq "1"}display:none;{/if}" id="stepContent1">
                <form name="install" id="editLicense" method="POST" action="index.php" class="form-horizontal">
                    <input type="hidden" name="module" value="ITS4YouMultiCompany"/>
                    <input type="hidden" name="view" value="List"/>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <h4><strong>{vtranslate('LBL_WELCOME','ITS4YouMultiCompany')}</strong></h4>
                            <br>
                            <p>
                                {vtranslate('LBL_WELCOME_DESC','ITS4YouMultiCompany')}<br>
                                {vtranslate('LBL_WELCOME_FINISH','ITS4YouMultiCompany')}
                            </p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <label><strong>{vtranslate('LBL_INSERT_KEY','ITS4YouMultiCompany')}</strong></label>
                            <br>
                            <p>
                                {vtranslate('LBL_ONLINE_ASSURE','ITS4YouMultiCompany')}
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            {include file='LicenseDetails.tpl'|@vtemplate_path:$MODULE}
                        </div>
                    </div>
                </form>
            </div>
            <div style="border:1px solid #ccc;padding:1%;{if $STEP neq "2"}display:none;{/if}" id="stepContent2">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h4><strong>{vtranslate('LBL_INSTALL_STEP2','ITS4YouMultiCompany')}</strong></h4><br>
                        {if !$HIDE_SUCCESS_ALERT}
                        <div class="alert alert-success">
                            {vtranslate('LBL_INSTALL_STEP2_SUCCESS_VALIDATION', $MODULE)}
                        </div>
                        {/if}
                        <p>
                            {vtranslate('LBL_INSTALL_STEP2_DESC', $MODULE)}
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <form class="form-horizontal enableNumberingModulesForm" id="enableNumberingModulesForm"
                          method="POST">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                            <table class="table editview-table no-border">
                                <tbody>
                                <tr>
                                    {foreach item=module from=$SUPPORTED_MODULES name="supportModules"}
                                    <td class="{$WIDTHTYPE} fieldLabel">
                                        <label class="fieldLabel"><b>{$module.name|@getTranslatedString:$module.name}</b></label>
                                    </td>
                                    <td class="{$WIDTHTYPE} fieldValue">
                                        <div class="controls col-sm-1 col-md-1 col-lg-1">
                                            <input class="form-control" type="checkbox"
                                                   name="allowed_{$module.tabid}" id="allowed_{$module.tabid}"
                                                   {if $module.tab_id}checked{/if}>
                                        </div>
                                    </td>
                                    {if $module@iteration % 3 == 0}
                                </tr>
                                <tr>
                                    {/if}
                                    {/foreach}
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row clearfix">
                            <div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                                <button type='submit' class='btn btn-success saveButton'
                                        type="button"><strong>{vtranslate('LBL_NEXT', $MODULE)}</strong></button>&nbsp;&nbsp;
                            </div>
                        </div>
                    </form>
                </div>
                <br>
            </div>
            <div style="border:1px solid #ccc;padding:1%;{if $STEP neq "3"}display:none;{/if}" id="stepContent3">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h4><strong>{vtranslate('LBL_INSTALL_STEP3','ITS4YouMultiCompany')}</strong></h4><br>
                        <p>
                            {vtranslate('LBL_INSTALL_STEP3_DESC', $MODULE)}<br>
                            {vtranslate('LBL_INSTALL_STEP3_DESC1', $MODULE)}
                        </p>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-3">
                        <img src="layouts/v7/modules/ITS4YouMultiCompany/images/roles.png" class="img img-responsive">
                    </div>
                </div>
                <br>
                <div class="row textAlignCenter">
                    <div class="col-sm-12">
                        <button class="btn btn-success btn-large"
                                id="selectRoleBtn"><strong>{vtranslate('LBL_CREATE_ROLES', $MODULE)}</strong></button>&nbsp;
                        <button class="btn btn-primary" id="step3NextBtn"
                                data-step="3"><strong>{vtranslate('LBL_NEXT', $MODULE)}</strong></button>
                    </div>
                </div>
            </div>
            <div style="border:1px solid #ccc;padding:1%;{if $STEP neq "4"}display:none;{/if}" id="stepContent4">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h4><strong>{vtranslate('LBL_INSTALL_STEP4','ITS4YouMultiCompany')}</strong></h4><br>
                        <div id="step4content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script language="javascript" type="text/javascript">
        jQuery(document).ready(function() {
            var thisInstance = ITS4YouMultiCompany_License_Js.getInstance();
            thisInstance.registerInstallEvents();
        });
    </script>
{/strip}