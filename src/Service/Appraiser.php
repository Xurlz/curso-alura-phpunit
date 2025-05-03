<?php

namespace Charles\Auction\Service;

use Charles\Auction\Model\Auction;

class Appraiser
{
  private float $greatestValue = -INF;
  private float $lowestValue = INF;

  public function evaluate(Auction $auction) : void
  {
    foreach($auction->getBids() as $bid) {
      if($bid->getValue() > $this->greatestValue) $this->greatestValue = $bid->getValue();
      if($bid->getValue() < $this->lowestValue) $this->lowestValue = $bid->getValue();
    }
  }

  public function getGreatestValue() : float
  {
    return $this->greatestValue;
  }
}

