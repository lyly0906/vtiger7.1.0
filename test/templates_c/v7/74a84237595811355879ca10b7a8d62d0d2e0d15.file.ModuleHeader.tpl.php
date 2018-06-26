<?php /* Smarty version Smarty-3.1.7, created on 2018-06-07 10:49:31
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Books\ModuleHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:243095b190dbb80f486-76935835%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '74a84237595811355879ca10b7a8d62d0d2e0d15' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Books\\ModuleHeader.tpl',
      1 => 1514861613,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '243095b190dbb80f486-76935835',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'VIEW' => 0,
    'SOURCE_MODULE' => 0,
    'FIELDS_INFO' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b190dbb8b358',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b190dbb8b358')) {function content_5b190dbb8b358($_smarty_tpl) {?>

<div class="col-sm-12 col-xs-12 module-action-bar clearfix coloredBorderTop"><div class="module-action-content clearfix"><span class="col-lg-7 col-md-7 module-breadcrumb module-breadcrumb-<?php echo $_REQUEST['view'];?>
"><span><h4 title="<?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
" class="module-title pull-left text-uppercase"> <?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 </h4></span><span><p class="current-filter-name pull-left">&nbsp;&nbsp;<span class="fa fa-angle-right" aria-hidden="true"></span> <?php echo vtranslate($_smarty_tpl->tpl_vars['VIEW']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 </p></span><span><p class="current-filter-name pull-left textOverflowEllipsis" style="width:250px;">&nbsp;&nbsp;<span class="fa fa-angle-right" aria-hidden="true"></span> <?php echo vtranslate($_smarty_tpl->tpl_vars['SOURCE_MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 </p></span></span></div><?php if ($_smarty_tpl->tpl_vars['FIELDS_INFO']->value!=null){?><script type="text/javascript">var uimeta = (function () {var fieldInfo = <?php echo $_smarty_tpl->tpl_vars['FIELDS_INFO']->value;?>
;return {field: {get: function (name, property) {if (name && property === undefined) {return fieldInfo[name];}if (name && property) {return fieldInfo[name][property]}},isMandatory: function (name) {if (fieldInfo[name]) {return fieldInfo[name].mandatory;}return false;},getType: function (name) {if (fieldInfo[name]) {return fieldInfo[name].type}return false;}}};})();</script><?php }?></div><?php }} ?>