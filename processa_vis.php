<?php
// processa_vis.php

// Inclua o arquivo de configuração
require_once('config.php');

// Captura o IP do usuário usando a API ipify.org
$content = file_get_contents('https://api.ipify.org?format=json');
$data = json_decode($content);
$ip = isset($data->ip) ? $data->ip : 'Unknown';

// Use a API HGBrasil para obter informações detalhadas sobre o IP
$api_key = 'bbae6dab'; // Sua chave de API HGBrasil
$details_content = file_get_contents('https://api.hgbrasil.com/geoip?key=' . $api_key . '&address=' . $ip);
$details_data = json_decode($details_content);

// Verificar se a consulta foi bem-sucedida e se os dados estão disponíveis
if ($details_data && isset($details_data->results) && $details_data->valid_key == true) {
    // Extrair informações de localização do objeto JSON retornado
    $country = isset($details_data->results->country_name) ? $details_data->results->country_name : 'Unknown';
    $regionName = isset($details_data->results->region) ? $details_data->results->region : 'Unknown';
    $city = isset($details_data->results->city) ? $details_data->results->city : 'Unknown';
} else {
    // Se a consulta falhar ou a chave de API for inválida, defina os valores como desconhecidos
    $country = 'Unknown';
    $regionName = 'Unknown';
    $city = 'Unknown';
}

$navegador = filter_input(INPUT_SERVER, "HTTP_USER_AGENT", FILTER_DEFAULT);
$browsers = array(
    'amaya' => 'Amaya',
    'Camino' => 'Camino',
    'Chimera' => 'Chimera',
    'Chrome' => 'Chrome',
    'Edge' => 'Edge',
    'Firebird' => 'Firebird',
    'Firefox' => 'Firefox',
    'Flock' => 'Flock',
    'hotjava' => 'HotJava',
    'IBrowse' => 'IBrowse',
    'icab' => 'iCab',
    'Internet Explorer' => 'Internet Explorer',
    'Konqueror' => 'Konqueror',
    'Links' => 'Links',
    'Lynx' => 'Lynx',
    'Maxthon' => 'Maxthon',
    'Mozilla' => 'Mozilla',
    'MSIE' => 'Internet Explorer',
    'Netscape' => 'Netscape',
    'OmniWeb' => 'OmniWeb',
    'Opera' => 'Opera',
    'Opera.*?Version' => 'Opera',
    'Phoenix' => 'Phoenix',
    'Safari' => 'Safari',
    'Shiira' => 'Shiira',
    'Trident.* rv' => 'Internet Explorer',
    'Ubuntu' => 'Ubuntu Web Browser',
    'OPR' => 'Opera',
);
if (strpos($navegador, 'Edge')):
    $browserDetect = 'Edge';
elseif (strpos($navegador, 'OPR')):
    $browserDetect = 'Opera';
else:
    $browserDetect = null;
    foreach ($browsers as $key => $value):
        if (preg_match('|' . $key . '.*?([0-9\.]+)|i', $navegador)):
            $browserDetect = $value;
        endif;
    endforeach;
endif;
if (!empty($browserDetect)):
    $browserDetect;
else:
    echo 'Desconhecido';
endif;

function getOS() {
    global $user_agent;
    $os_platform = "Desconhecida";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile',
    );

    foreach ($os_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }

    }
    return $os_platform;
}

function getBrowser() {
    global $user_agent;
    $browser = "Desconhecido";
    $browser_array = array(
        '/msie/i' => 'Internet_Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Navegador_Mobile',
    );

    foreach ($browser_array as $regex => $value) {

        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }
    return $browser;
}

$user_agent = $_SERVER['HTTP_USER_AGENT'];
$user_os = getOS();
$user_browser = getBrowser();


$dns = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$nav = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$data = date('Y-m-d H:i:s');
$pieces = explode(".", $dns);

if($country === 'Brazil' ):
    $situacao = "liberado";

    elseif($country !== "Brazil"):
    $situacao = "liberado";
endif;

$dnsblock = "Kraken";

$sql = $pdo->prepare("INSERT INTO relatorio set ip = :ip, data = :data, sistema = :sistema, dnsblock = :dnsblock, navegador = :navegador, acesso = :acesso, dns = :dns, nav = :nav, country = :country, regionName = :regionName, city = :city ");
$sql->bindValue(":data", $data);
$sql->bindValue(":ip", $ip);
$sql->bindValue(":sistema", $user_os);
$sql->bindValue(":dnsblock", $dnsblock);
$sql->bindValue(":navegador", $user_browser);
$sql->bindValue(":acesso", $situacao);
$sql->bindValue(":dns", $dns);
$sql->bindValue(":nav", $nav);

$sql->bindValue(":country", $country);

$sql->bindValue(":regionName", $regionName);

$sql->bindValue(":city", $city);
$sql->execute();

?>
