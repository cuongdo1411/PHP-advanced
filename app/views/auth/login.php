<?php
if ($register_success) {
    echo '<script>alert("Đăng ký thành công")</script>';
}
?>
<form method="post" action="{{WEB_ROOT}}/authentication/login_action">
    <div class="mb-3 mt-3">
        <label for="username" class="form-label">Tên tài khoản:</label>
        <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" value='<?php echo old('username'); ?>'>
        <?php
        echo form_error('username', '<span style="color:red;">', '</span>');
        ?>
    </div>
    <div class="mb-3">
        <label for="pwd" class="form-label">Mật khẩu:</label>
        <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
        <?php
        echo form_error('password', '<span style="color:red;">', '</span>');
        ?>
    </div>
    <?php
    if (!empty($msg)) {
        echo "
            <div class='alert alert-danger' role='alert'>
                <strong>$msg</strong>
            </div> 
            ";
    }
    ?>

    <button type="submit" class="btn btn-primary">Submit</button><br/>
    <strong>Nếu bạn chưa có tài khoản hãy</strong>
    <a type="submit" class="btn btn-success" href="<?php echo WEB_ROOT;?>/authentication/register">Register</a>
</form>