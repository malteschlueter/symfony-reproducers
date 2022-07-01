<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MismatchedRoutesController extends AbstractController
{
    /**
     * @Route("/mismatched-route/{foo}")
     */
    public function mismatchedParamRoute(string $foo): Response
    {
        return new Response(__METHOD__ . $foo);
    }

    /**
     * @Route("/mismatched-route/static")
     */
    public function mismatchedStaticRoute(): Response
    {
        return new Response(__METHOD__);
    }

    /**
     * @Route("/matched-route/static")
     */
    public function matchedStaticRoute(): Response
    {
        return new Response(__METHOD__);
    }

    /**
     * @Route("/matched-route/{foo}")
     */
    public function matchedParamRoute(string $foo): Response
    {
        return new Response(__METHOD__ . $foo);
    }
}
