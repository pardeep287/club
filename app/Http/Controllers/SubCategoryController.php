<?php

    namespace App\Http\Controllers;

    use App\Category;
    use App\SubCategory;
    use Illuminate\Http\Request;

    class SubCategoryController extends Controller
    {

        /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
            $this->middleware('auth');
            $this->middleware('care');
        }

        public function index()
        {
            $subcategories = SubCategory::orderBy('category_id')->get();

            return view('admin.subcategory.index', compact(['subcategories']));
        }

        public function add(Request $request)
        {
            $this->validate($request, [
                'category_id' => 'required|exists:categories,id',
                'name'        => 'required|min:2|max:150|unique:sub_categories,name',
                'description' => 'required|min:5',
            ]);

            $category = Category::find($request->category_id);

            $subcategory = $category->subcategories()->create([
                'name'        => $request->name,
                'description' => $request->description,
            ]);

            return back()->with([
                'message' => "Subcategory {$subcategory->name} added into {$category->name}",
            ]);
        }

        public function edit(Request $request)
        {
            $this->validate($request, [
                'id'          => 'required|exists:sub_categories',
                'category_id' => 'required|exists:categories,id',
                'name'        => 'required|min:2|max:150|unique:sub_categories,name,' . $request->id,
                'description' => 'required|min:5',
            ]);

            $subcategory = SubCategory::find($request->id);

            $subcategory->fill([
                'name'        => $request->name,
                'description' => $request->description,
                'category_id' => $request->category_id,
            ]);

            $subcategory->save();

            return back()->with([
                'message' => 'Subcategory edited',
            ]);
        }
    }
