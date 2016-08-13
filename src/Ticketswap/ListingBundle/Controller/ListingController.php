<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 12/08/16
 * Time: 23:36
 */

namespace Ticketswap\ListingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as API;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ListingController extends Controller
{
    /**
     * Class ListingController
     * @package Ticketswap\ListingBundle\Controller
     *
     * ### Response ###
     *     {
     *         "status": "ok",
     *         "data": "success"
     *     }
     *
     * @API\Get("/listing/{uid}", requirements={"uid":"\d+"})
     *
     */
    public function getListingAction(Request $request, $uid)
    {
        return new JsonResponse();
    }
}