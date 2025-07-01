<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->custom_authorize('browse_people');

        return view('administrations.people.browse');
    }
    
    public function list(){

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;

        $data = Person::where(function($query) use ($search){
                            $query->OrWhereRaw($search ? "id = '$search'" : 1)
                            ->OrWhereRaw($search ? "ci like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "phone like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "first_name like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "middle_name like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "paternal_surname like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "maternal_surname like '%$search%'" : 1)
                        // ->OrWhereRaw($search ? "CONCAT(first_name, ' ', middle_name, ' ', paternal_surname) like '%$search%'" : 1)
                            ->orWhere(function ($subQ) use ($search) {
                                $subQ->whereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, '')) like ?", ["%$search%"])
                                    ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, '')) like ?", ["%$search%"])
                                    ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, '')) like ?", ["%$search%"]);
                            });
                        })
                        ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);

        return view('administrations.people.list', compact('data'));
    }
}
