<?php echo validation_errors();?>
<?php echo form_open('forgotpw/forget');?>
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" valign="top">
            <fieldset>
                <legend>User Information (required)</legend>
                <table cellpadding="2" cellspacing="5" border="0">
                    <tr>
                        <td><strong>Username</strong></td>
                        <td><?php echo form_input('username', 'Your Username', 'type="text" size="23" onfocus="if(this.value==\'Your Username\')this.value=\'\'"');?></td>
                        <td><?php echo form_error('username'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Security Answer</strong></td>
                        <td><?php echo form_input('security', 'Your Answer','type="text" size="50" onfocus="if(this.value==\'Your Answer\')this.value=\'\'"');?></td>
                        <td><?php echo form_error('security'); ?></td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>
<br />
<?php echo form_submit('submit', 'Recover');?>
<?php echo form_close();?>
