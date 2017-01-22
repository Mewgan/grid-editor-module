<?php
namespace Jet\Modules\GridEditor\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Jet\Services\LoadFixture;

class LoadGridEditorModuleCategory extends AbstractFixture
{
    use LoadFixture;

    protected $data = [
        'name' => 'Grid Editor',
        'title' => 'Contenu wysiwyg',
        'slug' => 'grid-editor',
        'nav' => false,
        'description' => 'Module pour afficher des contenus',
        'icon' => 'fa fa-code',
        'author' => 'S.Sumugan',
        'version' => '0.1',
        'update_available' => false,
        'access_level' => 4
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadModuleCategory($manager);
    }
}