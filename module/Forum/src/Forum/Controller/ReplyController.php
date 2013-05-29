<?php

namespace Forum\Controller;

use Forum\Entity\Topic;
use Forum\Entity\Reply;
use Forum\Form\ReplyForm;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class ReplyController extends AbstractActionController {

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
    return array();
  }

  public function addAction() {
    $em = $this->getEntityManager();

    $user = $em->getRepository("Forum\Entity\User")->find(1);

    $reply = new Reply();
    $reply->setCreatedBy($user);
    $form = new ReplyForm($this->serviceLocator);
    $form->bind($reply);

    $request = $this->getRequest();
    if ($request->isPost()) {
      $form->setData($request->getPost());
      if ($form->isValid()) {
        $em->persist($reply);
        $em->flush();
        $this->redirect()->toRoute('topic', array('action' => 'show', 'id' => $reply->getTopic()->getId()));
      }
    }else
      $this->redirect()->toRoute('topic');

    return $this->getResponse();
  }

  public function editAction() {
    $id = (int) $this->params('id', null);
    if (null === $id) {
      return $this->redirect()->toRoute('topic');
    }

    $topic = $this->getEntityManager()->find('Forum\Entity\Topic', $id);

    $form = new TopicForm($this->serviceLocator);
    $form->bind($topic);

    $request = $this->getRequest();
    if ($request->isPost()) {
      $form->setData($request->getPost());
      if ($form->isValid()) {
        $this->getEntityManager()->persist($topic);
        $this->getEntityManager()->flush();

        $this->redirect()->toRoute('topic');
      }
    }

    return array(
      'form' => $form,
      'id' => $id
    );
  }

  public function deleteAction() {
    $id = (int) $this->params('id', null);
    if (null === $id) {
      return $this->redirect()->toRoute('topic');
    }

    $em = $this->getEntityManager();

    $topic = $em->find('Forum\Entity\Topic', $id);

    $em->remove($topic);
    $em->flush();

    $this->redirect()->toRoute('topic');
  }
}