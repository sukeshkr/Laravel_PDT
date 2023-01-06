<?php

namespace App\Http\Controllers;

use App\Exports\ExportReport;
use App\Exports\ExportReportFirst;
use App\Exports\ExportReportSecond;
use App\Imports\ImportData;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function index()
    {
        return view('master.excel-import');

    }
    public function userImport(Request $request) {

        $request->validate([
            'file' => 'required|mimes:csv,xlx,xls,xlsx'
            ]);

        if($request->file()) {
            Excel::import(new ImportData, $request->file('file')->store('files'));
            return back()->with('success','File has uploaded Sucessfully');

        }


    }

    public function exportReport(Request $request)
    {
        return Excel::download(new ExportReport,'stock_report.xlsx');

    }
    public function exportReportForm1(Request $request)
    {
        return Excel::download(new ExportReportFirst,'upload_first_format.xlsx');

    }
    public function exportReportForm2(Request $request)
    {
        return Excel::download(new ExportReportSecond,'upload_second_format.xlsx');

    }

}
