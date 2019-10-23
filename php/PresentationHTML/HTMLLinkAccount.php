<h1>Link your accounts</h1>
<div class="blocks">
    <div class="block">
        <h2>Steam</h2>
        {if $steamLink}
            <p>{$steamLink->GetUsername()}</p>
            <a class="buttonstyle" href="unlinksteam.php">Unlink Steam account</a>
        {else}
            <a class="buttonstyle" href="linksteam.php">Link Steam account</a>
        {/if}
    </div>
    <div class="block">
        <h2>Minecraft</h2>
        {if $mojangLink}
            <p>{$mojangLink->GetUsername()}</p>
            <a class="buttonstyle" href="unlinkminecraft.php">Unlink Minecraft username</a>
        {else}
            <form method="post" action="linkminecraft.php">
                <input type="text" name="username" class="inputstyle">
                <input type="submit" class="buttonstyle" value="Link Minecraft username">
            </form>
        {/if}
    </div>
</div>