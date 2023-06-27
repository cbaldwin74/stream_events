<?php

namespace App\Providers;

use SocialiteProviders\Twitch\Provider;

class SocialiteProvidersProvider extends Provider 
{
    /**
     * Redirect the user of the application to the provider's authentication screen.
     *
     * @return URL to redirecr to
     */
    public function redirect()
    {
        $state = null;

        if ($this->usesState()) {
            $this->request->session()->put('state', $state = $this->getState());
        }

        if ($this->usesPKCE()) {
            $this->request->session()->put('code_verifier', $this->getCodeVerifier());
        }

        return $this->getAuthUrl($state);
    }
}