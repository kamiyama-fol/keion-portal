<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Studio;

/**
 * 予約するスタジオを制御するコントローラ
 */

class StudioController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (Auth::user()->admin != 1) {
            return redirect('/');
        }

        $studios = Studio::all();
        return view('studios', compact('studios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        if (Auth::user()->admin != 1) {
            return redirect('/');
        }
        return view('studios');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->admin != 1) {
            return redirect('/');
        }
        //
        $studioNames = preg_split("/\r\n|\n|\r/", $request->input('studios'));

        // 各行をトリムして空でない行のみ処理
        foreach ($studioNames as $name) {
            $name = trim($name);
            if (!empty($name)) {
                Studio::create([
                    'name' => $name,
                    'made_by' => auth()->id(),
                ]);
            }
        }

        // リダイレクトまたはJSONレスポンス
        return redirect()->route('studios.index')->with('status', 'スタジオが作成されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::user()->admin != 1) {
            return redirect('/');
        }
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::user()->admin != 1) {
            return redirect('/');
        }
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Studio $studio)
    {
        if (Auth::user()->admin != 1) {
            return redirect('/');
        }
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $studio->update(['name' => $request->name]);

        return response()->json(['message' => 'Studio updated successfully.']);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Studio $studio)
    {
        if (Auth::user()->admin != 1) {
            return redirect('/');
        }
        $studio->delete();
        return redirect()->route('studios.index')->with('status', 'Studio deleted successfully.');
        //
    }
}
