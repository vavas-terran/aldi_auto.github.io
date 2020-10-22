 <?php
 
$to = 'mail@aldi-auto.ru';

if ( isset( $_POST['sendMail'] ) ) {
  $model = substr( $_POST['марка_модель'], 0, 20 );
  $year = substr( $_POST['год_выпуска'], 0, 10 );
  $numb = substr( $_POST['номер_телефона'], 0, 15 );
  $info = substr( $_POST['дополнительная_информация'], 0, 250 );

if($_FILES)
{
  $filepath = array();
  $filename = array();
  $file2 = array();
  $i = 0;
    foreach ($_FILES["file"]["error"] as $key => $error) {
      if ($error == UPLOAD_ERR_OK) {
        $filename[$i][0] = $_FILES["file"]["tmp_name"][$key];
        $filename[$i][1] = $_FILES["file"]["name"][$key];
        $i++;
      }
    }
  }

  $body .= "Марка и модель:\r\n".$model."\r\n\r\n";
  $body .= "Год выпуска транспортного средства:\r\n".$year."\r\n\r\n";
  $body .= "Номер телефона заказчика:\r\n".$numb."\r\n\r\n";
  $body .= "Дополнительная информация по транспортному средству:\r\n\r\n".$info; 
  send_mail($to, $body, $filename);
}

 // Вспомогательная функция для отправки почтового сообщения с вложением
function send_mail($to, $body, $filename)
{
  $subject = 'Форма обратной связи с полными данными с сайта aldi-auto.ru';
  $boundary = "--".md5(uniqid(time())); // генерируем разделитель

  $headers .= "MIME-Version: 1.0\r\n";
  $headers .="Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
  $multipart = "--".$boundary."\r\n";
  $multipart .= "Content-type: text/plain; charset=\"utf-8\"\r\n";
  $multipart .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

  $body = $body."\r\n\r\n";
 
  $multipart .= $body;
  foreach ($filename as $key => $value) {
    $fp = fopen($value[0], "r"); 
    $content = fread($fp, filesize($value[0]));
    fclose($fp);
    $file .= "--".$boundary."\r\n";
    $file .= "Content-Type: application/octet-stream\r\n";
    $file .= "Content-Transfer-Encoding: base64\r\n";
    $file .= "Content-Disposition: attachment; filename=\"".$value[1]."\"\r\n\r\n";
    $file .= chunk_split(base64_encode($content))."\r\n";
  }
  $multipart .= $file."--".$boundary."--\r\n";
  mail($to, $subject, $multipart, $headers);  
}

header('Refresh: 2; URL=index.html');

?>