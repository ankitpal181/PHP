<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Menu;
use App\Http\Requests\StoreMenu;
use App\Http\Requests\UpdateMenu;
use App\Events\OrderCreated;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * 
     * @return Renderable
     */
    public function index()
    {
        $data = Menu::all();
        $menu = [];
        try {
            foreach ($data as $row) {
                if (array_key_exists($row['category'], $menu)) {
                    $menu[$row['category']][] = $row;
                } else {
                    $menu[$row['category']] = [$row];
                }
            }
        } catch (\Exception $error) {
            report($error);
        }
        return view('menu::index', ['menu' => $menu]);
    }

    /**
     * Show the form for creating/deleting multiple new resources.
     * 
     * @return Renderable
     */
    public function create()
    {
        $data = Menu::all();
        $menu = [];
        try {
            foreach ($data as $row) {
                if (array_key_exists($row['category'], $menu)) {
                    $menu[$row['category']][] = $row;
                } else {
                    $menu[$row['category']] = [$row];
                }
            }
        } catch (\Exception $error) {
            report($error);
        }
        return view('menu::create', ['menu' => $menu]);
    }

    /**
     * Store newly created resources in storage or redirecting to destroy
     * method for deletion.
     * 
     * @param StoreMenu $request
     * @return Redirect '/menu'
     */
    public function store(StoreMenu $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validated();

            if ($request->has('ids')) {
                $this->destroy($validatedData['ids']);
            }

            if ($request->has('categories')) {
                DB::beginTransaction();
                foreach ($validatedData['categories'] as $key => $category) {
                    $item = new Menu();
                    $item->category = $category;
                    try {
                        $item->item = $validatedData['names'][$key];
                        $item->price = $validatedData['prices'][$key];
                        $item->available = $validatedData['availables'][$key];
                        $item->save();
                    } catch (\Exception $error) {
                        DB::rollback();
                        report($error);
                        return redirect('/menu');
                    }
                }
                DB::commit();
                event(new OrderCreated());
            }

            return redirect('/menu');
        }
    }

    /**
     * Show the form for editing multiple resources.
     * 
     * @return Renderable
     */
    public function edit()
    {
        $data = Menu::all();
        $menu = [];
        try {
            foreach ($data as $row) {
                if (array_key_exists($row['category'], $menu)) {
                    $menu[$row['category']][] = $row;
                } else {
                    $menu[$row['category']] = [$row];
                }
            }
        } catch (\Exception $error) {
            report($error);
        }

        return view('menu::edit', ['menu' => $menu]);
    }

    /**
     * Update multiple specified resources in storage.
     * 
     * @param UpdateMenu $request
     * @return Redirect '/menu' or 'Error'
     */
    public function update(UpdateMenu $request)
    {
        if ($request->isMethod('post')) {
            $validatedData = $request->validated();
            
            if ($request->has('ids')) {
                DB::beginTransaction();
                foreach ($validatedData['ids'] as $id) {
                    try {
                        $item = Menu::find($id);
                        $item->item = $validatedData['names'][$id];
                        $item->available = $validatedData['availables'][$id];
                        $item->price = $validatedData['prices'][$id];
                        $item->updated_at = date('Y-m-d');
                        $item->save();
                    } catch (\Exception $error) {
                        DB::rollback();
                        report($error);
                        return redirect('/menu');
                    }
                }
                DB::commit();
            }

            return redirect('/menu');
        }

        return "Error! Invalid Request";
    }

    /**
     * Remove the specified multiple resources from storage.
     * 
     * @param array $ids
     * @return 'Success'
     */
    public function destroy($ids = [])
    {
        foreach ($ids as $id) {
            try {
                $item = Menu::find($id);
                $item->delete();
            } catch (\Exception $error) {
                // Add a rollback for transaction so far to avoid partial data delete
                report($error);
            }
        }

        return "Success";
    }
}
