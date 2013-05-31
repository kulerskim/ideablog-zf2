<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
  public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap($e) {
      $translator = $e->getApplication()->getServiceManager()->get('translator');
      $session    = $e->getApplication()->getServiceManager()->get('session');
      if (isset($session->lang)) {
        $translator->setLocale($session->lang);
      }
      
      $viewModel           = $e->getApplication()->getMvcEvent()->getViewModel();
      $viewModel->lang     = $translator->getLocale();
      $viewModel->direction = in_array($translator->getLocale(), array('he_HE')) ? "rtl" : "ltr";
    }
}
