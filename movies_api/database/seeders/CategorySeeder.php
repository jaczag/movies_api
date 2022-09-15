<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'action',
            'anime',
            'biography',
            'kids',
            'teenagers',
            'documentary',
            'educational',
            'adventure',
            'comedy',
            'sport',
            'thriller',
            'horror',
            'romance'
        ];

        foreach ($categories as $category) {
            $cat = new Category();

            switch ($category) {
                case 'action':
                    $pl = 'akcja';
                    break;
                case 'anime':
                    $pl = 'animowany';
                    break;
                case 'biography':
                    $pl = 'biograficzny';
                    break;
                case 'kids':
                    $pl = "dzieci";
                    break;
                case 'teenagers':
                    $pl = 'młodzieżowy';
                    break;
                case 'documentaty':
                    $pl = 'dokumentalny';
                    break;
                case 'educational':
                    $pl = 'edukacyjny';
                    break;
                case 'adventure':
                    $pl = 'przygodowy';
                    break;
                case 'comedy':
                    $pl = 'komedia';
                    break;
                case 'romance':
                    $pl = 'romans';
                    break;
                default:
                    $pl = $category;
            }

            $cat->setTranslation('name', 'en', $category);
            $cat->setTranslation('name', 'pl', $pl);
            $cat->save();
        }
    }
}
