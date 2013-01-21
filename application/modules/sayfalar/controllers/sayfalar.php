<?php

class Sayfalar extends Public_Controller
{
	function __construct(){
		parent::__construct();
	}
	
	function index()
	{
		$this->template->build('public/sayfa');
	}
	
	function sayfa()
	{
		$this->template->build('public/sayfa');
	}
}