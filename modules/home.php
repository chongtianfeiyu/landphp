<?php
class home {
	public function index() {
		common::load_model('yy');
		echo "111";
		common::render('home','index');
	}
}