<?php

namespace App\Http\Controllers;

use App\Models\Mobile;
use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sales::with('mobile')->get();
        return response()->json($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sales = new Sales();
        $sales->mobile_id = $request->mobile_id;
        $sales->quantity = $request->quantity;
        $mobile = Mobile::findOrFail($request->mobile_id);
        $sales->amount = $mobile->price * $request->quantity;
        $sales->save();

        return response()->json($sales, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sales::with('mobile')->find($id);
        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }
        return response()->json($sale);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sales::find($id);
        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }
        $sale->delete();
        return response()->json(['message' => 'Sale canceled successfully']);
    }

    /**
     * validates products in the table for stock control.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addMobile(Request $request, $id)
    {
        $sale = Sales::find($id);
        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }
        foreach ($request->mobiles as $mobileId) {
            $sale->mobiles()->attach($mobileId);
        }
        return response()->json(['message' => 'Products added to the sale successfully']);
    }
}