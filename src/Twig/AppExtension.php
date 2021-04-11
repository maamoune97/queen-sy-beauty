<?php

namespace App\Twig;

use App\Controller\AdminCategoryController;
use App\Controller\AdminProductController;
use App\Controller\AdminSubCategoryController;
use ReflectionClass;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
       $this->requestStack = $requestStack; 
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('price', [$this, 'price']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('active_by_route', [$this, 'activeByRoute']),
            new TwigFunction('active_by_controller', [$this, 'activeByController']),
        ];
    }

    public function activeByRoute($route)
    {
        $currentRoute = $this->requestStack->getCurrentRequest()->get('_route');
        return $currentRoute === $route ? 'active' : '';
        
    }

    public function activeByController($controller)
    {
        $controllers = [
            AdminCategoryController::class,
            AdminSubCategoryController::class,
            AdminProductController::class,
        ];

        $controller = substr($controller, 0, strpos($controller, '::'));
        
        return in_array($controller, $controllers) ? 'active' : '';
        
    }

    /**
     * filtre pour formater les prix
     *
     * @param float $price
     * @param string|null $currency
     * @param integer|null $decimals
     * @return string
     */
    public function price(float $price, ?string $currency = 'KMF', ?int $decimals = 0): string
    {
        return number_format($price, $decimals, ',', ' '). ' '.$currency;
    }
}
