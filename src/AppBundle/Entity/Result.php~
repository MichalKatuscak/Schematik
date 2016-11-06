<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 */
class Result
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="results")
     */
    public $player;

    /**
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="results")
     */
    public $image;

    /**
     * @var int
     *
     * @ORM\Column(name="good", type="integer")
     */
    private $good;

    /**
     * @var int
     *
     * @ORM\Column(name="bad", type="integer")
     */
    private $bad;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_passible_more_result", type="boolean")
     */
    private $isPassibleMoreResult;


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
     * Set good
     *
     * @param integer $good
     *
     * @return Result
     */
    public function setGood($good)
    {
        $this->good = $good;

        return $this;
    }

    /**
     * Get good
     *
     * @return int
     */
    public function getGood()
    {
        return $this->good;
    }

    /**
     * Set bad
     *
     * @param integer $bad
     *
     * @return Result
     */
    public function setBad($bad)
    {
        $this->bad = $bad;

        return $this;
    }

    /**
     * Get bad
     *
     * @return int
     */
    public function getBad()
    {
        return $this->bad;
    }

    /**
     * Set isPassibleMoreResult
     *
     * @param boolean $isPassibleMoreResult
     *
     * @return Result
     */
    public function setIsPassibleMoreResult($isPassibleMoreResult)
    {
        $this->isPassibleMoreResult = $isPassibleMoreResult;

        return $this;
    }

    /**
     * Get isPassibleMoreResult
     *
     * @return bool
     */
    public function getIsPassibleMoreResult()
    {
        return $this->isPassibleMoreResult;
    }

    /**
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return Result
     */
    public function setPlayer(\AppBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \AppBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Result
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}
