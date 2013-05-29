<?php

namespace Forum\Controller;

use Forum\Entity\Topic;
use Forum\Entity\Reply;
use Forum\Form\TopicForm;
use Forum\Form\ReplyForm;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;

class TopicController extends AbstractActionController {

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
    $repository = $this->getEntityManager()->getRepository('Forum\Entity\Topic');
    $topics = $repository->findAll();

    return array(
      'topics' => $topics
    );
  }

  public function addAction() {
    $em = $this->getEntityManager();

    $user = $this->getEntityManager()->getRepository("Forum\Entity\User")->find(1);

    $topic = new Topic();
    $topic->setCreatedBy($user);
    $form = new TopicForm($this->serviceLocator);
    $form->bind($topic);

    $request = $this->getRequest();
    if ($request->isPost()) {
      $form->setData($request->getPost());
      if ($form->isValid()) {
        $em->persist($topic);
        $em->flush();

        $this->redirect()->toRoute('topic');
      }
    }

    return array(
      'form' => $form
    );
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

  public function showAction() {
    $id = (int) $this->params('id', null);
    if (null === $id) {
      return $this->redirect()->toRoute('topic');
    }

    $em = $this->getEntityManager();
    $topicRepository = $em->getRepository('Forum\Entity\Topic');
    $topic = $topicRepository->find($id);
    $replyRepository = $em->getRepository('Forum\Entity\Reply');
    $replies = $replyRepository->findBy(array('topic' => $id));

    $em = $this->getEntityManager();

    $topic = $em->find('Forum\Entity\Topic', $id);
    $user = $em->getRepository("Forum\Entity\User")->find(1);

    $reply = new Reply();
    $reply->setCreatedBy($user);
    $reply->setTopic($topic);
    $form = new ReplyForm($this->serviceLocator);
    $form->bind($reply);

    return array(
      'form' => $form,
      'topic' => $topic,
      'replies' => $replies
    );
  }

}