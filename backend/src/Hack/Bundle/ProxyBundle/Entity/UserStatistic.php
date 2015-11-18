<?php

namespace Hack\Bundle\ProxyBundle\Entity;

/**
 * UserStatistic
 */
class UserStatistic
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $score;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $answersReplied;

    /**
     * @var integer
     */
    private $userLevel;

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
     * Set score
     *
     * @param integer $score
     *
     * @return UserStatistic
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return UserStatistic
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
     * Set gamesPlayed
     *
     * @param integer $answersReplied
     *
     * @return UserStatistic
     */
    public function setAnswersReplied($answersReplied)
    {
        $this->answersReplied = $answersReplied;

        return $this;
    }

    /**
     * Get gamesPlayed
     *
     * @return integer
     */
    public function getAnswersReplied()
    {
        return $this->answersReplied;
    }

    public function setUserLevel($userLevel)
    {
        $this->userLevel = $userLevel;
        return $this;
    }

    public function getUserLevel()
    {
        return $this->userLevel;
    }
}

