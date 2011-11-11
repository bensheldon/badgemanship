<?php  
App::import('Vendor', 'Markdown', array('file' => 'markdown/markdown.php'));

class MarkdownHelper extends AppHelper { 
    function parse($text) { 
        return $this->output(Markdown($text)); 
    } 
} 
?> 