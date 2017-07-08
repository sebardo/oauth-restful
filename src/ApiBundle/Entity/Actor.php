<?php
namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as JMS;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank
     * 
     * @JMS\Expose
     * @JMS\Groups({"Default", "widget"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surnames", type="string", length=100, nullable=true)
     */
    private $surnames;


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
     * Set name
     *
     * @param string $name
     *
     * @return Actor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surnames
     *
     * @param string $surnames
     *
     * @return Actor
     */
    public function setSurnames($surnames)
    {
        $this->surnames = $surnames;

        return $this;
    }

    /**
     * Get surnames
     *
     * @return string
     */
    public function getSurnames()
    {
        return $this->surnames;
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->name . ' ' . $this->surnames;
    }

  

}
