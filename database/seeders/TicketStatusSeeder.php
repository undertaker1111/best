<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketStatus;

class TicketStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'Open', 'description' => 'Ticket is open and awaiting action.'],
            ['name' => 'In Progress', 'description' => 'Ticket is being worked on.'],
            ['name' => 'Pending', 'description' => 'Ticket is pending further information or action.'],
            ['name' => 'Solved', 'description' => 'Ticket has been solved.'],
            ['name' => 'Closed', 'description' => 'Ticket is closed.'],
        ];
        foreach ($statuses as $status) {
            TicketStatus::firstOrCreate(['name' => $status['name']], $status);
        }
    }
} 