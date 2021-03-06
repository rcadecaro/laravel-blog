<?php

namespace Tests\Browser\Admin;

use App\User;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTest;

class UsersBrowserTest extends BrowserKitTest
{
    use DatabaseMigrations;

    public function testUserIndexEditLink()
    {
        $admin = $this->admin();
        $anakin = factory(User::class)->states('anakin')->create();

        $this->actingAs($admin)
            ->visit('/admin/users')
            ->click('Anakin')
            ->seeRouteIs('admin.users.edit', $anakin);
    }

    public function testUserProfilViewLink()
    {
        $admin = $this->admin();
        $user = $this->user();

        $this->actingAs($admin)
            ->visit("/admin/users/{$user->id}/edit")
            ->click(route('users.show', $user))
            ->seeRouteIs('users.show', $user);
    }

    public function testUserUpdate()
    {
        $faker = Factory::create();
        $admin = $this->admin();
        $user = $this->user();

        $this->actingAs($admin)
            ->visit("/admin/users/{$user->id}/edit")
            ->type($faker->name, 'name')
            ->type($faker->email, 'email')
            ->check('roles[1]')
            ->press('Mettre à jour')
            ->see('Le profil a bien été mis à jour');
    }
}
