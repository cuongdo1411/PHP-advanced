<?php
echo (!empty($msg) ? $msg : false);
// echo '<pre>';
// print_r($data);
// echo '</pre>';
HtmlHelper::formOpen('post', WEB_ROOT . '/home/post_user');
HtmlHelper::input('<div>', form_error('fullname', '<span style="color:red;">', '</span>') . '</div>', 'text', 'fullname', '', '', 'Họ và tên...', old('fullname'));
HtmlHelper::input('<div>', form_error('email', '<span style="color:red;">', '</span>') . '</div>', 'text', 'email', '', '', 'Email..', old('email'));
HtmlHelper::input('<div>', form_error('age', '<span style="color:red;">', '</span>') . '</div>', 'text', 'age', '', '', 'Tuổi...', old('age'));
HtmlHelper::input('<div>', form_error('password', '<span style="color:red;">', '</span>') . '</div>', 'password', 'password', '', '', 'Mật khẩu...');
HtmlHelper::input('<div>', form_error('confirm_password', '<span style="color:red;">', '</span>') . '</div>', 'password', 'confirm_password', '', '', 'Nhập lại mật khẩu...');
HtmlHelper::submit('Submit');
HtmlHelper::formClose();
?>
</form>