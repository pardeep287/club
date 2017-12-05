<?php

    namespace App\Http\Controllers;

    use App\Category;
    use Illuminate\Http\Request;

    class CategoryController extends Controller
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
            $categories = Category::all();

            return view('admin.category.index', compact(['categories']));
        }

        public function add(Request $request)
        {
            $this->validate($request, [
                'name'        => 'required|min:2|max:180|unique:categories,name',
                'description' => 'required|min:5|max:1000',
            ]);

            $category = Category::create(
                [
                    'name'        => $request->name,
                    'description' => $request->description,
                ]
            );

            return back()->with([
                'message' => "Category {$category->name} added in system",
            ]);
        }

        public function edit(Request $request)
        {
            $this->validate($request, [
                'id'          => 'required|exists:categories,id',
                'name'        => 'required|min:2|max:180|unique:categories,name,' . $request->id,
                'description' => 'required|min:5|max:1000',
            ]);

            $category = Category::find($request->id);
            $category->fill(
                [
                    'name'        => $request->name,
                    'description' => $request->description,
                ]
            );
            $category->save();

            return back()->with([
                'message' => "Category {$category->name} edited in system",
            ]);
        }

    }