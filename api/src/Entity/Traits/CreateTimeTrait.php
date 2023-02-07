<?php

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping\PrePersist;

/**
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.11/reference/annotations-reference.html#preupdate
 * @property DateTime $createTime
 */
trait CreateTimeTrait
{
    #[PrePersist]
    /**
     * @PrePersist()
     */
    public function preSetCreateTime(): void
    {
        $this->createTime = new DateTime();
    }
}
