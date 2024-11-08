<?php

namespace App\Domain\Landing;

use App\Domain\Landing\Exceptions\PageExpiredException;
use App\Domain\Landing\Exceptions\PageTrashedException;

class LandingVerifierService
{
    public function validate(Landing $page): void
    {
        if (true === $this->isTrashed($page)) {
            throw new PageTrashedException();
        }

        if (false === $this->isActive($page)) {
            throw new PageExpiredException();
        }
    }

    public function isActive(Landing $page): bool
    {
        return $page->getExpirationDate()->isFuture();
    }

    public function isTrashed(Landing $page): bool
    {
        return $page->trashed();
    }

}
