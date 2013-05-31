<?php

namespace Forum\Service;

use Forum\Entity\Topic;
use Forum\Entity\Reply;
use Forum\Entity\User;

class TopicService
{
    /**
     */
    public function __construct($em)
    {
      $this->em = $em;
    }

    /**
     * @param  int $id
     * @return Thread
     */
    public function getById($id)
    {
        $topic = $this->em->find('Forum\Entity\Topic', $id);
        $replyRepository = $this->em->getRepository('Forum\Entity\Reply');
        $replies = $replyRepository->findBy(array('topic' => $id));

        return array('topic' => $topic, 'replies' => $replies);
    }
}