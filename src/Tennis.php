<?php

/**
 * Class Tennis
 */
class Tennis
{

    /**
     * @var array
     */
    protected $lookup = [
        0 => 'Love',
        1 => 'Fifteen',
        2 => 'Thirty',
        3 => 'Forty'
    ];

    /**
     * Tennis constructor.
     * @param Player $player1
     * @param Player $player2
     */
    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }

    /**
     * @return string
     */
    public function score()
    {
        if ($this->hasAWinner())
        {
            return 'Win for ' . $this->winner()->name;
        }
        if ($this->hasTheAdvantage())
        {
            return 'Advantage ' . $this->winner()->name;
        }
        if($this->inDeuce())
        {
            return 'Deuce';
        }

        return $this->generalScore();

    }

    /**
     * @return bool
     */
    private function tied()
    {
        return $this->player1->points == $this->player2->points;
    }

    /**
     * @return bool
     */
    private function hasAWinner()
    {
        return $this->hasEnoughPointsToBeWon() && $this->isLeadingByAtleast2();
    }

    /**
     * @return Player
     */
    public function winner()
    {
        return $this->player1->points > $this->player2->points ? $this->player1 : $this->player2;
    }

    /**
     * @return bool
     */
    public function hasEnoughPointsToBeWon()
    {
        return max([$this->player1->points, $this->player2->points]) >= 4;
    }

    /**
     * @return float|int
     */
    public function isLeadingByAtleast2()
    {
        return abs($this->player1->points - $this->player2->points) >= 2;
    }

    /**
     * @return bool
     */
    public function hasTheAdvantage()
    {
        return $this->hasEnoughPointsToBeWon() && $this->isLeadingByOne();
    }

    /**
     * @return bool
     */
    public function inDeuce()
    {
        //3-3 is a deuce. Therefore, score is 6 or higher for deuce
        return $this->totalScoreAtleast6() >= 6 && $this->tied();
    }

    /**
     * @return string
     */
    public function generalScore()
    {
        $score = $this->lookup[$this->player1->points] . '-';
        $score .= $this->tied() ? 'All' : $this->lookup[$this->player2->points];
        return $score;
    }

    /**
     * @return bool
     */
    private function isLeadingByOne()
    {
        return abs($this->player1->points - $this->player2->points) == 1;
    }

    /**
     * @return mixed
     */
    private function totalScoreAtleast6()
    {
        return $this->player1->points + $this->player2->points;
    }

}
