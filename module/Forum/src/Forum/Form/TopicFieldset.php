<?php
namespace Forum\Form;
 
use Forum\Entity\Topic;
 
use Zend\ServiceManager\ServiceManager;
 
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
 
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
 
 
class TopicFieldset extends Fieldset implements InputFilterProviderInterface
{
  public function __construct(ServiceManager $serviceManager)
  {
    parent::__construct('topic');
 
    $em =  $serviceManager->get('Doctrine\ORM\EntityManager');
 
    $this->setHydrator(new DoctrineEntity($em))
         ->setObject(new Topic());
 
    $this->setLabel('Topic');
 
    $this->add(array(
      'name' => 'id',
      'attributes' => array(
        'type' => 'hidden'
      )
    ));
 
    $this->add(array(
      'name' => 'title',
      'options' => array(
        //'label' => 'Title'        
      ),
      'attributes' => array(
        'type' => 'text',
        'class' => 'input-xxlarge',
        'placeholder'=>"Title"
      )
    ));
 
    $this->add(array(
      'name' => 'content',
      'options' => array(
        //'label' => 'Content'
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
      'title' => array(
        'required' => true,
        'filters' => array(
          array('name' => 'StringTrim'),
          array('name' => 'StripTags')
        ),
        'properties' => array(
          'required' => true
        )
      ),
      'content' => array(
        'required' => true,
        'filters' => array(
          array('name' => 'StringTrim'),
        ),
        'properties' => array(
          'required' => true
        )
      )
    );
  }
}