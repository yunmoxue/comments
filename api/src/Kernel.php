<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        if ($this->environment === 'dev') {
            $dir = sys_get_temp_dir() . '/comments/var/cache/' . $this->environment;
        } else {
            $dir = parent::getCacheDir();
        }

        return $dir;
    }

    public function getLogDir(): string
    {
        return $this->environment === 'dev' ? sys_get_temp_dir() . '/var/log/comments/' : parent::getLogDir();
    }
}
