<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OfficeSpaceResource;
use App\Models\OfficeSpaces;
use Illuminate\Http\Request;

class OfficeSpaceController extends Controller
{
    //
    public function index(){
        $officeSpaces=OfficeSpaces::with(['city'])->get();
        return OfficeSpaceResource::collection($officeSpaces);
    }

    public function show(OfficeSpaces $officeSpace){
        $officeSpace->load(['city','photos','benefits']);
        return new OfficeSpaceResource($officeSpace);
    }
}
