<?php

namespace App\Domain\Landing;

use App\Domain\Landing\Exceptions\PageExpiredException;
use App\Domain\Landing\Exceptions\PageTrashedException;

/**
 * Simple helper to validate landing page before it will be used
 */
class LandingVerifierService
{
    public function validate(Landing $page): void
    {
        if (true === $page->trashed()) {
            throw new PageTrashedException();
        }

        if (false === $page->isActive()) {
            throw new PageExpiredException();
        }
    }

}
