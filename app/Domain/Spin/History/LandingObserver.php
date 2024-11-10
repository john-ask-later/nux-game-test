<?php

namespace App\Domain\Spin\History;

use App\Domain\Landing\Landing;

class LandingObserver
{
    public function __construct(
        protected SpinsPresenceVerifier $verifier
    ) {
    }

    /**
     * @param Landing $page
     *
     * @return void
     */
    public function created(Landing $page)
    {
        $hashId = $page->hash;

        $this->verifier->add($hashId);
    }

}
