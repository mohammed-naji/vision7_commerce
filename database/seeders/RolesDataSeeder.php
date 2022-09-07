<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $ability = [
        'all_categories' => 'All Categories',
        'single_category' => 'Show Single Category',
        'add_category' => 'Add new category',
        'delete_category' => 'Delete Category',
        'edit_category' => 'Edit Category',
        'all_products' => 'All Products',
        'single_product' => 'Show Single Product',
        'add_product' => 'Add new Product',
        'delete_product' => 'Delete Product',
        'edit_product' => 'Edit Product',
    ];

    public function run()
    {
        $data = [
            ['name' => 'Super Admin'],
            ['name' => 'Category Manager'],
            ['name' => 'Product Manager']
        ];
        Role::insert($data);

        foreach($this->ability as $code => $name) {
            Ability::create([
                'name' => $name,
                'code' => $code
            ]);
        }


    }
}
