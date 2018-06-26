<?php /* Smarty version Smarty-3.1.7, created on 2018-06-07 04:06:07
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Settings\Departments\Index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:102645b18af2fe68489-23526892%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9fa4cc31f345ec5d33e30642a4fd977a3c99c45' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Settings\\Departments\\Index.tpl',
      1 => 1502696140,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102645b18af2fe68489-23526892',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ROOT_DEPARTMENT' => 0,
    'QUALIFIED_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b18af2ff2b98',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b18af2ff2b98')) {function content_5b18af2ff2b98($_smarty_tpl) {?>


<div class="listViewPageDiv " id="listViewContent"><div class="col-sm-12 col-xs-12 "><br><div class="clearfix treeView"><ul><li data-role="<?php echo $_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value->getParentDepartmentstring();?>
" data-roleid="<?php echo $_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value->getId();?>
"><div class="toolbar-handle"><a href="javascript:;" class="btn app-MARKETING droppable"><?php echo $_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value->getName();?>
</a><div class="toolbar" title="<?php echo vtranslate('LBL_ADD_RECORD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
">&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value->getCreateChildUrl();?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value->getCreateChildUrl();?>
" data-action="modal"><span class="icon-plus-sign"></span></a></div></div><?php $_smarty_tpl->tpl_vars["ROLE"] = new Smarty_variable($_smarty_tpl->tpl_vars['ROOT_DEPARTMENT']->value, null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("DepartmentTree.tpl","Settings:Departments"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</li></ul></div></div></div><?php }} ?>