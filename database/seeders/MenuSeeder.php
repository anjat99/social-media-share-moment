<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $names = ['News Feed', 'My Profile', 'My Stories','Manage Tags', 'Manage Locations','Manage Comments','Dashboard','Users','Categories','Albums', 'Stories','Tags','Locations','Messages','Comments'];
    private $urls = ['user.feed', 'profile.index', 'stories.index','tags.index', 'locations.index', 'comments.index', 'admin.dashboard', 'users.index', 'categories.index', 'albums-manage.index', 'stories-manage.index', 'tags-manage.index', 'locations-manage.index', 'messages.index', 'comments-manage.index'];
    private $icons = ['home','users','file','tag','map-pin','message-circle', 'home','users','book','folder','file','tag','map-pin','mail','message-circle'];
    private $role = [2, 2, 2, 2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1];

    public function run()
    {
        for ($i = 0, $iMax = count($this->names); $i < $iMax; $i++){
            DB::table('menus')->insert([
                'name' => $this->names[$i],
                'url' => $this->urls[$i],
                'icon' => $this->icons[$i],
                'role_id'=>$this->role[$i]
            ]);
        }
    }
}
