<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandsController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);
        return view('dashboard.brands.index', compact('brands'));
    }


    public function create()
    {
        return view('dashboard.brands.create');

    }


    public function store(BrandRequest $request)
    {

        try {

            DB::beginTransaction();
            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            $fileName = "";
            if($request->has('photo'))
            {
                $fileName = uploadImage('brands', $request->photo);
            }

            $brand = Brand::create($request->except('_token', 'photo'));
            // save translation
            $brand->name = $request->name;
            $brand->phto = $fileName;
            $brand->save();

            return redirect()->route('admin.brands')->with(['success', 'تم الإضافة بنجاح']);


            DB::commit();
        } catch (\Exception $ex) {

            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error', 'حدث خطأ ما']);
        }
    }



    public function edit($id)
    {
        $brand = Brand::find($id);
        if(!$brand)
            return redirect()->route('admin.brands')->with(['error', 'هذا القسم غير موجود']);
        return view('dashboard.brands.edit', compact('brand'));
    }


    public function update(BrandRequest $request, $id)
    {
        try {

            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $brand = Brand::find($id);

            if(!$brand)
                return redirect()->route('admin.brands')->with(['error', 'هذا القسم غير موجود']);

            $brand->update($request->all());

            // save translation
            $brand->name = $request->name;
            $brand->save();

            return redirect()->route('admin.brands')->with(['success', 'تم التحديث بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.brands')->with(['error', 'حدث خطأ ما']);
        }
    }


    public function destroy($id)
    {
        try {

            $brand = Brand::fnd($id);
            if(!$brand)
                return redirect()->route('admin.brands')->with(['error', 'هذا القسم غير موجود']);

            $brand->delete();
            return redirect()->route('admin.brands')->with(['success', 'تم الحذف بنجاح']);

        } catch (\Exception $ex){

            return redirect()->route('admin.brands')->with(['error', 'حدث خطأ ما']);
        }
    }
}
