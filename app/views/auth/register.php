<form method="post" action="<?php echo WEB_ROOT; ?>/authentication/register_action">
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
    <div class="mb-3">
        <label for="pwd" class="form-label">Xác nhận mật khẩu:</label>
        <input type="password" type="confirm_password" class="form-control" id="confirm_password" placeholder="Enter password" name="confirm_password">
        <?php
        echo form_error('confirm_password', '<span style="color:red;">', '</span>');
        ?>
    </div>
    <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value='<?php echo old('email'); ?>'>
        <?php
        echo form_error('email', '<span style="color:red;">', '</span>');
        ?>
    </div>
    <!-- <div class="form-check mb-3">
        <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="remember"> Remember me
        </label>
    </div> -->
    <!-- <h4 style="color:red;"><?php echo !empty($msg) ? $msg : false; ?></h4> -->
    <button type="submit" class="btn btn-primary">Submit</button>
</form>