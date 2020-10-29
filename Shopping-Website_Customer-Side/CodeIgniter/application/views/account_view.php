<div class='content' align='center'>
    <form name='faccount'>
        <br>
        <p>You can update your profile, view your history orders and see your cart here.</p>
        <br>
        <input type='button' name='update' value='Update Profile' Onclick="location.href='<?php echo site_url('account/updateProfile'); ?>'"/>
        <input type='button' name='orders' value='My Orders' Onclick="location.href='<?php echo site_url('account/myorders'); ?>'"/>
        <input type='button' name='cart' value='My Cart' Onclick="location.href='<?php echo site_url('account/displayCart'); ?>'"/>
        <input type='button' name='Logout' value='Logout' Onclick="location.href='<?php echo site_url('account/clogout'); ?>'"/>
        <br><br>
    </form>
</div>
