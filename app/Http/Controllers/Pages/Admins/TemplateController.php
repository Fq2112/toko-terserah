<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function create_data(Request $request)
    {
        Template::create([
            'pertanyaan' => $request->pertanyaan
        ]);

        return back()->with('success', 'Berhasil Menambah Template Pertanyaan');
    }

    public function edit(Request $request)
    {

        $data = Template::find($request->id);

        $data->update([
            'pertanyaan' => $request->pertanyaan
        ]);
        return back()->with('success', 'Berhasil Memperbarui Template Pertanyaan');
    }
}
