<?php

namespace Forum\Entity;

use Doctrine\ORM\Mapping as ORM;
use Forum\Entity\User;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Topic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $title;

    /**
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $created_by;
    
    /**
     * @ORM\PrePersist
     */
    public function onPrePersistSetCreated()
    {
        $this->created_at = new \DateTime('now', new \DateTimeZone('UTC'));        
    }
}

