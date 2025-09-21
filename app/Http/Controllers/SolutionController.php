<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class SolutionController extends Controller
{
    public function index()
    {
        $solutions = config('solutions.products', []);

        return view('solutions.index', compact('solutions'));
    }

    public function show(string $slug)
    {
        // Fetch products and solutions from config
        $products = config('solutions.products', []);

        // Search for the product by slug
        $product = collect($products)->firstWhere('slug', $slug);

        // If no product is found, abort with 404
        abort_if(!$product, 404);

        // Set sensible defaults in case some fields are missing
        $product = array_merge([
            'title' => 'Product',
            'subtitle' => null,
            'hero_image' => null,
            'video' => null,
            'color' => '',
            'benefits' => [],
            'features' => [],
            'stats' => [],
            'gallery' => [],
            'testimonials' => [],
            'faqs' => [],
            'price_cards' => [],
            'cta' => [
                'primary_text' => 'Get a quote',
                'primary_href' => '#contact',
                'secondary_text' => 'See a demo',
                'secondary_href' => '#contact',
            ],
        ], $product);

        return view('solutions.show', compact('product'));
    }
}