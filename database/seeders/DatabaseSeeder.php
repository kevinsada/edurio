<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //inserts 1m records in less than a minute;
        for ($i = 1; $i <= 10; $i++) {
            Question::create([
                'question' => substr(fake()->realText, 0, -1) . ' ?',
                'question_type' => $i != 10 ? 'graph' : 'free_text'
            ]);

            $answers = [];

            for ($j = 1; $j <= 100000; $j++) {
                $answers[] = [
                    'question_id' => $i,
                    'answer' => $i == 10 ? fake()->realText : null,
                    'scalar_value' => $i == 10 ? null : rand(0, 5),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            $chunks = collect($answers)->chunk(10000);
            foreach ($chunks as $chunked) {
                Answer::insert($chunked->toArray());
            }
        }
    }
}
