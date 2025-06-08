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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $statuses = collect([
            ['name' => 'En attente'],
            ['name' => 'Ouvert'],
            ['name' => 'Fermé'],
        ])->map(fn ($data) => Status::create($data));

        $priorities = collect([
            ['name' => 'Faible', 'level' => 1],
            ['name' => 'Moyenne', 'level' => 2],
            ['name' => 'Élevée', 'level' => 3],
        ])->map(fn ($data) => Priority::create($data));

        $this->call(RoleAndPermissionSeeder::class);

        $users = User::factory()->count(20)->create();

        $users->each(function (User $user) {
            $roles = ['Admin', 'Support', 'User'];
            $user->assignRole(collect($roles)->random());
        });

        $userCreators = User::role('User')->get();
        $userSupports = User::role('Support')->get();

        Ticket::factory()->count(10)->make()->each(function ($ticket) use ($userCreators, $userSupports, $priorities, $statuses) {
            $ticket->user_id = $userCreators->random()->id;
            $ticket->assigned_to = $userSupports->random()->id;
            $ticket->priority_id = $priorities->random()->id;
            $ticket->status_id = $statuses->random()->id;
            $ticket->save();

            $authors = [$ticket->user_id, $ticket->assigned_to];

            $messages = collect(range(1, 10))->map(function () use ($authors) {
                return Message::factory()->make([
                    'user_id' => collect($authors)->random(),
                ])->toArray();
            });

            $ticket->messages()->createMany($messages->toArray());
        });
    }
}
