<!DOCTYPE html>
 
<html xmlns="http://www.w3.org/1999/xhtml"> 
 
<head> 
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
	<title>Login | Jayon Express Admin</title> 
	
	<?php $this->tf_assets->render_css(); ?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head> 
 
<body> 

<div id="login">
	<h1>Dashboard</h1>
	<div id="login_panel">
		<? if (@$error): ?>
            <h3 style="color:red"><?php print  $error ?></h3>
        <? endif; ?>
        <?php print form_open('front/login') ?>	
			<div class="login_fields">
				<div class="field">
					<label for="email">Email</label>
					<input type="text" name="email" value="" id="email" tabindex="1" placeholder="email@example.com" />		
				</div>
				
				<div class="field">
					<label for="password">Password <small><a href="">Forgot Password?</a></small></label>
					<input type="password" name="password" value="" id="password" tabindex="2" placeholder="password" />			
				</div>
			</div> <!-- .login_fields -->
			
			<div class="login_actions">
				<button type="submit" class="btn btn-orange" tabindex="3">Login</button>
			</div>
        <?php print form_close() ?>	
	</div> <!-- #login_panel -->		
</div> <!-- #login -->

</body> 
 
</html>