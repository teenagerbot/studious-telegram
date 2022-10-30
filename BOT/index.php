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
	if ($text == "/start") {
		sendTelegram(
			 'sendMessage',
			 array(
				 'chat_id' => $data['message']['chat']['id'],
	       'text' => 'Hello World'
			 )
		 );
	} else if ($text == "/search") {
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