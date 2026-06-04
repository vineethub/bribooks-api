<?php

namespace App\Services;

use App\Models\Chapter;
use App\Models\Page;

class PageService
{
    public function create(Chapter $chapter, array $data)
    {
        return $chapter->pages()->create([
            'page_number' => $data['page_number'],
            'content' => $data['content']
        ]);
    }

    public function update(Page $page, array $data)
    {
        $page->update([
            'page_number' => $data['page_number'] ?? $page->page_number,
            'content' => $data['content'] ?? $page->content,
        ]);

        return $page->fresh();
    }
}