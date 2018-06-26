{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Departments/views/Index.php *}

{strip}
    <div class="listViewPageDiv " id="listViewContent">
        <div class="col-sm-12 col-xs-12 ">
            <br>
            <div class="clearfix treeView">
                <ul>
                    <li data-role="{$ROOT_DEPARTMENT->getParentDepartmentstring()}" data-roleid="{$ROOT_DEPARTMENT->getId()}">
                        <div class="toolbar-handle">
                            <a href="javascript:;" class="btn app-MARKETING droppable">{$ROOT_DEPARTMENT->getName()}</a>
                            <div class="toolbar" title="{vtranslate('LBL_ADD_RECORD', $QUALIFIED_MODULE)}">
                                &nbsp;<a href="{$ROOT_DEPARTMENT->getCreateChildUrl()}" data-url="{$ROOT_DEPARTMENT->getCreateChildUrl()}" data-action="modal"><span class="icon-plus-sign"></span></a>
                            </div>
                        </div>
                        {assign var="ROLE" value=$ROOT_DEPARTMENT}
                        {include file=vtemplate_path("DepartmentTree.tpl", "Settings:Departments")}
                    </li>
                </ul>
            </div>
        </div>
    </div>
{/strip}