<?php

namespace App\Providers;

use SocialiteProviders\Manager\SocialiteWasCalled;

class TwitchExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('twitch', SocialiteProvidersProvider::class);
    }
}