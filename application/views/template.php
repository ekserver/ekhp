<?php

// Set definitions for parser
$this->load->library('parser');

$data = array(
        //HEAD PARTIALS
        'head:head'         => $this->load->view('partials/head'),
        //HEADER
        'header:header'     => $this->load->view('partials/header'),
        //CONTENT
        'content:content'   => $this->load->view('controller/'. $controller),
        //FOOTER
        'footer:footer'     => $this->load->view('partials/footer')
        );
        
// Load layout set in controller
$this->parser->parse('layout/' .$layout, $data);