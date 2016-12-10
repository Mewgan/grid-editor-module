<?php

namespace Jet\Modules\GridEditor\Controllers;

use Jet\FrontBlock\Controllers\MainController;
use Jet\Models\Content;

class FrontGridEditorController extends MainController
{

    /**
     * @param $content
     * @return null
     */
    public function show($content){
        $data = $content->getData();
        if(!empty($data)) {
            return (empty($data['content']))
                ? null
                : $data['content'];
        }
        return null;
    }
    
}