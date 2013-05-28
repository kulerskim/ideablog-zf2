<?php
namespace Application\Form;

use Zend\Form\Form;

class TopicForm extends Form
{
  public function __construct($name = null)
  {
    parent::__construct('topic');
    $this->setAttribute('method', 'post');
//    $this->add(array(
//            'name' => 'id',
//            'attributes' => array(
//                'type'  => 'hidden',
//            ),
//        ));
        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        $this->add(array(
            'name' => 'content',
            'attributes' => array(
                'type'  => 'textarea',
            ),
            'options' => array(
                'label' => 'Content',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
  }
}
