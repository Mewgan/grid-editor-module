<?php
namespace Jet\Modules\GridEditor\Fixtures;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Jet\Services\LoadFixture;

class LoadGridEditorModule extends AbstractFixture implements OrderedFixtureInterface
{
    use LoadFixture;

    protected $data = [
        'module_grid_editor' => [
            'name' => 'Editeur de contenu',
            'slug' => 'grid-editor',
            'callback' => 'Jet\Modules\GridEditor\Controllers\FrontGridEditorController@show',
            'description' => 'Affiche un contenu wysiwyg',
            'category' => 'grid-editor',
            'access_level' => 4,
            'templates' => []
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadModule($manager);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 302;
    }
}