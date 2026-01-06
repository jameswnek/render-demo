<?php

namespace Database\Seeders;

use App\Models\Quote;
use Illuminate\Database\Seeder;

class QuoteSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if quotes already exist (idempotent)
        if (Quote::count() > 0) {
            return;
        }

        $quotes = [
            ['content' => 'The only way to do great work is to love what you do.', 'author' => 'Steve Jobs'],
            ['content' => 'Innovation distinguishes between a leader and a follower.', 'author' => 'Steve Jobs'],
            ['content' => 'Stay hungry, stay foolish.', 'author' => 'Steve Jobs'],
            ['content' => 'The future belongs to those who believe in the beauty of their dreams.', 'author' => 'Eleanor Roosevelt'],
            ['content' => 'It is during our darkest moments that we must focus to see the light.', 'author' => 'Aristotle'],
            ['content' => 'The best time to plant a tree was 20 years ago. The second best time is now.', 'author' => 'Chinese Proverb'],
            ['content' => 'Your time is limited, don\'t waste it living someone else\'s life.', 'author' => 'Steve Jobs'],
            ['content' => 'The only impossible journey is the one you never begin.', 'author' => 'Tony Robbins'],
        ];

        foreach ($quotes as $quote) {
            Quote::create($quote);
        }
    }
}

