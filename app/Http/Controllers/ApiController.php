<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use App\Calc;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function getusers(Request $request)
    {
        $users = User::all();
        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function removeuser(Request $request, $id)
    {
        if (Auth::user()->role == 1) {
            User::find($id)->delete();
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'failed'
            ]);
        }
    }

    public function getcalcs(Request $request)
    {
        $calcs = Calc::all();
        return response()->json([
            'status' => 'success',
            'data' => $calcs
        ]);
    }

    public function getcalc(Request $request, $id)
    {
        $calc = Calc::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $calc
        ]);
    }

    public function removecalc(Request $request, $id)
    {
        if (Auth::user()->role == 1) {
            Calc::find($id)->delete();
            return response()->json([
                'status' => 'success'
            ]);
        } else {
        }
    }

    public function savecalc(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'data' => 'required'
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 200);
        }

        $calc = new Calc();
        $calc->name = $request['name'];
        $calc->description = $request['description'];
        $calc->json = json_encode($request['data']);
        $calc->save();
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function editcalc(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'data' => 'required'
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 200);
        }

        $calc = Calc::find($request['id']);
        $calc->name = $request['name'];
        $calc->description = $request['description'];
        $calc->json = json_encode($request['data']);
        $calc->save();
        return response()->json([
            'status' => 'success'
        ]);
    }
}
