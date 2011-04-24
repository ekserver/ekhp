<?php echo validation_errors();?>
<?php echo form_open('forgetpw/step1');?>
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="100%" valign="top">
            <fieldset>
                <legend>User Information (required)</legend>
                <table cellpadding="2" cellspacing="5" border="0">
                    <tr>
                        <td><strong>Username</strong></td>
                        <td><?php echo form_input('username', set_value('username'), 'type="text" size="23" onfocus="if(this.value==\'Your Username\')this.value=\'\'"');?></td>
                        <td><?php echo form_error('username'); ?></td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>
<br />
<?php echo form_submit('submit', 'Next'); echo form_reset('reset', 'Reset');?>
<?php echo form_close();?>
