<?php

add_action( 'after_setup_theme', 'statenshare_load' );

function statenshare_load() {
	\Carbon_Fields\Carbon_Fields::boot();
}