<?php

namespace App\Http\Controllers;

use App\Jobs\AttendanceRecord;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $from = $request->query('from') ?? '';
            $to = $request->query('to') ?? '';
            $user_id = $request->query('user_id') ?? '';
            $reset = $request->query('reset') ?? '';
            if($reset != '') {
                $from = '';
                $to = '';
                $user_id = '';
            }
            $record = Attendance::on('sqlite')->when($from != '', function ($query) use ($from) {
                $query->whereDate('created_at', '>=', $from);
            })
            ->when($to != '', function ($query) use ($to) {
                $query->whereDate('created_at', '<=', $to);
            })
            ->when($user_id != '', function ($query) use($user_id){
                $query->where('user_id', $user_id);
            })
            ->when($from == '' && $to == '', function ($query) {
                $query->whereDate('created_at', today());
            })
            ->orderBy('attendance_timestamp','DESC')
            ->paginate(10)
            ->appends($request->query());
            return view('welcome', ['record' => $record,'from'=>$from,'to'=>$to,'user_id'=>$user_id]);
        } catch (\Exception $e) {
            Log::error('Error fetching records: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage(),'tables' => Schema::connection('sqlite')->getAllTables()], 500);
        }
    }
}
