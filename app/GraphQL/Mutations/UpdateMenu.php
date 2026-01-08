<?php

namespace App\GraphQL\Mutations;

use App\Models\Menu;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UpdateMenu
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Menu
     */
    public function __invoke($_, array $args, ?GraphQLContext $context = null, ?ResolveInfo $resolveInfo = null): Menu
    {
        $menu = Menu::findOrFail($args['id']);

        $menu->update([
            'menu_code' => $args['menu_code'] ?? $menu->menu_code,
            'name' => $args['name'] ?? $menu->name,
            'price' => $args['price'] ?? $menu->price,
            'description' => $args['description'] ?? $menu->description,
        ]);

        return $menu;
    }
}
