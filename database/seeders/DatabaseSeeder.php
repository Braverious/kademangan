<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChatbotSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            UserSeeder::class,
            LayananSeeder::class,
            SuratSktmSeeder::class
        ]);

        ChatbotSetting::create([
            'key' => 'system_prompt',
            'value' => 'Anda adalah asisten virtual resmi Kelurahan Kademangan...'
        ]);
    }
}
