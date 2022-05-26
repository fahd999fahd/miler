<?php
$token = json_decode(file_get_contents('admin.json'),true)['info']['token'];
$id = json_decode(file_get_contents('admin.json'),true)['info']['id'];
include 'index.php';
$JS1 = json_decode(file_get_contents('data.json'),true);
$subject = $JS1['subject'];
$msg_count = $JS1['message_count'];
$message = $JS1['message'];
$from = $JS1['sender']['email'];
$to = $JS1['send']['email'];
$sname = $JS1['sender']['name'];
bot('sendMessage',[
'chat_id'=>$id,
'text'=>"
معلومات النافذه

اسم الراسل : $sname

إيميل الراسل : $from

إيميل المستلم : $to

عدد الرسائل : $msg_count

الموضوع : $subject

الرسالة : 
$message
",
]);
$done = 0;
$error = 0;
$total = 0;
$remaining = 0;
$edit = bot('sendMessage',[
'chat_id'=>$id,
'text'=>"
تم بدء الميلر
",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"From : $from",'callback_data'=>'.']],
[['text'=>"To : $to",'callback_data'=>'..']],
[['text'=>"Messages : $msg_count",'callback_data'=>'...']],
[['text'=>"Done : $done",'callback_data'=>'....'],['text'=>"Error : $error",'callback_data'=>'.........']],
[['text'=>"Total : $total",'callback_data'=>'.....']],
[['text'=>"Remaining : $remaining",'callback_data'=>'.......']],
]
])
]);
for($i=0;$i<$msg_count;$i++){
$send = send($sname,$from,$to,$subject,$message);
if($send == 'true'){
$done += 1;
$total = $done + $error;
$remaining = $msg_count - $total;
bot('editMessageReplyMarkup',[
'chat_id'=>$id,
'message_id'=>$edit->result->message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"From : $from",'callback_data'=>'.']],
[['text'=>"To : $to",'callback_data'=>'..']],
[['text'=>"Messages : $msg_count",'callback_data'=>'...']],
[['text'=>"Done : $done",'callback_data'=>'....'],['text'=>"Error : $error",'callback_data'=>'.........']],
[['text'=>"Total : $total",'callback_data'=>'.....']],
[['text'=>"Remaining : $remaining",'callback_data'=>'.......']],
]
])
]);
} else {
$error += 1;
$total = $done + $error;
$remaining = $msg_count - $total;
bot('editMessageReplyMarkup',[
'chat_id'=>$id,
'message_id'=>$edit->result->message_id,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"From : $from",'callback_data'=>'.']],
[['text'=>"To : $to",'callback_data'=>'..']],
[['text'=>"Messages : $msg_count",'callback_data'=>'...']],
[['text'=>"Done : $done",'callback_data'=>'....'],['text'=>"Error : $error",'callback_data'=>'.........']],
[['text'=>"Total : $total",'callback_data'=>'.....']],
[['text'=>"Remaining : $remaining",'callback_data'=>'.......']],
]
])
]);
}
}
bot('sendMessage',[
'chat_id'=>$id,
'text'=>"
تم الانتهاء من الإرسال
تم إرسال : $done
فشل إرسال : $error
المجموع : $total
إيميل المستلم : $to
",
'reply_to_message_id'=>$edit->result->message_id,
]);
exit();
?>