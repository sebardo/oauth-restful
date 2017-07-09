<?php
namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;
use CoreBundle\Entity\BaseActor;

/**
 * @ORM\Entity(repositoryClass="ApiBundle\Entity\Repository\ActorRepository")
 * @ORM\Table(name="actor")
 * @JMS\ExclusionPolicy("all")
 */
class Actor extends BaseActor
{


    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     * @JMS\Expose
     * @JMS\Groups({"Default"})
     */
    protected $id;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->lastname;
    }

  

}
