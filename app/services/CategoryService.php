<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Utils\DatatableService;
use App\Utils\ImageUpload;
use Yajra\DataTables\Facades\DataTables;

class CategoryService
{
    public $categoryRepository;
    protected $pathImage;
    public function __construct(CategoryRepository $repo)
    {
        $this->pathImage = 'categoryImages';
        $this->categoryRepository = $repo;
    }

    public function getMainCategories()
    {
        return $this->categoryRepository->getMainCategories();
    }


    public function store($params)
    {
        $params['parent_id'] = $params['parent_id'] ?? 0;
        if (isset($params['image'])) {
            $params['image'] = ImageUpload::uploadImage($params['image'],200,200,$this->pathImage);
        }
        return  $this->categoryRepository->store($params);
    }


    public function getById($id, $childrenCount = false)
    {
        return $this->categoryRepository->getbyId($id, $childrenCount);
    }

    public function update($id, $params)
    {
        $category = $this->categoryRepository->getById($id);
        // dd($category->image);
        $params['parent_id'] = $params['parent_id'] ?? 0;
        if (isset($params['image'])) {
            $params['image'] = ImageUpload::uploadImage($params['image'],200,200,path:$this->pathImage,oldImage:$category->image);
        }
        return  $this->categoryRepository->update($category, $params);
    }


    public function delete($params)
    {
        $this->categoryRepository->delete($params);
    }

    public function datatable()
    {
        $query = $this->categoryRepository->baseQuery(['parent']);
        return  DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
                        <a href="' . Route('dashboard.categories.edit', $row->id) . '"  class="edit btn btn-success btn-sm" ><i class="fa fa-edit"></i></a>

                        <button type="button" id="deleteBtn"  data-id="' . $row->id . '" class="btn btn-danger mt-md-0 mt-2" data-bs-toggle="modal"
                        data-original-title="test" data-bs-target="#deletemodal"><i class="fa fa-trash"></i></button>';
            })

            ->addColumn('parent', function ($row) {
                if ($row->parent) {
                    return $row->parent->name;
                }
                return 'قسم رئيسي';
            })

            ->addColumn('image', function ($row) {
                return '<img src="' . asset($row->image) . '" width="100px" height="100px">';
            })

            ->rawColumns(['parent', 'action', 'image'])
            ->make(true);
    }


    public function getAll()
    {
        return $this->categoryRepository->baseQuery(['child'])->get();
    }
}
