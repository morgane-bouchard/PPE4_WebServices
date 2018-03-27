<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Page d'accueil des web services</h1>

	<div id="body">
		<p>Formulaire de modification de la situation professionnelle 19 de pierre.jean</p>
                <p>On peut changer cette valeur par l'inspecteur du navigateur en changeant la valeur du champ caché de nom ref</p>
                <p>On peut ici modifier libellé court et code localisation.</p>
                <form method="post" action="<?php echo site_url("WSSitPros/update/format/json/login/pierre.jean%40gmail.com/mdp/motdepasse"); ?>">
                    <label for="libcourt">Libellé court : </label>
                    <input type="text" id="libcourt" name="libcourt" size="60" /><br />
                    <label for="codeLocalisation">Localisation : </label>
                    <select id="codeLocalisation" name="codeLocalisation" />
                        <option value="1">Organisation</option>
                        <option value="2">Centre de formation</option>
                    </select>
                    <br />
                    <input type="hidden" id="ref" name="ref" value="19"/>
                    <input type="submit" id="valider" value="Valider" />
                </form>
		<p>Formulaire de modification de la situation professionnelle 19 de pierre.jean</p>
                <p>On peut changer cette valeur par l'inspecteur du navigateur en changeant la valeur du champ caché de nom ref</p>
                <p>On peut ici modifier descriptif et code source.</p>
                <form method="post" action="<?php echo site_url("WSSitPros/update/format/json/login/pierre.jean%40gmail.com/mdp/motdepasse"); ?>">
                    <label for="descriptif">Descriptif : </label>
                    <input type="text" id="descriptif" name="descriptif" size="60" /><br />
                    <label for="codeSource">Source : </label>
                    <select id="codeSource" name="codeSource" />
                        <option value="1">Stage 1</option>
                        <option value="2">Stage 2</option>
                        <option value="3">TP</option>
                        <option value="4">PPE</option>
                    </select>
                    <br />
                    <input type="hidden" id="ref" name="ref" value="19"/>
                    <input type="submit" id="valider" value="Valider" />
                </form>
		<p>Formulaire de modification de la situation professionnelle 174 de pierre.jean</p>
                <p>On peut changer cette valeur par l'inspecteur du navigateur en changeant la valeur du champ caché de nom ref</p>
                <p>On peut ici modifier dates de début et de fin.</p>
                <form method="post" action="<?php echo site_url("WSSitPros/update/format/json/login/pierre.jean%40gmail.com/mdp/motdepasse"); ?>">
                    <label for="datedebut">Date de début : </label>
                    <input type="text" id="datedebut" name="datedebut" size="60" placeholder="AAAA-MM-JJ" pattern="^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$" /><br />
                    <label for="datefin">Date de fin : </label>
                    <input type="text" id="datefin" name="datefin" size="60" placeholder="AAAA-MM-JJ" /><br />
                    <input type="hidden" id="ref" name="ref" value="19"/>
                    <input type="submit" id="valider" value="Valider" />
                </form>
	
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
</div>

</body>
</html>