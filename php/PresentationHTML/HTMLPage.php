<!DOCTYPE html>
<html lang="uk">
    <head>
        <meta charset="utf-8">
        <title>{$title|escape} - {$name}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="For beauty, for glory and for friends. {$name} is a place for people to play together as a community sharing the love of games.">
        <meta property="og:image" content="{$path}/images/logo.svg">
        <script>var stripePublicKey = "{$stripePublicKey}";</script>
        <script>var recaptchaSiteKey = "{$recaptchaSiteKey}";</script>
        {foreach from=$links item=link}
            {$link}
        {/foreach}
    </head>
    <body>
        {$body}
    </body>
</html>