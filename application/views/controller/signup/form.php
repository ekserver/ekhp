<?php echo validation_errors();?>
<?php echo form_open('signup/create');?>
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="50%" valign="top">
            <fieldset>
                <legend><?=lang('signup_form_legend_user_info');?></legend>
                <table cellpadding="2" cellspacing="5" border="0">
                    <tr>
                        <td><strong><?=lang('signup_form_email');?></strong></td>
                        <td><?php echo form_input('email', set_value('email'), 'type="text" size="23"');?></td>
                        <td><?php echo form_error('email'); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?=lang('signup_form_username');?></strong></td>
                        <td><?php echo form_input('username', set_value('username'), 'type="text" size="23"');?></td>
                        <td><?php echo form_error('username');?></td>
                    </tr>
                    <tr>
                        <td><strong><?=lang('signup_form_pass');?></strong></td>
                        <td><?php echo form_password('password');?></td>
                        <td><?php echo form_error('password'); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?=lang('signup_form_pass_repeat');?></strong></td>
                        <td><?php echo form_password('password2');?></td>
                        <td><?php echo form_error('password2'); ?></td>
                    </tr>
                    <tr>
                        <?php
                            $expansion_options = array(
                                EXPANSION_CLASSIC => 'Classic',
                                EXPANSION_TBC => 'Burning Crusade',
                                EXPANSION_WOTLK => 'Wrath of the Lich King',
                                );
                        ?>
                        <td><strong><?=lang('signup_form_expansion');?></strong></td>
                        <td><?php echo form_dropdown('expansion', $expansion_options, '2');?></td>
                    </tr>
                </table>
            </fieldset>
        </td>
        <td width="50%" valign="top">
            <fieldset>
                <legend><?=lang('signup_form_legend_additional_info');?></legend>
                <table cellpadding="2" cellspacing="5" border="0">
                    <tr>
                        <td><strong><?=lang('signup_form_firstname');?></strong></td>
                        <td><?php echo form_input('firstname', set_value('firstname'), 'type="text" size="23"');?></td>
                        <td><?php echo form_error('firstname'); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?=lang('signup_form_lastname');?></strong></td>
                        <td><?php echo form_input('lastname', set_value('lastname'), 'type="text" size="23"');?></td>
                        <td><?php echo form_error('lastname'); ?></td>
                    </tr>
                    <tr>
                        <td><strong><?=lang('signup_form_birth');?></strong></td>
                        <?php
                            $this->load->helper('date');
                            $year = "%Y";
                            $time = time();
                            $options_y = range(mdate($year, $time)-11, mdate($year, $time)-100, 1);
                            $options_m = range(1,12,1);
                            $options_d = range(1,31,1);
                        ?>
                        <td><?php echo form_dropdown('age_d', $options_d, '12'); echo form_dropdown('age_m', $options_m, 'Januar'); echo form_dropdown('age_y', $options_y, '1911');?></td>
                        <td><?php echo form_error('age'); ?></td>
                    </tr>
                </table>
            </fieldset>
        </td>
    </tr>
</table>
<br />
<?php echo form_submit('submit', $this->lang->line('signup_form_submit')); echo form_reset('reset', $this->lang->line('signup_form_reset'));?>
<?php echo form_close();?>
