<?php /* Smarty version Smarty-3.1.7, created on 2018-06-07 10:49:31
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Books\partials\SidebarEssentials.tpl" */ ?>
<?php /*%%SmartyHeaderCode:189555b190dbb8ceb01-60511855%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '91a0dafdace822a5da868d1bbf54fca3e68be99e' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Books\\partials\\SidebarEssentials.tpl',
      1 => 1514862547,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '189555b190dbb8ceb01-60511855',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ROOT_DEPARTMENT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b190dbb93ff8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b190dbb93ff8')) {function content_5b190dbb93ff8($_smarty_tpl) {?>
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
                    <?php $_smarty_tpl->tpl_vars["ROLE"] = new Smarty_variable($_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value, null, 0);?>
                    <ul class="nav nav-list-main">
                        <li><label class="nav-toggle nav-header"><span class="nav-toggle-icon glyphicon glyphicon-chevron-right"></span>
                                <a class="filterName" href="" > <?php echo vtranslate('LBL_ORGANIZATIONS','Settings:$MODULE');?>
</a>
                            </label>
                    <?php echo $_smarty_tpl->getSubTemplate ("modules/Books/partials/BooksTree.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                        </li>
                    </ul>
                 </div>
                <div class="list-group hide noLists">
                    <h6 class="lists-header"><center> <?php echo vtranslate('LBL_NO');?>
 <?php echo vtranslate('LBL_MODULES','Settings:$MODULE');?>
 <?php echo vtranslate('LBL_FOUND');?>
 ... </center></h6>
                </div>
            </div>
        </div>
    </div>
</div>



    
        
            
                
                    
                
            
        
    


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
</script><?php }} ?>