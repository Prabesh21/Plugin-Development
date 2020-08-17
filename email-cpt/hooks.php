<?php
 add_action( 'init', array($this, 'my_cpt' ));
 add_action( 'publish_email', array($this, 'save_movie_details' ));