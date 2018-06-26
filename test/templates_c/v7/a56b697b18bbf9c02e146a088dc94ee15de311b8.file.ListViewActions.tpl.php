<?php /* Smarty version Smarty-3.1.7, created on 2018-06-07 10:49:32
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Books\ListViewActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:256655b190dbc56b803-72315482%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a56b697b18bbf9c02e146a088dc94ee15de311b8' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Books\\ListViewActions.tpl',
      1 => 1502259392,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '256655b190dbc56b803-72315482',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'LISTVIEW_ENTRIES_COUNT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b190dbc5d110',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b190dbc5d110')) {function content_5b190dbc5d110($_smarty_tpl) {?>

<div id="listview-actions" class="listview-actions-container"><div class = "row"><div class='col-md-5'><div class="hide messageContainer" style = "height:30px;"><center><a id="selectAllMsgDiv" href="#"><?php echo vtranslate('LBL_SELECT_ALL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;<?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;(<span id="totalRecordsCount" value=""></span>)</a></center></div><div class="hide messageContainer" style = "height:30px;"><center><a href="#" id="deSelectAllMsgDiv"><?php echo vtranslate('LBL_DESELECT_ALL_RECORDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></center></div></div><div class="col-md-3"><?php $_smarty_tpl->tpl_vars['RECORD_COUNT'] = new Smarty_variable($_smarty_tpl->tpl_vars['LISTVIEW_ENTRIES_COUNT']->value, null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("Pagination.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('SHOWPAGEJUMP'=>true), 0);?>
</div></div><?php }} ?>