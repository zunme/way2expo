<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends AdminbaseController
{
    public function index()
    {
        return view('admin.contact.index');
    }

    public function list(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $data = Contact::select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'contacts.*')
            ->latest()->get();
        return Datatables::of($data)
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
}
