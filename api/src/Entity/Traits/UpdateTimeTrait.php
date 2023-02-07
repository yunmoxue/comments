<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

/**
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.11/reference/annotations-reference.html#preupdate
 * @property DateTime $updateTime
 */
trait UpdateTimeTrait
{
    #[PrePersist]
    #[PreUpdate]
    /**
     * @PrePersist()
     * @PreUpdate()
     */
    public function preSetUpdateTime(): void
    {
        $this->updateTime = new DateTime();
    }
}
