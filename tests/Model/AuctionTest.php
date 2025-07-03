<?php

namespace Charles\Auction\Tests\Model;

use Charles\Auction\Model\Auction;
use Charles\Auction\Model\Bid;
use Charles\Auction\Model\User;
use PHPUnit\Framework\TestCase;

class AuctionTest extends TestCase {

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

