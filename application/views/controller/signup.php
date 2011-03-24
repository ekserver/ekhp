<?php echo form_open('signup');?>
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" valign="top">
            <fieldset>
                <legend>User Information (required)</legend>
                <table cellpadding="2" cellspacing="5" border="0">
                    <tr>
                        <td><strong>E-Mail Address</strong></td>
                        <td><?php echo form_input('email', 'christian@web.de', 'type="text" size="23" onfocus="if(this.value==\'christian@web.de\')this.value=\'\'"');?></td>
                        <td><?php echo form_error('email'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Username</strong></td>
                        <td><?php echo form_input('username', 'z.B Steffen','type="text" size="23" onfocus="if(this.value==\'z.B Steffen\')this.value=\'\'"');?></td>
                        <td><?php echo form_error('username'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Password</strong></td>
                        <td><?php echo form_password('password');?></td>
                        <td><?php echo form_error('password'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Password (confirm)</strong></td>
                        <td><?php echo form_password('password2');?></td>
                        <td><?php echo form_error('password2'); ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><?php echo form_hidden('ip');?></td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>
<br />
<?php echo form_submit('submit', 'Erstellen');?>
<?php echo form_close();?>
