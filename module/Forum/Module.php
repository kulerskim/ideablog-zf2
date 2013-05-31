<?php

namespace Forum;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Doctrine\ORM\EntityManager;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{

  public function getConfig() {
    return include __DIR__ . '/config/module.config.php';
  }

  public function getAutoloaderConfig() {
    return array(
      'Zend\Loader\StandardAutoloader' => array(
        'namespaces' => array(
          __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
        ),
      ),
    );
  }

  /**
   * @return array
   */
  public function getServiceConfig() {
    return array(
      /**
       * Factories
       */
      'factories' => array(
        'Forum\Service\TopicService' => function ($serviceManager) {
          $em     = $serviceManager->get('Doctrine\ORM\EntityManager');

          return new Service\TopicService($em);
        }
      )
    );
  }

}