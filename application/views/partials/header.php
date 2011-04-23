    <div id="header">
    	<ul>
    		<li><a href="#">Home</a></li>
    		<li><a href="#">Forum</a></li>
    		<li class="dropdown">
    			<span>Account</span>
    			<div>
    				<?if(!$this->user->is_logged_in()):?>
					<div>
						<h3>Accountverwaltung</h3>
						
						<form action="login/validate" method="post">
							<label>E-Mail / Accountname</label>
							<input type="text" name="name_mail" value="" /><br />
							
							<label>Passwort</label>
							<input type="password" name="password" value="" /><br />
							
							<input type="submit" name="submit" value="Anmelden" />
						</form>
					</div>
					<div>
						<h3>Noch keinen Account?</h3>
						Jetzt registrieren und sofort loslegen &ndash; 100% kostenlos!<br /><br /><br />
						<a href="#" id="account-erstellen">Account erstellen</a>
					</div>
					<?else:?>
					<div>
						Hallo <?php echo $this->session->userdata('username')?>! | <a href="login/logout">Logout</a>
					</div>
					<?endif?>
    			</div>
    		</li>
    		<li><a href="#">Server</a></li>
    		<li><a href="#">Armory</a></li>
    	</ul>
    </div>
