<?php

namespace Charles\Auction\Service;

use Charles\Auction\Model\Auction;
use Charles\Auction\Model\Bid;

class Appraiser
{
  private float $greatestValue = -INF;
  private float $lowestValue = INF;
  private array $greatestValues = [];

  public function evaluate(Auction $auction) : void
  {
    foreach($auction->getBids() as $bid) {
      if($bid->getValue() > $this->greatestValue) $this->greatestValue = $bid->getValue();
      if($bid->getValue() < $this->lowestValue) $this->lowestValue = $bid->getValue();
    }

    $bids = $auction->getBids();

    usort($bids, function(Bid $bid1, Bid $bid2) {
      return $bid1->getValue() - $bid2->getValue();
    });
    $this->greatestValues = array_slice($bids,0,3);
  }

  public function getGreatestValue() : float
  {
    return $this->greatestValue;
  }

  public function getLowestValue() : float
  {
    return $this->lowestValue;
  }

  /**
   * @return Bid[]
   */
  public function getTheGreatestValues() : array
  {
    return $this->greatestValues;
  }

}

