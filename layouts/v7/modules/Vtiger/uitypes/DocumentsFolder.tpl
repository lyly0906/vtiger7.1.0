{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is: vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
{strip}
{assign var="FIELD_INFO" value=$FIELD_MODEL->getFieldInfo()}
{assign var=FOLDER_VALUES value=$FIELD_MODEL->getDocumentFolders()}
{assign var="SPECIAL_VALIDATOR" value=$FIELD_MODEL->getValidator()}
<select class="select2 inputElement" name="{$FIELD_MODEL->getFieldName()}" {if !empty($SPECIAL_VALIDATOR)}data-validator="{Zend_Json::encode($SPECIAL_VALIDATOR)}"{/if} 
        {if $FIELD_INFO["mandatory"] eq true} data-rule-required="true" {/if}
        {if count($FIELD_INFO['validator'])} 
            data-specific-rules='{ZEND_JSON::encode($FIELD_INFO["validator"])}'
        {/if}  id="folders-list-option-upload">

{foreach item=FOLDER_NAME key=FOLDER_VALUE from=$FOLDER_VALUES}
    {if $FOLDER_VALUE == 1}
	<option value="{$FOLDER_VALUE}" {if $FIELD_MODEL->get('fieldvalue') eq $FOLDER_VALUE} selected {/if} okk="parent_{$FOLDER_VALUE}">{$FOLDER_NAME}</option>
    {/if}
{/foreach}
</select>
    <script>
        $("span[data-toggle=tooltip]").toggle(function(){
            $(this).text($(this).attr('data-original-title')).show();

        },function(){
            $(this).text("");
        });

        function parentlistss(parentid, tab){
            $.ajax({
                type: "GET",
                url: "index.php?module=Documents&action=ParentList&id="+parentid,
                dataType:"json",
                success: function(result) {
                    $.each( result.result, function(index, content) {
                        var html = '';
                        html = '<option value="'+ content.folderid +'" okk="parent_'+ content.folderid +'">'+ tab + '|--' +content.foldername +'</option>';
                        $('#folders-list-option-upload').find("option[okk=parent_" + parentid + "]").after(html);

                        parentlistss(content.folderid,tab+"&nbsp;&nbsp;&nbsp;&nbsp;");
                    });
                }
            });
        }
        $(function(){
            $('#folders-list-option-upload > option').each(function(){
                if($(this).val() != ''){
                    var parentid = $(this).val();
                    parentlistss(parentid,"&nbsp;&nbsp;");
                }
            });
        });
    </script>
{/strip}