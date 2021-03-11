<?php

namespace App\Http\Controllers\admin;

use App\Models\Posts;
use App\Models\PostsFile;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends BaseController
{
    public function index()
    {
        return view('admin.posts.index');
    }

    public function getQueries(Builder $builder)
    {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }

    public function postslist(Request $request)
    {
        DB::statement(DB::raw('set @rownum=0'));
        $data = Posts::with('attachFiles')
            ->select(DB::raw('@rownum  := @rownum  + 1 AS rownum'), 'posts.*')
            ->where('use_yn', 'Y')
            ->where('noti', 'N')
            ->latest()
            ->get();

        return Datatables::of($data)
            ->with('noti', function () use ($data) {
                return Posts::with('attachFiles')
                    ->where('noti', 'Y')
                    ->where('use_yn', 'Y')
                    ->limit(5)
                    ->latest()->get();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function postinfo(Request $request)
    {
        return Posts::with('attachFiles')->find($request->id);
    }

    public function postupdate(Request $request)
    {
        $messages = [
            'noti.*' => '고정 유무를 선택해주세요.',
            'title.*' => '제목을 입력해주세요.',
            'body.*' => '내용을 입력해주세요.',
            'select_attach.*.max' => '20메가 이하만 업로드 가능합니다.',
            'select_attach.*.mimes' => '이미지 및 문서만 업로드 가능합니다.',
        ];

        $validatedData = $request->validate([
            'noti' => 'required|in:Y,N',
            'title' => 'required',
            'body' => 'required',
            'select_attach.*' => 'nullable|mimes:jpeg,jpg,gif,bmp,png,zip,pdf,doc,docx,hwp,csv,txt,xlsx,xls,pptx|max:20480',
        ], $messages);

        if (!empty($request->id)) {
            $post = Posts::findOrFail($request->id);
            $msg = "수정되었습니다.";
            $isupdate = true;
        } else {
            $msg = "등록되었습니다.";
            $isupdate = false;
        }

        if ($validatedData['noti'] == 'Y'){
            $noti_count = Posts::where([
                'use_yn'=>'Y',
                'noti'=>'Y',
            ])->count();
            if($noti_count >= 5) return response()->json(['errors' => ['parameter' => ['고정글은 5개 까지만 가능합니다.']]], 422);
        }

        $dom = new \DOMDocument();
        @$dom->loadHtml('<?xml encoding="utf-8"?>' . $validatedData['body'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOXMLDECL);
        $dom->encoding = 'utf-8';
        $images = $dom->getElementsByTagName('img');
        $images_arr = [];
        foreach ($images as $img) {
            array_push($images_arr, $img->getAttribute('src'));
        }

        $storage = Storage::disk('public');
        $path = 'post/' . Carbon::now()->format('ymd') . '/';

        try {
            if (count($images) > 0) {
                foreach ($images as $k => $img) {
                    $image_64 = $img->getAttribute('src');
                    if (strpos($image_64, ';base64')) {
                        $image_data_aux = explode(';base64', $img->getAttribute('src'));
                        $image_data = $image_data_aux[1];
                        $extension = explode('/', $image_data_aux[0])[1];
                        $imageName = Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $extension;
                        $storage->put($path . $imageName, base64_decode($image_data));
                        $img->removeAttribute('src');
                        $img->setAttribute('src', '/storage/' . $path . $imageName);
                    } else {
                        continue;
                    }
                }
            }

        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $request->all()]], 422);
        }
        $validatedData['body'] = Str::of($dom->saveHTML())->replace('<?xml encoding="utf-8"?>','');

        if ($isupdate) {
            // 기존 이미지 삭제
            $ori_dom = new \DOMDocument();
            @$ori_dom->loadHtml($post->body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $ori_images = $ori_dom->getElementsByTagName('img');

            foreach ($ori_images as $img) {
                if (!in_array($img->getAttribute('src'), $images_arr)) {
                    $file = Str::of($img->getAttribute('src'))->replace('/storage/', '');
                    $this->delfile($file);
                }
            }
            $post->update($validatedData);
        } else {
            $post = Posts::create($validatedData);
        }

        try {
            if ($request->hasFile('select_attach')) {
                $files = $request->file('select_attach');
                foreach ($files as $file) {
                    $filename = $file->getClientOriginalName();
                    $ext = $file->getClientOriginalExtension();
                    $fileNameToStore = Carbon::now()->format('ymdhis') . '_' . Str::random(9) . "." . $ext;
                    $storage->putFileAs($path, $file, $fileNameToStore);
                    $url = $path . $fileNameToStore;
                    PostsFile::create([
                        'posts_id' => $post->id,
                        'url' => $url,
                        'org_name' => $filename,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => ['system' => ['시스템 오류입니다.'], 'e' => $e, 'data' => $request->all()]], 422);
        }

        return response()->json(['result' => "OK", "msg" => $msg]);
    }

    public function postremove(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|numeric',
        ], ['id.*' => '해당 항목이 없습니다.']);

        Posts::find($validatedData['id'])->update([
            'use_yn' => 'N'
        ]);
        return response()->json(['result' => "OK", "msg" => "삭제되었습니다."]);
    }

    public function removeAttach(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'url' => 'required',
        ], ['id.*' => '해당 파일이 없습니다.', 'url.*' => '해당 파일이 없습니다.']);

        $postFile = PostsFile::where([
            'id' => $validatedData['id'],
        ])->first();

        if(empty($postFile)) return response()->json(['errors' => ['parameter' => ['해당 파일이 없습니다.']]], 422);

        $this->delfile($postFile->url);
        PostsFile::where('id', $postFile->id)->delete();

        return response()->json(['result' => "OK", "msg" => "삭제되었습니다."]);
    }

    private function uploadfile($table, $file)
    {
        $this->delfile($table->expo_attachment_file_url);
        $file_extension = $file->getClientOriginalExtension();
        $fileName = Carbon::now()->timestamp . '_' . (Str::random(8)) . '.' . $file_extension;
        Storage::disk('public')->put('expo/' . $fileName, \File::get($file));
        $filePath = $file->storeAs('expo', $fileName, 'public');
        $table->update([
            'expo_attachment_file_url' => $filePath,
        ]);
    }

    private function delfile($path)
    {
        $storage = Storage::disk('public');

        if ($storage->exists($path) && $path !== null) {
            $storage->delete($path);
        }
    }
}
