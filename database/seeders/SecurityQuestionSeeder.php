<?php

namespace Database\Seeders;

use App\Models\User\SecurityQuestion;
use Illuminate\Database\Seeder;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SecurityQuestion::create(['question' => 'What is you favourite colour?']);
        SecurityQuestion::create(['question' => 'What is favourite place to visit?']);
        SecurityQuestion::create(['question' => 'What is your place of birth?']);
    }
}
