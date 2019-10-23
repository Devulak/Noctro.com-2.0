<h1>Game lottery</h1>
<div class='widthLimit'>
    <div class='gameLottery'>
        <div class='brick'>
            <div class='enlarge'>€ {$tokenPrice}</div>
            <div class='sub'>to go for another token</div>
        </div>
        <div class='brick'>
            <div class='enlarge'>{$tokensLeft} <span class='alt'>/ {$tokensRecieved}</span></div>
            <div class='sub'>tokens left</div>
        </div>
        <div class='brick'>
            <div class='enlarge'>{$gamesToClaim}</div>
            <div class='sub'>games to claim</div>
        </div>
        <div class='brick'>
            <div id='spinList' class='spinList'></div>
            {if $tokensLeft > 0}
                <a class='spin available' href='spin.php'>Spin (1 token)</a>
            {else}
                <div class='spin' >Spin (1 token)</div>
            {/if}
        </div>
    </div>
    <script>
        var currentNumber = 0;
        function rollSpinList()
        {
            var gamesArray = [];

            {foreach from=$gameCodesShuffled item=gameCode}
                gamesArray.push("{$gameCode->GetTitle()|escape}");
            {/foreach}

            var spinList = document.getElementById('spinList');

            var game = document.createElement('div');
            game.innerHTML = gamesArray[currentNumber];

            currentNumber++;
            if (currentNumber >= gamesArray.length)
            {
                currentNumber = 0;
            }


            var games = spinList.getElementsByClassName('out');
            for (var i = games.length - 1; i >= 0; i--)
            {
                spinList.removeChild(games[i]);
            }


            var games = spinList.getElementsByClassName('in');
            for (var i = games.length - 1; i >= 0; i--)
            {
                games[i].classList.add('out');
            }


            var games = spinList.getElementsByClassName('absolute');
            for (var i = games.length - 1; i >= 0; i--)
            {
                games[i].classList.add('in');
            }


            game.classList.add('game');
            game.classList.add('absolute');
            spinList.appendChild(game);
        }
        rollSpinList();
        rollSpinList();
        setInterval(rollSpinList, 2000);
    </script>
    {foreach from=$gameCodes item=gameCode}
        <div class="gameWon">
            <div class="container">
                <h2>{$gameCode->GetTitle()}</h2>
                <div class="code">{$gameCode->GetCode($profile)}</div>
            </div>
            <div class="infobar">
                {date('m/d/Y H:i:s', $gameCode->GetTime())}
            </div>
        </div>
    {/foreach}
</div>
