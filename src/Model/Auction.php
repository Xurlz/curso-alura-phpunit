<?php

namespace Charles\Auction\Model;

use Charles\Auction\Model\Bid;

class Auction
{
  private array $bids;
  private string $description;

  public function __construct(
    string $description
  )
  {
    $this->bids = [];
    $this->description = $description;
  }

  public function getBids() : array
  {
    return $this->bids;
  }

  public function placeBid(Bid $bid) : void
  {
    if(!empty($this->bids) && $bid->getUser() == $this->bids[array_key_last($this->bids)]->getUser()) return;
    $this->bids[] = $bid;
  }
}

