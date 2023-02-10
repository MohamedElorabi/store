<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{

    public function index()
    {
       $categories = Category::whereNotNull('parent_id')->paginate(PAGINATION_COUNT);
        return view('dashboard.sub_categories.index', compact('categories'));
    }


    public function create()
    {
        $categories = Category::whereNull('parent_id')->orderBy('id', 'DESC')->get();
        return view('dashboard.sub_categories.create', compact('categories'));

    }


    public function store(SubCategoryRequest $request)
    {

        try {

            DB::beginTransaction();
            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));
            // save translation
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.subcategories')->with(['success', 'تم الإضافة بنجاح']);


            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            return redirect()->route('admin.subcategories')->with(['error', 'حدث خطأ ما']);
        }
    }



    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category)
            return redirect()->route('admin.subcategories')->with(['error', 'هذا القسم غير موجود']);
        $categories = Category::whereNull('parent_id')->orderBy('id', 'DESC')->get();

        return view('dashboard.sub_categories.edit', compact('category', 'categories'));
    }


    public function update(SubCategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);
            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            if(!$category)
                return redirect()->route('admin.sub_categories')->with(['error', 'هذا القسم غير موجود']);

            $category->update($request->all());

            // save translation
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.sub_categories')->with(['success', 'تم التحديث بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.subcategories')->with(['error', 'حدث خطأ ما']);
        }
    }


    public function destroy($id)
    {
        try {

        $category = Category::fnd($id);
        if(!$category)
            return redirect()->route('admin.subcategories')->with(['error', 'هذا القسم غير موجود']);

        $category->delete();
        return redirect()->route('admin.subcategories')->with(['success', 'تم الحذف بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.subcategories')->with(['error', 'حدث خطأ ما']);
        }
    }

}
