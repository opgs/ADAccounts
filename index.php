<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$showdebug = false;

if(isset($_GET['debug']) && htmlspecialchars($_GET['debug']) == '1'){$showdebug = true;}else{$showdebug = false;}

require('accounts.php');

if(!isset($body))
{
	ob_start();
	?>
	
	<div class="section">
		<div id="loanInfo" class="group block col span_10_of_10">
			
			<div class="title">AD Accounts</div>
			
			<div class="section">
				<div id="enableButton" class="block col span_5_of_10">
					Enable
				</div>
				<div id="disableButton" class="block col span_5_of_10">
					Disable
				</div>
			</div>
			<?php
			
			function getTree($base, $path)
			{
				global $LDAP;
			
				$srou = $LDAP->searchlist($base, "(objectClass=organizationalunit)", array('dn','ou'));
				$entou = $LDAP->get_entries($srou);
				
				$sr = $LDAP->searchlist($base, "(sAMAccountName=*)", array('sAMAccountName'));
				$ent = $LDAP->get_entries($sr);
				
				array_shift($entou);
				array_shift($ent);
				
				foreach($entou as $ou)
				{					
					getTree($ou['dn'], $path . '/' . $ou['ou'][0]);
				}
				
				foreach($ent as $account)
				{
					$icon = 'X&nbsp;';
				
					if($LDAP->isEnabled($account['samaccountname'][0], $base))
					{
						$icon = 'O&nbsp;';
					}
				
					echo '<option value="' . $account['samaccountname'][0] . '" data-section="' . $path . '">' . $icon . $account['samaccountname'][0] . '</option>';
				}
			}
			
			echo '<select id="userList" multiple="multiple">';
			
			if($AD->isAdmin())
			{
				getTree($SITE->ldapExamsBase, 'Exam Users');
			}else{
				foreach($PERMISSIONS[strtolower($LDAP->getSamAccountNameFromName($AD->getUser()))] as $entry => $ou)
				{
					getTree($ou . ',' . $SITE->ldapExamsBase, $ou);
				}
			}
			
			echo '</select>';
			
			?>
			
		</div>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#userList").treeMultiselect({startCollapsed: true});
			
			$(document).ajaxStop(function(){location.reload()});
			
			$("#enableButton").on("click", function(){
				var progress = new LoadingOverlayProgress();
				$.LoadingOverlay("show", {image: "js/loading.gif", custom: progress.Init()});
				
				$("#enableButton").off("click");
				$("#disableButton").off("click");
				
				var userlist = $("#userList").val();
				
				var barValue = 100 / userlist.length;
				
				for(var i = 0; i < userlist.length; ++i)
				{
					if(console){console.log(userlist[i]);}
					$.ajax({type: 'POST', url: "<?php echo $SITE->path ?>/?page=do", data: {acc: userlist[i], act: "1"}, async: true, complete: function(){progress.Update((i + 1) * barValue);}});
				}
			});
			$("#disableButton").on("click", function(){
				var progress = new LoadingOverlayProgress();
				$.LoadingOverlay("show", {image: "js/loading.gif", custom: progress.Init()});
			
				$("#enableButton").off("click");
				$("#disableButton").off("click");
			
				var userlist = $("#userList").val();
				
				var barValue = 100 / userlist.length;
				
				for(var i = 0; i < userlist.length; ++i)
				{
					if(console){console.log(userlist[i]);}
					$.ajax({type: 'POST', url: "<?php echo $SITE->path ?>/?page=do", data: {acc: userlist[i], act: "0"}, async: true, complete: function(){progress.Update((i + 1) * barValue);}});
				}
			});
		});
		</script>
	</div>
	
	<?php
	$body = ob_get_clean();
}

if(!isset($noheader)){echo $header;}
if(!isset($nobody)){echo $body;}
if($showdebug){echo $debug;}
if(!isset($nofooter)){echo $footer;}

?>
