<?php


class Email {

	private $post;
	private $namespaces;
	private $norequired;
	private $attachments;
	private $pathToUpload;
	private $pathToUpload = 'http://idschool.com.pl/wp-content/themes/italiandesignschool/uploads/';
	private $pathToTemplate;
	private $values;
	private $valid = true;

	public function __construct($post, $namespaces, $norequired, $attachments, $pathToUpload, $pathToTemplate) {
		$this->post = $post;
		$this->namespaces = $namespaces;
		$this->norequired = $norequired;
		$this->attachments = $attachments;
		$this->pathToUpload = $pathToUpload;
		$this->pathToTemplate = $pathToTemplate;

		$this->prepareData();
		$this->sendEmail();
	}

	private function prepareData() {
		foreach($this->namespaces as $key => $value) {
			if (in_array($value, $this->attachments)) {
				$this->values[] = '<a href="'.$this->pathToUpload.$this->post[$value].'">'.$this->post[$value].'</a>';
			} else {
				$this->values[] = nl2br($this->post[$value]);
			}
			if (!$this->post[$value] && !in_array($value, $this->norequired)) {

				$this->valid = false;
				break;
			}
			$this->namespaces[$key] = '{{'.$value.'}}';
		}
	}

	private function sendEmail() {
		if ($this->valid) {
			$validation = array();
			$content = file_get_contents($this->pathToTemplate, true);
			$content = str_replace($this->namespaces, $this->values, $content);
			$to = $this->post['to'];
			$from = $this->post['from'];

			@$title = $this->post['title'];
			@$content = $content;

			$header = "From: $from \nContent-Type:".' text/html;charset="utf-8"'."\nContent-Transfer-Encoding: 8bit";

			if (mail($to, $title, $content, $header)) {
				echo json_encode(true);
				exit;
			}
		}
		echo json_encode(false);
	}
}