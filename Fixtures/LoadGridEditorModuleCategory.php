<?php
namespace Jet\Modules\GridEditor\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jet\Models\ModuleCategory;

class LoadGridEditorModuleCategory extends AbstractFixture implements OrderedFixtureInterface
{
    private $data = [
        'name' => 'Grid Editor',
        'title' => 'Contenu wysiwyg',
        'slug' => 'grid-editor',
        'nav' => false,
        'description' => 'Module pour afficher des contenus',
        'icon' => 'fa fa-code',
        'author' => 'S.Sumugan',
        'version' => '0.1'
    ];

    public function load(ObjectManager $manager)
    {
        if(ModuleCategory::where('name',$this->data['name'])->where('author',$this->data['author'])->count() == 0) {
            $cat = new ModuleCategory();
            $cat->setName($this->data['name']);
            $cat->setTitle($this->data['title']);
            $cat->setSlug($this->data['slug']);
            $cat->setNav($this->data['nav']);
            $cat->setIcon($this->data['icon']);
            $cat->setAuthor($this->data['author']);
            $cat->setDescription($this->data['description']);
            $manager->persist($cat);
            $this->setReference($this->data['slug'], $cat);
            $manager->flush();
        }else{
            ModuleCategory::where('name',$this->data['name'])->set($this->data);
        }
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 301;
    }
}