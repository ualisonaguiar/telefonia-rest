<?php

$retorno = "";
$strUsuario = '';
$strSenha = '';

function curl($dados = "", $tipo = "", $meta = "", $GET = false)
{
    $strUrl = 'http://localhost/slim/public/index.php/enviosms';
    if ($GET && $dados) {
        $strUrl .= '/' . $dados;
    }

    $curl = curl_init($strUrl); // Inicia o cURL acessando uma URL 

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Define a opção que diz que você quer receber o resultado encontrado

    /* PARA METODOS POST, PUT e DELETE */
    if (!$GET)
        curl_setopt($curl, $meta, $tipo);
    if (!$GET)
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dados); // Definimos quais informações serão enviadas pelo POST (array)

    $strAuthentication = base64_encode($_REQUEST['usuario'] . '@' . $_REQUEST['senha']);
    $arrHeaders = array(
        'Authorization: Basic ' . $strAuthentication,
        'Content-Type: application/json',
        'Accept: application/json',
    );

    curl_setopt($curl, CURLOPT_HTTPHEADER, $arrHeaders); // Defini o cabeçalho HTTP
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // Seguir qualquer redirecionamento que houver na URL - Quando definida como TRUE, Curl automaticamente segue qualquer redirecionamento feito pela página
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10); // Define a quantidade de redirecionamentos
    $curl_response = curl_exec($curl); // Executa a consulta, conectando-se ao site e salvando o resultado na variável $curl_response
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Pega o código de resposta HTTP
    curl_close($curl);
	
    if ($http_status !== 200) {
        return 'Error: ' . $http_status . ' - ' . $curl_response;
    }
	
    return $curl_response;
}

$dados = "";

if ($_POST) {
    $strUsuario = $_REQUEST['usuario'];
    $strSenha = $_REQUEST['senha'];
    $dados = $_POST['dados'];
    switch ($_POST['metodo']) {
        case 'GET':
            $retorno = curl($_POST['dados'], "", "", true);
        break;
        
		case 'POST':
            $retorno = curl($_POST['dados'], "POST", CURLOPT_POST);
        break;
        
		case 'PUT':
            $retorno = curl($_POST['dados'], "PUT", CURLOPT_CUSTOMREQUEST);
        break;
        
		case 'DELETE':
            $retorno = curl($_POST['dados'], "DELETE", CURLOPT_CUSTOMREQUEST);
        break;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<br>

<form method="POST">
    <center>
        <table>
            <tr>
                <td>Usuario:</td>
                <td><input type="text" name="usuario" autocomplete="off" required="true"
                           value="<?php echo $strUsuario; ?>"></td>
            </tr>
            <tr>
                <td>Senha:</td>
                <td><input type="password" name="senha" required="true" value="<?php echo $strSenha; ?>"></td>
            </tr>
            <tr>
                <td valign="TOP">
                    <input type="hidden" id='met' name='metodo'>
                    <input onclick="document.getElementById('met').value='GET'" style="width:80px" type="submit"
                           value="GET"><br>
                    <input onclick="document.getElementById('met').value='POST'" style="width:80px" type="submit"
                           value="POST"><br>
                    <input onclick="document.getElementById('met').value='PUT'" style="width:80px" type="submit"
                           value="PUT"><br>
                    <input onclick="document.getElementById('met').value='DELETE'" style="width:80px" type="submit"
                           value='DELETE'>
                </td>
                <td valign="TOP">
                    <textarea placeholder="Dados" name="dados"
                              style="width:500px; height:94px;"><?php echo $dados; ?></textarea><br>
                    <textarea placeholder="Retorno"
                              style="width:500px; height:200px;"><?php echo $retorno; ?></textarea>
                </td>
            </tr>
        </table>
        <hr>
        <p>Exemplos:</p>
        <strong>GET</strong>
        <p>
            Informar o ID
        </p>
        <strong>POST</strong>
        <p>
            {
            "from":"",
            "to":"",
            "text":""
            }
        </p>
        <strong>PUT</strong>
        <p>
            {
            "from":"",
            "to":"",
            "text":"",
            "id_sms":
            }
        </p>
        <strong>DELETE</strong>
        <p>
            {
            "id_sms":
            }
        </p>
    </center>
</form>
</body>
</html>