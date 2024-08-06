<?php

namespace App\Jobs;

use App\Models\attendance;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Jmrashed\Zkteco\Lib\ZKTeco;

class AttendanceRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $zk = new ZKTeco('192.168.18.25');
        $connected = $zk->connect();
        $version = $zk->getAttendance();
        $todaysAttendance = array_filter($version, function ($record) {
            return Carbon::parse($record['timestamp'])->format('Y-m-d') == now()->format('Y-m-d');
        });
        $attendance_data = [];
        foreach($todaysAttendance as $row) {
            $new_arr = [];
            $new_arr['user_id'] = $row['id'];
            $new_arr['state'] = $row['state'];
            $new_arr['type'] = $row['type'];
            $new_arr['attendance_timestamp'] = $row['timestamp'];
            $attendance_data[] = $new_arr;
        }
        $chunks = collect($attendance_data)->chunk(25);
        foreach($chunks as $chunk) {
            foreach($chunk as $row) {
                Attendance::on('sqlite')->UpdateOrCreate(
                    [
                        'user_id' => $row['user_id'],
                        'attendance_timestamp' => $row['attendance_timestamp'],
                        'type' => $row['type'],
                    ],
                    [
                        'state' => $row['state'],
                    ]
                );
            }
        }
        $response = Http::post('https://remitchoice.work/api/employee/attendance', ['attendance_data' =>$attendance_data]);
    }
}
