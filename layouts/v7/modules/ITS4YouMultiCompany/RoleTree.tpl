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
<ul>
{foreach from=$ROLE->getChildren() item=CHILD_ROLE}
    <li data-role="{$CHILD_ROLE->getParentRoleString()}" data-roleid="{$CHILD_ROLE->getId()}">
        <div class="toolbar-handle">
                <a style="white-space: nowrap" class="btn btn-default draggable droppable"
                   data-id="{$CHILD_ROLE->getId()}" data-name="{$CHILD_ROLE->getName()}"
                   data-info="" data-toggle="tooltip" data-placement="top" data-animation="true"
                   title="{$CHILD_ROLE->getName()}" {if array_key_exists($CHILD_ROLE->getId(), $USED_ROLES)}disabled="true" {/if}>
                    {$CHILD_ROLE->getName()}
                </a>
        </div>

        {assign var="ROLE" value=$CHILD_ROLE}
        {include file=vtemplate_path("RoleTree.tpl", "ITS4YouMultiCompany")}
    </li>
{/foreach}
</ul>
{/strip}