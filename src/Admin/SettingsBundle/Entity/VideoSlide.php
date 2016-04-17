<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 2/13/16
 * Time: 10:15 AM
 */

namespace Admin\SettingsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class VideoSlide
 * @package Admin\SettingsBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="video_slides")
 * @Vich\Uploadable
 */
class VideoSlide
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Vich\UploadableField(mapping="video_slide", fileNameProperty="video")
     * @var File $videoFile
     */
    protected $videoFile;

    /**
     * @ORM\Column(type="string")
     */
    protected $video;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     * @var \DateTime $updatedAt
     */
    protected $updatedAt;

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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $video
     */
    public function setVideoFile(File $video = null)
    {
        $this->videoFile = $video;

        if ($video) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return File
     */
    public function getVideoFile()
    {
        return $this->videoFile;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return VideoSlide
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return VideoSlide
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
}
