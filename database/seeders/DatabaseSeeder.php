<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Priority;
use App\Models\Role;
use App\Models\Status;
use App\Models\Ticket;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statuses = Status::factory()->count(3)->create();
        $priorities = Priority::factory()->count(3)->create();
        $roles = Role::factory()->count(3)->create();
        $users = User::factory()->count(20)->create()
            ->each(function ($user) use ($roles) {
                $user->roles()->attach($roles->random()->id);
            });

        Ticket::factory()->count(10)->create([
            'user_id' => $users->random()->id,
            'assigned_to' => $users->random()->id,
            'priority_id' => $priorities->random()->id,
            'status_id' => $statuses->random()->id,
        ])->each(function ($ticket) use ($users) {
            $ticket->messages()->createMany(
                Message::factory()->count(10)->make([
                    'user_id' => $users->random()->id,
                ])->toArray()
            );
        });
    }
}
