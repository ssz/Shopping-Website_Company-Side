<body>
	<div class="container">
	<div class="login" align='center'>
	<?php echo form_open('account/clogin_new'); ?>
			<div id="left">
				<p>Return Customer?<span style="color:#D2691E">&nbsp;&nbsp;SIGN IN</span></p>
				<p><input id="cusername" name="cusername" type="text" placeholder="Username" autofocus/></p>
				<?php echo form_error('cusername'); ?>
				<p><input id="cpassword" name="cpassword" type="password" placeholder="Password"></p>
				<p class="submit"><input type = "submit" value = "Login"/></p>
			</div>
			<br>
			<div id="right">
				<p>Create An Account? &nbsp;
				<a href = "<?php echo site_url('account/addProfile'); ?>"><span style="color:#D2691E">SIGN UP</span></a>
				</p>
			</div>
			<?php echo validation_errors('<p class="err" align="center" style="color:red">'); ?>
		</form>
	</div>
	</div>
</body>
</html>