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
    {if $SUCCESS eq 'true'}
        <p>
            <strong>{vtranslate('LBL_INSTALL_STEP4_DESC', $QUALIFIED_MODULE)}</strong><br>
        </p>
        {*<div class="row">*}
            {*<div class="col-sm-12 col-md-12 col-lg-12">*}
                {*{vtranslate('LBL_GO_EDIT_VIEW', $QUALIFIED_MODULE)}*}
                {*&nbsp;<strong><a class="btn-link" href="{$RECORD->getEditViewUrl()}">Edit view</a></strong>&nbsp;*}
                {*{vtranslate('LBL_OF_COMPANY', $QUALIFIED_MODULE)}*}
            {*</div>*}
        {*</div>*}
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                {vtranslate('LBL_GO_DEFINE_ROLE', $QUALIFIED_MODULE)}
            </div>
        </div>
        <div class="row textAlignCenter">
            <div class="col-sm-12">
                <button class="btn btn-success"
                        id="" title="{vtranslate('LBL_DEFINE_ROLE', $QUALIFIED_MODULE)}" onclick="location.href='{$RECORD->getEditViewUrl()}'"><strong>{vtranslate('LBL_DEFINE_ROLE', $QUALIFIED_MODULE)}</strong></button>
            </div>
        </div>
    {else}
        <div class="row textAlignCenter">
            <div class="col-sm-12">
                <button class="btn btn-success"
                        id="" title="{vtranslate('LBL_FINISH', $QUALIFIED_MODULE)}" onclick="location.href='index.php?module=ITS4YouMultiCompany&view=List'"><strong>{vtranslate('LBL_FINISH', $QUALIFIED_MODULE)}</strong></button>
            </div>
        </div>
    {/if}
{/strip}