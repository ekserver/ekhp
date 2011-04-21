    <div id="header_title">
    <h1><?php echo $title;?></h1>
    </div>
    
    <div id="login-container">
        <?php if(!$this->user->is_logged_in()):?>
        <h3>Login</h3>
            <p>
                <?php
                    echo form_open('login/validate');
                    echo form_input('name_mail', 'Email/Benutzername', 'type="text" size="23" onfocus="if(this.value==\'Email/Benutzername\')this.value=\'\'"');
                    echo form_password('password', 'Passwort', 'type="password" size="23" onfocus="if(this.value==\'Password\')this.value=\'\'"');
                    echo form_submit('submit', 'Login', 'style="width: 80px"');
                    echo '<br/><a href="#" >Passwort vergessen?</a>';
                    echo form_close();
                ?>
            </p>
        <? else: ?>
        <h4>Hallo <?php echo $this->session->userdata('username')?>! | <a href="login/logout">Logout</a></h4>
        <? endif; ?>
    </div>
