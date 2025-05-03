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
    $this->bids[] = $bid;
  }
}

