<?php
namespace Forum\Form;

use Forum\Entity\Reply;
use Forum\Entity\Topic;

use Zend\ServiceManager\ServiceManager;

use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;


class ReplyFieldset extends Fieldset implements InputFilterProviderInterface
{
  public function __construct(ServiceManager $serviceManager)
  {
    parent::__construct('reply');

    $em =  $serviceManager->get('Doctrine\ORM\EntityManager');

    $this->setHydrator(new DoctrineEntity($em))
         ->setObject(new Reply());

    $this->setLabel('Reply');

    $this->add(array(
      'name' => 'id',
      'attributes' => array(
        'type' => 'hidden'
      )
    ));

    $this->add(array(
      'name' => 'topic',
      'type' => 'DoctrineModule\Form\Element\ObjectSelect',
      'attributes' => array(
        'type' => 'hidden'
      ),
      'options'    => array(
          'object_manager'  => $em,
          'target_class'    => 'Forum\Entity\Topic',
          'property'        => 'id'
      )
    ));

    $this->add(array(
      'name' => 'content',
      'options' => array(
        'label' => 'Reply'
      ),
      'attributes' => array(
        'type' => 'textarea',
        'class' => 'edit-content'
      )
    ));

  }

  /**
   * Define InputFilterSpecifications
   *
   * @access public
   * @return array
   */
  public function getInputFilterSpecification()
  {
    return array(
      'content' => array(
        'required' => true,
        'filters' => array(
          array('name' => 'StringTrim'),
        ),
        'properties' => array(
          'required' => true
        )
      ),
      'topic' => array(
        'required' => true,
        'filters' => array(
        ),
        'properties' => array(
          'required' => true
        )
      ),
    );
  }
}