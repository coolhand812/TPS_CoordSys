<?php
 include('jpgraph.php');
 include('jpgraph_pie.php');
 include('jpgraph_pie3d.php');
// Some dat
$ydata = array(11.5,3,8,12,5,1,9,13,5,7);

// Create the graph. These two calls are always required
$graph = new PieGraph(450,250,"auto");
$graph->SetShadow();
 $graph->title->Set("A simple Pie plot");
 $p1 = new PiePlot3D($ydata);
 $p1->SetSize(0.5);
 $p1->SetCenter(0.45);
 $graph->Add($p1);
 $graph->Stroke();
?> 