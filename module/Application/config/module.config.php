<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
  'router' => array(
    'routes' => array(
      'language' => array(
        'type' => 'segment',
        'options' => array(
          'route' => '/language/:lang',
          'constraints' => array(
            'lang' => '[a-zA-Z_]*',
          ),
          'defaults' => array(
            'controller' => 'Application\Controller\Index',
            'action' => 'change',
          ),
        ),
      ),
    ),
  ),
  'controllers' => array(
    'invokables' => array(
      'Application\Controller\Index' => 'Application\Controller\IndexController'
    ),
  ),
  'translator' => array(
    'locale' => 'en_US',
    'translation_file_patterns' => array(
      array(
        'type' => 'gettext',
        'base_dir' => __DIR__ . '/../language',
        'pattern' => '%s.mo',
      ),
    ),
  ),
  'service_manager' => array(
    'abstract_factories' => array(
      'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
      'Zend\Log\LoggerAbstractServiceFactory',
    ),
    'aliases' => array(
      'translator' => 'MvcTranslator',
    ),
    'services' => array(
      'session' => new Zend\Session\Container('zf2'),
    ),
  ),
  'view_manager' => array(
    'display_not_found_reason' => true,
    'display_exceptions' => true,
    'doctype' => 'HTML5',
    'not_found_template' => 'error/404',
    'exception_template' => 'error/index',
    'template_map' => array(
      'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
      'error/404' => __DIR__ . '/../view/error/404.phtml',
      'error/index' => __DIR__ . '/../view/error/index.phtml',
    ),
    'template_path_stack' => array(
      __DIR__ . '/../view',
    ),
  ),
);
