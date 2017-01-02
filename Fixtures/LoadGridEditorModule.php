<?php
namespace Jet\Modules\GridEditor\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Jet\Models\Module;

class LoadGridEditorModule extends AbstractFixture implements OrderedFixtureInterface
{

    private $data = [
        'module_grid_editor' => [
            'name' => 'Editeur de contenu',
            'slug' => 'grid-editor',
            'callback' => 'Jet\Modules\GridEditor\Controllers\FrontGridEditorController@show',
            'description' => 'Affiche un contenu wysiwyg',
            'category' => 'grid-editor',
            'access_level' => 4,
            'templates' => [
               
            ]
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach($this->data as $key => $data){
            $module = (Module::where('callback',$data['callback'])->count() == 0)
                ? new Module()
                : Module::findOneByCallback($data['callback']);
            $module->setName($data['name']);
            $module->setSlug($data['slug']);
            $module->setCallback($data['callback']);
            $module->setDescription($data['description']);
            $module->setCategory($this->getReference($data['category']));
            $module->setAccessLevel($data['access_level']);
            $templates = new ArrayCollection();
            foreach ($data['templates'] as $template)
                $templates[] = $this->getReference($template);
            $module->setTemplates($templates);
            $this->setReference($key, $module);
            $manager->persist($module);
        }
        $manager->flush();
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