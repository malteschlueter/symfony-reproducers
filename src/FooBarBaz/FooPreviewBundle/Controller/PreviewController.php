<?php

declare(strict_types=1);

namespace FooBarBaz\FooPreviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class PreviewController extends AbstractController
{
    public function indexAction(): Response
    {
        return new Response(__METHOD__);
    }
}
