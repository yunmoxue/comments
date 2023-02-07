<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping\PrePersist;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.11/reference/annotations-reference.html#preupdate
 * @property UuidInterface $uuid
 */
trait UuidTrait
{
    #[PrePersist]
    /** @PrePersist() */
    public function preSetUuid(): void
    {
        $this->uuid = Uuid::uuid4();
    }
}
