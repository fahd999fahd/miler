<?php
function SJ($file,$content){
	return file_put_contents($file,json_encode($content,JSON_PRETTY_PRINT));
}
if(!file_exists('admin.json')){
$token = readline('- token: ');
$id = readline('- id: ');
$save['info'] = [
'token'=>$token,
'id'=>$id
];
file_put_contents('admin.json',json_encode($save),64|128|256);
}
function save($array){
file_put_contents('admin.json',json_encode($array),64|128|256);
}
$token = json_decode(file_get_contents('admin.json'),true)['info']['token'];
$id = json_decode(file_get_contents('admin.json'),true)['info']['id'];
include 'index.php';
if($id == ""){
echo "Error Id";
}
try {
 $callback = function ($update, $bot) {
  global $id;
  if($update != null){
$message = $update->message;
$text = $message->text; 
$data = $update->callback_query->data; 
$user = $update->message->from->username; 
$user2 = $update->callback_query->from->username; 
$name = $update->message->from->first_name; 
$name2 = $update->callback_query->from->first_name; 
$message_id = $message->message_id;
$message_id2 = $update->callback_query->message->message_id; 
$chat_id = $message->chat->id; 
$chat_id2 = $update->callback_query->message->chat->id; 
$from_id = $message->from->id;
$from_id2 = $update->callback_query->message->from->id; 
$type = $update->message->chat->type;
$id = json_decode(file_get_contents('admin.json'),true)['info']['id'];
$JS1 = json_decode(file_get_contents('data.json'),true);
if($text == '/start' && $from_id == $id){
	bot('sendMessage',[
		'chat_id'=>$chat_id,
		'text'=>"
اهلا بك في الميلر الخاص بك

اختر من الأسفل
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
		[['text'=>"قسم الراسل",'callback_data'=>'sender']],
		[['text'=>"الإيميل الموضوع : {$JS1['send']['email']}",'callback_data'=>'email_send']],
		[['text'=>"بدء الميلر",'callback_data'=>'run'],['text'=>"إيقاف الميلر",'callback_data'=>'stop']],
		[['text'=>"حالة الاداه",'callback_data'=>'status']],
		]
	])
		]);
}
if($data == 'back'){
	bot('editMessageText',[
		'chat_id'=>$chat_id2,
		'message_id'=>$message_id2,
		'text'=>"
تم الرجوع
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
		[['text'=>"قسم الراسل",'callback_data'=>'sender']],
		[['text'=>"الإيميل الموضوع : {$JS1['send']['email']}",'callback_data'=>'email_send']],
		[['text'=>"بدء الميلر",'callback_data'=>'run'],['text'=>"إيقاف الميلر",'callback_data'=>'stop']],
		[['text'=>"حالة الاداه",'callback_data'=>'status']],
		]
	])
		]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'sender'){
	bot('editMessageText',[
		'chat_id'=>$chat_id2,
		'message_id'=>$message_id2,
		'text'=>"
اختر الذي تريده
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"اسم الراسل : {$JS1['sender']['name']}",'callback_data'=>'sender_name'],['text'=>"إيميل الراسل : {$JS1['sender']['email']}",'callback_data'=>'sender_email']],
[['text'=>"تعيين عدد الرسائل : {$JS1['message_count']}",'callback_data'=>'countmsg']],
[['text'=>" : تعيين موضوع الرسالة",'callback_data'=>'subj'],['text'=>'- '.$JS1['subject'],'callback_data'=>'subj']],
[['text'=>' : تعيين الرساله','callback_data'=>'messages'],['text'=>'- '.$JS1['message'],'callback_data'=>'messages']],
[['text'=>"رجوع",'callback_data'=>'back']],
	]
	]
	)
		]);
}
if($data == 'sender_name'){
	bot('editMessageText',[
		'chat_id'=>$chat_id2,
		'message_id'=>$message_id2,
		'text'=>"
ارسل اسم الراسل
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = 'sender_name';
SJ('data.json',$JS1);
}
if($text && $JS1['commands']['type'] == 'sender_name'){
	$JS1['sender']['name'] = $text;
	SJ('data.json',$JS1);
	bot('sendMessage',[
		'chat_id'=>$chat_id,
		'text'=>"
تم تعيين اسم الراسل: $text
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
		[['text'=>"رجوع",'callback_data'=>'back']]
]
	])
]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'sender_email'){
	 bot('editMessageText',[
	 	'chat_id'=>$chat_id2,
		'message_id'=>$message_id2,
		'text'=>"
ارسل إيميل الراسل
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = 'sender_email';
SJ('data.json',$JS1);
}
if($text && $JS1['commands']['type'] == 'sender_email'){
	$JS1['sender']['email'] = $text;
	SJ('data.json',$JS1);
	bot('sendMessage',[
		'chat_id'=>$chat_id,
		'text'=>"
تم تعيين إيميل الراسل: $text
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
		[['text'=>"رجوع",'callback_data'=>'back']]
]
	])
]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'email_send'){
	bot('editMessageText',[
		'chat_id'=>$chat_id2,
		'message_id'=>$message_id2,
		'text'=>"
ارسل الإيميل المستلم
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = 'email_send';
SJ('data.json',$JS1);
}
if($text && $JS1['commands']['type'] == 'email_send'){
	$JS1['send']['email'] = $text;
	SJ('data.json',$JS1);
	bot('sendMessage',[
		'chat_id'=>$chat_id,
		'text'=>"
تم تعيين إيميل المستلم: $text
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
		[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'stop'){
	foreach ($JS1['screens'] as $screen){
		$keys['inline_keyboard'][] = [['text'=>$screen,'callback_data'=>'del_screen#'.$screen]];
}
$keys['inline_keyboard'][] = [['text'=>'رجوع','callback_data'=>'back']];
$keys = json_encode($keys);
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"
النوافذ الشغاله ..
اضغط علي النافذه لحذفها
",
'reply_markup'=>$keys,
]);
	}
if($data == 'status'){
	if($JS1['screens'][0] == null){
$counts = 0;
} else {
$counts = count($JS1['screens'])-1;
}
$counts = $counts + 1;
	if($JS1['screens'][0] == null){
		$stat = 'واقفه';
	} else {
		$stat = 'شغاله';
	}
	bot('editMessageText',[
		'chat_id'=>$chat_id2,
		'message_id'=>$message_id2,
		'text'=>"
عدد النوافذ: $counts
حالة الاداه: $stat
",
'reply_markup'=>json_encode([
	'inline_keyboard'=>[
		[['text'=>"رجوع",'callback_data'=>'back']],
]
])
]);
}
$exd = explode('#',$data);
if($exd[0] == 'del_screen'){
$as = array_search($exd[1],$JS1['screens']);
unset($JS1['screens'][$as]);
array_values($JS1['screens']);
SJ('data.json',$JS1);
foreach($JS1['screens'] as $screen){
$key['inline_keyboard'][] = [['text'=>$screen,'callback_data'=>'del_screen#'.$screen]];
}
$key['inline_keyboard'][] = [['text'=>"رجوع",'callback_data'=>'back']];
bot('answarCallbackQuery',[
	'callback_query_id'=>$update->callback_query->id,
	'text'=>"
تم حذف النافذه: {$exd[1]}
",
	]);
bot('editMessageReplyMarkup',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'reply_markup'=>json_encode($key),
]);
system('screen -S n'.$exd[1].' -X kill');
}
if($data == 'countmsg'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"
عدد الرسائل الحاليه : {$JS1['message_count']}

ارسل عدد الرسائل",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = 'message_count';
SJ('data.json',$JS1);
}
if(is_numeric($text) && $JS1['commands']['type'] == 'message_count'){
$JS1['message_count'] = $text;
SJ('data.json',$JS1);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
تم تعيين عدد الرسائل : $text
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'subj'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"
الموضوع الحالي : {$JS1['subject']}

ارسل عدد الرسائل",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = 'subject';
SJ('data.json',$JS1);
}
if($text && $JS1['commands']['type'] == 'subject'){
$JS1['subject'] = $text;
SJ('data.json',$JS1);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
تم تعيين الموضوع : 

$text
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'messages'){
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"
الرسائل الحاليه : {$JS1['message']}

ارسل الرسائل",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = 'messages';
SJ('data.json',$JS1);
}
if($text && $JS1['commands']['type'] == 'messages'){
$JS1['message'] = $text;
SJ('data.json',$JS1);
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"
تم تعيين الرساله : 

$text
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"رجوع",'callback_data'=>'back']]
]
])
]);
$JS1['commands']['type'] = null;
SJ('data.json',$JS1);
}
if($data == 'run'){
$screen = substr(str_shuffle('51H2qnTBb28ADdCbCWwRxXSZIy06SgpACACc0tRwWK0XwUw0pwQXSLrtcJf3tz8asNhRPVZaZ9e8rKMMeNIEysNbf00cxKc1sG910283791'),1,4);
$JS1['screens'][] = $screen;
SJ('data.json',$JS1);
system('screen -dmS n'.$screen.' php send.php');
bot('editMessageText',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"
تم فتح نافذه جديده: $screen
",
]);
}
}
    };
         $bot = new EzTG(array('throw_telegram_errors'=>true,'token' => $token, 'callback' => $callback));
  }
    catch(Exception $e){
 echo $e->getMessage().PHP_EOL;
 sleep(1);
}