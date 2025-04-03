<?php

namespace Database\Seeders;

use App\Models\Priority;
use App\Models\Role;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $status = Status::factory()->count(3)->create();
        $priorities = Priority::factory()->count(3)->create();
        $roles = Role::factory()->count(3)->create();
        $users = User::factory()->count(20)->create();

        User::factory()->count(20)->make()
            ->each(function($user) use ($roles) {
                $user->save();

                $user->roles()->attach($roles->random()->id);
            });

        Ticket::factory()->count(10)->make()
            ->each(function($ticket) use ($status, $priorities, $users) {
                    $ticket->save();

                    $ticket->user()->attach($users->random()->id);
                    $ticket->assignedTo()->attach($users->random()->id);
                    $ticket->priority()->attach($priorities->random()->id);
                    $ticket->status()->attach($status->random()->id);
            });
    }
}
