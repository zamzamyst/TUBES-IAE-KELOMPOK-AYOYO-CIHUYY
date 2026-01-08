<?php

namespace App\GraphQL\Mutations;

use App\Models\Menu;

class DeleteMenu
{
    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function __invoke($_, array $args): bool
    {
        $menu = Menu::findOrFail($args['id']);
        return $menu->delete();
    }
}
