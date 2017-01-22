<?php
namespace Jet\Modules\GridEditor\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Jet\Services\LoadFixture;

class LoadGridEditorModule extends AbstractFixture implements DependentFixtureInterface
{
    use LoadFixture;

    protected $data = [
        'module_grid_editor' => [
            'name' => 'Editeur de contenu',
            'slug' => 'grid-editor',
            'callback' => 'Jet\Modules\GridEditor\Controllers\FrontGridEditorController@show',
            'description' => 'Affiche un contenu wysiwyg',
            'category' => 'grid-editor',
            'access_level' => 4
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadModule($manager);
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    function getDependencies()
    {
        return [
            'Jet\Modules\GridEditor\Fixtures\LoadGridEditorModuleCategory'
        ];
    }
}