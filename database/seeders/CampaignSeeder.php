<?php

namespace Database\Seeders;

use App\Models\Campaign;
use Database\Factories\CampaignFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campaign::factory()->count(50)->create();
    }
}
