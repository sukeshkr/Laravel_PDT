<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Report::select('item_code','item_name','unit','price','sys_stock','phy_stock','difference')->where('branch_id',session('branch')->id)->get();
            return datatables($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.stock-report');
    }
    public function formatOne(Request $request)
    {
        if($request->ajax()) {
            $data = Report::where('branch_id',session('branch')->id)->where('difference','!=',0)->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('batch', 'Batch')
            ->make(true);
        }
        return view('master.stock-upload-format1');

    }
    public function formatTwo(Request $request)
    {
        if($request->ajax()) {
            $data = Report::where('branch_id',session('branch')->id)->get();
            return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('batch', 'Batch')
            ->make(true);
        }
        return view('master.stock-upload-format2');

    }
}
