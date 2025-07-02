<?php

namespace Charles\Auction\Tests\Service;

use PHPUnit\Framework\TestCase;
use Charles\Auction\Model\Auction;
use Charles\Auction\Service\Appraiser;
use Charles\Auction\Model\User;
use Charles\Auction\Model\Bid;

class AppraiserTest extends TestCase
{
  private Appraiser $auctioneer;

  protected function setUp() : void
  {
    echo "Running setUp". PHP_EOL;
    $this->auctioneer = new Appraiser;
  }
  /**
   * @dataProvider auctionAtAscendingOrder
   * @dataProvider auctionAtDescendingOrder
   * @dataProvider auctionAtScrambledOrder
   */
  public function testAppraiserMustGetTheGreatestBid(Auction $auction) : void
  {
    // Act - When / Code to be executed
    $this->auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(2500, $this->auctioneer->getGreatestValue());

  }

  /**
   * @dataProvider auctionAtAscendingOrder
   * @dataProvider auctionAtDescendingOrder
   * @dataProvider auctionAtScrambledOrder
   */
  public function testAppraiserMustGetTheLowestBid(Auction $auction) : void
  {
    // Act - When / Code to be executed
    $this->auctioneer->evaluate($auction);

    // Assert - Then / Verify if the output was the expected
    $this->assertEquals(1700, $this->auctioneer->getLowestValue());

  }

  /**
   * @dataProvider auctionAtAscendingOrder
   * @dataProvider auctionAtDescendingOrder
   * @dataProvider auctionAtScrambledOrder
   */
  public function testAppraiserMustFindThe3GreatestValues(Auction $auction) : void
  {
    $this->auctioneer->evaluate($auction);

    $theGreatest = $this->auctioneer->getTheGreatestValues();

    $this->assertCount(3, $theGreatest);
    $this->assertEquals(2500, $theGreatest[0]->getValue());
    $this->assertEquals(2000, $theGreatest[1]->getValue());
    $this->assertEquals(1700, $theGreatest[2]->getValue());
  }

  /**
   * @return array<Auction>
   */
  public static function auctionAtAscendingOrder() : Array
  {
    echo "Generating aunction at ascending order" . PHP_EOL;
    $auction = new Auction('Fiat Uno 200000Km');
    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');

    $auction->placeBid(new Bid($alice, 1700));
    $auction->placeBid(new Bid($bob, 2000));
    $auction->placeBid(new Bid($carl, 2500));

    return [[$auction]];
  }

  /**
   * @return array<Auction>
   */
  public static function auctionAtDescendingOrder() : Array
  {
    echo "Generating auction at descending order" . PHP_EOL;
    $auction = new Auction('Fiat Uno 200000Km');
    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');

    $auction->placeBid(new Bid($carl, 2500));
    $auction->placeBid(new Bid($bob, 2000));
    $auction->placeBid(new Bid($alice, 1700));

    return [[$auction]];
  }


  /**
   * @return array<Auction>
   */
  public static function auctionAtScrambledOrder() : Array
  {
    echo "Generating auction at scrambled order" . PHP_EOL;
    $auction = new Auction('Fiat Uno 200000Km');
    $alice = new User('Alice');
    $bob = new User('Bob');
    $carl = new User('Carl');

    $auction->placeBid(new Bid($bob, 2000));
    $auction->placeBid(new Bid($carl, 2500));
    $auction->placeBid(new Bid($alice, 1700));

    return [[$auction]];
  }
}

