<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::orderBy('sort_order')->get();

        return view('admin.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        $categories = Portfolio::CATEGORIES;

        return view('admin.portfolios.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Portfolio::create($data);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio berhasil dibuat.');
    }

    public function edit(Portfolio $portfolio)
    {
        $categories = Portfolio::CATEGORIES;

        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $data = $this->validated($request, $portfolio);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $portfolio->update($data);

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')
            ->with('success', 'Portofolio berhasil dihapus.');
    }

    private function validated(Request $request, ?Portfolio $portfolio = null): array
    {
        $slugUnique = 'unique:portfolios,slug' . ($portfolio ? ',' . $portfolio->id : '');

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugUnique],
            'category' => ['required', 'in:' . implode(',', array_keys(Portfolio::CATEGORIES))],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cover_color' => ['nullable', 'string', 'max:20'],
            'description' => ['required', 'string'],
            'link' => ['nullable', 'url', 'max:255'],
            'tech_stack' => ['nullable', 'array'],
            'tech_stack.*' => ['nullable', 'string', 'max:100'],
            'year' => ['nullable', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['tech_stack'] = array_values(array_filter($data['tech_stack'] ?? []));
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['cover_color'] = $data['cover_color'] ?: '#0A0A0A';

        unset($data['cover_image']);

        return $data;
    }
}
