<?	
if ($user == null){
	header("HTTP/1.0 404 Not Found");
	exit ();
}	
?>
<style type="text/css">
	body{font-size: 14px;font-family:Helvetica;color:#000;}
	a{font-weight:bold;color:blue}
	#div_login{font-weight:bold;}
	#p_obs{font-style:italic;}
</style>

<h2>Bem-vindo ao KADE Caminh�es!!!</h2>

<p>
	Para informar uma nova senha, clique neste link: 
	<a href="<?=$url?>"><?=$url?></a>
</p>

<div id="div_login">Login: <?=$user->getLogin();?></div>
<br/>
<p id="p_obs">
***OBSERVA��O*** Para solicitar uma nova senha, <a href="<?=$_SERVER ["HTTP_HOST"]?>/request_new_password/">clique aqui</a> para redefinir sua senha. 
</p>

<p>
Se voc� recebeu esta mensagem por engano, � prov�vel que outro usu�rio tenha 
inserido seu endere�o de e-mail ao tentar criar uma conta para outro 
endere�o de e-mail. Se voc� n�o clicar no link de verifica��o, a conta n�o 
ser� ativada. 
</p>

<p>
Se clicar no link acima n�o funcionar, copie e cole o URL em uma nova janela do navegador. 
</p>

<p>
Atenciosamente,<br/>
Equipe Kade Caminh�es.
</p>

