<?php

namespace Forum\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\ServiceManager\ServiceManager;

class ReplyForm extends Form {

  public function __construct(ServiceManager $serviceManager) {
    parent::__construct('reply');

    $this->setAttribute('method', 'post')
      ->setHydrator(new ClassMethods())
      ->setInputFilter(new InputFilter());

    $replyFieldSet = new ReplyFieldset($serviceManager);
    $replyFieldSet->setUseAsBaseFieldset(true);
    $this->add($replyFieldSet);

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
      'reply' => array(
        'topic',
        'content'
      )
    ));
  }

}