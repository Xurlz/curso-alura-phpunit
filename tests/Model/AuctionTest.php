<?php

namespace Charles\Auction\Tests\Model;

use Charles\Auction\Model\Auction;
use Charles\Auction\Model\Bid;
use Charles\Auction\Model\User;
use Charles\Auction\Service\Appraiser;
use PHPUnit\Framework\TestCase;

class AuctionTest extends TestCase {

  /** @var Appraiser */
  private Appraiser $auctioneer;

  public function testFinishedAuctionMustntBeEvaluated() : void
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Auction already finished');

    $auction = new Auction('Legendary Stair roof Fiat Uno');
    $auction->placeBid(new Bid(new User('Turing'), 2000));
    $auction->finish();

    $this->auctioneer = new Appraiser;
    $this->auctioneer->evaluate($auction);
  }

  public function testEmptyAuctionMustntBeAvaluated() : void
  {
    $auction = new Auction('Yellow Brasilia');
    $this->auctioneer = new Appraiser;
    $this->expectException(\DomainException::class);
    $this->auctioneer->evaluate($auction);
  }

  public function testAuctionMustntPlaceMoreThan5BidsPerUser() : void
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('User can\'t place more than 5 bids per auction');

    $auction = new Auction('Blue beatle');

    $alice = new User('Alice');
    $bob = new User('Bob');

    $auction->placeBid(new Bid($alice, 1000));
    $auction->placeBid(new Bid($bob, 1500));
    $auction->placeBid(new Bid($alice, 2000));
    $auction->placeBid(new Bid($bob, 2500));
    $auction->placeBid(new Bid($alice, 3000));
    $auction->placeBid(new Bid($bob, 3500));
    $auction->placeBid(new Bid($alice, 4000));
    $auction->placeBid(new Bid($bob, 4500));
    $auction->placeBid(new Bid($alice, 5000));
    $auction->placeBid(new Bid($bob, 5500));
    $auction->placeBid(new Bid($alice, 6000));

    $this->assertCount(10, $auction->getBids());
    $this->assertEquals(5500, $auction->getBids()[array_key_last($auction->getBids())]->getValue());
  }

  public function testAuctionMustntPlaceRepeatedBids() : void
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('User can\'t place two consecutive bids');

    $auction = new Auction('Flipper Zero (first prototype)');

    $alice = new User('Alice');

    $auction->placeBid(new Bid($alice, 1000));
    $auction->placeBid(new Bid($alice, 1500));

    $this->assertCount(1, $auction->getBids());
    $this->assertEquals(1000, $auction->getBids()[0]->getValue());
  }

  /**
   * @dataProvider createBids
   * @param array<int> $values
   */
  public function testAuctionMustPlaceBids(int $bidsCount, Auction $auction, array $values) : void
  {
    $this->assertCount($bidsCount, $auction->getBids());
    foreach($values as $i => $expectedValue) {
      $this->assertEquals($expectedValue,$auction->getBids()[$i]->getValue());
    }
  }

  /**
  * @return Array<Bid,int,Array>
  */
  public static function createBids() : array
  {
    $alice = new User('Alice');
    $bob = new User('Bob');

    $auctionWith2Bids = new Auction('Fiat Uno 200.000Km (With a roof ladder)');
    $auctionWith2Bids->placeBid(new Bid($alice, 1000));
    $auctionWith2Bids->placeBid(new Bid($bob, 2000));

    $auctionWith1Bid = new Auction('Mystery machine 1992');
    $auctionWith1Bid->placeBid(new Bid($bob,5000));

    return [
      '2-bids' => [2, $auctionWith2Bids, [1000,2000]],
      '1-bid' => [1, $auctionWith1Bid, [5000]]
    ];

  }
}

