<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Menu access', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Menu create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Menu edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Menu delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $menus = Menu::orderBy('order_by')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::where('parent_id', null)->get();
        
        return view('admin.menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'link'=> ['required'],
            'parent_id' => ['nullable'],
            'order_by' => ['nullable', 'numeric'],
            'status' => ['nullable'],
        ]);
        
        $menu = Menu::create([
            'title' => $request->title,
            'parent_id' => $request->parent_id,
            'link'=> $request->link,
            'order_by' => $request->order_by,
            'status' => $request->status,
            'link' => $request->link
        ]);
        return redirect()->route('admin.menu.index')->withMessage(__('Menu Added successfully'));
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'icon_image' => ['nullable', 'image', 'max:2048'],
            'order_by' => ['nullable', 'numeric'],
            'status' => ['nullable'],
            'has_submenu' => ['nullable'],
            //validate if has_submenu will be null or not
            'custome_link' => ['nullable', 'max:255'],
        ]);
        // dd($validated);
        if ($request->hasFile('icon_image')) {
            Storage::delete($menu->icon_image);
            $image = $request->icon_image->store('menus', 'public');
        }
        $menu->update([
            'title' => $request->title,
            'icon_image' => $image ?? $menu->icon_image,
            'order_by' => $request->order_by,
            'status' => $request->status,
            'has_sub_menu' => $request->has_submenu,
            'url' => $request->custome_link
        ]);
        return redirect()->route('admin.menu.index')->withMessage(__('Menu Updated successfully'));
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu.index')->with(__('Menu Deleted successfully'));
    }
}
