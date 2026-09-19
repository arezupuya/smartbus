<?php
	class array2xml extends DomDocument{
	    public $nodeName;
	    private $xpath;
	    private $root;
	    private $node_name;

	    public function __construct($root='root',$node_name='item'){
	        parent::__construct();
	        //$this->encoding = "ISO-8859-1";
	        $this->encoding = "UTF-8";
	        $this->formatOutput = false;
			$this->substituteEntities = false;
	        $this->node_name = $node_name;
	        $this->root = $this->appendChild($this->createElement( $root ));
	        $this->xpath = new DomXPath($this);
	    }

	    public function createNode($arr, $node = null){
	        if(is_null($node)){
	            $node = $this->root;
	        }
	        foreach($arr as $element => $value){
	            $element = is_numeric( $element ) ? $this->node_name : $element;
				
				if(getType($value) == "string") $value = htmlspecialchars($value);				
				
				$child = $this->createElement($element, (is_array($value) ? null : $value));
				
				$child = $this->createElement($element, (is_array($value) ? null : $value));
				
				/*
				if(getType($value) == "string"){				//to every string - cdata element
					$child = $this->createElement($element);					
					$section = $this->createCDATASection($value);
					$child->appendChild($section);
				}
				else{
					$child = $this->createElement($element, (is_array($value) ? null : $value));
				}
				*/
				
	            $node->appendChild($child);
				
	            if (is_array($value)){
	                self::createNode($value, $child);
	            }
				
	        }
	    }
		
	    public function __toString(){
	        return $this->saveXML();
	    }

	    public function query($query){
	        return $this->xpath->evaluate($query);
	    }
	}
	
?>