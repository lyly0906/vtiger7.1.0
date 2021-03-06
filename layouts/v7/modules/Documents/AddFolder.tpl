{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************}
{* modules/Documents/views/AddFolder.php *}
{strip}
<div class="modal-dialog modelContainer">
	<div class = "modal-content">
	{assign var=HEADER_TITLE value={vtranslate('LBL_ADD_NEW_FOLDER', $MODULE)}}
	{if $FOLDER_ID}
		{assign var=HEADER_TITLE value="{vtranslate('LBL_EDIT_FOLDER', $MODULE)}: {$FOLDER_NAME}"}
	{/if}
	{include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}
	<form class="form-horizontal" id="addDocumentsFolder" method="post" action="index.php">
		<input type="hidden" name="module" value="{$MODULE}" />
		<input type="hidden" name="action" value="Folder" />
		<input type="hidden" name="mode" value="save" />
		{if $FOLDER_ID neq null}
			<input type="hidden" name="folderid" value="{$FOLDER_ID}" />
			<input type="hidden" name="savemode" value="{$SAVE_MODE}" />
		{/if}
		<div class="modal-body">
			<div class="container-fluid">
				<div class="form-group">
					<label class="control-label fieldLabel col-sm-3">
						上一级文件夹<span class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" data-original-title="上一级文件夹不选，则默认为Default"></span></label>
					<div class="controls col-sm-9">


						    <select name="parentfolder" class="inputElement select2 select2-offscreen" title="" tabindex="-1" id="folders-list-option">
								<option value="">请选择上一级文件夹</option>
								{foreach item="FOLDER" from=$FOLDERS}
									{assign var=FOLDERNAME value={vtranslate($FOLDER->get('foldername'), $MODULE)}}

									<option value="{$FOLDER->get('folderid')}" okk="parent_{$FOLDER->get('folderid')}">{$FOLDERNAME}</option>
								{/foreach}
                            </select>
						<script>
							$("span[data-toggle=tooltip]").toggle(function(){
								$(this).text($(this).attr('data-original-title')).show();

							},function(){
								$(this).text("");
							});

							function parentlists(parentid, tab){
								$.ajax({
									type: "GET",
									url: "index.php?module=Documents&action=ParentList&id="+parentid,
									dataType:"json",
									success: function(result) {
										$.each( result.result, function(index, content) {
											var html = '';
											html = '<option value="'+ content.folderid +'" okk="parent_'+ content.folderid +'">'+ tab + '|--' +content.foldername +'</option>';
											$('#folders-list-option').find("option[okk=parent_" + parentid + "]").after(html);

											parentlists(content.folderid,tab+"&nbsp;&nbsp;&nbsp;&nbsp;");
										});
									}
								});
							}
							$(function(){
								$('#folders-list-option > option').each(function(){
									if($(this).val() != ''){
										var parentid = $(this).val();
										parentlists(parentid,"&nbsp;&nbsp;");
									}
								});
							});
						</script>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label fieldLabel col-sm-3">
						<span class="redColor">*</span>
						{vtranslate('LBL_FOLDER_NAME', $MODULE)}
					</label>
					<div class="controls col-sm-9">
						<input class="inputElement" id="documentsFolderName" data-rule-required="true" name="foldername" type="text" value="{if $FOLDER_NAME neq null}{$FOLDER_NAME}{/if}"/>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label fieldLabel col-sm-3">
						{vtranslate('LBL_FOLDER_DESCRIPTION', $MODULE)}
					</label>
					<div class="controls col-sm-9">
						<textarea rows="3" class="inputElement form-control" name="folderdesc" id="description" style="resize: vertical;">{if $FOLDER_DESC neq null}{$FOLDER_DESC}{/if}</textarea>
					</div>
				</div>
			</div>
		</div>
		{include file='ModalFooter.tpl'|@vtemplate_path:$MODULE}
	</form>
	</div>
</div>
{/strip}

