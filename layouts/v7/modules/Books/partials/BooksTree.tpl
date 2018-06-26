{*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************}
{strip}
<ul class="nav nav-list nav-left-ml">
{foreach from=$ROLE->getChildren() item=CHILD_ROLE}
    <li >
        {if empty($CHILD_ROLE->getChildren())}
            <a class="filterName" href="index.php?module=Books&view=List&companyid={$CHILD_ROLE->get('its4you_company')}&groupid={$CHILD_ROLE->getName()}" >{vtranslate($CHILD_ROLE->getName(), $CHILD_ROLE->getName())}</a>
        {else}
            <label class="nav-toggle nav-header"><span class="nav-toggle-icon glyphicon glyphicon-chevron-right"></span>
                <a class="filterName" href="index.php?module=Books&view=List&groupid={$CHILD_ROLE->getName()}" >{vtranslate($CHILD_ROLE->getName(), $CHILD_ROLE->getName())}</a>
            </label>
        {/if}
        {assign var="ROLE" value=$CHILD_ROLE}
        {include file="modules/Books/partials/BooksTree.tpl"}
    </li>
{/foreach}
</ul>
{/strip}