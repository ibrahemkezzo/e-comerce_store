<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Category\CategoryDeleteRequest;
use App\Http\Requests\Dashboard\Category\CategoryStroeRequest;
use App\Http\Requests\Dashboard\Category\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mainCategories = $this->categoryService->getMainCategories();
        return view('dashboard.categories.index', compact('mainCategories'));
    }

    public function getall(){
        return $this->categoryService->datatable();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->categoryService->store($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'تمت الاضافة بنجاح');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->getById($id,true);
        $mainCategories = $this->categoryService->getMainCategories();
        return view('dashboard.categories.edit',compact(['category','mainCategories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id)
    {
        $this->categoryService->update($id,$request->validated());
        return redirect()->route('dashboard.categories.index')->with('success', 'تمت التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(CategoryDeleteRequest $request)
    {
        $this->categoryService->delete($request->validated());
        return redirect()->route('dashboard.categories.index');
        }
}
