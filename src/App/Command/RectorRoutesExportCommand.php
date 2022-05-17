<?php

declare(strict_types=1);

namespace App\Command;

final class RectorRoutesExportCommand extends \Symfony\Component\Console\Command\Command
{
    protected static $defaultName = 'rector:routes:export';
    /**
     * @readonly
     *
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct(\Symfony\Component\Routing\RouterInterface $router)
    {
        $this->router = $router;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Displays current routes for an application with resolved controller');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int
    {
        $routeCollection = $this->router->getRouteCollection();
        $routes = array_map(static fn (\Symfony\Component\Routing\Route $route): array => ['path' => $route->getPath(), 'host' => $route->getHost(), 'schemes' => $route->getSchemes(), 'methods' => $route->getMethods(), 'defaults' => $route->getDefaults(), 'requirements' => $route->getRequirements(), 'condition' => $route->getCondition()], $routeCollection->all());
        $content = json_encode($routes, \JSON_PRETTY_PRINT) . "\n";
        $output->write($content, false, \Symfony\Component\Console\Output\OutputInterface::OUTPUT_RAW);

        return 0;
    }
}
