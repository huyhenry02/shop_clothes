<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function showIndex(): View
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(10);
        $categories = Category::all();
        return view('admin.pages.product.index',
            [
                'products' => $products,
                'categories' => $categories,
            ]);
    }
    public function filter(Request $request): JsonResponse
    {
        $query = Product::orderBy('created_at', 'desc')->with('category');

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('code', 'like', '%' . $request->keyword . '%')
                ->orWhere('description', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('category_ids') && is_array($request->category_ids)) {
            $query->whereIn('category_id', $request->category_ids);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->filled('sort_price')) {
            $query->orderBy('price', $request->sort_price);
        }

        if ($request->filled('stock_quantity')) {
            $query->orderBy('stock_quantity', $request->stock_quantity);
        }

        $products = $query->get();

        return response()->json([
            'html' => view('admin.pages.product.table', compact('products'))->render()
        ]);
    }

    public function showCreate(): View
    {
        $categories = Category::all();
        return view('admin.pages.product.create',
            [
                'categories' => $categories,
            ]);
    }

    public function showUpdate(Product $product): View
    {
        $categories = Category::all();
        return view('admin.pages.product.update',
            [
                'product' => $product,
                'categories' => $categories,
            ]);
    }

    public function postProduct(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->input();
            $lastProduct = Product::orderBy('id', 'desc')->first();
            $input['code'] = 'SP_' . str_pad(($lastProduct ? $lastProduct->id + 1 : 1), 3, '0', STR_PAD_LEFT);
            $product = new Product();
            if ($request->hasFile('image')) {
                $product->image = $this->handleUploadFile($request->file('image'), $product, 'image');
            }
            if ($request->hasFile('image_detail_1')) {
                $product->image_detail_1 = $this->handleUploadFile($request->file('image_detail_1'), $product, 'image_detail_1');
            }
            if ($request->hasFile('image_detail_2')) {
                $product->image_detail_2 = $this->handleUploadFile($request->file('image_detail_2'), $product, 'image_detail_2');
            }
            if ($request->hasFile('image_detail_3')) {
                $product->image_detail_3 = $this->handleUploadFile($request->file('image_detail_3'), $product, 'image_detail_3');
            }
            $product->fill($input);
            $product->save();
            DB::commit();
            return redirect()->route('admin.product.showIndex')->with('success', 'Tạo sản phẩm thành công');
        }catch (Exception $exception){
            return redirect()->route('admin.product.showIndex')->with('error', 'Tạo sản phẩm thất bại');
        }
    }

    public function putProduct(Request $request, Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $input = $request->input();
            if ($request->hasFile('image_detail_2')) {
                $product->image_detail_2 = $this->handleUploadFile($request->file('image_detail_2'), $product, 'image_detail_2');
            }
            if ($request->hasFile('image_detail_3')) {
                $product->image_detail_3 = $this->handleUploadFile($request->file('image_detail_3'), $product, 'image_detail_3');
            }
            if ($request->hasFile('image')) {
                $product->image = $this->handleUploadFile($request->file('image'), $product, 'image');
            }
            if ($request->hasFile('image_detail_1')) {
                $product->image_detail_1 = $this->handleUploadFile($request->file('image_detail_1'), $product, 'image_detail_1');
            }
            $product->fill($input);
            $product->save();
            DB::commit();
            return redirect()->route('admin.product.showIndex')->with('success', 'Chỉnh sửa sản phẩm thành công');
        }catch (Exception $exception){
            return redirect()->route('admin.product.showIndex')->with('error', 'Chỉnh sửa sản phẩm thất bại');
        }
    }

    public function delete(Product $product): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            return redirect()->route('admin.product.showIndex')->with('success', 'Xóa sản phẩm thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.product.showIndex')->with('error', 'Xóa sản phẩm thất bại');
        }
    }

    private function handleUploadFile($file, $model, $type): string
    {
        $fileName = $type . '_' . $model->id . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storePubliclyAs('products/' . $type, $fileName);
        return asset('storage/' . $filePath);
    }
}
