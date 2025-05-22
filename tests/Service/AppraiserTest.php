<?php

namespace Charles\Auction\Tests\Service;

use PHPUnit\Framework\TestCase;
use Charles\Auction\Model\Auction;
use Charles\Auction\Service\Appraiser;
use Charles\Auction\Model\User;
use Charles\Auction\Model\Bid;

class AppraiserTest extends TestCase
{
  public function testAppraiserMustGetTheGreatestBidsAtAscendingOrder() : void
  {
    $auction = new Auction('Fiat Uno 0Km');
    $mary = new User('Mary');
    $john = new User('John');

    $auction->placeBid(new Bid($john, 2000));
    $auction->placeBid(new Bid($mary, 2500));

    $auctioneer = new Appraiser;

    // Act - When / Code to be executed
    $auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(2500, $auctioneer->getGreatestValue());

  }

  public function testAppraiserMustGetTheLowestBidsAtAscendingOrder() : void
  {
    $auction = new Auction('Fiat Uno 0Km');
    $mary = new User('Mary');
    $john = new User('John');

    $auction->placeBid(new Bid($john, 2000));
    $auction->placeBid(new Bid($mary, 2500));

    $auctioneer = new Appraiser;

    // Act - When / Code to be executed
    $auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(2000, $auctioneer->getLowestValue());

  }
}

