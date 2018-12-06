<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

<script src="//code.jquery.com/jquery-2.1.3.js"></script>
<script src="/assets/js/jquery.steps.js"></script>
<script src="/assets/js/jquery.steps.min.js"></script>


</head>
<body>

  <!-- Thanks to Pieter B. for helping out with the logistics -->
  <div class="container">
    <form id="contact" action="#">
        <div>
            <h3>Account</h3>
            <section>
                <label for="userName">User name *</label>
                <input id="userName" name="userName" type="text" class="required">
                <label for="password">Password *</label>
                <input id="password" name="password" type="text" class="required">
                <label for="confirm">Confirm Password *</label>
                <input id="confirm" name="confirm" type="text" class="required">
                <p>(*) Mandatory</p>
            </section>
            <h3>Profile</h3>
            <section>
                <label for="name">First name *</label>
                <input id="name" name="name" type="text" class="required">
                <label for="surname">Last name *</label>
                <input id="surname" name="surname" type="text" class="required">
                <label for="email">Email *</label>
                <input id="email" name="email" type="text" class="required email">
                <label for="address">Address</label>
                <input id="address" name="address" type="text">
                <p>(*) Mandatory</p>
            </section>
            <h3>Hints</h3>
            <section>
                <ul>
                    <li>Foo</li>
                    <li>Bar</li>
                    <li>Foobar</li>
                </ul>
            </section>
            <h3>Finish</h3>
            <section>
                <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
            </section>
        </div>
    </form>
  </div>
   
<script>
var form = $("#contact");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        confirm: {
            equalTo: "#password"
        }
    }
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
});
 </script>
  

</body>
</html>



