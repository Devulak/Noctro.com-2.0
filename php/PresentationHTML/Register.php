<canvas id="background"></canvas>
<script type="application/javascript">
    var dust = Dust(document.getElementById("background"), 1);
</script>
<form class="submit" method="post" action="php/Ajax/userRegister.php">
    <h1>Create an account</h1>
    <h2>How's it going?</h2>
    <label for="email" data-error="email">Email</label>
    <input type="email" name="email" id="email">
    <label for="password" data-error="password">Password</label>
    <input type="password" name="password" id="password">
    <input type="submit" value="Continue">
    <sub>By continuing you accept to have read and agree to the <a href='terms'>Terms of Service</a> and <a href='terms'>Privacy Policy</a></sub>
    <sub>Already have an account? <a href='login'>Login</a></sub>
</form>
