<?php

namespace Plugin\DataBackup3\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Application;
use Eccube\Common\Constant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ConfigController
{
    /**
     * 設定画面
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Application $app, Request $request)
    {
        $form = $app['form.factory']->createBuilder('databackup3_config')->getForm();
        return $app->render('DataBackup3/Resource/template/admin/config.twig', array(
            'form' => $form->createView()
        ));

    }

    /**
     * バックアップ実行
     *
     * @param Application $app
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function doBackup(Application $app, Request $request)
    {
        $form = $app['form.factory']->createBuilder('databackup3_config')->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $backupDir = __DIR__.'/../backup/'.date('YmdHis');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0777, true);
            }
            $tables = $app['eccube.service.databackup3']->listTableNames();
            foreach ($tables as $table) {
                $app['eccube.service.databackup3']->dumpCSV($table, $backupDir);
            }

            $tarFile = $backupDir.'.tar';

            // tar.gzファイルに圧縮する.
            $phar = new \PharData($tarFile);
            $phar->buildFromDirectory($backupDir);
            $phar->compress(\Phar::GZ);


            return $app
                ->sendFile($tarFile.'.gz')
                ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'backup_'.date('YmdHis').'.tar.gz');
        }

        return $app->redirect($app->url('plugin_DataBackup3_config'));
    }
}
