<?php /* Smarty version Smarty-3.1.7, created on 2018-06-07 10:49:32
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Books\ListViewRecordActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:261035b190dbc632b88-13321674%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0bb10c4efdaffdc1acdd39f02a6c75e9809c60d0' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Books\\ListViewRecordActions.tpl',
      1 => 1502259362,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '261035b190dbc632b88-13321674',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SEARCH_MODE_RESULTS' => 0,
    'LISTVIEW_ENTRY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b190dbc655e0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b190dbc655e0')) {function content_5b190dbc655e0($_smarty_tpl) {?>
<!--LIST VIEW RECORD ACTIONS--><div class="table-actions"><?php if (!$_smarty_tpl->tpl_vars['SEARCH_MODE_RESULTS']->value){?><span class="input" ><input type="checkbox" value="<?php echo $_smarty_tpl->tpl_vars['LISTVIEW_ENTRY']->value->getId();?>
" class="listViewEntriesCheckBox"/></span><?php }?></div><?php }} ?>