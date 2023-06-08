<?php

namespace Tests\Unit;

use App\Http\Services\NewsService;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    use RefreshDatabase;

    private array $mockData = [
        'status' => 'published',
        'data' => [
            [
                'locale' => 'az',
                'title' => 'Az title',
                'description' => 'Az description',
            ],
            [
                'locale' => 'en',
                'title' => 'En title',
                'description' => 'En description',
            ],
            [
                'locale' => 'ru',
                'title' => 'Ru title',
                'description' => 'Ru description',
            ],
        ],
    ];


    public function testInsert()
    {
        $request = new Request();
        $request->merge($this->mockData);

        $newsService = new NewsService();
        $result = $newsService->insert($request);


        $this->assertInstanceOf(News::class, $result);
        $this->assertEquals('published', $result->status);
        $this->assertEquals(0, $result->view_count);

        $this->assertCount(3, $result->translations);

        $this->assertEquals('az', $result->translations[0]->locale);
        $this->assertEquals('Az title', $result->translations[0]->title);
        $this->assertEquals('Az description', $result->translations[0]->description);

        $this->assertEquals('en', $result->translations[1]->locale);
        $this->assertEquals('En title', $result->translations[1]->title);
        $this->assertEquals('En description', $result->translations[1]->description);

        $this->assertEquals('ru', $result->translations[2]->locale);
        $this->assertEquals('Ru title', $result->translations[2]->title);
        $this->assertEquals('Ru description', $result->translations[2]->description);
    }


    public function testUpdate()
    {
        $news = Factory::factoryForModel(News::class)->create([
            'id' => 1,
            'status' => 'old_status',
        ]);

        $request = new Request();
        $request->merge($this->mockData);

        $newsService = new NewsService();
        $result = $newsService->update($news->id, $request);

        $this->assertInstanceOf(News::class, $result);
        $this->assertEquals('published', $result->status);

        foreach ($result->translations as $index => $translation) {
            $this->assertEquals($request->data[$index]['title'], $translation->title);
            $this->assertEquals($request->data[$index]['description'], $translation->description);
        }
    }

    public function testDelete()
    {
        $news = Factory::factoryForModel(News::class)->create([
            'id' => 1,
            'status' => 'old_status',
        ]);

        $newsService = new NewsService();
        $newsService->delete($news->id);

        $this->assertDatabaseMissing('news', ['id' => $news->id]);
    }
}
