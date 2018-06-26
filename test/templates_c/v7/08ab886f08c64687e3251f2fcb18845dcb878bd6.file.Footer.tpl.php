<?php /* Smarty version Smarty-3.1.7, created on 2018-06-08 02:23:56
         compiled from "D:\php\vtigercrm7.1.0\includes\runtime/../../layouts/v7\modules\Vtiger\Footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:54025b17b1022aad07-78358984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08ab886f08c64687e3251f2fcb18845dcb878bd6' => 
    array (
      0 => 'D:\\php\\vtigercrm7.1.0\\includes\\runtime/../../layouts/v7\\modules\\Vtiger\\Footer.tpl',
      1 => 1528424460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54025b17b1022aad07-78358984',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b17b1022d9b0',
  'variables' => 
  array (
    'VTIGER_VERSION' => 0,
    'LANGUAGE_STRINGS' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b17b1022d9b0')) {function content_5b17b1022d9b0($_smarty_tpl) {?>

<footer class="app-footer">
	<p>
		Powered by vtiger CRM - <?php echo $_smarty_tpl->tpl_vars['VTIGER_VERSION']->value;?>
&nbsp;&nbsp;© 2004 - <?php echo date('Y');?>
&nbsp;&nbsp;
		<a href="//www.vtiger.com" target="_blank">Vtiger</a>&nbsp;|&nbsp;
		<a href="https://www.vtiger.com/privacy-policy" target="_blank">Privacy Policy</a>
	</p>
</footer>
</div>
<div id='overlayPage'>
	<!-- arrow is added to point arrow to the clicked element (Ex:- TaskManagement), 
	any one can use this by adding "show" class to it -->
	<div class='arrow'></div>
	<div class='data'>
	</div>
</div>
<div id='helpPageOverlay'></div>
<div id="js_strings" class="hide noprint"><?php echo Zend_Json::encode($_smarty_tpl->tpl_vars['LANGUAGE_STRINGS']->value);?>
</div>
<div class="modal myModal fade"></div>
<script>
	var outuser = "<?php echo Vtiger_Session::get('OUTTELEPHONE');?>
|<?php echo Vtiger_Session::get('OUTPWD');?>
";

	var switchs = 0;

	var myfun = setInterval(function() {
		if(outuser != "|"){
			var ws = new WebSocket("ws://127.0.0.1:9998?t=test");
			ws.onopen = function() {
				//console.log(ws.readyState);
				if(ws.readyState == 1){
					if(outuser){
						ws.send(outuser);
					}
				}
			};
			ws.onmessage = function(evnt) {
				var strs = evnt.data.toString();
				if(strs.indexOf(outuser) >= 0){
					console.log(evnt.data);
					stopsocket();
				}
			};
		}

	},2000);
	function stopsocket(){
		clearInterval(myfun);
	}
	function exit() {
		var r = ws.close();
		console.log("退出", r);
	}

	$(function(){
		// 点击注销按钮时，触发的操作
		$('#menubar_item_right_LBL_SIGN_OUT').on('click',function(){
			var ws = new WebSocket("ws://127.0.0.1:9998?t=test");
			ws.onopen = function() {
				//console.log(ws.readyState);
				if(ws.readyState == 1){
					if(outuser){
						ws.send("logout");
					}
				}
			};
			ws.onmessage = function(evt) {
				console.log(evt.data)
				// alert(evt.data);
				//$("#show").append(evt.data + "</br>");
			};
		});
	});
</script>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('JSResources.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</body>

</html><?php }} ?>