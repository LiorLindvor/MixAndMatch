<?php

namespace Hack\Bundle\ProxyBundle\Entity;

/**
 * GameResult
 */
class GameResult
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $itemId;

    /**
     * @var string
     */
    private $chosenCategory;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $scoreBonus;

    /**
     * @var integer
     */
    private $level;


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
     * Set itemId
     *
     * @param integer $itemId
     *
     * @return GameResult
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set chosenCategory
     *
     * @param string $chosenCategory
     *
     * @return GameResult
     */
    public function setChosenCategory($chosenCategory)
    {
        $this->chosenCategory = $chosenCategory;

        return $this;
    }

    /**
     * Get chosenCategory
     *
     * @return string
     */
    public function getChosenCategory()
    {
        return $this->chosenCategory;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return GameResult
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set scoreBonus
     *
     * @param string $scoreBonus
     *
     * @return GameResult
     */
    public function setScoreBonus($scoreBonus)
    {
        $this->scoreBonus = $scoreBonus;

        return $this;
    }

    /**
     * Get scoreBonus
     *
     * @return string
     */
    public function getScoreBonus()
    {
        return $this->scoreBonus;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return GameResult
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }
}

