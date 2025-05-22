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

  public function testAppraiserMustGetTheGreatestBidsAtDescendingOrder() : void
  {
    $auction = new Auction('Fiat Uno 0Km');
    $mary = new User('Mary');
    $john = new User('John');

    $auction->placeBid(new Bid($mary, 2500));
    $auction->placeBid(new Bid($john, 2000));

    $auctioneer = new Appraiser;

    // Act - When / Code to be executed
    $auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(2500, $auctioneer->getGreatestValue());

  }

  public function testAppraiserMustGetTheLowestBidsAtDescendingOrder() : void
  {
    $auction = new Auction('Fiat Uno 0Km');
    $mary = new User('Mary');
    $john = new User('John');

    $auction->placeBid(new Bid($mary, 2500));
    $auction->placeBid(new Bid($john, 2000));

    $auctioneer = new Appraiser;

    // Act - When / Code to be executed
    $auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(2500, $auctioneer->getGreatestValue());

  }

  public function testAppraiserMustFindThe3GreatestValues() : void
  {
    $auction = new Auction('Fiat Uno 0Km');

    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');
    $doug = new User('Doug');
    $edward = new User('Edward');

    $auction->placeBid(new Bid($alice, 1500));
    $auction->placeBid(new Bid($bob, 1000));
    $auction->placeBid(new Bid($carl, 2000));
    $auction->placeBid(new Bid($edward, 1700));

    $auctioneer = new Appraiser;
    $auctioneer->evaluate($auction);

    $theGreatest = $auctioneer->getTheGreatestValues();

    $this->assertCount(3, $theGreatest);
    $this->assertEquals(2000, $theGreatest[0]->getValue());
    $this->assertEquals(1700, $theGreatest[1]->getValue());
    $this->assertEquals(1500, $theGreatest[2]->getValue());

  }
}

