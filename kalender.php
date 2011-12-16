<?php
if(isset($_GET['sub']))
{
	$activ = $_GET['sub'];
}
else
{
	$activ = 'uebersicht';
}

if(isset($_GET['sub']))
{
	switch($_GET['sub'])
	{
            case 'uebersicht': include('kalender_uebersicht.php'); break;
            case 'detail': include('kalender_detail.php'); break;
            
	    default: break;
	}
}
else
{
	include('kalender_uebersicht.php');
}