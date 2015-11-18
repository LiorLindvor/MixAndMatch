<?php

namespace Hack\Bundle\ProxyBundle\Entity;

/**
 * Game
 */
class Game
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $cheapestItem;

    /**
     * @var string
     */
    private $expensiveItem;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Set cheapestItem
     *
     * @param string $cheapestItem
     *
     * @return Game
     */
    public function setCheapestItem($cheapestItem)
    {
        $this->cheapestItem = $cheapestItem;

        return $this;
    }

    /**
     * Get cheapestItem
     *
     * @return string
     */
    public function getCheapestItem()
    {
        return $this->cheapestItem;
    }

    /**
     * Set expensiveItem
     *
     * @param string $expensiveItem
     *
     * @return Game
     */
    public function setExpensiveItem($expensiveItem)
    {
        $this->expensiveItem = $expensiveItem;

        return $this;
    }

    /**
     * Get expensiveItem
     *
     * @return string
     */
    public function getExpensiveItem()
    {
        return $this->expensiveItem;
    }
}

