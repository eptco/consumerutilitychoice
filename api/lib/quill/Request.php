<?php

namespace Quill;

class Request {
    
    public function getBody() {
        
        return file_get_contents('php://input');
    }
    
    public function getJSONObject() {
        
        return json_decode($this->getBody());
    }
}
