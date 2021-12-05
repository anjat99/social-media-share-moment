<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\InsertLocationRequest;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LocationController extends AdminController
{

    public function index()
    {
        $this->data["locations"] =  Location::all();
        return view('admin.pages.locations.index', $this->data);
    }

    public function getAll()
    {
        $this->data["apiLocations"] = Location::all();
        return response()->json($this->data);
    }

    public function create()
    {
        return view('admin.pages.locations.add',$this->data);
    }

    public function store(InsertLocationRequest $request)
    {
        try{
            $location = new Location();
            $location->name = $request->locationName;

            $location->save();
            return redirect()->route('locations-manage.index')->with('successInsertLocation', 'Location created successfully!');
        }catch (\Exception $e){
            return redirect()->route('locations-manage.create' )->with('errorInsertLocation', $e->getMessage());
        }
    }
}
