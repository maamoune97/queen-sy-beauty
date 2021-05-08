<?php

namespace App\Twig;

use App\Controller\AdminCategoryController;
use App\Controller\AdminProductController;
use App\Controller\AdminSubCategoryController;
use Exception;
use ReflectionClass;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    const COLOR_ID = [
        "rouge" => "choose-red",
        "noire" => "choose-black",
        "noir" => "choose-black",
        "bleu" => "choose-blue",
        "jaune" => "choose-yellow",
        "blanc" => "choose-white",
        "blanche" => "choose-white",
        "violet" => "choose-violet",
        "violete" => "choose-violet",

    ];

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
            new TwigFilter('color_id', [$this, 'colorId']),
            new TwigFilter('trunc_it', [$this, 'truncIt']),
            new TwigFilter('obj_array_to_str', [$this, 'objArrayToStr']),
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

    /**
     * flltre pour donner l'id du couleur css
     *
     * @param string $color
     * @return string
     */
    public function colorId(string $color): string
    {
        return isset(self::COLOR_ID[strtolower($color)]) ? self::COLOR_ID[strtolower($color)] : self::COLOR_ID['noir'];
    }

    /**
     * Undocumented function
     *
     * @param string $text
     * @param integer|null $limit
     * @param string|null $endword
     * @return string
     */
    public function truncIt(string $text, ?int $limit = 10, ?string $endword): string
    {
        if (strlen($text) > $limit)
        {
            if ($endword)
            {
                $endwordSize = strlen($endword);
                $truncText = substr($text,0,$limit-$endwordSize).$endword;
            }
            else
            {
                $truncText = substr($text,0,$limit);
            }
        }
        else
        {
            $truncText = $text;
        }
        return $truncText;
    }

    /**
     * @param array $objTab
     * @param string $property
     * @param string|null $separator
     * @return string $str
     */
    public function objArrayToStr(array $objTab, string $property, ?string $separator = ','): string
    {
        $tab = [];
        foreach ($objTab as $obj)
        {
            try {
                if ($obj->$property)
                {
                    $tab[] = $obj->$property;
                    continue;
                }
            }
            catch (\Throwable $th)
            {
                $methodPrefixer = ['get', 'has', 'is'];
                $i = 0;
                foreach ($methodPrefixer as $prefixer)
                {
                    $method = $prefixer.ucwords($property);
                    if (method_exists($obj, $method))
                    {
                        $tab[] = $obj->$method();
                        break;
                    }
                    else
                    {
                        if (++$i >= count($methodPrefixer))
                        {
                            $ucProperty = ucwords($property);
                            throw new Exception("Undefined property {$property} or methods get{$ucProperty}(), has{$ucProperty}(), is{$ucProperty}()",500);
                        }
                    }
                }
            }
            
        }
        
        $str = implode($separator, $tab);

        return $str;
    }
}
