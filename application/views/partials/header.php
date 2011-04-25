    <div id="header">
    	<ul>
    		<li><a href="<?=base_url()?>">Home</a></li>
    		<li><a href="http://forum.eternal-knights.net">Forum</a></li>
    		<li class="dropdown">
    			<span>Account</span>
    			<div>
    				<?if(!$this->user->is_logged_in()):?>
					<div>
						<h3>Accountverwaltung</h3>
						
						<form action="<?=site_url('login/validate')?>" method="post">
							<label>E-Mail / Accountname</label>
							<input type="text" name="name_mail" value="" /><br />
							
							<label>Passwort</label>
							<input type="password" name="password" value="" /><br />
							
							<input type="submit" name="submit" value="" />
						</form>
					</div>
					<div>
						<h3>Noch keinen Account?</h3>
						Jetzt registrieren und sofort loslegen &ndash; 100% kostenlos!<br /><br /><br />
						<a href="<?=site_url('signup')?>" id="account-erstellen">Account erstellen</a>
					</div>
					<?else:?>
					<div>
						Hallo <?php echo $this->session->userdata('username')?>! | <a href="<?=site_url('login/logout')?>">Logout</a><br />
						<a href="<?=site_url('controlpanel')?>">Accountverwaltung</a>
					</div>
					<?endif?>
    			</div>
    		</li>
    		<li><a href="<?=site_url('server')?>">Server</a></li>
    		<li><a href="<?=site_url('armory')?>">Armory</a></li>
    	</ul>
    </div>
	