<h1>Donation shop</h1>
<div class="shop">
    <div class="items">
        {foreach from=$shop->GetAllProducts() item=product}
            <div class="item {if $shop->IsOwned($product)}own{elseif $product->IsDiscounted()}discount{/if}" discountprocent="{if !$shop->IsOwned($product) && $product->IsDiscounted()}{$product->GetDiscountedPercentage()}{/if}">
                <sub>{$product->GetInfo()}</sub>
                <h2>{$product->GetTitle()}</h2>
                {if !$shop->IsOwned($product)}
                    <form action="php/Ajax/purchase.php" method="post" class="donate payment">
                        <input type="hidden" name="public_key" value="{$stripePublicKey}">
                        <input type="hidden" name="email" value="{$profile->GetEmail()}">
                        <input type="hidden" name="title" value="{$product->GetTitle()}">
                        <input type="hidden" name="description" value="{$product->GetInfo()}">
                        <input type="hidden" name="amount" value="{$shop->GetPrice($product) - $shop->GetBalance()}">
                        <input type="hidden" name="product" value="{$product->GetId()}">
                        <label for="submit{$product->GetId()}" class="option buy">
                            € {number_format($shop->GetPrice($product) / 100, 2)}
                            {if $shop->GetPrice($product) != $product->GetDefaultPrice()}
                                <span>(€ {number_format($product->GetDefaultPrice() / 100, 2)}</span>
                            {/if}
                        </label>
                        <input type="submit" id="submit{$product->GetId()}" value="{$product->GetId()}" hidden>
                    </form>
                {else}
                    <div class="option">Owned</div>
                {/if}
            </div>
        {/foreach}
    </div>
</div>