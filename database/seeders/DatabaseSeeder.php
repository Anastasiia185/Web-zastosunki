<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        $users->each(function ($user) use ($users) {
            $projects = Project::factory(2)->create(['user_id' => $user->id]);

            $projects->each(function ($project) use ($users) {
                $tasks = Task::factory(5)->create([
                    'project_id' => $project->id,
                    'author_id' => $project->user_id,
                    'assigned_to' => $users->random()->id,
                ]);

                $tasks->each(function ($task) use ($users) {
                    Comment::factory(rand(2, 3))->create([
                        'task_id' => $task->id,
                        'user_id' => $users->random()->id,
                    ]);
                });
            });
        });
    }
}