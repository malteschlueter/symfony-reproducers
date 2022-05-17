<?php

declare(strict_types=1);

namespace FooBarBaz\FooPreviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PreviewController extends AbstractController
{
    public function indexAction(): Response
    {
        return new Response(__METHOD__);
    }

    /**
     * @Route("/already-exists-with-short-annotation")
     */
    public function alreadyExistsWithShortAnnotationAction(): Response
    {
        return new Response(__METHOD__);
    }

    /**
     * @\Symfony\Component\Routing\Annotation\Route("/already-exists-with-long-annotation")
     */
    public function alreadyExistsWithLongAnnotationAction(): Response
    {
        return new Response(__METHOD__);
    }
}
