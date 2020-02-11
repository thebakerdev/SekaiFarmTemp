<div class="ui grid centered">
    <div class="sixteen wide mobile seven wide tablet seven wide computer column footer__left mb-h">
        <a href="{{ action('LocaleController@setLocale',['locale' => 'en']) }}" class="{{ \App\Services\Localization::setActive('en') }} mr-1">English</a>
        <a href="{{ action('LocaleController@setLocale',['locale' => 'th']) }}" class="{{ \App\Services\Localization::setActive('th') }} mr-1">Thai</a>
    </div>
    <div class="sixteen wide mobile seven wide tablet seven wide computer column footer__right mb-h"><a> service@sekaifarm.com </a></div>
</div>