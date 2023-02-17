<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\TagsRequest;
use App\Models\Brand;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index()
    {
        $tag = Tag::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.tags.index', compact('tag'));
    }


    public function create()
    {
        return view('dashboard.tags.create');

    }


    public function store(TagsRequest $request)
    {

        try {

            DB::beginTransaction();

            $brand = Brand::create(['slug' => $request->slug]);
            // save translation
            $brand->name = $request->name;
            $brand->save();

            return redirect()->route('admin.tags')->with(['success', 'تم الإضافة بنجاح']);


            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error', 'حدث خطأ ما']);
        }
    }



    public function edit($id)
    {
        $tag = Tag::find($id);
        if(!$tag)
            return redirect()->route('admin.tags')->with(['error', 'هذه العلامة غير موجودة']);
        return view('dashboard.tags.edit', compact('tag'));
    }


    public function update(TagsRequest $request, $id)
    {
        try {

            $tag = Tag::find($id);
            if(!$tag)
                return redirect()->route('admin.tags')->with(['error', 'هذه العلامة غير موجودة']);

            DB::beginTransaction();


            $tag->update($request->except('_token', 'id'));

            // save translation
            $tag->name = $request->name;
            $tag->save();

            DB::commit();
            return redirect()->route('admin.tags')->with(['success', 'تم التحديث بنجاح']);

        } catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error', 'حدث خطأ ما']);
        }
    }


    public function destroy($id)
    {
        try {

            $tag = Tag::fnd($id);
            if(!$tag)
                return redirect()->route('admin.tags')->with(['error', 'ةهذه العلامة غير موجود']);

            $tag->delete();
            return redirect()->route('admin.tags')->with(['success', 'تم الحذف بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.tags')->with(['error', 'حدث خطأ ما']);
        }
    }
}
