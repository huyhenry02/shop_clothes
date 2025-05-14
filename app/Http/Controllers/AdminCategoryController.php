<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminCategoryController extends Controller
{
    public function showIndex(): View
    {
        $categories = Category::paginate(10);
        return view('admin.pages.category.index',
            [
                'categories' => $categories,
            ]);
    }

    public function showCreate(): View
    {
        return view('admin.pages.category.create');
    }

    public function showUpdate(Category $category): View
    {
        return view('admin.pages.category.update',
            [
                'category' => $category,
            ]);
    }

    public function postCategory(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $category = new Category();
            $input = $request->all();
            $lastId = Category::latest('id')->value('id');
            $category->code = 'DM_' . str_pad($lastId + 1, 3, '0', STR_PAD_LEFT);
            $category->fill($input);
            $category->save();
            DB::commit();
            return redirect()->route('admin.category.showIndex')->with('success', 'Tạo loại sản phẩm thành công');
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->route('admin.category.showIndex')->with('error', 'Tạo loại sản phẩm thất bại');
        }
    }

    public function putCategory(Request $request, Category $category): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $input = $request->all();
            $category->fill($input);
            $category->save();
            DB::commit();
            return redirect()->route('admin.category.showIndex')->with('success', 'Chỉnh sửa loại sản phẩm thành công');
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->route('admin.category.showIndex')->with('error', 'Chỉnh sửa loại sản phẩm thất bại');
        }
    }

    public function delete(Category $category): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $category->delete();
            DB::commit();
            return redirect()->route('admin.category.showIndex')->with('success', 'Xóa loại sản phẩm thành công');
        }catch (Exception $e){
            return redirect()->route('admin.category.showIndex')->with('error', 'Xóa loại sản phẩm thất bại');
        }
    }
}

