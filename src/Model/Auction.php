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
    if(!empty($this->bids) && $this->isFromTheLastUser($bid))
      throw new \DomainException('User can\'t place two consecutive bids');

    $user = $bid->getUser();

    $totalBids = $this->totalBidsPerUser($user);

    if($totalBids >= 5)
      throw new \DomainException('User can\'t place more than 5 bids per auction');

    $this->bids[] = $bid;
  }

  private function totalBidsPerUser(User $user) : int
  {
    $totalBidsPerUser = function(?int $accumulated,Bid $currentBid) use ($user) {
      if($currentBid->getUser() == $user) {
        return ++$accumulated;
      }
      return $accumulated;
    };

    return array_reduce($this->bids, $totalBidsPerUser, 0);
  }

  private function isFromTheLastUser(Bid $bid) : bool
  {
    $lastBid = $this->bids[array_key_last($this->bids)];
    return $bid->getUser() == $lastBid->getUser();
  }
}

