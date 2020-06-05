<?php

namespace Plugin\DataBackup3\Tests\Service;

use Plugin\DataBackup3\Tests\PluginTestCase;
use Plugin\DataBackup3\Service\DataBackup3Service;

class DataBackup3ServiceTest extends PluginTestCase
{
    /** @var DataBackup3Service */
    protected $DataBackup3Service;

    public function setUp()
    {
        parent::setUp();
        if (isset($this->app['orm.em'])) {
            $this->app['orm.em']->getConnection()->beginTransaction();
        }
        $this->DataBackup3Service = $this->app['eccube.service.databackup3'];
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('\Plugin\DataBackup3\Service\DataBackup3Service', $this->DataBackup3Service);

    }
}
