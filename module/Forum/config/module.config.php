<?php

namespace Forum;

return array(
  'router' => array(
    'routes' => array(
      'topic' => array(
        'type' => 'segment',
        'options' => array(
          'route' => '/topic[/:action][/:id]',
          'constraints' => array(
            'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
            'id' => '[0-9]+',
          ),
          'defaults' => array(
            'controller' => 'Forum\Controller\Topic',
            'action' => 'index',
          ),
        ),
      ),
    ),
  ),
  'controllers' => array(
    'invokables' => array(
      'Forum\Controller\Topic' => 'Forum\Controller\TopicController'
    ),
  ),
  'view_manager' => array(
    'template_path_stack' => array(
      'forum' => __DIR__ . '/../view',
    ),
  ),
  'doctrine' => array(
    'driver' => array(
      'AnnotationDriver' => array(
        'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
        'cache' => 'array',
        'paths' => array(__DIR__ . '/../src/Forum/Entity')
      ),
      'orm_default' => array(
        'drivers' => array(
          'Forum\Entity' => 'AnnotationDriver',
        )
      )
    ),
  ),
  'view_helpers' => array(
    'invokables' => array(
      'contentEditor' => 'Forum\View\Helper\ContentEditor'
    )
  ),
);