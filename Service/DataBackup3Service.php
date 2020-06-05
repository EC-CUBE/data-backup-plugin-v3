<?php

namespace Plugin\DataBackup3\Service;

use Eccube\Application;

class DataBackup3Service
{
    /** @var Application $app */
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}
