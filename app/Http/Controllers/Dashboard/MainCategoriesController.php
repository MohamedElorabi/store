<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{

    public function index()
    {
       $categories = Category::whereNull('parent_id')->paginate(PAGINATION_COUNT);
        return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('dashboard.categories.create');

    }


    public function store(MainCategoryRequest $request)
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

            return redirect()->route('admin.maincategories')->with(['success', 'تم الإضافة بنجاح']);


            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error', 'حدث خطأ ما']);
        }
    }



    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category)
            return redirect()->route('admin.maincategories')->with(['error', 'هذا القسم غير موجود']);
        return view('dashboard.categories.edit', compact('category'));
    }


    public function update(MainCategoryRequest $request, $id)
    {
        try {

            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::find($id);

            if(!$category)
                return redirect()->route('admin.maincategories')->with(['error', 'هذا القسم غير موجود']);

            $category->update($request->all());

            // save translation
            $category->name = $request->name;
            $category->save();

            return redirect()->route('admin.maincategories')->with(['success', 'تم التحديث بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.maincategories')->with(['error', 'حدث خطأ ما']);
        }
    }


    public function destroy($id)
    {
        try {

        $category = Category::fnd($id);
        if(!$category)
            return redirect()->route('admin.maincategories')->with(['error', 'هذا القسم غير موجود']);

        $category->delete();
        return redirect()->route('admin.maincategories')->with(['success', 'تم الحذف بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.maincategories')->with(['error', 'حدث خطأ ما']);
        }
    }

}
