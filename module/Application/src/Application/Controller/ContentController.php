<?php

namespace Application\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\TopicForm;
use Application\Entity\Topic;

class ContentController extends AbstractActionController {

  /**
   * @var EntityManager
   */
  protected $entityManager;

  /**
   * Sets the EntityManager
   *
   * @param EntityManager $em
   * @access protected
   * @return PostController
   */
  protected function setEntityManager(EntityManager $em) {
    $this->entityManager = $em;
    return $this;
  }

  /**
   * Returns the EntityManager
   *
   * Fetches the EntityManager from ServiceLocator if it has not been initiated
   * and then returns it
   *
   * @access protected
   * @return EntityManager
   */
  protected function getEntityManager() {
    if (null === $this->entityManager) {
      $this->setEntityManager($this->getServiceLocator()->get('Doctrine\ORM\EntityManager'));
    }
    return $this->entityManager;
  }

  public function indexAction() {
    $repo = $this->getEntityManager()->getRepository('Application\Entity\Topic');
    $topics = $repo->findAll();
    return array('topics' => $topics);
  }

  public function addtopicAction() {
    $form = new TopicForm();
    $form->get('submit')->setValue('Save');

    $request = $this->getRequest();
    if ($request->isPost()) {
      $topic = new Topic();
      $form->setInputFilter($topic->getInputFilter());
      $form->setData($request->getPost());

      if ($form->isValid()) {
        var_dump($topic);
        die;
        $this->getEntityManager()->persist($topic);
        $this->getEntityManager()->flush();

        // Redirect to list of albums
        return $this->redirect()->toRoute('topic');
      }
    }
    return array('form' => $form);
  }

}

