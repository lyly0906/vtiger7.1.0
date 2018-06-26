{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
<style>
.nav-list{
    padding-right:15px;
    padding-left:15px;
    margin-bottom:0;
}
.nav-list-main{
    padding-left:0px;
    padding-right:0px;
    margin-bottom:0;
}
span.nav-toggle-icon{
    font-size:7px !important;
    top:-2px !important;
    color:#888 !important;
}
</style>
<div class="sidebar-menu sidebar-menu-full">
    <div class="module-filters" id="module-filters">
        <div class="sidebar-container lists-menu-container">

            <hr>
            <div class="list-menu-content" style="margin-top: 50px;">
                <div class="list-group">
                    {assign var="ROLE" value=$ROOT_DEPARTMENT}
                    <ul class="nav nav-list-main">
                        <li><label class="nav-toggle nav-header"><span class="nav-toggle-icon glyphicon glyphicon-chevron-right"></span>
                                <a class="filterName" href="" > {vtranslate('LBL_ORGANIZATIONS', 'Settings:$MODULE')}</a>
                            </label>
                    {include file="modules/Books/partials/BooksTree.tpl"}
                        </li>
                    </ul>
                 </div>
                <div class="list-group hide noLists">
                    <h6 class="lists-header"><center> {vtranslate('LBL_NO')} {vtranslate('LBL_MODULES', 'Settings:$MODULE')} {vtranslate('LBL_FOUND')} ... </center></h6>
                </div>
            </div>
        </div>
    </div>
</div>


{*<div class="list-group">*}
    {*<ul class="lists-menu" style="list-style-type: none; padding-left: 0px;">*}
        {*{if $MODULE_LIST|@count gt 0}*}
            {*{foreach item=MODULEMODEL from=$MODULE_LIST}*}
                {*<li style="font-size:12px;" class='listViewFilter {if $MODULEMODEL->getName() eq $SOURCE_MODULE}active{/if} '>*}
                    {*<a class="filterName" href="index.php?module=Books&view=List&groupid={$MODULEMODEL->getId()}" >{vtranslate($MODULEMODEL->getName(), $MODULEMODEL->getName())}</a>*}
                {*</li>*}
            {*{/foreach}*}
        {*{/if}*}
    {*</ul>*}
{*</div>*}

<script type="text/javascript">
    $('ul.nav-left-ml').toggle();
    $('label.nav-toggle span').click(function () {
        $(this).parent().parent().children('ul.nav-left-ml').toggle(300);
        var cs = $(this).attr("class");
        if(cs == 'nav-toggle-icon glyphicon glyphicon-chevron-right') {
            $(this).removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
        }
        if(cs == 'nav-toggle-icon glyphicon glyphicon-chevron-down') {
            $(this).removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
        }
    });
    $('ul.nav-left-ml').css("display","block");
</script>