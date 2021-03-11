<?php

namespace App\Http\Controllers\Admin;

use App\Models\EntryForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EntryFormController extends AdminbaseController
{
    public function index()
    {
        return view('admin.entry.index');
    }

    public function list(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $data = EntryForm::with('expo:id,expo_name')->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'entry_forms.*')
            ->latest()->get();
        return Datatables::of($data)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
