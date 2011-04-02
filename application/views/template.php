<?php

// Set definitions for parser
$this->load->library('parser');

$data = array(
        //HEAD PARTIALS
        'head:head'         => $this->load->view('partials/head', NULL, TRUE),
        //HEADER
        'header:header'     => $this->load->view('partials/header', NULL, TRUE),
        //CONTENT
        'content:content'   => $this->load->view('controller/'. $content, NULL, TRUE),
        //FOOTER
        'footer:footer'     => $this->load->view('partials/footer', NULL, TRUE)
        );
        
// Load layout set in controller
$this->parser->parse('layout/' .$layout, $data);