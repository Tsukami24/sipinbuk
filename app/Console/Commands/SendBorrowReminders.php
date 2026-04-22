<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use App\Notifications\UserNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendBorrowReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:borrow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send borrow reminders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $borrows = Borrow::where('status', 'active')
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDay())
            ->get();

        foreach ($borrows as $borrow) {

            $due = \Carbon\Carbon::parse($borrow->due_date);

            $diff = now()->diffInMinutes($due, false);

            $reminders = [
                'h1'  => 1000,  
                'h5h' => 300,
                'h1h' => 60,
                'm30' => 30,
                'm15' => 15,
                'm5'  => 5,
            ];

            $tolerances = [
                'h1'  => 60,
                'h5h' => 30,
                'h1h' => 30,
                'm30' => 15,
                'm15' => 10,
                'm5'  => 5,
            ];

            foreach ($reminders as $type => $target) {
                $tolerance = $tolerances[$type] ?? 5;

                // Cek apakah saat ini dalam rentang tolerance dari target
                if ($diff >= ($target - $tolerance) && $diff <= ($target + $tolerance)) {

                    $log = DB::table('notification_logs')->firstOrCreate(
                        ['borrow_id' => $borrow->id, 'reminder_type' => $type],
                        ['reminder_type' => $type]
                    );

                    if ($log->wasRecentlyCreated) {
                        $borrow->user->notify(new UserNotification([
                            'type' => 'reminder',
                            'title' => 'Pengingat Pengembalian',
                            'message' => match ($type) {
                                'h1'  => 'Pengembalian H-1 hari lagi',
                                'h5h' => 'Pengembalian 5 jam lagi',
                                'h1h' => 'Pengembalian 1 jam lagi',
                                'm30' => 'Pengembalian 30 menit lagi',
                                'm5'  => 'Pengembalian 5 menit lagi',
                                'm1'  => 'Pengembalian 1 menit lagi',
                            },
                            'borrow_id' => $borrow->id,
                        ]));

                        Log::info("Reminder sent for borrow {$borrow->id} ({$type}): " . $borrow->user->name);
                    }
                }
            }
        }
        $this->info('COMMAND JALAN');
        $this->info('TOTAL BORROW: ' . $borrows->count());
    }
}
