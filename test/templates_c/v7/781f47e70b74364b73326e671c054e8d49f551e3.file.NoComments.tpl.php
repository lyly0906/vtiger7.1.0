<?php /* Smarty version Smarty-3.1.7, created on 2018-06-11 03:26:00
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Vtiger\NoComments.tpl" */ ?>
<?php /*%%SmartyHeaderCode:76515b1debc889d788-16907807%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '781f47e70b74364b73326e671c054e8d49f551e3' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\NoComments.tpl',
      1 => 1520586669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '76515b1debc889d788-16907807',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b1debc88b8d0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b1debc88b8d0')) {function content_5b1debc88b8d0($_smarty_tpl) {?>
<div class="noCommentsMsgContainer noContent"><p class="textAlignCenter"> <?php echo vtranslate('LBL_NO_COMMENTS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</p></div><?php }} ?>