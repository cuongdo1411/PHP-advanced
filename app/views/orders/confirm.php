
<form method="post" action="<?php echo WEB_ROOT; ?>/order/add_contact">
    <h1 class="text-center">Thông tin liên hệ</h1>
    <div class="mb-3">
        <label for="" class="form-label">Anh(Chị):</label>
        <input type="text" class="form-control" name="fullname" id="" placeholder="" value="<?php echo old('fullname'); ?>">
        <?php echo form_error('fullname', '<span style="color:red;">', '</span>'); ?>
    </div>
    <div class="mb-3">
        <label for="" class="form-label">SĐT:</label>
        <input type="number" class="form-control" name="phone" id="" placeholder="" value="<?php echo old('phone'); ?>">
        <?php echo form_error('phone', '<span style="color:red;">', '</span>'); ?>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="" name="email" value='<?php echo (!empty($customers) ? $customers[0]['email'] : '') ?>'>
        <?php
        echo form_error('email', '<span style="color:red;">', '</span>');
        ?>
    </div>

    <button type="submit" class="btn btn-primary">Tiếp theo</button>
</form>