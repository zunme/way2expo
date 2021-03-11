<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends AdminbaseController
{
    public function showManageCategory()
    {
        $categories = Category::where('parent_id', '=', 0)->display()->get();
        $allCategories = Category::pluck('name', 'id')->all();
        return view('admin.category', compact('categories', 'allCategories'));

    }

    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $input = $request->all();

        if (!empty($input['id'])) {
            $category = Category::find($input['id']);
            $category->name = $input['name'];
            $category->update();
            return response()->json(['result' => "OK", "data" => $input, "msg" => "수정되었습니다."], 200);
        }

        if (empty($input['parent_id'])) {
            $input['parent_id'] = 0;
            $max = Category::max('code1');
            $input['code1'] = (empty($max)) ? "A" : ++$max;
            $input['code2'] = 0;
        } else {
            $input['code1'] = Category::find($input['parent_id'])->code1;
            $code2 = Category::where('parent_id', $input['parent_id'])->max('code2');
            $input['code2'] = (empty($code2)) ? 1 : ++$code2;
        }
        $input['full_code'] = $input['code1'] . sprintf("%02d", $input['code2']);

        $category = Category::create($input);
        return response()->json(['result' => "OK", "data" => $category, "msg" => "추가되었습니다."], 200);

    }

    public function removeCategory(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);
        $input = $request->all();
        $item = Category::find($input['id']);
        if ($item->parent_id < 1) {
            Category::where('parent_id', $item->id)->update(['display_yn' => 'N']);
        }
        $item->update(['display_yn' => 'N']);
        return response()->json(['result' => "OK", "data" => $input, "msg" => "삭제되었습니다."], 200);
    }
}
