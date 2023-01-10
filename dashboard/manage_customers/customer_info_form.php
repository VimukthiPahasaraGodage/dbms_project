<form action="add_update_customer.php" method="POST">
    <div class="input-field">
        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
        <label for="email">Email</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('email') : null; ?></div>
    </div>
    <div class="input-field">
        <input type="password" id="password" name="password" value="<?php echo $password; ?>">
        <label for="password">Password</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('password') : null; ?></div>
    </div>
    <div class="input-field">
        <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $confirm_password; ?>">
        <label for="confirm_password">Confirm Password</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('confirm_password') : null; ?></div>
    </div>
    <div class="input-field">
        <input type="text" id="name" name="name" value="<?php echo $name; ?>">
        <label for="name">Name</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('name') : null; ?></div>
    </div>
    <div class="input-field">
        <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone_number; ?>">
        <label for="phone_number">Phone Number(Eg: 0123456789)</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('phone_number') : null; ?></div>
    </div>
    <div class="input-field">
        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
        <label for="address">Address(Eg: 123/A, ABCD, EFGH)</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('address') : null; ?></div>
    </div>
    <div class="input-field">
        <input type="text" step="any" id="discount" name="discount" value="<?php echo $discount; ?>">
        <label for="discount">Discount(Eg: 12.35)</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('discount') : null; ?></div>
    </div>
    <div class="input-field">
        <select id="type" name="type">
            <option value="" disabled <?php echo $type === ''? 'selected' : ''; ?>>Choose customer type</option>
            <option value="WHOLESALER" <?php echo $type === 'WHOLESALER'? 'selected' : ''; ?>>WHOLESALER</option>
            <option value="RETAILER" <?php echo $type === 'RETAILER'? 'selected' : ''; ?>>RETAILER</option>
            <option value="END_CUSTOMER" <?php echo $type === 'END_CUSTOMER'? 'selected' : ''; ?>>END_CUSTOMER</option>
        </select>
        <label for="type">Select Customer Type</label>
        <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('type') : null; ?></div>
    </div>
    <input type="hidden" name="mode" value="<?php echo $mode; ?>">
    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
    <div class="center">
        <input type="submit" name="submit" value="SUBMIT" class="btn brand">
    </div>
</form>
