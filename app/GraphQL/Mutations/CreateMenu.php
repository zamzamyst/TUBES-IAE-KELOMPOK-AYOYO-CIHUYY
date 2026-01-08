<?php

namespace App\GraphQL\Mutations;

use App\Models\Menu;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateMenu
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Menu
     */
    public function __invoke($_, array $args, ?GraphQLContext $context = null, ?ResolveInfo $resolveInfo = null): Menu
    {
        // Explicitly specify the connection to use
        $menu = Menu::create([
            'menu_code' => $args['menu_code'],
            'name' => $args['name'],
            'price' => $args['price'],
            'description' => $args['description'],
        ]);

        return $menu;
    }
}
