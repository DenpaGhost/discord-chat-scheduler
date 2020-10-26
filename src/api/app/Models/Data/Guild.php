<?php


namespace App\Models\Data;


use Illuminate\Support\Collection;

class Guild
{
    public string $id, $icon_url, $name;
    public ?Collection $tasks;

    /**
     * Guild constructor.
     * @param string $id
     * @param string $icon_url
     * @param string $name
     * @param Collection|null $tasks
     */
    public function __construct(string $id, string $icon_url, string $name, ?Collection $tasks)
    {
        $this->id = $id;
        $this->icon_url = $icon_url;
        $this->name = $name;
        $this->tasks = $tasks;
    }
}
