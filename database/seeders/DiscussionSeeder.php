<?php

namespace Database\Seeders;

use App\Models\DiscussionThread;
use App\Models\ThreadReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $threads = [
            [
                'category' => 'Bean Recommendations',
                'title' => 'Best Ethiopian coffees under $20?',
                'content' => 'I\'m looking for recommendations for Ethiopian coffees that won\'t break the bank. I love fruity, floral notes and bright acidity. What are your favorites?',
            ],
            [
                'category' => 'Brewing Techniques',
                'title' => 'V60 brewing tips for beginners',
                'content' => 'Just got my first V60 and I\'m having trouble getting consistent results. Any tips on grind size, water temp, and pour technique? Share your recipes!',
            ],
            [
                'category' => 'Equipment Reviews',
                'title' => 'Fellow Ode grinder - worth the hype?',
                'content' => 'Thinking about upgrading to the Fellow Ode. Current using a Baratza Encore. Is the upgrade worth it for filter coffee?',
            ],
            [
                'category' => 'Bean Recommendations',
                'title' => 'Looking for low-acid coffees',
                'content' => 'I have a sensitive stomach and need coffee recommendations that are naturally lower in acidity. What origins and processing methods should I look for?',
            ],
            [
                'category' => 'Brewing Techniques',
                'title' => 'Dialing in espresso - how long did it take you?',
                'content' => 'Been trying to dial in my first bag of beans for espresso. How long did it take you to get comfortable with dialing in? Any shortcuts or tips?',
            ],
            [
                'category' => 'Coffee News & Industry',
                'title' => 'New roaster alert: Onyx Coffee Lab expansion',
                'content' => 'Just saw that Onyx is opening a new location in Los Angeles! Anyone been to their other cafes? What should I expect?',
            ],
            [
                'category' => 'Bean Recommendations',
                'title' => 'Best natural process coffees?',
                'content' => 'I absolutely love natural process coffees with those wine-like, fruit-forward flavors. What are your current favorites?',
            ],
            [
                'category' => 'Brewing Techniques',
                'title' => 'Water chemistry - does it really matter?',
                'content' => 'Curious how many of you are paying attention to water chemistry. Are you using Third Wave Water or similar? Notice a big difference?',
            ],
            [
                'category' => 'Regional Communities',
                'title' => 'Seattle coffee scene recommendations',
                'content' => 'Visiting Seattle next month. Besides the obvious spots, what are some hidden gem coffee shops I should check out?',
            ],
            [
                'category' => 'Equipment Reviews',
                'title' => 'Budget espresso machine recommendations',
                'content' => 'Want to get into home espresso but budget is around $500-700. What machines should I be looking at? Is it even possible at this price point?',
            ],
        ];

        $replies = [
            'Great question! I\'d recommend checking out...',
            'I\'ve been using this technique and it works great for me.',
            'Totally agree with the previous comment. Also want to add...',
            'Have you tried adjusting the grind size? That made a huge difference for me.',
            'This is exactly what I was looking for, thanks!',
            'I had the same issue. Here\'s what worked for me:',
            'Not sure I agree with that approach. In my experience...',
            'Adding to this thread because I have the same question!',
            'Update: Tried this and it worked perfectly. Thanks everyone!',
            'Another thing to consider is...',
        ];

        foreach ($threads as $threadData) {
            $thread = DiscussionThread::create([
                'user_id' => $users->random()->id,
                'category' => $threadData['category'],
                'title' => $threadData['title'],
                'content' => $threadData['content'],
                'view_count' => rand(50, 500),
                'created_at' => now()->subDays(rand(1, 30)),
            ]);

            // Add 2-5 replies to each thread
            $numReplies = rand(2, 5);
            for ($i = 0; $i < $numReplies; $i++) {
                ThreadReply::create([
                    'thread_id' => $thread->id,
                    'user_id' => $users->random()->id,
                    'content' => $replies[array_rand($replies)],
                    'is_best_answer' => ($i === 0 && rand(0, 10) > 7), // 30% chance first reply is marked as best
                    'upvotes' => rand(0, 20),
                    'created_at' => $thread->created_at->addHours(rand(1, 48)),
                ]);
            }
        }
    }
}
