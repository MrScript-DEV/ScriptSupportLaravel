<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\Message;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Priority;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statuses = Status::factory()->count(3)->create();
        $priorities = Priority::factory()->count(3)->create();
        $users = User::factory()->count(20)->create();

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

        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleSupport = Role::create(['name' => 'Admin']);
        $roleUser = Role::create(['name' => 'Admin']);
    }
}
