<?php

$lang['email_must_be_array'] = "The email validation method must be passed an array.";
$lang['email_invalid_address'] = "Invalid email address: %s";
$lang['email_attachment_missing'] = "Unable to locate the following email attachment: %s";
$lang['email_attachment_unreadable'] = "Unable to open this attachment: %s";
$lang['email_no_recipients'] = "You must include recipients: To, Cc, or Bcc";
$lang['email_send_failure_phpmail'] = "Unable to send email using PHP mail().  Your server might not be configured to send mail using this method.";
$lang['email_send_failure_sendmail'] = "Unable to send email using PHP Sendmail.  Your server might not be configured to send mail using this method.";
$lang['email_send_failure_smtp'] = "Unable to send email using PHP SMTP.  Your server might not be configured to send mail using this method.";
$lang['email_sent'] = "Your message has been successfully sent using the following protocol: %s";
$lang['email_no_socket'] = "Unable to open a socket to Sendmail. Please check settings.";
$lang['email_no_hostname'] = "You did not specify a SMTP hostname.";
$lang['email_smtp_error'] = "The following SMTP error was encountered: %s";
$lang['email_no_smtp_unpw'] = "Error: You must assign a SMTP username and password.";
$lang['email_failed_smtp_login'] = "Failed to send AUTH LOGIN command. Error: %s";
$lang['email_smtp_auth_un'] = "Failed to authenticate username. Error: %s";
$lang['email_smtp_auth_pw'] = "Failed to authenticate password. Error: %s";
$lang['email_smtp_data_failure'] = "Unable to send data: %s";
$lang['email_exit_status'] = "Exit status code: %s";
$lang['email_tpl_from_name'] = "猫头鹰";
$lang['chkemail_tpl_title'] = "注册邮箱验证 - 猫头鹰";
$lang['chkemail_tpl_content'] = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>注册邮箱验证 - 猫头鹰</title>
</head>
<body>
%s您好:<br />
感谢你您用 猫头鹰（matoin.com），请点击以下链接完成邮箱验证：<br />
{unwrap}<a href="%s">%s</a>{/unwrap}<br />
（如果以上链接无法点击，您可以复制该地址到您的浏览器地址栏中访问）<br />
猫头鹰团队<br />
猫头鹰，优美图片休憩之地<br />
</body>
</html>';
$lang['lostpwd_tpl_title'] = "重置密码链接 - 猫头鹰";
$lang['lostpwd_tpl_content'] = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>重置密码链接 - 猫头鹰</title>
</head>
<body>
%s您好:<br />
您在猫头鹰（matoin.com）申请了重置密码，您可以点击以下链接修改您的密码：
{unwrap}<a href="%s">%s</a>{/unwrap}<br />
（如果您不需要修改密码，或者从未申请密码重置，请忽略本邮件。）<br />
猫头鹰团队<br />
猫头鹰，优美图片休憩之地<br />
</body>
</html>';

/* End of file email_lang.php */
/* Location: ./system/language/english/email_lang.php */