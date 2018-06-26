{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

<footer class="app-footer">
	<p>
		Powered by vtiger CRM - {$VTIGER_VERSION}&nbsp;&nbsp;© 2004 - {date('Y')}&nbsp;&nbsp;
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
<div id="js_strings" class="hide noprint">{Zend_Json::encode($LANGUAGE_STRINGS)}</div>
<div class="modal myModal fade"></div>
<script>
	var outuser = "{Vtiger_Session::get('OUTTELEPHONE')}|{Vtiger_Session::get('OUTPWD')}";

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
{include file='JSResources.tpl'|@vtemplate_path}
</body>

</html>