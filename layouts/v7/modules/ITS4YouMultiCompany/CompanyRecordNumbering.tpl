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
    <input type="hidden" id="tab_label" name="tab_label" value="{$TAB_LABEL}"/>
    {assign var=DEFAULT_MODULE_DATA value=$DEFAULT_MODULE_MODEL->getModuleCustomNumberingData($smarty.request.record)}
    {assign var=DEFAULT_MODULE_NAME value=$DEFAULT_MODULE_MODEL->getName()}
    <div class="row form-group">
        <div class="col-lg-3 col-md-3 col-sm-3 control-label fieldLabel">
            <label><b>{vtranslate('LBL_USE_PREFIX', $QUALIFIED_MODULE)}</b></label>
        </div>
        <div class=" col-lg-3 col-md-3 col-sm-3">
            <input class="inputElement" type="text" name="prefix"
                   value="{$DEFAULT_MODULE_DATA['prefix']}"
                   data-old-prefix="{$DEFAULT_MODULE_DATA['prefix']}">
        </div>
        <div class=" col-lg-2 col-md-2 col-sm-2" id="special_values">
            <select name="special_values"
                    onchange="if (this.value != 0) this.form.prefix.value += this.value"
                    class="select2 inputElement">
                <option value="0">{vtranslate('LBL_CHOOSE_ONCE', $QUALIFIED_MODULE)}
                <option value="$year$">{vtranslate('LBL_YEAR', $QUALIFIED_MODULE)}
                <option value="$month$">{vtranslate('LBL_MONTH', $QUALIFIED_MODULE)}
                <option value="$week$">{vtranslate('LBL_WEEK', $QUALIFIED_MODULE)}
                <option value="$day$">{vtranslate('LBL_DAY', $QUALIFIED_MODULE)}
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-lg-3 col-md-3 col-sm-3 control-label fieldLabel">
            <label>
                <b>{vtranslate('LBL_START_SEQUENCE', $QUALIFIED_MODULE)}</b>&nbsp;
                <span class="redColor">*</span>
            </label>
        </div>
        <div class=" col-lg-5 col-md-5 col-sm-5">
            <input type="text" class="inputElement " id="sequence"
                   value="{$DEFAULT_MODULE_DATA['cur_id']}"
                   data-old-sequence-number="{$DEFAULT_MODULE_DATA['sequenceNumber']}"
                   data-rule-required="true" data-rule-positive="true"
                   data-rule-wholeNumber="true" name="sequenceNumber"/>
        </div>
    </div>
{/strip}