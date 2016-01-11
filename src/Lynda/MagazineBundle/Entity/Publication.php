<?php

namespace Lynda\MagazineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//1-import ArrayCollection class(Doctrine uses a data structure called collections to represents the association with entities)
use  Doctrine\Common\Collections\ArrayCollection;

/**
 * Publication
 *
 * @ORM\Table(name="publications")
 * @ORM\Entity(repositoryClass="Lynda\MagazineBundle\Entity\PublicationRepository")
 */
class Publication
{
    //2-Create plural name based on the Child and create it is Association annotation
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Issue",mappedBy="publication")
     */
    private $issues;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    //3-Create a constructor that will populate the property created at step 2
    public function __construct(){
        //4-store empty collection object in the property created at step 2 to initialize it
      $this->issues = new ArrayCollection();
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Publication
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
     * Add issues
     *
     * @param \Lynda\MagazineBundle\Entity\Issue $issues
     * @return Publication
     */
    public function addIssue(\Lynda\MagazineBundle\Entity\Issue $issues)
    {
        $this->issues[] = $issues;

        return $this;
    }

    /**
     * Remove issues
     *
     * @param \Lynda\MagazineBundle\Entity\Issue $issues
     */
    public function removeIssue(\Lynda\MagazineBundle\Entity\Issue $issues)
    {
        $this->issues->removeElement($issues);
    }

    /**
     * Get issues
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIssues()
    {
        return $this->issues;
    }
}
