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
    if(!empty($this->bids) && $this->isFromTheLastUser($bid)) return;
    $this->bids[] = $bid;
  }

  private function isFromTheLastUser(Bid $bid) : bool
  {
    $lastBid = $this->bids[array_key_last($this->bids)];
    return $bid->getUser() == $lastBid->getUser();
  }
}

