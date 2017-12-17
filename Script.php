<?php
#Тут ваш токен.
#XXXXXXXX это то что нужно вводить.
#oauth.vk.com/blank.html#access_token=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX&expires_in=0&user_id=133116406
#Токен брать тут http://u.to/token-vk-dlja-avtostatusa/EnTlBQ
#Токен брать тут http://u.to/super_access_token/uVy-Bw
$access_token = "";

#ID пользователя. Пример: vk.com/wall264585790_1091 \ вставлять нужно 264585790
$owner_id = "264585790"; 

#ID поста. Пример: vk.com/wall264585790_1091 \ вставлять нужно 1091
$post_id = "1091"; 

#Дальше не чего не трогать!
$weater = file_get_contents("https://xml.meteoservice.ru/export/gismeteo/point/183.xml");
$xml = xml_parser_create();
$indexes = array();
$values = array();
xml_parse_into_struct($xml,$weater, $values, $indexes);
xml_parser_free($xml);
function replace($str){
$rplc = array('0'=>"ясно",'1'=>"переменная облачность",'2'=>"облачно",'3'=>"пасмурно");
return strtr($str,$rplc);
}
function replace1($str){
$rplc=array('4'=>"дождь",'5'=>"ливень",'6'=>"снег",'7'=>"снег",'8'=>"гроза",'9'=>"нет данных",'10'=>"без осадков");
return strtr($str,$rplc);
}
$wiz = $values[38][attributes][MAX];
$wiz1 = $values[4][attributes][CLOUDINESS];
$wiz2 = $values[4][attributes][PRECIPITATION];
$cloudiness = replace($wiz1);
$precipitation = replace1($wiz2);
$список_лоченных = curl('https://api.vk.com/method/account.getBanned?access_token='.$access_token);
$json = json_decode($список_лоченных,1);
$колво_в_чс = $json['response']['0'];
$RequestsGet = curl('https://api.vk.com/method/users.get?fields=online&name_case=Nom&access_token='.$access_token);
$json1 = json_decode($RequestsGet,1);
$countR = $json1[response][0][online_mobile];
$countD = $json1[response][0][online];
$online2 = array(
    0 => 'В данный момент я &#128564;    ', 1 => 'компьютера &#128187;'
);
$online = array(
    1 => 'телефона &#128242;'
);
if ($countR == 1) {
$answer="$online[$countR]";
} else {
$answer="$online2[$countD]";
}
date_default_timezone_set ('Asia/Yekaterinburg');
$time = date("H:i");
function rdate($param, $time=0) {
if(intval($time)==0)$time=time();
$MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
if(strpos($param,'M')===false) return date($param, $time);
else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);

}
$a = rand(1,5);

if('1' == $a) $рандом_лол = "Шутка: ".strip_tags(file_get_contents('http://bohdash.com/random/joke/random.php'));
if('2' == $a) $рандом_лол = "Анекдот: ".strip_tags(file_get_contents('http://bohdash.com/random/anekdot/random.php'));
if('3' == $a) $рандом_лол = "Цитата: ".strip_tags(file_get_contents('http://bohdash.com/random/citata/random.php'));
if('4' == $a) $рандом_лол = "Башорг: ".strip_tags(file_get_contents('http://bohdash.com/random/bash/random.php'));
if('5' == $a) {
$res = file_get_contents('http://www.factroom.ru/random/');
preg_match('/<title>	(.*?) #factroom/', $res, $a);
$рандом_лол = $a[1];
}

$date1 = rdate("d M");
$date2 = strtotime("1 January 2017");
$enddate = strtotime("1 January 2018");
$diff = $enddate - $date2;
$now = time() - $date2;
$finish = round((100 * $now) / $diff, 3);
$получаем_лайки = curl('https://api.vk.com/method/photos.get?album_id=profile&rev=1&extended=1&count=1&access_token='.$access_token.'&v=3.0');
$json = json_decode($получаем_лайки,1);
$колво = $json['response']['0']['likes']['count'];
$getMessages = curl('https://api.vk.com/method/messages.get?lang=ru&v=3.0&count=1&access_token='.$access_token);
$getMessagesJson = json_decode($getMessages,1);
$messages = $getMessagesJson['response']['0'];
$айди_отправителя = $getMessagesJson['response']['1']['uid'];
$getInfo = curl('https://api.vk.com/method/users.get?access_token='.$access_token.'&fields=uid,first_name,last_name,nickname,screen_name,sex,bdate,city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,contacts,education,online,counters');
$json2 = json_decode($getInfo,1);
$followers = $json2['response']['0']['counters']['followers'];
$fonline = $json2['response']['0']['counters']['online_friends'];
$friends = $json2['response']['0']['counters']['friends'];
$диалоги = curl('https://api.vk.com/method/messages.getDialogs?access_token='.$access_token);
$json = json_decode($диалоги,1);
$колво_диалогов = $json['response']['0'];
$текст = рандом(array('&#9200;','&#8986;'))."Обновлено: ".date("H:i [d.m]")."
👥Друзей: ".$friends."
🏄Онлайн: ".$fonline."
📖Подписчиков: ".$followers."
⛔Заблокированных: ".$колво_в_чс."
&#9993;Сообщений: ".$messages."
&#128221;Последнее сообщение пришло от @id".$айди_отправителя."
".рандом(array('&#128229;','&#128232;','&#128233;'))."Диалогов: ".$колво_диалогов."
".рандом(array('&#128159;','&#128156;','&#128155;','&#128154;','&#128153;','&#10084;'))."Лайков на аве: ".$колво."
⛅Погода в Нефтекамске: +".$wiz." [".$cloudiness."]
📶В данный момент я с ".$answer."
⏳2017 год прошёл на ".$finish."%
".рандом(array('&#127863;','&#127877;','&#127876;'))."До Нового Года: ".ceil((mktime(0,0,0, 1, 1, 2018) - time())/3600)." часов
".рандом(array('&#9728;','&#128262;'))."До Лета: ".ceil((mktime(0,0,0, 6, 1, 2018) - time())/3600)." часов
".рандом(array('&#128166;','&#9925;','&#9729;','&#127809;','&#9748;','&#128167;'))."До Осени: ".ceil((mktime(0,0,0, 9, 1, 2018) - time())/3600)." часов
&#10052;До Зимы: ".ceil((mktime(0,0,0, 12, 1, 2017) - time())/3600)." часов
".рандом(array('&#9728;','&#127774;','&#127801;','&#127802;','&#127804;','&#127799;','&#127800;'))."До Весны: ".ceil((mktime(0,0,0, 3, 1, 2018) - time())/3600)." часов
".рандом(array('&#128518;','&#128540;','&#128527;','&#128524;','&#128516;','&#128563;','&#128514;','&#128559;','&#128541;')).$рандом_лол;
$нью_коммент = curl('https://api.vk.com/method/wall.addComment?owner_id='.$owner_id.'&post_id='.$post_id.'&text='.urlencode($текст).'&access_token='.$access_token);
function рандом($text){
$рандом = mt_rand (0, count($text)-1); 
return $text[$рандом]; 
}
function curl($url){
$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
$response = curl_exec( $ch );
curl_close( $ch );
return $response;
}//wWw.Statuses.96.LT
?><!-- Скрипт предоставил http://vk.com/ieducool -->
