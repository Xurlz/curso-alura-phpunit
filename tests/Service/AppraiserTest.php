<?php

namespace Charles\Auction\Tests\Service;

use PHPUnit\Framework\TestCase;
use Charles\Auction\Model\Auction;
use Charles\Auction\Service\Appraiser;
use Charles\Auction\Model\User;
use Charles\Auction\Model\Bid;

class AppraiserTest extends TestCase
{
  /**
   * @dataProvider deliverAuctions
   */
  public function testAppraiserMustGetTheGreatestBidsAtAscendingOrder(Auction $auction) : void
  {
    $auctioneer = new Appraiser;

    // Act - When / Code to be executed
    $auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(2500, $auctioneer->getGreatestValue());

  }

  /**
   * @dataProvider deliverAuctions
   */
  public function testAppraiserMustGetTheLowestBidsAtAscendingOrder(Auction $auction) : void
  {

    $auctioneer = new Appraiser;

    // Act - When / Code to be executed
    $auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(1700, $auctioneer->getLowestValue());

  }


  /**
   * @dataProvider deliverAuctions
   */
  public function testAppraiserMustGetTheGreatestBidsAtDescendingOrder(Auction $auction) : void
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

  /**
   * @dataProvider deliverAuctions
   */
  public function testAppraiserMustGetTheLowestBidsAtDescendingOrder(Auction $auction) : void
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

  /**
   * @dataProvider deliverAuctions
   */
  public function testAppraiserMustFindThe3GreatestValues(Auction $auction) : void
  {
    $auctioneer = new Appraiser;
    $auctioneer->evaluate($auction);

    $theGreatest = $auctioneer->getTheGreatestValues();

    $this->assertCount(3, $theGreatest);
    $this->assertEquals(2500, $theGreatest[0]->getValue());
    $this->assertEquals(2000, $theGreatest[1]->getValue());
    $this->assertEquals(1700, $theGreatest[2]->getValue());

  }

  /**
   * @return array<array<Auction>>
   */
  public function deliverAuctions() : array
  {
    return [
      $this->auctionAtAscendingOrder(),
      $this->auctionAtDescendingOrder(),
      $this->auctionAtScrambledOrder()
    ];
  }

  /**
   * @return array<Auction>
   */
  public function auctionAtAscendingOrder() : Array
  {
    $auction = new Auction('Fiat Uno 200000Km');
    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');

    $auction->placeBid(new Bid($alice, 1700));
    $auction->placeBid(new Bid($bob, 2000));
    $auction->placeBid(new Bid($carl, 2500));

    return [$auction];
  }

  /**
   * @return array<Auction>
   */
  public function auctionAtDescendingOrder() : Array
  {
    $auction = new Auction('Fiat Uno 200000Km');
    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');

    $auction->placeBid(new Bid($carl, 2500));
    $auction->placeBid(new Bid($bob, 2000));
    $auction->placeBid(new Bid($alice, 1700));

    return [$auction];
  }


  /**
   * @return array<Auction>
   */
  public function auctionAtScrambledOrder() : Array
  {
    $auction = new Auction('Fiat Uno 200000Km');
    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');

    $auction->placeBid(new Bid($bob, 2000));
    $auction->placeBid(new Bid($carl, 2500));
    $auction->placeBid(new Bid($alice, 1700));

    return [$auction];
  }
}

