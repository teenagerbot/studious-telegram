# studious-telegram

Щоб розробити телеграм-бота, тобі треба мати телеграм-акаунт.

Бота ми розроблятимемо на мові програмування PHP.<br />
ДОКУМЕНТАЦІЇ:

PHP: https://www.php.net/ <br />
Telegram: https://core.telegram.org/bots/api

Перед розробкою ти:

Якщо працюєш на локальній машині, треба мати сервер та редактор <br />
Якщо ти працюєш в онлайн, треба мати сайт https://replit.com/


Ну що, приступимо)) <br />
Зробимо ось таку структуру нашого проекту:

index.php<br />
:card_index_dividers:lib<br />
  &emsp;:card_index_dividers:parser<br />
    &emsp;&emsp;parser.php<br />
    &emsp;&emsp;simple_html_dom.php<br />
  &emsp;:card_index_dividers:telegram<br />
    &emsp;&emsp;:card_index_dividers:GRAB<br />
      &emsp;&emsp;&emsp;telegram.php<br />

```php
<?php
include_once "lib/functions/stdFuncs.php";
include_once "lib/parser/parser.php";
include_once "lib/telegram/GRAB/telegram.php";
//ЗЧИТУЄМО ВСІ ЗАПИТИ:
$data = file_get_contents('php://input');
//ПЕРЕТВОРИМО В МАСИВ JSON:
$data = json_decode($data, true);
//https://unsplash.com/s/photos/hello
//УСТАНОВКА ВЕБХУКА:
//https://api.telegram.org/bot(mytoken)/setWebhook?url=https://mywebpagetorespondtobot

if (!empty($data['message']['text'])) {
	$text = $data['message']['text'];
  //ЯКЩО КОРИСТУВАЧ ПРИСЛАВ КОМАНДУ /start
	if ($text == "/start") {
		sendTelegram(
			 'sendMessage',
			 array(
				 'chat_id' => $data['message']['chat']['id'],
	       'text' => 'Hello World'
			 )
		 );
	} else if ($text == "/search") {
  //ЯКЩО КОРИСТУВАЧ ПРИСЛАВ КОМАНДУ /search
		$url = urlencode($data['message']['reply_to_message']['text']);
		$URL_WEBSITE = "https://unsplash.com/s/photos/$url";
		$dom = file_get_contents($URL_WEBSITE);
		$questionsDom = phpQuery::newDocument($dom);
		foreach ($questionsDom->find('img') as $question) {
			$image = pq($question)->attr('src');
			sendTelegram (
				'sendMessage',
				array (
					'chat_id' => $data['message']['chat']['id'],
					'text' => "$image",
					'parse_mode' => "html"
				)
			);
		}
	}
}
```


У файлі telegram.php зробимо функцію яка допоможе надсилати запити:<br />
```php
<?php
echo $token;
function sendTelegram($method, $response)
{
	$ch = curl_init('https://api.telegram.org/bot' . "ТОКЕН_ТВОГО_БОТА" . '/' . $method);  
	 curl_setopt($ch, CURLOPT_POST, 1);  
	 curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_HEADER, false);
	 $res = curl_exec($ch);
	 curl_close($ch);
	 return $res;
}
?>
```
