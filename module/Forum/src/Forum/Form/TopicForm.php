<?php

namespace Forum\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceManager;

class TopicForm extends Form {

  public function __construct(ServiceManager $serviceManager) {
    parent::__construct('topic');

    $this->setAttribute('method', 'post')
      ->setHydrator(new ClassMethods())
      ->setInputFilter(new InputFilter());

    $topicFieldSet = new TopicFieldset($serviceManager);
    $topicFieldSet->setUseAsBaseFieldset(true);
    $this->add($topicFieldSet);

    $this->add(array(
      'name' => 'security',
      'type' => 'Zend\Form\Element\Csrf'
    ));

    $this->add(array(
      'name' => 'submit',
      'attributes' => array(
        'type' => 'submit',
        'value' => 'Go',
        'id' => 'submitbutton'
      )
    ));

    $this->setValidationGroup(array(
      'security',
      'topic' => array(
        'title',
        'content'
      )
    ));
  }

}