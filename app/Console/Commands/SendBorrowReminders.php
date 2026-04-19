<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use App\Notifications\UserNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $borrows = Borrow::where('status', 'active')->get();

        foreach ($borrows as $borrow) {

            $due = \Carbon\Carbon::parse($borrow->due_date);

            $diff = now()->diffInMinutes($due, false);

            $reminders = [
                'h1'  => 1000,  // ~16-17 jam
                'h5h' => 300,
                'h1h' => 60,
                'm30' => 30,
                'm15' => 15,
                'm5'  => 5,
            ];

            $tolerances = [
                'h1'  => 720,  // 24 jam ± 720 menit (12 jam) - range 12-36 jam sebelum due
                'h5h' => 180,  // 5 jam ± 180 menit (3 jam)
                'h1h' => 60,   // 1 jam ± 60 menit (1 jam)
                'm30' => 30,   // 30 menit ± 30 menit
                'm15' => 15,   // 15 menit ± 15 menit
                'm5'  => 5,    // 5 menit ± 5 menit
            ];

            foreach ($reminders as $type => $target) {
                $tolerance = $tolerances[$type] ?? 5;

                // Cek apakah saat ini dalam rentang tolerance dari target
                if ($diff >= ($target - $tolerance) && $diff <= ($target + $tolerance)) {

                    // Cek apakah notifikasi sudah pernah dikirim ke user ini
                    $exists = DB::table('notifications')
                        ->where('notifiable_type', 'App\Models\User')
                        ->where('notifiable_id', $borrow->user_id)
                        ->where('type', 'reminder')
                        ->whereRaw("JSON_EXTRACT(data, '$.type') = ?", [$type])
                        ->whereRaw("JSON_EXTRACT(data, '$.borrow_id') = ?", [$borrow->id])
                        ->exists();

                    if ($exists) continue;

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
                }
            }
        }
        $this->info('COMMAND JALAN');
        $this->info('TOTAL BORROW: ' . $borrows->count());
    }
}
