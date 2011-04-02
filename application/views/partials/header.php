    <div id="header_title">
    <h1><?php echo $title;?></h1>
    </div>
    
    <div id="login-container">
        <?php if(!$this->session->userdata('id')) : ?>
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
        <?php else : ?>
        <h3>Hallo <?php echo $this->session->userdata('username')?>!</h3>
        <?php endif ?>
    </div>