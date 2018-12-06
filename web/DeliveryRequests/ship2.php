

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<title>Multiple step form</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
	<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"></script>
	<style type="text/css">
		#personal_information,
		#company_information{
			display:none;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="col-lg-5">
			<form class="form-horizontal" action="" method="POST" id="myform">

				<fieldset id="account_information" class="">
					<legend>Account information</legend>
					<div class="form-group">
						<label for="username" class="col-lg-4 control-label">Username</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="username" name="username" placeholder="username">
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-lg-4 control-label">Password</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
					</div>
					<div class="form-group">
						<label for="conf_password" class="col-lg-4 control-label">Confirm password</label>
						<div class="col-lg-8">
							<input type="password" class="form-control" id="conf_password" name="conf_password" placeholder="Password">
						</div>
					</div>
					<p><a class="btn btn-primary next">next</a></p>
				</fieldset>

				<fieldset id="company_information" class="">
					<legend>Account information</legend>
					<div class="form-group">
						<label for="company" class="col-lg-4 control-label">Company</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="company" name="company" placeholder="Company">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-lg-4 control-label">Website url</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="url" name="url" placeholder="Website url">
						</div>
					</div>
					<p><a class="btn btn-primary next">next</a></p>
				</fieldset>

				<fieldset id="personal_information" class="">
					<legend>Personal information</legend>
					<div class="form-group">
						<label for="name" class="col-lg-4 control-label">Name</label>
						<div class="col-lg-8">
							<input type="text" class="form-control" id="name" name="name" placeholder="Name">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-lg-4 control-label">Email</label>
						<div class="col-lg-8">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email">
						</div>
					</div>
					<p><a class="btn btn-primary" id="previous" >Previous</a></p>
					<p><input class="btn btn-success" type="submit" value="submit"></p>
				</fieldset>

			</form>
		</div>  
	</div>

	<script type="text/javascript">
		$(document).ready(function(){

			// Custom method to validate username
			$.validator.addMethod("usernameRegex", function(value, element) {
				return this.optional(element) || /^[a-zA-Z0-9]*$/i.test(value);
			}, "Username must contain only letters, numbers");

			$(".next").click(function(){
				var form = $("#myform");
				form.validate({
					errorElement: 'span',
					errorClass: 'help-block',
					highlight: function(element, errorClass, validClass) {
						$(element).closest('.form-group').addClass("has-error");
					},
					unhighlight: function(element, errorClass, validClass) {
						$(element).closest('.form-group').removeClass("has-error");
					},
					rules: {
						username: {
							required: true,
							usernameRegex: true,
							minlength: 6,
						},
						password : {
							required: true,
						},
						conf_password : {
							required: true,
							equalTo: '#password',
						},
						company:{
							required: true,
						},
						url:{
							required: true,
						},
						name: {
							required: true,
							minlength: 3,
						},
						email: {
							required: true,
							minlength: 3,
						},
						
					},
					messages: {
						username: {
							required: "Username required",
						},
						password : {
							required: "Password required",
						},
						conf_password : {
							required: "Password required",
							equalTo: "Password don't match",
						},
						name: {
							required: "Name required",
						},
						email: {
							required: "Email required",
						},
					}
				});
				if (form.valid() === true){
					if ($('#account_information').is(":visible")){
						current_fs = $('#account_information');
						next_fs = $('#company_information');
					}else if($('#company_information').is(":visible")){
						current_fs = $('#company_information');
						next_fs = $('#personal_information');
					}
					
					next_fs.show(); 
					current_fs.hide();
				}
			});

			$('#previous').click(function(){
				if($('#company_information').is(":visible")){
					current_fs = $('#company_information');
					next_fs = $('#account_information');
				}else if ($('#personal_information').is(":visible")){
					current_fs = $('#personal_information');
					next_fs = $('#company_information');
				}
				next_fs.show(); 
				current_fs.hide();
			});
			
		});
	</script>
</body>
</html>
