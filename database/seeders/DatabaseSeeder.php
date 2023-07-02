<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Group;
use App\Models\Status;
use App\Models\Timelog;
use App\Models\Todo;
use App\Models\User;
use Database\Factories\CommentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $count = 1;

        echo "Generating groups...\n";
        Group::factory(rand(2,5))->create();

        echo "Generating Statuses...\n";
        Status::factory(rand(2,5))->create();

        echo "Generating Users...\n";
        User::factory(3)->create()->each(function($user) {

            echo "Generating {$user['name']} Todos...\n";
            Todo::factory(rand(5,10))->create([
                'user_id' => $user->id,
            ])->each(function($todo){
                echo "  Generating timelog...\n";
                $finished = $todo->finished ? $todo->finished : rand(0,1);
                Timelog::factory(rand(3,6))->create([
                    'todo_id' => $todo->id,
                    'user_id' => $todo->user_id,
                    'finished' => 1
                ]);
                echo "  Generating comment...\n";
                Comment::factory(rand(5,10))->create([
                    'todo_id' => $todo->id,
                ]);

            });
        });
    }
}
