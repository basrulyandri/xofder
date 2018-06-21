<?php

namespace App;


class Chart
{
	public $chart = [];
	public $title = [
		'text' => 'Graphic Chart'
	];

	public $xAxis = [
		'title' => 'xAxis',
		'categories' => []
	];

	public $yAxis = [
		'title' => 'yAxis'
	];

	public $series= [];

	public function __construct($type = 'line')
	{		
		$this->chart['type'] = $type;
	}

	public function chart($type = 'line')
	{
		$this->chart['type'] = $type;
		return $this;
	}
    public function title($title)
    {
    	$this->title['text'] = $title;
    	return $this;
    }

    public function xAxis($title, array $categories)
    {
    	$this->xAxis['title'] = $title;
    	$this->xAxis['categories'] = $categories;
    	return $this;
    }

    public function yAxis($title)
    {
    	$this->xAxis['title'] = $title;
    	return $this;
    }

    public function series(array $series)
    {
    	if($this->chart['type'] == 'pie'){
    		$this->series[0] = ['name' => 'Barang'];
    		$this->series[0]['colorByPoint'] = true;
    		$maxValue = [];
    		foreach($series as $findMax){
    			$maxValue[] = $findMax['data'];
    		}

    		$max = max($maxValue);


    		foreach($series as $data){    			
	    		$this->series[0]['data'][] = [
	    			'name' => $data['name'],
	    			'y' => $data['data'],
	    			'sliced' => ($data['data'] == $max) ? true: false
	    		];
	    	} 
    	} else {
    		foreach($series as $data){
	    		$this->series[] = [
	    			'name' => $data['name'],
	    			'data' => $data['data']
	    		];
	    	} 
    	}
    }
}
