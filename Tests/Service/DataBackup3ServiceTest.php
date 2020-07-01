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

    public function testListTableNames()
    {
        $tables = $this->DataBackup3Service->listTableNames();
        $this->assertTrue(in_array('dtb_base_info', $tables));
    }

    public function testListTableColumnNames()
    {
        $columns = $this->DataBackup3Service->listTableColumnNames('dtb_base_info');
        $this->assertTrue(in_array('shop_name', $columns));
    }

    public function testFindAll()
    {
        $result = $this->DataBackup3Service->findAll('dtb_product');
        $this->assertTrue(is_array($result));
    }

    public function testDumpCSV()
    {
        $backupDir = __DIR__.'/../../backup/'.date('YmdHis');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0777, true);
        }

        $this->DataBackup3Service->dumpCSV('dtb_product', $backupDir);
        $this->assertFileExists($backupDir.'/dtb_product.csv');
    }
}
