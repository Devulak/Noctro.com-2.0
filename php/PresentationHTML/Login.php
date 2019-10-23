<canvas id="background"></canvas>
<script type="application/javascript">
    var dust = Dust(document.getElementById("background"), 1);
</script>
<form class="submit" method="post" action="php/Ajax/userLogin.php">
    <h1>Welcome</h1>
    <h2>How's it going?</h2>
    <label for="email" data-error="email">Email</label>
    <input type="email" name="email" id="email">
    <label for="password" data-error="password">Password</label>
    <input type="password" name="password" id="password">
    <sub><strike>Lost your password? <a href="#">Find it!</a></strike></sub>
    <input type="submit" value="Login">
    <sub>Need an account? <a href="register">Register</a></sub>
</form>
