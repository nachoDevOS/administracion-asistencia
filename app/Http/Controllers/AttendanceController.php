<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;
use Illuminate\Support\Facades\Http;

class AttendanceController extends Controller
{
    public function index()
    {  
        return view('adm-attendances.attendances.browse');
    }

    public function list($search = null){
        $user = Auth::user();
        $paginate = request('paginate') ?? 10;
     
        $data = DB::table('attendances')
            ->leftJoin('people', 'attendances.user_id', '=', 'people.ci')
            ->where('people.status', 1)
            ->select(
                'attendances.*',
                DB::raw("COALESCE(CONCAT(people.first_name , ' ', people.middle_name, ' ', people.paternal_surname,' ', people.maternal_surname), 'Sin Nombre') as name")
            )
            ->where(function ($query) use ($search) {

                $query->orWhereDate('attendances.timestamp', '=', $search) // Buscar por fecha
                        ->orWhereTime('attendances.timestamp', '=', $search)
                        ->orWhere(function ($subQ) use ($search) {
                            $subQ->whereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, '')) like ?", ["%$search%"])
                            ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, '')) like ?", ["%$search%"])
                            ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, '')) like ?", ["%$search%"]);
                        });
            })
            ->orderBy('attendances.timestamp', 'desc')

            ->paginate($paginate);

        return view('adm-attendances.attendances.list', compact('data'));        
    }

    public function synchronize()
    {
        $apiKey = env('ZKTeco_API_KEY');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-API-TOKEN' => $apiKey,
        ])->post(setting('clock.url'), [
            'ip' => setting('clock.ip'),
            'port'=> setting('clock.port'),
            'password'=>setting('clock.password')
        ]);


        if ($response->successful()) {
            $data = $response->json();

            foreach ($data['asistencias'] as $record) {
                Attendance::updateOrCreate(
                    ['user_id' => $record['user_id'], 'timestamp' => $record['timestamp']],
                    ['status' => $record['status']]
                    // ['punch' => $record['punch'], 'status' => $record['status']]
                );
            }
            return back()->with(['message' => 'Datos de asistencia sincronizados exitosamente', 'alert-type' => 'success']);
        } else {
            return back()->with(['message' => 'Failed to fetch attendance data.', 'alert-type' => 'error']);
        }
    }




    // public function import(Request $request)
    // {

    //     DB::beginTransaction();
    //     try {
    //         $file = $request->file('file');
    //         Excel::import(new AttendanceImport, $file);
    //         DB::commit();
    //         return redirect()->route('attendances.index')->with(['message' => 'Asistenacia importada exitosamente.', 'alert-type' => 'success']);
    //     } catch (\Throwable $th) {
    //         DB::rollBack();
    //         // return 0;
    //         return redirect()->route('attendances.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
    //     }

    // }
}
