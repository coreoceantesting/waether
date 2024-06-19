<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\YearlyData;
use DB;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $req)
    {
        if($req->ajax())
        {
            $yearly_data = DB::table('yearly_data');

            return DataTables::of($yearly_data)
                    ->addIndexColumn()
                    ->editColumn('date', function ($data) {
                        return date('d-m-Y', strtotime($data->date));
                    })
                    ->editColumn('time', function ($data) {
                        return date('h:i A', strtotime($data->time));
                    })
                    ->toJson();
        }
        return view('admin.dashboard');
    }

    public function status_update(Request $request)
    {
           $updatestatus = [
            'status' => '0',
            ];

            $changeStatus=DB::table('visitor')
            ->where('id',$request->id)
            ->update($updatestatus);

        return redirect()->back()->with('success','Status Change Successfully');
    }

    public function edit($id){
        $hightide = YearlyData::find($id);
        // return $hightide;
        return view('admin.hightide.edit')->with(['hightide' => $hightide]);
    }

    public function update(Request $req){
        $hightide = YearlyData::find($req->id);
        $hightide->date = $req->date;
        $hightide->time = $req->time;
        $hightide->height = $req->height;
        $hightide->message = $req->message;
        if($hightide->save()){
            return redirect('/admin/dashboard')->with(['status' => "Hightide updated successfully"]);
        }
    }

    public function delete(Request $req){
        $hightide = YearlyData::find($req->id);

        if($hightide->delete()){
            return redirect('/admin/dashboard')->with(['status' => "Hightide removed successfully"]);
        }
    }

}