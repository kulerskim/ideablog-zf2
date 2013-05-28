<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\TopicForm;
use Application\Entity\Topic;

class ContentController extends AbstractActionController
{
  public function indexAction()
  {
    $om = $this
              ->getServiceLocator()
              ->get('Doctrine\ORM\EntityManager');
    $r = $om->getRepository('Application\Entity\Topic')->findAll();

    return array('topics'=>$r);
  }

  public function addtopicAction()
  {
      $form = new TopicForm();
      $form->get('submit')->setValue('Save');

      $request = $this->getRequest();
      if ($request->isPost()) {
          $topic = new Topic();
          $form->setInputFilter($topic->getInputFilter());
          $form->setData($request->getPost());

          if ($form->isValid()) {
            var_dump($topic);die;
              $om = $this
                ->getServiceLocator()
                ->get('Doctrine\ORM\EntityManager');

              $om->persist($topic);
              $om->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('topic');
            }
        }
        return array('form' => $form);
    }
}

