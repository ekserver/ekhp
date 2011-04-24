<?php

// Set definitions for parser
$this->load->library('parser');

$data = array(
        // Head partials
        'head:head'         => $this->load->view('partials/head', NULL, TRUE),
        // Header
        'header:header'     => $this->load->view('partials/header', NULL, TRUE),
        // Serverstatus
        'serverstatus:serverstatus'	=> $this->load->view('partials/serverstatus', NULL, TRUE),
        // Content
        'content:content'   => $this->load->view('controller/'. $content, NULL, TRUE),
        'content:teaserbox' => $this->load->view('partials/teaserbox', NULL, TRUE),
        // Footer
        'footer:footer'     => $this->load->view('partials/footer', NULL, TRUE)
        );
        
// Load layout set in controller
$this->parser->parse('layout/' .$layout, $data);