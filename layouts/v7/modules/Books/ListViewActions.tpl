{*<!--
/*+***********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************/
-->*}

{strip}
	<div id="listview-actions" class="listview-actions-container">
		<div class = "row">
			<div class='col-md-5'>
				<div class="hide messageContainer" style = "height:30px;">
					<center><a id="selectAllMsgDiv" href="#">{vtranslate('LBL_SELECT_ALL',$MODULE)}&nbsp;{vtranslate($MODULE ,$MODULE)}&nbsp;(<span id="totalRecordsCount" value=""></span>)</a></center>
				</div>
				<div class="hide messageContainer" style = "height:30px;">
					<center><a href="#" id="deSelectAllMsgDiv">{vtranslate('LBL_DESELECT_ALL_RECORDS',$MODULE)}</a></center>
				</div>
			</div>
			<div class="col-md-3">
				{assign var=RECORD_COUNT value=$LISTVIEW_ENTRIES_COUNT}
				{include file="Pagination.tpl"|vtemplate_path:$MODULE SHOWPAGEJUMP=true}
			</div>
		</div>
{/strip}