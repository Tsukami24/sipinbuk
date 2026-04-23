<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use Illuminate\Console\Command;

class UpdateBorrowStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-borrow-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Borrow::where('status', 'active')
            ->whereDate('due_date', '<', now())
            ->update([
                'status' => 'overdue'
            ]);

        return 0;
    }
}
