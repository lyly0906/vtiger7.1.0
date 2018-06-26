<?php /* Smarty version Smarty-3.1.7, created on 2018-06-08 06:07:44
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Books\partials\BooksTree.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25525b190dbb95f385-39131653%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5238bbc3a7dbe6f86a474a8424cb9dec0e4ab9d7' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Books\\partials\\BooksTree.tpl',
      1 => 1528438062,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25525b190dbb95f385-39131653',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b190dbba2a58',
  'variables' => 
  array (
    'ROLE' => 0,
    'CHILD_ROLE' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b190dbba2a58')) {function content_5b190dbba2a58($_smarty_tpl) {?>
<ul class="nav nav-list nav-left-ml"><?php  $_smarty_tpl->tpl_vars['CHILD_ROLE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['CHILD_ROLE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ROLE']->value->getChildren(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['CHILD_ROLE']->key => $_smarty_tpl->tpl_vars['CHILD_ROLE']->value){
$_smarty_tpl->tpl_vars['CHILD_ROLE']->_loop = true;
?><li ><?php if (empty($_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getChildren())){?><a class="filterName" href="index.php?module=Books&view=List&companyid=<?php echo $_smarty_tpl->tpl_vars['CHILD_ROLE']->value->get('its4you_company');?>
&groupid=<?php echo $_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getName();?>
" ><?php echo vtranslate($_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getName(),$_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getName());?>
</a><?php }else{ ?><label class="nav-toggle nav-header"><span class="nav-toggle-icon glyphicon glyphicon-chevron-right"></span><a class="filterName" href="index.php?module=Books&view=List&groupid=<?php echo $_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getName();?>
" ><?php echo vtranslate($_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getName(),$_smarty_tpl->tpl_vars['CHILD_ROLE']->value->getName());?>
</a></label><?php }?><?php $_smarty_tpl->tpl_vars["ROLE"] = new Smarty_variable($_smarty_tpl->tpl_vars['CHILD_ROLE']->value, null, 0);?><?php echo $_smarty_tpl->getSubTemplate ("modules/Books/partials/BooksTree.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</li><?php } ?></ul><?php }} ?>