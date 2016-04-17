<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 11/30/15
 * Time: 5:27 PM
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class MemberStatus
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="member_statuses")
 * @Vich\Uploadable
 */
class MemberStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="integer")
     */
    protected $percent = 0;

    /**
     * @Vich\UploadableField(mapping="status_image", fileNameProperty="image")
     * @var File $imageFile
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", name="image", nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\User", mappedBy="status", cascade={"persist", "remove"})
     */
    protected $users;

    /**
     * @ORM\Column(type="decimal", scale=2, name="mining_rights")
     */
    protected $miningRights = 0.00;

//    /**
//     * @ORM\Column(type="string")
//     */
//    protected $sponsorBonus = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     *
     * @return MemberStatus
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
     * Set price
     *
     * @param string $price
     *
     * @return MemberStatus
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Add user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return MemberStatus
     */
    public function addUser(\UserBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \UserBundle\Entity\User $user
     */
    public function removeUser(\UserBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return MemberStatus
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return MemberStatus
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return \DateTime
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set percent
     *
     * @param string $percent
     *
     * @return MemberStatus
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return string
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * Set miningRights
     *
     * @param string $miningRights
     *
     * @return MemberStatus
     */
    public function setMiningRights($miningRights)
    {
        $this->miningRights = $miningRights;

        return $this;
    }

    /**
     * Get miningRights
     *
     * @return string
     */
    public function getMiningRights()
    {
        return $this->miningRights;
    }

//    /**
//     * Set sponsorBonus
//     *
//     * @param string $sponsorBonus
//     *
//     * @return MemberStatus
//     */
//    public function setSponsorBonus($sponsorBonus)
//    {
//        $this->sponsorBonus = $sponsorBonus;
//
//        return $this;
//    }
//
//    /**
//     * Get sponsorBonus
//     *
//     * @return string
//     */
//    public function getSponsorBonus()
//    {
//        return $this->sponsorBonus;
//    }
}
