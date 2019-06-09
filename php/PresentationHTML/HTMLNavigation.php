<nav>
    <div class='logo'>
        <img src='images/logo.svg' />
    </div>
    <div class='spread'></div>
    <form class='donate payment' method='post' action="php/Ajax/donate.php">
        <div class='valuta'>€</div>
        <input type='hidden' name='public_key' value='{StripePublicKey}' />
        <input type='hidden' name='email' value="{EMAIL}" />
        <input type='hidden' name='title' value='Donation' />
        <input type='text' name='amountCustom' class='strictNumber' min='1' max='1337' value='10' />
        <input type='submit' value='Donate' />
    </form>
    <div class='balance'>
        € {balanceInt}<span class='small'>{balanceDecimal}</span>
        <span class='alt small'> / {donatedInt}<span class='small'>{donatedDecimal}</span></span>
    </div>
    <div class='email'>{EMAIL}</div>
    <a class='logout end' href='login.php'>Logout</a>
</nav>