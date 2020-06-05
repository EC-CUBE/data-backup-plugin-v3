<?php

namespace Plugin\DataBackup3\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Eccube\Application;
use Eccube\Common\Constant;
use Symfony\Component\HttpFoundation\Request;

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

        }

        return $app->render('Securitychecker3/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
        ));
    }
}
