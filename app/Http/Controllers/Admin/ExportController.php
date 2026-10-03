<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{

    /**
     * Export semua resep ke CSV.
     */
    public function recipes(): StreamedResponse
    {
        $filename = 'recipes-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');

            // BOM untuk Excel
            fputs($handle, "\xEF\xBB\xBF");

            // Header
            fputcsv($handle, [
                'ID', 'Title', 'Slug', 'Category', 'Author',
                'Servings', 'Duration (min)', 'Difficulty',
                'Calories', 'Status', 'Views', 'Created At',
            ]);

            Recipe::with(['category', 'user'])
                ->chunk(200, function ($recipes) use ($handle) {
                    foreach ($recipes as $recipe) {
                        fputcsv($handle, [
                            $recipe->id,
                            $recipe->title,
                            $recipe->slug,
                            $recipe->category->name ?? '-',
                            $recipe->user->name ?? '-',
                            $recipe->servings,
                            $recipe->duration_minutes ?? '-',
                            $recipe->difficulty,
                            $recipe->calories ?? '-',
                            $recipe->status,
                            $recipe->views,
                            $recipe->created_at?->format('Y-m-d H:i'),
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Export daftar user (tanpa password).
     */
    public function users(): StreamedResponse
    {
        $filename = 'users-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['ID', 'Name', 'Email', 'Role', 'Created At']);

            \App\Models\User::chunk(200, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->role,
                        $user->created_at?->format('Y-m-d H:i'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}