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
	<div class="col-lg-6 col-md-6 col-sm-6">
		<div class="record-header clearfix">
			{if !$MODULE}
				{assign var=MODULE value=$MODULE_NAME}
			{/if}
			<div class="hidden-sm hidden-xs recordImage bg_{$MODULE} app-{$SELECTED_MENU_CATEGORY}">
				{assign var=FIELD_MODEL value=$RECORD->getField('logo')}
				{assign var=IMAGE_DETAILS value=$RECORD->getImageDetails($FIELD_MODEL)}
                {foreach key=ITER item=IMAGE_INFO from=$IMAGE_DETAILS}
					{if !empty($IMAGE_INFO.path)}
						<img src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}" alt="{$IMAGE_INFO.orgname}" title="{$IMAGE_INFO.orgname}" width="100%" height="100%" align="left"><br>
					{/if}
				{/foreach}
                {if empty($IMAGE_DETAILS)}
				<div class="name">
					<span><strong><i class="vicon-its4youmulticompany"></i></strong></span>
				</div>
				{/if}
			</div>

			<div class="recordBasicInfo">
				<div class="info-row">
					<h4>
						<span class="recordLabel pushDown" title="{$RECORD->getName()}">
							{foreach item=NAME_FIELD from=$MODULE_MODEL->getNameFields()}
								{assign var=FIELD_MODEL value=$MODULE_MODEL->getField($NAME_FIELD)}
								{if $FIELD_MODEL->getPermissions()}
									<span class="{$NAME_FIELD}">{$RECORD->get($NAME_FIELD)}</span>&nbsp;
								{/if}
							{/foreach}
						</span>
					</h4>
				</div>
				{include file="DetailViewHeaderFieldsView.tpl"|vtemplate_path:$MODULE}
			</div>
		</div>
	</div>
{/strip}