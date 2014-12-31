<?php
	include('Email.php');

	$namespaces = array(
		'from',
		'to',
		'title',
		'content'
	);
	$norequired = array();
	$attachments = array();
	$pathToUpload = '';
	$pathToTemplate = 'form-template.php';

	new Email($_POST, $namespaces, $norequired, $attachments, $pathToUpload, $pathToTemplate);
