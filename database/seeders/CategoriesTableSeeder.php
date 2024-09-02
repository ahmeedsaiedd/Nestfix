<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'مشكلة فواتير',
            'مشكله خدمات اتصالات',
            'شاشه سوداء',
            'مشكلة الحساب/تسجيل الدخول',
            'مشكلة كروت كهرباء',
            'خدمه غير موجوده بالسيستم',
            'مشكلة اقساط و قروض',
            'مشكله في خدمات التبرعات',
            'مشكله ب خدمات الحج و العمره',
            'others'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert(['name' => $category]);
        }
    }
}
