<?php

use Illuminate\Http\Response;

class CategoryTest extends TestCase
{
    public function testCreateCategory()
    {
        $data = factory(\App\Category::class)->make()->toArray();

        $this->post('category', $data);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJson([
            'name' => $data['name'],
        ]);
    }

    public function testListCategory()
    {
        $data = \App\Category::first();

        $this->get('category');
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJson([
            'name' => $data->name,
        ]);
    }

    public function testShowCategory()
    {
        $category = \App\Category::first();
        $this->get('category/'.$category->id);
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJsonContains([
            'name' => $category->name,
        ]);
    }

    public function testUpdateCategory()
    {
        $category = \App\Category::first();
        $name = $category->name;

        $category->name = null;
        $this->put('category/'.$category->id, $category->toArray());
        $this->seeStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);

        $name = str_replace("-Updated", "", $name);

        $category->name = $name.'-Updated';
        $this->put('category/'.$category->id, $category->toArray());
        $this->seeStatusCode(Response::HTTP_OK);
        $this->seeJson([
            'name' => $category->name,
        ]);
    }
}
