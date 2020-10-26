<?php


namespace App\Models\Data;


use Illuminate\Support\Collection;

class User
{
    public string $name, $icon_url;
    public Collection $guilds;

    /**
     * User constructor.
     * @param string $name
     * @param string $icon_url
     * @param Collection|null $guilds
     */
    public function __construct(string $name, string $icon_url, Collection $guilds = null)
    {
        $this->name = $name;
        $this->icon_url = $icon_url;

        if ($guilds === null) {
            $this->guilds = collect();
        } else {
            $this->guilds = $guilds;
        }
    }
}
