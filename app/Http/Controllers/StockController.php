<?php

namespace App\Http\Controllers;

use App\Models\Import;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StockController extends Controller
{
    public function index()
    {
        return view('master.stock-create');
    }
    public function stockCreate(Request $request)
    {
        $validator = Validator::make($request->all(),[

            'itemcode'=> 'required|min:2|max:20',
            'itemname'=> 'required',
            'unit'=> 'required',
            'price'=> 'required',
            'system_stock'=> 'required',
            'phy_stock'=> 'required|integer',
        ]);
        if($validator->fails()) {

            return redirect()->back()->withErrors($validator,'stock_error');

        }
        else {

            if(DB::table('stock_taking')->where('branch_id',session('branch',1)->id)->where('item_code',$request->itemcode)->exists()) {

                $stock = Stock::where('branch_id',session('branch',1)->id)->where('item_code',$request->itemcode)->first();
                $stock->phy_stock  = ($stock->phy_stock + $request->phy_stock);
                $stock->difference = ($stock->phy_stock - $stock->sys_stock);
                $stock->save();
            }
            else{
                $stock = Stock::create([
                    'item_code' => $request->itemcode,
                    'item_name' => $request->itemname,
                    'unit' => $request->unit,
                    'price' => $request->price,
                    'phy_stock' => $request->phy_stock,
                    'sys_stock' => $request->system_stock,
                    'difference' => ($request->phy_stock - $request->system_stock),
                    'branch_id' => session('branch',1)->id,
                ]);
            }
            return redirect()->back()->with('success','Created Sucessfully');
        }

    }

    public function stockTakenList()
    {
        return view('master.taken-list');

    }

    public function fetch(Request $request)
    {
        $col_order = ['item_code','item_name','unit','price','difference'];
        $total_data = Stock::where('branch_id',session('branch',1)->id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value'))) {
            $post = Stock::where('branch_id',session('branch',1)->id)->offset($start)->limit($limit)->orderBy($order,$dir)->get();
            $total_filtered = Stock::where('branch_id',session('branch',1)->id)->count();
        }
        else {
            $search = $request->input('search.value');
            $post = Stock::where('id','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_code','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_name','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('unit','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $total_filtered = Stock::where('id','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_code','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_name','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('unit','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->count();
        }
        $data = array();
        if($post) {
            $slno=1;
            foreach($post as $row) {
                $dataedit =  route('stock.edit',Crypt::encryptString($row->id));
                $nest['slno'] = $slno++;
                $nest['item_code'] = $row->item_code;
                $nest['item_name'] = $row->item_name;
                $nest['unit'] = $row->unit;
                $nest['price'] = $row->price;
                $nest['sys_stock'] = $row->sys_stock;
                $nest['phy_stock'] = $row->phy_stock;
                $nest['difference'] = $row->difference;
                $nest['actions'] = "<a href='{$dataedit}' class='btn btn-primary btn-sm'><i class='fa fa-edit' aria-hidden='true'></i></a>
                <a data-toggle='modal' data-id='{$row->id}' data-target='#del-modal' class='btn btn-danger btn-sm' href='#'><i class='fa  fa-trash' aria-hidden='true'></i></a>";

                $data[]=$nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal'=>intval($total_data),
            'recordsFiltered'=>intval($total_filtered),
            'data'=>$data,
        );
        echo json_encode($json);

    }

    public function stockEdit($id)
    {
        $data = Stock::where('id',Crypt::decryptString($id))->first();
        return view('master.stock-edit',compact('data'));
    }

    public function stockUpdate(Request $request)
    {
        $request->validate([
            'item_code'=>'required',
            'phy_stock'=>'required',
        ]);
        $id = $request->id;

        $item_code = $request->item_code;
        $phy_stock = $request->phy_stock;
        $newDifference = ($phy_stock - $request->sys_stock);

        Stock::where('id',$id)->update([
            'item_code' => $item_code,
            'phy_stock' => $phy_stock,
            'difference' => $newDifference,
        ]);
        return redirect()->route('taken.list')->with('success','Updated Successfully');
    }

    public function stockDelete(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->rowid;
            $res = Stock::destroy($id);
            return $res;
        }
    }



    public function ImportList()
    {
        return view('master.import-list');

    }

    public function importFetch(Request $request)
    {
        $col_order = ['id'];
        $total_data = Import::where('branch_id',session('branch',1)->id)->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value'))) {
            $post = Import::where('branch_id',session('branch',1)->id)->offset($start)->limit($limit)->orderBy($order,$dir)->get();
            $total_filtered = Import::where('branch_id',session('branch',1)->id)->count();
        }
        else {
            $search = $request->input('search.value');
            $post = Import::where('id','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_code','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_name','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('unit','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $total_filtered = Import::where('id','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_code','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('item_name','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->orWhere('unit','like',"%{$search}%")
            ->where('branch_id',session('branch',1)->id)
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->count();
        }
        $data = array();
        if($post) {
            $slno=1;
            foreach($post as $row) {
                $dataedit =  route('upload.edit',Crypt::encryptString($row->id));
                $nest['slno'] = $slno++;
                $nest['item_code'] = $row->item_code;
                $nest['item_name'] = $row->item_name;
                $nest['unit'] = $row->unit;
                $nest['price'] = $row->price;
                $nest['stock'] = $row->stock;
                $nest['actions'] = "<a href='{$dataedit}' class='btn btn-primary btn-sm'><i class='fa fa-edit' aria-hidden='true'></i></a>
                <a data-toggle='modal' data-id='{$row->id}' data-target='#del-modal' class='btn btn-danger btn-sm' href='#'><i class='fa  fa-trash' aria-hidden='true'></i></a>";

                $data[]=$nest;
            }
        }
        $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal'=>intval($total_data),
            'recordsFiltered'=>intval($total_filtered),
            'data'=>$data,
        );
        echo json_encode($json);
    }

    public function uploadEdit($id)
    {
        $data = Import::where('id',Crypt::decryptString($id))->first();
        return view('master.upload-edit',compact('data'));
    }
    public function uploadUpdate(Request $request)
    {
        $request->validate([
            'item_code'=>'required',
            'stock'=>'required',
        ]);
        $id = $request->id;
        $item_code = $request->item_code;
        $stock = $request->stock;
        Import::where('id',$id)->update([
            'item_code' => $item_code,
            'stock'     => $stock,
        ]);
        return redirect()->route('import.list')->with('success','Updated Successfully');
    }
    public function uploadDelete(Request $request)
    {
        if ($request->ajax()) {

            $id = $request->rowid;
            $res = Import::destroy($id);
            return $res;
        }
    }
    public function selectData(Request $request) {

        if ($request->ajax()) {

            $id = $request->rowid;
            $data = Import::where('item_code',$id)->get();
            $exist = Stock::select('phy_stock')->where('branch_id',session('branch',1)->id)->where('item_code',$id)->first();
            if(isset($exist->phy_stock)) {

                $exists = $exist->phy_stock;
            }
            else {
                $exists = 0;
            }
            $json = array(

            'exists' => $exists,
            'data'=>$data,
            );

            return $json;

        }

    }
    public function manualSearch(Request $request) {

        if(!empty(trim($_GET['search']))) {

            $string = Str::of($request->search)->lower()->trim();
            $result = Import::where('branch_id',session('branch',1)->id)->where('item_code','LIKE','%'.$string.'%')->orWhere('item_name','LIKE','%'.$string.'%')->get();

            echo '<ul class="search-drop-ab">';
            foreach ($result as $rs) {

                $data = "'".$rs['item_code'].','.$rs['item_name'].','.$rs['unit'].','.$rs['price'].','.$rs['stock']."'";
                echo '<li  onclick="fill('.$data.')"><a href="#">'.$rs['item_name'].' | QR:'.$rs['price'].'</a></li>';
            }

            echo '</ul>';
        }
        else{
            return "Please Enter a Value";
        }
    }
    public function chechExistence() {

        if(!empty($_GET['search'])) {

            $search = Str::of($_GET['search'])->lower()->trim();
            $exist = Stock::select('phy_stock')->where('branch_id',session('branch',1)->id)->where('item_code',$_GET['search'])->first();
            if(isset($exist->phy_stock)) {

                $exists = $exist->phy_stock;
            }
            else {
                $exists = 0;
            }
            return $exists;
        }
        else{
            return "Please Enter a Value";
        }
    }

    public function destroyStock()
    {
        Stock::where('branch_id',session('branch',1)->id)->delete();
        return redirect()->back()->with('success','All Taken data deleted sucessfully');
    }
    public function destroyUpload()
    {
        Import::where('branch_id',session('branch',1)->id)->delete();
        return redirect()->back()->with('success','All Imported data deleted sucessfully');
    }
    public function dataSettings()
    {
        return view('user.data-setting');
    }

    public function trashStock()
    {
        Stock::truncate();
        return redirect()->back()->with('success','All Stock Taken data deleted sucessfully');
    }
    public function trashUpload()
    {
        Import::truncate();
        return redirect()->back()->with('success','All Imported data deleted sucessfully');
    }
}
