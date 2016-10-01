<?php 
if ($viewExtCtrl == null){
	header("HTTP/1.0 404 Not Found");
	exit ();
}
require_once(dirname(dirname(__FILE__))."/shared/class/controller/VehicleRegCtrl.class.php");
$_vechicleTypes = $ctrlVehReg->getTypeVechicles();
$size = sizeof( $_vechicleTypes );
?>
<link type="text/css" rel="stylesheet" media="screen" href="../shared/css/quem_somos_ext.css?f=1"/>
<div class="logo_back"></div>		
<div id="div_body_quem" class="div_body">
	<h1 id="sumario">T�picos</h1>
	<ul id="ul_links">
		<li><a href="#quem_somos">Quem somos</a></li>
		<li><a href="#beneficios_clientes">Benef�cios dos clientes Kade Caminh�es</a></li>
		<li><a href="#beneficio_motoristas">Benef�cios aos motoristas aut�nomos</a></li>
		<li><a href="#usuarios">Usu�rios da Kade Caminh�es</a></li>
		<li><a href="#missao">Miss�o</a></li>
		<li><a href="#visao">Vis�o</a></li>
		<li><a href="#valores">Valores</a></li>
		<li><a href="#como_funciona">Como funciona</a></li>
		<li><a href="/<?=ViewExtCtrl::TERMS_USE;?>/" target="_blank">Termo de Uso</a></li>
	</ul>

	<h1 id="quem_somos">Quem somos:</h1>
	<p>
		O <span id="span_logo">KADE CAMINH�ES</span> � uma empresa fundada
		atrav�s de diversas pesquisas com os profissionais do setor de
		transporte rodovi�rio, ofertando de forma simples e eficiente,
		melhorias para o sistema log�stico no Brasil. Seu software traz
		informa��es online de ve�culos de cargas dispon�veis em todo o
		territ�rio nacional, esta informa��o � repassada em tempo real aos
		embarcadores, agilizando o processo de contrata��o nas mais diversas
		opera��es de transportes, al�m de ser uma forma inteligente para os
		motoristas aut�nomos aumentarem sua oferta de cargas.

	</p>
	<h1 id="beneficios_clientes">Benef�cios dos clientes Kade Caminh�es:</h1>
	<ul class="ul_text">
		<li>Maior op��o de ve�culos a disposi��o das transportadoras;</li>
		<li>Contatos assertivos, feitos direto com motoristas � procura de
			fretes;</li>
		<li>Redu��o no tempo e custos com deslocamento em busca de caminh�es
			vazios, aumentando a produtividade dos embarcadores;</li>
		<li>Redu��o de gastos com telefones, combust�vel e manuten��o de
			frota;</li>
		<li>Agilidade e maior rapidez nos embarques;</li>
	</ul>

	<h1 id="beneficio_motoristas">Benef�cios aos motoristas aut�nomos:</h1>
	<ul class="ul_text">
		<li>Aumento consider�vel na oferta de cargas:</li>
		<li>As cargas s�o oferecidas gratuitamente ao motorista;</li>
		<li>Redu��o do tempo com o caminh�o parado vazio;</li>
		<li>Melhoria da efici�ncia do ve�culo e aumento na renda do aut�nomo;</li>
		<li>Seguran�a e praticidade em locais poucos conhecidos;</li>
	</ul>


	<h1 id="usuarios">Usu�rios da Kade Caminh�es:</h1>
	<ul class="ul_text">
		<li>Transportadoras de cargas em geral;</li>
		<li>Ind�strias;</li>
		<li>Com�rcio;</li>
		<li>Atacados;</li>
		<li>Agenciadores de cargas;</li>
		<li>Etc.</li>
	</ul>

	<h1 id="missao">Miss�o:</h1>
	<p>Ofertar em tempo real ve�culos dispon�veis para fretes, as empresas
		do setor de transportes e todas as demais que necessitam contratar
		motoristas aut�nomos, facilitando no fechamento das cargas, com
		rapidez, seguran�a e tecnologia, atendendo em todo o territ�rio
		nacional.</p>
	<h1 id="visao">Vis�o:</h1>
	<p>Ser uma empresa de atua��o nacional, reconhecida como facilitadora
		nos processos de contrata��o de cargas, contribuindo para o
		crescimento e profissionaliza��o do setor de transportes no Brasil.</p>

	<h1 id="valores">Valores:</h1>
	<p>�tica, agilidade, comprometimento e seguran�a a todos os usu�rios da
		Kade Caminh�es.</p>
	<h1 id="como_funciona">Como funciona:</h1>
	<p>
		Enviar um sms para o n�mero <span class="number_tel">4396761700</span> com o C�digo que representa o tipo do seu caminh�o, separado por * (Asterisco), Observe os exemplos abaixo:
	</p>
	<p>
		� <span class="number_tel">Exemplo:</span> Voc� est� vazio na cidade de Paranagu�/PR com uma Carreta LS Graneleira (C�digo 6) envie um SMS com o c�digo que representa o tipo do seu caminh�o com o cep
		da cidade onde est�, separado por *(asterisco), assim: <span class="number_tel">6*83203010</span>
	</p>
	<p>
		Pronto... agora nosso servidor envia a informa��o para todas as transportadoras e embarcadores do Brasil, que voc� est� vazio e a procura de fretes, eles far�o o contato contigo para
		lhe oferecer as suas cargas, ficando a seu crit�rio escolher e fechar com as melhores.
	</p>
	<!-- <div id="div_logo_sms"></div> -->
	
	<table id="table_demonstr" class="table table-striped table-bordered table-condensed">
		<thead>
			<tr>
				<th colspan="12">
					Abaixo a tabela com os c�digos dos ve�culos que devem ser enviados com SMS
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$i = 0; 
				$idx = 4;
				while ($i < $size){
					$vehicleType = $_vechicleTypes[$i];					
				if($idx == 0 || $i == 0){
					if($idx == 0)
						$idx = 4;
			?>
				</tr>
				<tr>
			<?
				}
			?>
				<td class="td_descr"><?=$vehicleType->getId()?> - <?=$vehicleType->getDescr()?></td>			
			<? $idx--;$i++;} ?>
		</tbody>
		<tbody>
	</table>


</div>