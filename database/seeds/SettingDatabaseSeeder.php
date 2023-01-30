<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::setMany([
            'default_local' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'my name' => 'Mohamed Elorabi',
            'supported_currencies' => ['USD','LE','SAR'],
            'default_currency' => 'LE',
            'store_email' => 'admin@store.com',
            'search_engine' => 'mysql',
            'local_shipping_cost' => 0,
            'outer_shipping_cost' => 0,
            'free_shipping_cost' => 0,
            'translatable' => [
                'store_name' => 'متجر متعدد',
                'free_shipping_label' => 'توصيل مجانى',
                'local_label' => 'توصيل داخلى',
                'outer_label' => 'توصيل خارجى',
            ],
        ]);
    }
}
