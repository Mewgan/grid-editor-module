<?php

namespace Jet\Modules\GridEditor\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Jet\Models\Website;

class LoadGridEditorWebsiteModule extends AbstractFixture implements OrderedFixtureInterface
{
    private $data = [
        'aster-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'balsamine-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'heliotrope-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'pivoine-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'rose-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'luffy-society' => [
            'modules' => [
                /*'module_grid_editor',*/
            ],
        ],
        'zoro-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'sanji-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'chopper-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
        'robin-society' => [
            'modules' => [
                'module_grid_editor',
            ],
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach($this->data as $key => $data) {
            $website = Website::findOneByDomain($key);
            foreach ($data['modules'] as $module) {
                $mod = $this->getReference($module);
                $modules = is_null($website->getModules())?[]:$website->getModules();
                if(!in_array($mod->getId(),$modules)) 
                    $website->addModule($mod->getId());
            }
            if(isset($data['exclude'])){
                $d = $website->getData();
                $d['parent_exclude']['grid_editors'] = (isset($d['parent_exclude']['grid_editors']))
                    ? array_merge($data['exclude'],$d['parent_exclude']['grid_editors'])
                    : $data['exclude'];
                $website->setData($d);
            }
            $manager->persist($website);
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
        return 7;
    }
}