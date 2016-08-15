<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 15/08/16
 * Time: 11:31
 */

namespace Ticketswap\ListingBundle\Tests\Service;

use Doctrine\ORM\EntityManager;
//WTF!! phpunit is not able to load Mockery class. Added a require_once for the time being just to complete the test
require_once "vendor/mockery/mockery/library/Mockery.php";
use \Mockery as m;

use Ticketswap\ListingBundle\Entity\Listings;
use Ticketswap\ListingBundle\Service\ListingService;
use Ticketswap\ListingBundle\Validation\PostListing;

class ListingServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ListingService $listingService */
    private $listingService;
    /** @var  PostListing $postListingMock */
    private $postListingMock;
    
    public function setup()
    {
        $emMock = $this->getEMMock();
        $this->listingService = new ListingService(getEMListingMock);
        $this->postListingMock = m::mock('Ticketswap\ListingBundle\Validation\PostListing');

    }

    public function testCreateListingWithDuplicateBarcodesProvided()
    {
        
        $this->listingService->createListing($this->postListingMock);
    }

    private function getEMMock()
    {
        $emMock = \Mockery::mock('\Doctrine\ORM\EntityManager',
            array(
                'getRepository' => new Listings(),
                'getClassMetadata' => (object)array('name' => 'aClass'),
                'persist' => null,
                'flush' => null,
            ));
        return $emMock;
    }
}