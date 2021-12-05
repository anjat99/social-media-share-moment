<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\admin\InsertLocationRequest;
use App\Models\Location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LocationController extends FrontendController
{
    public function index(Request $request)
    {
        $this->data["locations"] =  Location::all();
        return view('frontend.pages.locations.index', $this->data);
    }

    public function create()
    {
        return view('frontend.pages.locations.add', $this->data);
    }

    public function store(InsertLocationRequest $request)
    {
        try{
            $location = new Location();
            $location->name = $request->locationName;

            $location->save();
            return redirect()->route('locations.index')->with('successInsertLocation', 'Location created successfully!');
        }catch (\Exception $e){
            return redirect()->route('locations.create' )->with('errorInsertLocation', $e->getMessage());
        }
    }
}
