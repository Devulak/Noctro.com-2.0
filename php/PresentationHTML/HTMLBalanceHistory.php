<h1>Account purchase history</h1>
<div class='balanceHistory widthLimit'>
    {if count($transactions)}
        {foreach from=$transactions item=transaction}
            <div class="balanceMark {if $transaction->GetAmount() < 0}remove{/if}">
                <h2>€ {number_format($transaction->GetAmount() / 100, 2)}</h2>
                <div class='infobar'>
                    {date('m/d/Y H:i:s', $transaction->GetTime())}
                    {if $transaction->GetToken()}
                        | {$transaction->GetToken()|escape}
                    {/if}
                </div>
                {if $transaction->GetProduct()}
                    <div class='extra'><span>{$transaction->GetProduct()->GetGameServer()->GetTitle()|escape}</span> {$transaction->GetProduct()->GetTitle()|escape}</div>
                {/if}
            </div>
        {/foreach}
    {else}
        <div class='shrug'>¯\_(ツ)_/¯</div>
    {/if}
</div>