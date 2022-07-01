<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\TraceableUrlMatcher;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class RouterMismatchCommand extends Command
{
    protected static $defaultName = 'router:mismatch';

    private RouterInterface $router;
    private SymfonyStyle $io;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Displays mismatched routes for an application');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $routes = $this->router->getRouteCollection();

        foreach ($routes as $name => $route) {
            $this->convertController($route);

            $methods = $route->getMethods();
            if (count($methods) === 0) {
                $methods = [''];
            }

            $schemes = $route->getSchemes();

            if (count($schemes) === 0) {
                $schemes = [''];
            }

            foreach ($methods as $method) {
                if ($method === Request::METHOD_OPTIONS) {
                    continue;
                }

                foreach ($schemes as $scheme) {
                    $this->match($method, $scheme, $route->getHost(), $route->getPath(), $name);
                }
            }
        }

        return 0;
    }

    private function convertController(Route $route): void
    {
        if ($route->hasDefault('_controller')) {
            $nameParser = new ControllerNameParser($this->getApplication()->getKernel());
            try {
                $route->setDefault('_controller', $nameParser->build($route->getDefault('_controller')));
            } catch (\InvalidArgumentException $e) {
            }
        }
    }

    private function match(string $method, string $scheme, string $host, string $pathInfo, string $name): void
    {
        $context = $this->router->getContext();

        if ('' !== $method) {
            $context->setMethod($method);
        }
        if ('' !== $scheme) {
            $context->setScheme($scheme);
        }
        if ('' !== $host) {
            $context->setHost($host);
        }

        $matcher = new TraceableUrlMatcher($this->router->getRouteCollection(), $context);

        $traces = $matcher->getTraces($pathInfo);

        foreach ($traces as $trace) {
            if (TraceableUrlMatcher::ROUTE_MATCHES === $trace['level']) {
                if ($trace['name'] === $name && $trace['path'] === $pathInfo) {
                    continue;
                }

                $this->io->table(
                    [
                        '',
                        'Name',
                        'Method',
                        'Scheme',
                        'Host',
                        'Path',
                    ],
                    [
                        [
                            'Route',
                            $name,
                            $method,
                            $scheme,
                            $host,
                            $pathInfo,
                        ],
                        [
                            'Trace',
                            $trace['name'],
                            '',
                            '',
                            '',
                            $trace['path'],
                        ],
                    ],
                );
            }
        }
    }
}
