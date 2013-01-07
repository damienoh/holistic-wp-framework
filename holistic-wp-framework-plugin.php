<?php

/*
Plugin Name:Holistic WP Framework
Description: This is a wrapper class for the Holistic WP Framework
Version: 1.0
Author: Damien Oh


This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if(!class_exists('HolisticWPFramework') && file_exists('holistic-wp-framework.php'))
	include_once('holistic-wp-framework.php');
if(!class_exists('HolisticWP_List_Table') && file_exists('holistic-wp-list-table-framework.php'))
	include_once('holistic-wp-list-table-framework.php');

?>
