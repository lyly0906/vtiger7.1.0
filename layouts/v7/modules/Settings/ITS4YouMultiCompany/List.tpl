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
    <div class="container-fluid">
        <div class="row">
            <div class="listViewContentDiv col-lg-12 col-sm-12 col-md-12">
                <h4>{vtranslate('LBL_MODULE_NAME', $QUALIFIED_MODULE)}</h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <form class="form-horizontal numberingModulesForm" method="POST">
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
                                    <input class="form-control" type="checkbox" name="allowed_{$module.tabid}" id="allowed_{$module.tabid}"
                                           {if $module.tab_id}checked{/if}>
                                </div>
                            </td>
                            {if $module@iteration % 3 == 0}
                                </tr><tr>
                            {/if}
                        {/foreach}
                        </tr>
                        </tbody>
                    </table>
                    <br>
                    <div class='modal-overlay-footer clearfix'>
                        <div class="row clearfix">
                            <div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                                <button type='submit' class='btn btn-success saveButton' >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
                                {*<a class='cancelLink' data-dismiss="modal" href="#">{vtranslate('LBL_CANCEL', $MODULE)}</a>*}
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
{/strip}